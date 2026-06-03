param(
    [Parameter(Mandatory=$true)]  [string]$Version,
    [Parameter(Mandatory=$false)] [string]$FromTag = "",
    [Parameter(Mandatory=$false)] [ValidateSet("full","diff","custom")] [string]$Mode = "full"
)

Set-Location $PSScriptRoot

$OutputDir   = Join-Path $PSScriptRoot "dist"
$TempDir     = Join-Path $env:TEMP "melodiyam_update_$Version"
$ZipPath     = Join-Path $OutputDir "update-v$Version.zip"
$ManifestOut = Join-Path $OutputDir "update-v$Version.manifest.json"
$VersionOut  = Join-Path $OutputDir "version.json"

$ExcludeDirs = @(
    "vendor", "node_modules", "storage", "dist", ".git",
    "public\storage", "public\uploads", ".kilo", ".kiro",
    "tests", "__pycache__"
)
$ExcludeFiles = @(
    ".env", ".env.backup", ".env.production",
    "*.log", "*.lock", "package-lock.json",
    "build-update.ps1"
)

$CoreDirs = @(
    "app", "bootstrap", "config", "database",
    "lang", "resources", "routes", "public"
)
$CoreFiles = @(
    "artisan", "composer.json", ".env.example",
    ".gitignore", ".editorconfig"
)

if (!(Test-Path $OutputDir)) { New-Item -ItemType Directory -Path $OutputDir | Out-Null }
if (Test-Path $TempDir)      { Remove-Item -Recurse -Force $TempDir }
New-Item -ItemType Directory -Path $TempDir | Out-Null

Write-Host ""
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host "  Melodiyam Update Package Builder" -ForegroundColor Cyan
Write-Host "  Version: $Version  |  Mode: $Mode" -ForegroundColor Cyan
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host ""

function ShouldExclude {
    param([string]$relativePath)
    $normalized = $relativePath -replace "\\", "/"
    foreach ($dir in $Script:ExcludeDirs) {
        if ($normalized -like "$dir/*" -or $normalized -eq $dir) { return $true }
    }
    $fileName = Split-Path $relativePath -Leaf
    foreach ($pattern in $Script:ExcludeFiles) {
        if ($fileName -like $pattern) { return $true }
    }
    return $false
}

function CopyFile {
    param([string]$src, [string]$rel)
    $dest    = Join-Path $Script:TempDir $rel
    $destDir = Split-Path $dest -Parent
    if (!(Test-Path $destDir)) {
        New-Item -ItemType Directory -Path $destDir -Force | Out-Null
    }
    Copy-Item -Path $src -Destination $dest -Force
}

$FilesToInclude = @()
$MigrationFiles = @()
$DeletedFiles   = @()

# ---------- FULL ----------
if ($Mode -eq "full") {
    Write-Host "[1/5] Mode: FULL - collecting all project files..." -ForegroundColor Yellow

    foreach ($dir in $CoreDirs) {
        $fullDir = Join-Path $PSScriptRoot $dir
        if (!(Test-Path $fullDir)) { continue }
        Get-ChildItem -Path $fullDir -Recurse -File | ForEach-Object {
            $rel = $_.FullName.Substring($PSScriptRoot.Length + 1)
            if (-not (ShouldExclude $rel)) {
                $FilesToInclude += $rel
                if ($rel -match "^database[/\\]migrations[/\\].*\.php$") {
                    $MigrationFiles += $rel
                }
            }
        }
    }

    foreach ($f in $CoreFiles) {
        $fullPath = Join-Path $PSScriptRoot $f
        if (Test-Path $fullPath) {
            $FilesToInclude += $f
        }
    }

    if (Test-Path (Join-Path $PSScriptRoot "version.json")) {
        if ($FilesToInclude -notcontains "version.json") {
            $FilesToInclude += "version.json"
        }
    }
}
# ---------- DIFF ----------
elseif ($Mode -eq "diff") {
    if (!$FromTag) {
        Write-Host "ERROR: -FromTag is required for diff mode." -ForegroundColor Red
        exit 1
    }

    $TagCheck = git tag -l "$FromTag" 2>$null
    if (!$TagCheck) {
        Write-Host "ERROR: git tag '$FromTag' not found." -ForegroundColor Red
        git tag -l
        exit 1
    }

    Write-Host "[1/5] Mode: DIFF from $FromTag to HEAD..." -ForegroundColor Yellow
    $ChangedFiles = git diff --name-only "$FromTag" HEAD 2>$null
    $DeletedFiles = git diff --name-only --diff-filter=D "$FromTag" HEAD 2>$null

    foreach ($file in $ChangedFiles) {
        if (ShouldExclude $file) { continue }
        if (!(Test-Path (Join-Path $PSScriptRoot $file))) { continue }
        $FilesToInclude += $file
        if ($file -match "^database/migrations/.*\.php$") {
            $MigrationFiles += $file
        }
    }

    if ($FilesToInclude -notcontains "version.json") {
        $FilesToInclude += "version.json"
    }
}
# ---------- CUSTOM ----------
elseif ($Mode -eq "custom") {
    $customListFile = Join-Path $PSScriptRoot "custom-files.txt"
    if (!(Test-Path $customListFile)) {
        Write-Host "ERROR: custom-files.txt not found." -ForegroundColor Red
        exit 1
    }
    $customFiles = Get-Content $customListFile | Where-Object { $_ -notmatch "^\s*#" -and $_.Trim() -ne "" }
    foreach ($f in $customFiles) {
        $full = Join-Path $PSScriptRoot $f.Trim()
        if (Test-Path $full) {
            $FilesToInclude += $f.Trim()
        }
    }
}

