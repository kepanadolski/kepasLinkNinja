# Builds kepas-link-ninja.zip with FORWARD SLASHES in paths (so Linux/server extracts correctly).
# Run from project root: .\build-zip.ps1

$ErrorActionPreference = "Stop"
$rootDir = $PSScriptRoot
$folderName = "kepas-link-ninja"
$zipPath = Join-Path $rootDir "$folderName.zip"
$tempDir = Join-Path $rootDir $folderName

# Clean
if (Test-Path $tempDir) { Remove-Item -Recurse -Force $tempDir }
if (Test-Path $zipPath) { Remove-Item -Force $zipPath }

# Copy plugin files into temp folder
New-Item -ItemType Directory -Path $tempDir | Out-Null
Copy-Item (Join-Path $rootDir "kepas-link-ninja.php") $tempDir -Force
Copy-Item (Join-Path $rootDir "README.md") $tempDir -Force
Copy-Item (Join-Path $rootDir "admin") (Join-Path $tempDir "admin") -Recurse -Force
Copy-Item (Join-Path $rootDir "includes") (Join-Path $tempDir "includes") -Recurse -Force
Copy-Item (Join-Path $rootDir "public") (Join-Path $tempDir "public") -Recurse -Force

# Create zip using .NET with forward slashes in entry names
Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem
try {
    $zip = [System.IO.Compression.ZipFile]::Open($zipPath, [System.IO.Compression.ZipArchiveMode]::Create)
    $baseLen = (Resolve-Path $tempDir).Path.Length + 1
    Get-ChildItem -Path $tempDir -Recurse -File | ForEach-Object {
        $fullPath = $_.FullName
        $relativePath = $fullPath.Substring($baseLen)
        $entryName = "$folderName/" + $relativePath.Replace("\", "/")
        [void][System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile($zip, $fullPath, $entryName, [System.IO.Compression.CompressionLevel]::Optimal)
    }
} finally {
    if ($zip) { $zip.Dispose() }
}

# Clean temp folder
Remove-Item -Recurse -Force $tempDir

Write-Host "Created: $zipPath (paths use / for compatibility with Linux servers)"
