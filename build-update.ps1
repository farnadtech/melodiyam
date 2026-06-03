param(
    [Parameter(Mandatory=$true)]  [string]$Version,
    [Parameter(Mandatory=$false)] [string]$UpdateServerUrl = 'https://iranbooklet.ir/melodiyam',
    [Parameter(Mandatory=$false)] [string]$Changelog = ''
)

Set-Location $PSScriptRoot

$OutputDir  = Join-Path $PSScriptRoot "dist"
$TempUpdate = Join-Path $env:TEMP "melodiyam_upd_$Version"
$UpdateZip  = Join-Path $OutputDir "melodiyam-v$Version-update.zip"

if (!(Test-Path $OutputDir)) { New-Item -ItemType Directory -Path $OutputDir | Out-Null }
if (Test-Path $TempUpdate)   { Remove-Item -Recurse -Force $TempUpdate }
New-Item -ItemType Directory -Path $TempUpdate | Out-Null

Write-Host ""
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host "  Melodiyam Update Package Builder" -ForegroundColor Cyan
Write-Host "  Version: $Version" -ForegroundColor Cyan
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host ""

# ─── Step 1: Collect files ─────────────────────────────────────────────────
Write-Host "[1/4] Collecting files..." -ForegroundColor Yellow

$IncludeDirs = @("app","bootstrap","config","database","lang","public","resources","routes")
$IncludeRootFiles = @("artisan","composer.json","composer.lock",".env.example",".gitignore",".editorconfig","version.json","vite.config.js","package.json")

$ExcludeRelPaths = @(
    "storage/app/public","storage/app/private","storage/app/temp-updates",
    "storage/logs","storage/backups",
    "storage/framework/cache/data","storage/framework/sessions","storage/framework/views",
    "public/storage","public/uploads","database/database.sqlite"
)
$ExcludeFileNames = @(".env",".env.backup",".env.production",".env.local","installed.lock","*.log","Thumbs.db",".DS_Store","install.php")

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
$fileList = @()

foreach ($dir in $IncludeDirs) {
    $fullDir = Join-Path $PSScriptRoot $dir
    if (!(Test-Path $fullDir)) { continue }
    Get-ChildItem -Path $fullDir -Recurse -File | ForEach-Object {
        $rel = $_.FullName.Substring($PSScriptRoot.Length + 1)
        if (!(ShouldExclude $rel)) {
            CopyToDir $_.FullName $rel $TempUpdate
            $fileList += $rel.Replace("\", "/")
            $count++
        }
    }
}

foreach ($f in $IncludeRootFiles) {
    $fp = Join-Path $PSScriptRoot $f
    if (Test-Path $fp) {
        CopyToDir $fp $f $TempUpdate
        $fileList += $f
        $count++
    }
}

Write-Host "  Files collected: $count" -ForegroundColor Green

# ─── Step 2: version.json + manifest.json ──────────────────────────────────
Write-Host "[2/4] Writing version.json and manifest.json..." -ForegroundColor Yellow

$downloadUrl = "$UpdateServerUrl/melodiyam-v$Version-update.zip"

$versionObj = [ordered]@{
    version      = $Version
    released_at  = (Get-Date -Format "yyyy-MM-dd")
    download_url = $downloadUrl
    changelog    = $Changelog
}
$versionJson = $versionObj | ConvertTo-Json

$versionJson | Out-File -FilePath (Join-Path $TempUpdate "version.json") -Encoding utf8
$versionJson | Out-File -FilePath (Join-Path $PSScriptRoot "version.json") -Encoding utf8

$manifestObj = [ordered]@{ version = $Version; files = $fileList }
$manifestObj | ConvertTo-Json -Depth 3 | Out-File -FilePath (Join-Path $TempUpdate "manifest.json") -Encoding utf8

Write-Host "  version.json written (v$Version, download_url set)" -ForegroundColor Green
Write-Host "  manifest.json written ($($fileList.Count) files)" -ForegroundColor Green

# ─── Step 3: Create ZIP ────────────────────────────────────────────────────
Write-Host "[3/4] Creating update ZIP..." -ForegroundColor Yellow

if (Test-Path $UpdateZip) { Remove-Item $UpdateZip -Force }

if (Get-Command "7z" -ErrorAction SilentlyContinue) {
    & 7z a -tzip -mx=5 $UpdateZip "$TempUpdate\*" | Out-Null
} else {
    Compress-Archive -Path "$TempUpdate\*" -DestinationPath $UpdateZip -Force
}

$sizeMB = [math]::Round((Get-Item $UpdateZip).Length / 1MB, 2)
Write-Host "  $UpdateZip - $sizeMB MB" -ForegroundColor Green

Remove-Item -Recurse -Force $TempUpdate

# ─── Step 4: Git commit + tag ──────────────────────────────────────────────
Write-Host "[4/4] Git commit and tag..." -ForegroundColor Yellow

if (Get-Command "git" -ErrorAction SilentlyContinue) {
    git add -A
    git commit -m "release: v$Version"
    git tag -a "v$Version" -m "Version $Version"
    Write-Host "  Committed and tagged v$Version" -ForegroundColor Green
} else {
    Write-Host "  git not found, skipping." -ForegroundColor DarkYellow
}

# ─── Summary ───────────────────────────────────────────────────────────────
Write-Host ""
Write-Host "=================================================" -ForegroundColor Green
Write-Host "  Update package ready! v$Version" -ForegroundColor Green
Write-Host "=================================================" -ForegroundColor Green
Write-Host "  File: $UpdateZip" -ForegroundColor White
Write-Host "  Size: $sizeMB MB" -ForegroundColor White
Write-Host ""
Write-Host "  Next steps:" -ForegroundColor Cyan
Write-Host "  1. Upload $UpdateZip  ->  $UpdateServerUrl/melodiyam-v$Version-update.zip" -ForegroundColor White
Write-Host "  2. Upload version.json  ->  $UpdateServerUrl/version.json" -ForegroundColor White
Write-Host "  3. git push && git push --tags" -ForegroundColor White
Write-Host ""
