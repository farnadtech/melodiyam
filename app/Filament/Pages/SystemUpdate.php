<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use ZipArchive;

class SystemUpdate extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrow-path';
    protected static string | \UnitEnum | null $navigationGroup = 'تنظیمات سیستم';
    protected static ?string $title = 'آپدیت سیستم';
    protected static ?string $navigationLabel = 'آپدیت سیستم';
    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.pages.system-update';

    const UPDATE_SERVER = 'https://iranbooklet.ir/melodiyam'; // آدرس سرور آپدیت

    public $currentVersion;
    public $serverVersion;
    public $hasUpdate = false;
    public $changelog = '';
    public $isDownloading = false;
    public $backups = [];

    public function mount()
    {
        $this->currentVersion = $this->getCurrentVersion();
        $this->checkUpdate();
        $this->loadBackups();
    }

    public function getCurrentVersion()
    {
        $path = base_path('version.json');
        if (!File::exists($path)) {
            return '1.0.0';
        }
        $data = json_decode(File::get($path), true);
        return $data['version'] ?? '1.0.0';
    }

    public function checkUpdate()
    {
        try {
            $response = Http::timeout(10)->get(self::UPDATE_SERVER . '/version.json');
            if ($response->successful()) {
                $data = $response->json();
                $this->serverVersion = $data['version'];
                $this->changelog = $data['changelog'] ?? '';
                $this->hasUpdate = version_compare($this->serverVersion, $this->currentVersion, '>');
            }
        } catch (\Exception $e) {
            Log::error("Failed to check update: " . $e->getMessage());
        }
    }

    public function loadBackups()
    {
        $path = storage_path('backups');
        if (File::exists($path)) {
            $this->backups = collect(File::directories($path))
                ->map(fn($dir) => [
                    'name' => basename($dir),
                    'path' => $dir,
                    'date' => date('Y-m-d H:i:s', File::lastModified($dir))
                ])
                ->sortByDesc('date')
                ->values()
                ->toArray();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('check_now')
                ->label('بررسی مجدد')
                ->color('gray')
                ->action('checkUpdate'),
        ];
    }

    public function runUpdate()
    {
        try {
            $response = Http::timeout(10)->get(self::UPDATE_SERVER . '/version.json');
            if (!$response->successful()) {
                throw new \Exception("خطا در ارتباط با سرور آپدیت");
            }

            $meta = $response->json();
            $downloadUrl = $meta['download_url'];
            $newVersion = $meta['version'];

            // 1. Download ZIP
            $zipContent = Http::timeout(120)->get($downloadUrl)->body();
            $zipPath = storage_path('app/update.zip');
            File::put($zipPath, $zipContent);

            // 2. Read Manifest from ZIP
            $zip = new ZipArchive();
            if ($zip->open($zipPath) !== TRUE) {
                throw new \Exception("فایل آپدیت معتبر نیست");
            }
            $manifestContent = $zip->getFromName('manifest.json');
            $manifest = json_decode($manifestContent, true);
            $zip->close();

            // 3. Apply Update
            $this->applyUpdate($zipPath, $newVersion, $manifest);

            Notification::make()
                ->title('آپدیت با موفقیت انجام شد')
                ->success()
                ->send();

            return redirect()->to(request()->header('Referer'));

        } catch (\Exception $e) {
            Log::error("Update failed: " . $e->getMessage());
            Notification::make()
                ->title('خطا در آپدیت')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    private function applyUpdate($zipPath, $newVersion, $manifest)
    {
        // 1. Create Backup
        $backupName = "backup-v{$this->currentVersion}-" . date('Ymd-His');
        $this->createBackup($backupName, $manifest['files'] ?? []);

        // 2. Extract ZIP
        $zip = new ZipArchive();
        if ($zip->open($zipPath) === TRUE) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $name = $zip->getNameIndex($i);
                if (str_contains($name, '..') || str_starts_with($name, '/')) continue;
                
                $target = base_path($name);
                if ($zip->getNameIndex($i) === 'manifest.json') continue;

                if (!File::isDirectory(dirname($target))) {
                    File::makeDirectory(dirname($target), 0755, true);
                }
                
                if (!$zip->extractTo(base_path(), $name)) {
                    Log::warning("Failed to extract: $name");
                }
            }
            $zip->close();
        }

        // 3. Clean BOM and Fixes
        $this->removeBomFromPhpFiles();

        // 4. Database Migrations
        $this->runMigrations();

        // 5. Clear Cache
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');

        // 6. Update version.json
        File::put(base_path('version.json'), json_encode([
            'version' => $newVersion,
            'released_at' => now()->toDateString(),
        ], JSON_PRETTY_PRINT));

        @unlink($zipPath);
    }

    private function createBackup($name, $files)
    {
        $backupDir = storage_path("backups/$name");
        File::makeDirectory($backupDir, 0755, true);

        // Backup files
        foreach ($files as $file) {
            $source = base_path($file);
            $dest = $backupDir . '/' . $file;
            if (File::exists($source)) {
                if (!File::isDirectory(dirname($dest))) {
                    File::makeDirectory(dirname($dest), 0755, true);
                }
                File::copy($source, $dest);
            }
        }

        // Backup database
        $this->backupDatabase($backupDir . '/database.sql');
        
        // Keep last 5 backups
        $this->pruneBackups(5);
    }

    private function backupDatabase($path)
    {
        $tables = DB::select('SHOW TABLES');
        $sql = "";
        $dbName = config('database.connections.mysql.database');
        $key = "Tables_in_" . $dbName;

        foreach ($tables as $tableObj) {
            $table = $tableObj->$key;
            $createTable = DB::select("SHOW CREATE TABLE `{$table}`")[0]->{'Create Table'};
            $sql .= "\n\n" . $createTable . ";\n\n";
            
            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $rowArray = (array)$row;
                $keys = array_keys($rowArray);
                $values = array_values($rowArray);
                $sql .= "INSERT INTO `{$table}` (`" . implode("`, `", $keys) . "`) VALUES (" . implode(", ", array_map(fn($v) => is_null($v) ? 'NULL' : "'" . addslashes($v) . "'", $values)) . ");\n";
            }
        }
        File::put($path, $sql);
    }

    private function pruneBackups($keep)
    {
        $path = storage_path('backups');
        $dirs = collect(File::directories($path))
            ->sortByDesc(fn($dir) => File::lastModified($dir));
        
        if ($dirs->count() > $keep) {
            $dirs->slice($keep)->each(fn($dir) => File::deleteDirectory($dir));
        }
    }

    private function runMigrations()
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        } catch (\Exception $e) {
            Log::error("Migration failed: " . $e->getMessage());
        }
    }

    private function removeBomFromPhpFiles()
    {
        // Placeholder for BOM removal logic if needed
    }

    public function rollback($name)
    {
        try {
            $backupDir = storage_path("backups/$name");
            if (!File::exists($backupDir)) throw new \Exception("بکاپ یافت نشد");

            // Restore files
            $files = File::allFiles($backupDir);
            foreach ($files as $file) {
                if ($file->getFilename() === 'database.sql') continue;
                $relativePath = str_replace($backupDir . DIRECTORY_SEPARATOR, '', $file->getRealPath());
                $target = base_path($relativePath);
                if (!File::isDirectory(dirname($target))) {
                    File::makeDirectory(dirname($target), 0755, true);
                }
                File::copy($file->getRealPath(), $target);
            }

            // Restore DB
            if (File::exists($backupDir . '/database.sql')) {
                DB::unprepared(File::get($backupDir . '/database.sql'));
            }

            Notification::make()
                ->title('بازگردانی با موفقیت انجام شد')
                ->success()
                ->send();

            return redirect()->to(request()->header('Referer'));

        } catch (\Exception $e) {
            Log::error("Rollback failed: " . $e->getMessage());
            Notification::make()
                ->title('خطا در بازگردانی')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