$FilesToInclude = $FilesToInclude | Sort-Object -Unique
$totalFiles     = $FilesToInclude.Count
Write-Host "  Files collected: $totalFiles" -ForegroundColor Green
Write-Host ""

# ---------- manifest ----------
Write-Host "[2/5] Building manifest.json..." -ForegroundColor Yellow

$changelog = "Update to version $Version"
if ($FromTag) {
    $gitLog = git log "$FromTag..HEAD" --oneline 2>$null
    if ($gitLog) {
        $changelog = ($gitLog | ForEach-Object { "- $_" }) -join "`n"
    }
}

$fromVerValue = if ($FromTag) { $FromTag } else { "any" }

$manifest = [ordered]@{
    version      = $Version
    from_version = $fromVerValue
    released_at  = (Get-Date -Format "yyyy-MM-dd")
    mode         = $Mode
    files        = $FilesToInclude
    migrations   = $MigrationFiles
    delete       = $DeletedFiles
}

$manifestJson = $manifest | ConvertTo-Json -Depth 10
$manifestJson | Out-File -FilePath $ManifestOut -Encoding utf8
Write-Host "  Manifest saved: $ManifestOut" -ForegroundColor Green

# ---------- copy files ----------
Write-Host "[3/5] Copying files to temp dir..." -ForegroundColor Yellow
$copied  = 0
$skipped = 0

foreach ($file in $FilesToInclude) {
    $src = Join-Path $PSScriptRoot $file
    if (Test-Path $src) {
        CopyFile $src $file
        $copied++
    } else {
        Write-Host "  WARNING: not found - $file" -ForegroundColor DarkYellow
        $skipped++
    }
}

$manifestJson | Out-File -FilePath (Join-Path $TempDir "manifest.json") -Encoding utf8
Write-Host "  Copied: $copied  |  Not found: $skipped" -ForegroundColor Green

# ---------- ZIP ----------
Write-Host "[4/5] Creating ZIP archive..." -ForegroundColor Yellow

if (Test-Path $ZipPath) { Remove-Item $ZipPath -Force }
Compress-Archive -Path "$TempDir\*" -DestinationPath $ZipPath -Force

$zipBytes  = (Get-Item $ZipPath).Length
$zipKB     = [math]::Round($zipBytes / 1024, 1)
$zipMB     = [math]::Round($zipBytes / 1048576, 2)

Remove-Item -Recurse -Force $TempDir

Write-Host "  ZIP created: $ZipPath" -ForegroundColor Green
Write-Host "  Size: $zipKB KB / $zipMB MB  |  $totalFiles files" -ForegroundColor Green

# ---------- version.json for server ----------
Write-Host "[5/5] Building server version.json..." -ForegroundColor Yellow

$serverMeta = [ordered]@{
    version      = $Version
    min_version  = "1.0.0"
    changelog    = $changelog
    released_at  = (Get-Date -Format "yyyy-MM-dd")
    download_url = "https://iranbooklet.ir/melodiyam/update-v$Version.zip"
    manifest_url = "https://iranbooklet.ir/melodiyam/update-v$Version.manifest.json"
}
$serverMeta | ConvertTo-Json | Out-File -FilePath $VersionOut -Encoding utf8
Write-Host "  version.json saved: $VersionOut" -ForegroundColor Green

# ---------- summary ----------
Write-Host ""
Write-Host "=================================================" -ForegroundColor Green
Write-Host "  Done! Package built successfully." -ForegroundColor Green
Write-Host "=================================================" -ForegroundColor Green
Write-Host "  ZIP   : $ZipPath" -ForegroundColor White
Write-Host "  Size  : $zipKB KB" -ForegroundColor White
Write-Host "  Files : $totalFiles" -ForegroundColor White
Write-Host ""
Write-Host "Next steps - upload these to server:" -ForegroundColor Cyan
Write-Host "  dist\update-v$Version.zip" -ForegroundColor Gray
Write-Host "  dist\version.json  (as version.json on server)" -ForegroundColor Gray
Write-Host "  Server: https://iranbooklet.ir/melodiyam/" -ForegroundColor White
Write-Host ""
