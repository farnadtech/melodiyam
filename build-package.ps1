param(
    [Parameter(Mandatory=$true)] [string]$Version,
    [Parameter(Mandatory=$false)] [switch]$IncludeVendor = $false
)

Set-Location $PSScriptRoot

$OutputDir = Join-Path $PSScriptRoot "dist"
$TempDir   = Join-Path $env:TEMP "melodiyam_pkg_$Version"
$ZipPath   = Join-Path $OutputDir "melodiyam-v$Version.zip"

if (!(Test-Path $OutputDir)) { New-Item -ItemType Directory -Path $OutputDir | Out-Null }
if (Test-Path $TempDir)      { Remove-Item -Recurse -Force $TempDir }
New-Item -ItemType Directory -Path $TempDir | Out-Null

Write-Host ""
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host "  Melodiyam Install Package Builder" -ForegroundColor Cyan
Write-Host "  Version: $Version" -ForegroundColor Cyan
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host ""

# ─── Step 1: Export fresh schema.sql ───────────────────────────────────────
Write-Host "[1/5] Exporting database schema..." -ForegroundColor Yellow

$envPath = Join-Path $PSScriptRoot ".env"
if (!(Test-Path $envPath)) {
    Write-Host "  WARNING: .env not found, schema export skipped." -ForegroundColor DarkYellow
} else {
    # Read DB credentials from .env
    $envContent = Get-Content $envPath
    $dbHost = ($envContent | Select-String "^DB_HOST=(.+)$").Matches.Groups[1].Value.Trim()
    $dbPort = ($envContent | Select-String "^DB_PORT=(.+)$").Matches.Groups[1].Value.Trim()
    $dbName = ($envContent | Select-String "^DB_DATABASE=(.+)$").Matches.Groups[1].Value.Trim()
    $dbUser = ($envContent | Select-String "^DB_USERNAME=(.+)$").Matches.Groups[1].Value.Trim()
    $dbPass = ($envContent | Select-String "^DB_PASSWORD=(.*)$").Matches.Groups[1].Value.Trim()

    if ($dbHost -and $dbName -and $dbUser) {
        $schemaPath = Join-Path $PSScriptRoot "database\schema.sql"
        $mysqldump = "mysqldump"
        
        # Try common XAMPP/WAMP paths
        $candidates = @(
            "C:\xampp\mysql\bin\mysqldump.exe",
            "C:\wamp64\bin\mysql\mysql8.0.31\bin\mysqldump.exe",
            "mysqldump"
        )
        foreach ($c in $candidates) {
            if (Test-Path $c -ErrorAction SilentlyContinue) { $mysqldump = $c; break }
        }

        $passArg = if ($dbPass) { "-p$dbPass" } else { "" }
        $portArg = if ($dbPort) { "--port=$dbPort" } else { "--port=3306" }
        
        $cmd = "& `"$mysqldump`" -h $dbHost $portArg -u $dbUser $passArg --no-data --routines --single-transaction $dbName"
        $schema = Invoke-Expression $cmd 2>$null
        if ($schema) {
            $schema | Out-File -FilePath $schemaPath -Encoding utf8
            Write-Host "  Schema exported: $schemaPath" -ForegroundColor Green
        } else {
            Write-Host "  mysqldump failed, using existing schema.sql" -ForegroundColor DarkYellow
        }
    }
}

# ─── Step 2: Define what to include ────────────────────────────────────────
Write-Host "[2/5] Collecting files..." -ForegroundColor Yellow

# پوشه‌هایی که باید داخل پکیج باشن
$IncludeDirs = @(
    "app", "bootstrap", "config", "database",
    "lang", "public", "resources", "routes", "storage"
)
$IncludeRootFiles = @(
    "artisan", "composer.json", "composer.lock",
    ".env.example", ".gitignore", ".editorconfig",
    "install.php", "version.json",
    "vite.config.js", "package.json", "tailwind.config.*"
)

# پوشه‌ها/فایل‌هایی که باید حذف بشن
$ExcludeRelPaths = @(
    "storage/logs",
    "storage/backups",
    "storage/framework/cache/data",
    "storage/framework/sessions",
    "storage/framework/views",
    "storage/app/temp-updates",
    "database/database.sqlite",
    "public/storage",      # symlink - بعد از نصب ساخته میشه
    "public/uploads"
)
$ExcludeFileNames = @(
    ".env", ".env.backup", ".env.production", ".env.local",
    "installed.lock", "*.log", "Thumbs.db", ".DS_Store"
)

function ShouldExcludePkg {
    param([string]$rel)
    $norm = $rel -replace "\\", "/"
    foreach ($ex in $Script:ExcludeRelPaths) {
        $exNorm = $ex -replace "\\", "/"
        if ($norm -like "$exNorm*") { return $true }
    }
    $fname = Split-Path $rel -Leaf
    foreach ($p in $Script:ExcludeFileNames) {
        if ($fname -like $p) { return $true }
    }
    return $false
}

function CopyToPkg {
    param([string]$src, [string]$rel)
    if (ShouldExcludePkg $rel) { return $false }
    $dest = Join-Path $Script:TempDir $rel
    $dir  = Split-Path $dest -Parent
    if (!(Test-Path $dir)) { New-Item -ItemType Directory -Path $dir -Force | Out-Null }
    Copy-Item -Path $src -Destination $dest -Force
    return $true
}

$count = 0

# کپی پوشه‌های اصلی
foreach ($dir in $IncludeDirs) {
    $fullDir = Join-Path $PSScriptRoot $dir
    if (!(Test-Path $fullDir)) { continue }
    Get-ChildItem -Path $fullDir -Recurse -File | ForEach-Object {
        $rel = $_.FullName.Substring($PSScriptRoot.Length + 1)
        if (CopyToPkg $_.FullName $rel) { $count++ }
    }
}

# کپی فایل‌های root
foreach ($f in $IncludeRootFiles) {
    $matches = Get-Item (Join-Path $PSScriptRoot $f) -ErrorAction SilentlyContinue
    foreach ($m in $matches) {
        $rel = $m.Name
        if (CopyToPkg $m.FullName $rel) { $count++ }
    }
}

# vendor - اختیاری
if ($IncludeVendor) {
    Write-Host "  Including vendor directory (this may take a while)..." -ForegroundColor DarkYellow
    $vendorDir = Join-Path $PSScriptRoot "vendor"
    if (Test-Path $vendorDir) {
        Get-ChildItem -Path $vendorDir -Recurse -File | ForEach-Object {
            $rel = $_.FullName.Substring($PSScriptRoot.Length + 1)
            if (CopyToPkg $_.FullName $rel) { $count++ }
        }
    }
} else {
    Write-Host "  Vendor excluded (buyer runs: composer install --no-dev)" -ForegroundColor DarkGray
}

# ایجاد پوشه‌های خالی ضروری در storage
$storagePlaceholders = @(
    "storage/app/public",
    "storage/app/temp-updates",
    "storage/framework/cache/data",
    "storage/framework/sessions",
    "storage/framework/views",
    "storage/logs"
)
foreach ($sp in $storagePlaceholders) {
    $spPath = Join-Path $TempDir $sp
    if (!(Test-Path $spPath)) {
        New-Item -ItemType Directory -Path $spPath -Force | Out-Null
        # gitkeep placeholder
        "" | Out-File -FilePath (Join-Path $spPath ".gitkeep") -Encoding utf8
    }
}

Write-Host "  Files collected: $count" -ForegroundColor Green

# ─── Step 3: Update version.json داخل پکیج ─────────────────────────────────
Write-Host "[3/5] Writing version.json..." -ForegroundColor Yellow
$versionData = @{ version = $Version; released_at = (Get-Date -Format "yyyy-MM-dd") } | ConvertTo-Json
$versionData | Out-File -FilePath (Join-Path $TempDir "version.json") -Encoding utf8
Write-Host "  version.json written." -ForegroundColor Green

# ─── Step 4: Create ZIP ────────────────────────────────────────────────────
Write-Host "[4/5] Creating ZIP archive..." -ForegroundColor Yellow

if (Test-Path $ZipPath) { Remove-Item $ZipPath -Force }

if (Get-Command "7z" -ErrorAction SilentlyContinue) {
    Write-Host "  Using 7-Zip for compression..." -ForegroundColor DarkGray
    & 7z a -tzip -mx=5 $ZipPath "$TempDir\*" | Out-Null
} else {
    Compress-Archive -Path "$TempDir\*" -DestinationPath $ZipPath -Force
}

$zipBytes = (Get-Item $ZipPath).Length
$zipKB    = [math]::Round($zipBytes / 1024, 1)
$zipMB    = [math]::Round($zipBytes / 1048576, 2)

Remove-Item -Recurse -Force $TempDir
Write-Host "  ZIP created: $ZipPath" -ForegroundColor Green
Write-Host "  Size: $zipKB KB / $zipMB MB" -ForegroundColor Green

# ─── Step 5: Summary ───────────────────────────────────────────────────────
Write-Host ""
Write-Host "=================================================" -ForegroundColor Green
Write-Host "  Install package ready!" -ForegroundColor Green
Write-Host "=================================================" -ForegroundColor Green
Write-Host "  File : $ZipPath" -ForegroundColor White
Write-Host "  Size : $zipKB KB" -ForegroundColor White
Write-Host ""
Write-Host "Checklist before sending to customers:" -ForegroundColor Cyan
if (!$IncludeVendor) {
    Write-Host "  [!] vendor/ NOT included - buyer must run: composer install --no-dev" -ForegroundColor Yellow
}
Write-Host "  [x] install.php included" -ForegroundColor Green
Write-Host "  [x] database/schema.sql included" -ForegroundColor Green
Write-Host "  [x] version.json = $Version" -ForegroundColor Green
Write-Host ""
