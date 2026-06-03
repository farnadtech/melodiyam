param(
    [Parameter(Mandatory=$true)] [string]$Version,
    [Parameter(Mandatory=$true)] [string]$FromTag
)

$OutputDir = Join-Path $PSScriptRoot "dist"
if (!(Test-Path $OutputDir)) { New-Item -ItemType Directory -Path $OutputDir }

$ZipPath = Join-Path $OutputDir "update-v$Version.zip"
$ManifestPath = Join-Path $OutputDir "update-v$Version.manifest.json"
$VersionFilePath = Join-Path $OutputDir "version.json"

Write-Host "Building update package for version $Version from tag $FromTag..." -ForegroundColor Cyan

# 1. Get changed files
$ChangedFiles = git diff --name-only "$FromTag" HEAD
$DeletedFiles = git diff --name-only --diff-filter=D "$FromTag" HEAD

$FilesToInclude = @()
$MigrationFiles = @()

foreach ($file in $ChangedFiles) {
    if ($file -match "^(vendor|storage|node_modules|dist|\.env|public/storage)") { continue }
    if (!(Test-Path $file)) { continue }
    
    $FilesToInclude += $file
    if ($file -match "^database/migrations/.*\.php$") {
        $MigrationFiles += $file
    }
}

# 2. Create manifest
$manifest = [ordered]@{
    version = $Version
    from_version = $FromTag
    released_at = (Get-Date -Format "yyyy-MM-dd")
    files = $FilesToInclude
    migrations = $MigrationFiles
    delete = $DeletedFiles
}

$manifest | ConvertTo-Json -Depth 10 | Out-File -FilePath $ManifestPath -Encoding utf8

# 3. Create ZIP
if (Test-Path $ZipPath) { Remove-Item $ZipPath }
Add-Type -AssemblyName System.IO.Compression
$zip = [System.IO.Compression.ZipFile]::Open($ZipPath, 'Create')

foreach ($file in $FilesToInclude) {
    $entryName = $file.Replace("\", "/")
    [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile($zip, (Join-Path $PSScriptRoot $file), $entryName)
}
# Add manifest to zip as well
[System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile($zip, $ManifestPath, "manifest.json")
$zip.Dispose()

# 4. Create version.json for server
$serverVersion = [ordered]@{
    version = $Version
    min_version = "1.0.0"
    changelog = "Update to version $Version"
    released_at = (Get-Date -Format "yyyy-MM-dd")
    download_url = "https://iranbooklet.ir/melodiyam/update-v$Version.zip"
    manifest_url = "https://iranbooklet.ir/melodiyam/update-v$Version.manifest.json"
}
$serverVersion | ConvertTo-Json | Out-File -FilePath $VersionFilePath -Encoding utf8

Write-Host "Update package created successfully at $ZipPath" -ForegroundColor Green
