param(
    [Parameter(Mandatory=$true)]  [string]$Version,
    [Parameter(Mandatory=$false)] [switch]$IncludeVendor = $false,
    [Parameter(Mandatory=$false)] [string]$UpdateServerUrl = 'https://iranbooklet.ir/melodiyam',
    [Parameter(Mandatory=$false)] [string]$Changelog = ''
)

Set-Location $PSScriptRoot

$OutputDir  = Join-Path $PSScriptRoot "dist"
$TempDir    = Join-Path $env:TEMP "melodiyam_pkg_$Version"
$TempUpdate = Join-Path $env:TEMP "melodiyam_upd_$Version"
$InstallZip = Join-Path $OutputDir "melodiyam-v$Version.zip"
$UpdateZip  = Join-Path $OutputDir "melodiyam-v$Version-update.zip"

if (!(Test-Path $OutputDir)) { New-Item -ItemType Directory -Path $OutputDir | Out-Null }
foreach ($d in ($TempDir, $TempUpdate)) {
    if (Test-Path $d) { Remove-Item -Recurse -Force $d }
    New-Item -ItemType Directory -Path $d | Out-Null
}

Write-Host ""
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host "  Melodiyam Package Builder" -ForegroundColor Cyan
Write-Host "  Version: $Version" -ForegroundColor Cyan
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host ""

# ─── Step 1: Export schema.sql ─────────────────────────────────────────────
Write-Host "[1/6] Exporting database schema..." -ForegroundColor Yellow

