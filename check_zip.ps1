Add-Type -Assembly System.IO.Compression.FileSystem
$z=[System.IO.Compression.ZipFile]::OpenRead("c:\xampp\htdocs\melodiyam\dist\melodiyam-v1.2.3.zip")
$found = $z.Entries.FullName | Where-Object {$_ -like "public/build/*"}
if ($found) { $found } else { "NOT FOUND - public/build is missing from zip!" }
$z.Dispose()
