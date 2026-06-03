param(
    [Parameter(Mandatory=$true)] [string]$Version
)

$OutputDir = Join-Path $PSScriptRoot "dist"
if (!(Test-Path $OutputDir)) { New-Item -ItemType Directory -Path $OutputDir }

$ZipPath = Join-Path $OutputDir "melodiyam-v$Version.zip"

Write-Host "1. Refreshing database/schema.sql..." -ForegroundColor Cyan
c:\xampp\php\php.exe dump_schema.php

Write-Host "2. Building full package for version $Version..." -ForegroundColor Cyan

if (Test-Path $ZipPath) { Remove-Item $ZipPath }

# Exclude unnecessary files/folders for a clean install
$Excludes = @(
    ".git*",
    ".env",
    "node_modules",
    "storage/logs/*",
    "storage/framework/cache/data/*",
    "storage/framework/sessions/*",
    "storage/framework/views/*",
    "storage/backups/*",
    "dist/*",
    "dump_schema.php",
    "build-*.ps1",
    "phpunit.xml",
    "tests",
    "installed.lock"
)

# Using 7-Zip if available for better compression, otherwise use standard Compress-Archive
if (Get-Command 7z -ErrorAction SilentlyContinue) {
    Write-Host "Using 7-Zip for high compression..."
    $ExcludeParams = ""
    foreach ($ex in $Excludes) { $ExcludeParams += " -xr!$ex" }
    cmd /c "7z a -tzip $ZipPath . $ExcludeParams"
} else {
    Write-Host "7-Zip not found, using standard PowerShell compression (slower and larger)..."
    # PowerShell's Compress-Archive doesn't have an easy "exclude" flag, so we copy to temp then zip
    $TempDir = Join-Path $env:TEMP "melodiyam_build_$Version"
    if (Test-Path $TempDir) { Remove-Item -Recurse -Force $TempDir }
    New-Item -ItemType Directory -Path $TempDir
    
    Copy-Item -Path ".*", "*" -Destination $TempDir -Recurse -Exclude $Excludes
    Compress-Archive -Path "$TempDir\*" -DestinationPath $ZipPath -Force
    Remove-Item -Recurse -Force $TempDir
}

Write-Host "Full package created successfully at $ZipPath" -ForegroundColor Green