$envPath = Join-Path $PSScriptRoot ".env"
if (Test-Path $envPath) {
    $envContent = Get-Content $envPath
    $dbHost = ($envContent | Select-String "^DB_HOST=(.+)$").Matches.Groups[1].Value.Trim()
    $dbPort = ($envContent | Select-String "^DB_PORT=(.+)$").Matches.Groups[1].Value.Trim()
    $dbName = ($envContent | Select-String "^DB_DATABASE=(.+)$").Matches.Groups[1].Value.Trim()
    $dbUser = ($envContent | Select-String "^DB_USERNAME=(.+)$").Matches.Groups[1].Value.Trim()
    $dbPass = ($envContent | Select-String "^DB_PASSWORD=(.*)$").Matches.Groups[1].Value.Trim()

    if ($dbHost -and $dbName -and $dbUser) {
        $schemaPath = Join-Path $PSScriptRoot "database\schema.sql"
        $mysqldump = "mysqldump"
        foreach ($c in @("C:\xampp\mysql\bin\mysqldump.exe", "C:\wamp64\bin\mysql\mysql8.0.31\bin\mysqldump.exe")) {
            if (Test-Path $c -ErrorAction SilentlyContinue) { $mysqldump = $c; break }
        }
        $passArg = if ($dbPass) { "-p$dbPass" } else { "" }
        $portArg = if ($dbPort) { "--port=$dbPort" } else { "--port=3306" }
        $schema = Invoke-Expression "& `"$mysqldump`" -h $dbHost $portArg -u $dbUser $passArg --no-data --routines --single-transaction $dbName" 2>$null
        if ($schema) {
            $schema | Out-File -FilePath $schemaPath -Encoding utf8
            Write-Host "  Schema exported." -ForegroundColor Green
        } else {
            Write-Host "  mysqldump failed, using existing schema.sql" -ForegroundColor DarkYellow
        }
    }
} else {
    Write-Host "  WARNING: .env not found, schema export skipped." -ForegroundColor DarkYellow
}

# ─── Step 2: Collect files ─────────────────────────────────────────────────
Write-Host "[2/6] Collecting files..." -ForegroundColor Yellow

$IncludeDirs = @("app","bootstrap","config","database","lang","public","resources","routes","storage")
$IncludeRootFiles = @("artisan","composer.json","composer.lock",".env.example",".gitignore",".editorconfig","install.php","version.json","vite.config.js","package.json")

$ExcludeRelPaths = @(
    "storage/app/public","storage/app/private","storage/app/temp-updates",
    "storage/logs","storage/backups",
    "storage/framework/cache/data","storage/framework/sessions","storage/framework/views",
    "public/storage","public/uploads","database/database.sqlite"
)
$ExcludeFileNames = @(".env",".env.backup",".env.production",".env.local","installed.lock","*.log","Thumbs.db",".DS_Store")

function ShouldExclude([string]$rel) {
    $norm = $rel.Replace("\", "/")
    foreach ($ex in $ExcludeRelPaths) {
        if ($norm.StartsWith($ex)) { return $true }
    }
    $fname = [System.IO.Path]::GetFileName($rel)
    foreach ($p in $ExcludeFileNames) {
        if ($fname -like $p) { return $true }
    }
    return $false
}

function CopyToDir([string]$src, [string]$rel, [string]$destBase) {
    $target = Join-Path $destBase $rel
    $dir = [System.IO.Path]::GetDirectoryName($target)
    if (!(Test-Path $dir)) { New-Item -ItemType Directory -Path $dir -Force | Out-Null }
    Copy-Item -Path $src -Destination $target -Force
}

$count = 0
$updatedFiles = @()

foreach ($dir in $IncludeDirs) {
    $fullDir = Join-Path $PSScriptRoot $dir
    if (!(Test-Path $fullDir)) { continue }
    Get-ChildItem -Path $fullDir -Recurse -File | ForEach-Object {
        $rel = $_.FullName.Substring($PSScriptRoot.Length + 1)
        if (!(ShouldExclude $rel)) {
            CopyToDir $_.FullName $rel $TempDir
            CopyToDir $_.FullName $rel $TempUpdate
            $normRel = $rel.Replace("\", "/")
            $updatedFiles += $normRel
            $count++
        }
    }
}

foreach ($f in $IncludeRootFiles) {
    $fp = Join-Path $PSScriptRoot $f
    if (Test-Path $fp) {
        CopyToDir $fp $f $TempDir
        CopyToDir $fp $f $TempUpdate
        $updatedFiles += $f
        $count++
    }
}

if ($IncludeVendor) {
    Write-Host "  Including vendor..." -ForegroundColor DarkYellow
    $vendorDir = Join-Path $PSScriptRoot "vendor"
    if (Test-Path $vendorDir) {
        Get-ChildItem -Path $vendorDir -Recurse -File | ForEach-Object {
            $rel = $_.FullName.Substring($PSScriptRoot.Length + 1)
            if (!(ShouldExclude $rel)) {
                CopyToDir $_.FullName $rel $TempDir
                CopyToDir $_.FullName $rel $TempUpdate
                $normRel = $rel.Replace("\", "/")
                $updatedFiles += $normRel
                $count++
            }
        }
    }
}

# storage placeholders
foreach ($sp in @("storage/app/public","storage/app/temp-updates","storage/framework/cache/data","storage/framework/sessions","storage/framework/views","storage/logs")) {
    foreach ($base in ($TempDir, $TempUpdate)) {
        $spPath = Join-Path $base $sp
        if (!(Test-Path $spPath)) {
            New-Item -ItemType Directory -Path $spPath -Force | Out-Null
            "" | Out-File -FilePath (Join-Path $spPath ".gitkeep") -Encoding utf8
        }
    }
}

Write-Host "  Files collected: $count" -ForegroundColor Green

# ─── Step 3: version.json ──────────────────────────────────────────────────
Write-Host "[3/6] Writing version.json..." -ForegroundColor Yellow

$downloadUrl = "$UpdateServerUrl/melodiyam-v$Version-update.zip"
$versionObj = @{
    version      = $Version
    released_at  = (Get-Date -Format "yyyy-MM-dd")
    download_url = $downloadUrl
    changelog    = $Changelog
}
$versionJson = $versionObj | ConvertTo-Json

$versionJson | Out-File -FilePath (Join-Path $TempDir    "version.json") -Encoding utf8
$versionJson | Out-File -FilePath (Join-Path $TempUpdate "version.json") -Encoding utf8
$versionJson | Out-File -FilePath (Join-Path $PSScriptRoot "version.json") -Encoding utf8

Write-Host "  version.json written (v$Version)" -ForegroundColor Green

# ─── Step 4: manifest.json for update package ──────────────────────────────
Write-Host "[4/6] Writing update manifest.json..." -ForegroundColor Yellow

$manifestObj = @{ version = $Version; files = $updatedFiles }
$manifestJson = $manifestObj | ConvertTo-Json -Depth 3
$manifestJson | Out-File -FilePath (Join-Path $TempUpdate "manifest.json") -Encoding utf8

Write-Host "  manifest.json written ($($updatedFiles.Count) files)" -ForegroundColor Green

# ─── Step 5: Create ZIPs ───────────────────────────────────────────────────
Write-Host "[5/6] Creating ZIP archives..." -ForegroundColor Yellow

$zipTargets = @(
    @{ Src = $TempDir;    Out = $InstallZip; Label = "Install" }
    @{ Src = $TempUpdate; Out = $UpdateZip;  Label = "Update"  }
)

foreach ($t in $zipTargets) {
    if (Test-Path $t.Out) { Remove-Item $t.Out -Force }
    if (Get-Command "7z" -ErrorAction SilentlyContinue) {
        & 7z a -tzip -mx=5 $t.Out "$($t.Src)\*" | Out-Null
    } else {
        Compress-Archive -Path "$($t.Src)\*" -DestinationPath $t.Out -Force
    }
    $sizeMB = [math]::Round((Get-Item $t.Out).Length / 1MB, 2)
    Write-Host "  [$($t.Label)] $(Split-Path $t.Out -Leaf) - $sizeMB MB" -ForegroundColor Green
}

foreach ($d in ($TempDir, $TempUpdate)) {
    Remove-Item -Recurse -Force $d
}

# ─── Step 6: Git ───────────────────────────────────────────────────────────
Write-Host "[6/6] Git commit and tag..." -ForegroundColor Yellow

if (Get-Command "git" -ErrorAction SilentlyContinue) {
    git add -A 2>&1 | Out-Null
    git commit -m "release: v$Version" 2>&1
    git tag -a "v$Version" -m "Version $Version" 2>&1
    Write-Host "  Committed and tagged v$Version" -ForegroundColor Green
    Write-Host "  Run: git push && git push --tags" -ForegroundColor DarkGray
} else {
    Write-Host "  git not found, skipping." -ForegroundColor DarkYellow
}

# ─── Summary ───────────────────────────────────────────────────────────────
Write-Host ""
Write-Host "=================================================" -ForegroundColor Green
Write-Host "  Done! v$Version" -ForegroundColor Green
Write-Host "=================================================" -ForegroundColor Green
Write-Host "  Install : $InstallZip" -ForegroundColor White
Write-Host "  Update  : $UpdateZip" -ForegroundColor White
Write-Host ""
Write-Host "  Next steps:" -ForegroundColor Cyan
Write-Host "  1. Upload update zip  -> $UpdateServerUrl/melodiyam-v$Version-update.zip" -ForegroundColor White
Write-Host "  2. Upload version.json -> $UpdateServerUrl/version.json" -ForegroundColor White
Write-Host "  3. git push && git push --tags" -ForegroundColor White
Write-Host ""
