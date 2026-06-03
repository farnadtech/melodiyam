<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Livewire\WithFileUploads;

class SystemUpdate extends Page implements HasForms
{
    use InteractsWithForms;
    use WithFileUploads;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrow-path';
    protected static string | \UnitEnum | null $navigationGroup = 'تنظیمات سیستم';
    protected static ?string $title = 'آپدیت سیستم';
    protected static ?string $navigationLabel = 'آپدیت سیستم';
    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.pages.system-update';

    const UPDATE_SERVER = 'https://iranbooklet.ir/melodiyam';

    public ?string $currentVersion = '1.0.0';
    public ?string $serverVersion = '---';
    public bool $hasUpdate = false;
    public ?string $changelog = '';
    public ?string $errorDebug = null;
    
    // UI States
    public bool $isProcessing = false;
    public ?string $processMessage = '';
    public int $currentStep = 0; 
    
    // Manual Update
    public ?array $data = [];

    public function mount()
    {
        $this->currentVersion = $this->getCurrentVersion();
        $this->checkUpdate();
        $this->form->fill();
    }

    public function form($form)
    {
        return $form
            ->schema([
                FileUpload::make('manual_file')
                    ->label('فایل ZIP آپدیت را انتخاب کنید')
                    ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed', 'application/x-compressed', 'application/octet-stream'])
                    ->disk('local')
                    ->directory('temp-updates')
                    ->visibility('private')
                    ->maxSize(51200) // 50MB max
                    ->required()
                    ->helperText('فقط فایل‌های ZIP با حداکثر حجم 50 مگابایت')
            ])
            ->statePath('data');
    }

    public function getCurrentVersion()
    {
        // پاکسازی کش فایل برای اطمینان از خواندن مقدار واقعی از دیسک
        clearstatcache(true, base_path('version.json'));
        
        try {
            $path = base_path('version.json');
            if (File::exists($path)) {
                $content = File::get($path);
                // حذف کاراکترهای مخفی احتمالی و BOM
                $content = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $content);
                $data = json_decode(trim($content), true);
                if (is_array($data) && isset($data['version'])) {
                    return trim((string)$data['version']);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error reading version.json: " . $e->getMessage());
        }
        return '1.0.0';
    }

    public function checkUpdate()
    {
        $this->errorDebug = null;
        try {
            $url = self::UPDATE_SERVER . '/version.json?t=' . time();
            
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'application/json'
                ])
                ->timeout(10)
                ->get($url);

            $content = $response->body();
            $content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
            $content = trim($content);
            $data = json_decode($content, true);

            if (is_array($data) && isset($data['version'])) {
                $this->serverVersion = (string)$data['version'];
                $this->changelog = (string)($data['changelog'] ?? '');
                
                $current = trim((string)$this->currentVersion, 'v');
                $server = trim((string)$this->serverVersion, 'v');
                
                $this->hasUpdate = version_compare($server, $current, '>');
            } else {
                $this->serverVersion = 'نامعتبر';
                $this->errorDebug = "پاسخ سرور JSON معتبر نیست.";
            }
        } catch (\Exception $e) {
            $this->serverVersion = 'خطا';
            $this->errorDebug = $e->getMessage();
        }
    }

    public function runUpdate()
    {
        $this->isProcessing = true;
        $this->currentStep = 1;
        $this->processMessage = 'در حال دریافت اطلاعات از سرور...';
        $this->dispatch('update-step', step: 1);

        try {
            $url = self::UPDATE_SERVER . '/version.json?t=' . time();
            $response = Http::withoutVerifying()->timeout(15)->get($url);
            if (!$response->successful()) throw new \Exception("خطا در ارتباط با سرور آپدیت");

            $content = $response->body();
            $content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
            $meta = json_decode(trim($content), true);

            if (!is_array($meta) || !isset($meta['download_url'])) throw new \Exception("اطلاعات آپدیت ناقص است.");

            $downloadUrl = $meta['download_url'];
            $newVersion = $meta['version'];

            $this->currentStep = 2;
            $this->processMessage = 'در حال دانلود فایل آپدیت...';
            $this->dispatch('update-step', step: 2);

            $zipResponse = Http::withoutVerifying()->timeout(120)->get($downloadUrl);
            if (!$zipResponse->successful()) throw new \Exception("خطا در دانلود فایل آپدیت");

            $zipPath = storage_path('app/update.zip');
            File::put($zipPath, $zipResponse->body());

            $this->processUpdate($zipPath, $newVersion);

            $this->currentStep = 4;
            $this->dispatch('update-step', step: 5);

            Notification::make()
                ->title('آپدیت با موفقیت انجام شد ✅')
                ->body('سیستم به نسخه ' . $newVersion . ' بروزرسانی شد.')
                ->success()
                ->send();

            return redirect()->to(request()->header('Referer') ?? '/admin');

        } catch (\Exception $e) {
            $this->isProcessing = false;
            $this->currentStep = 0;
            $this->dispatch('update-step', step: 0);
            Notification::make()
                ->title('خطا در بروزرسانی')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function uploadManualUpdate()
    {
        $data = $this->form->getState();
        $this->isProcessing = true;
        $this->currentStep = 1;
        $this->processMessage = 'در حال پردازش فایل آپلودی...';
        $this->dispatch('update-step', step: 1);

        try {
            $relativePath = $data['manual_file'];

            if (!Storage::disk('local')->exists($relativePath)) {
                throw new \Exception("فایل آپلود شده در دیسک محلی یافت نشد.");
            }

            $zipPath = Storage::disk('local')->path($relativePath);

            $zip = new ZipArchive();
            if ($zip->open($zipPath) === TRUE) {
                $manifestContent = $zip->getFromName('manifest.json');
                if ($manifestContent) {
                    $manifestContent = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $manifestContent);
                    $manifest = json_decode(trim($manifestContent), true);
                    $newVersion = $manifest['version'] ?? $this->serverVersion;
                } else {
                    $newVersion = $this->serverVersion;
                }
                $zip->close();

                $this->currentStep = 2;
                $this->dispatch('update-step', step: 2);

                $this->processUpdate($zipPath, $newVersion);

                // پاکسازی فایل آپلود شده
                Storage::disk('local')->delete($relativePath);

                $this->currentStep = 4;
                $this->dispatch('update-step', step: 5);

                Notification::make()
                    ->title('آپدیت دستی با موفقیت انجام شد ✅')
                    ->body('سیستم به نسخه ' . $newVersion . ' بروزرسانی شد.')
                    ->success()
                    ->send();

                return redirect()->to(request()->header('Referer') ?? '/admin');

            } else {
                throw new \Exception("فایل ZIP معتبر نیست یا قابل باز شدن نیست.");
            }
        } catch (\Exception $e) {
            $this->isProcessing = false;
            $this->currentStep = 0;
            $this->dispatch('update-step', step: 0);
            Notification::make()
                ->title('خطا در آپدیت دستی')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    private function processUpdate($zipPath, $newVersion)
    {
        $this->currentStep = 3;
        $this->processMessage = 'در حال ایجاد نسخه پشتیبان و جایگزینی فایل‌ها...';
        $this->dispatch('update-step', step: 3);

        $zip = new ZipArchive();
        if ($zip->open($zipPath) === TRUE) {
            $manifestContent = $zip->getFromName('manifest.json');
            $manifest = json_decode($manifestContent, true);

            if (!$newVersion && isset($manifest['version'])) {
                $newVersion = $manifest['version'];
            }

            $backupName = "backup-v{$this->currentVersion}-" . date('Ymd-His');
            $filesToBackup = is_array($manifest) ? ($manifest['files'] ?? []) : [];
            $this->createBackup($backupName, $filesToBackup);

            // استخراج و جایگزینی فایل‌ها
            $zip->extractTo(base_path());
            $zip->close();
        } else {
            throw new \Exception("خطا در باز کردن فایل ZIP آپدیت");
        }

        $this->currentStep = 4;
        $this->processMessage = 'در حال اجرای migrations و پاکسازی کش...';
        $this->dispatch('update-step', step: 4);

        $this->finalizeUpdate($newVersion);
    }

    private function finalizeUpdate($newVersion)
    {
        try {
            // اجرای میگریشن‌ها
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            
            // پاکسازی تمام کش‌ها
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            
            // بروزرسانی فایل ورژن
            File::put(base_path('version.json'), json_encode([
                'version' => $newVersion ?: '1.0.0',
                'updated_at' => now()->toDateTimeString(),
            ], JSON_PRETTY_PRINT));

            if (File::exists(storage_path('app/update.zip'))) {
                @unlink(storage_path('app/update.zip'));
            }
            
            clearstatcache();
        } catch (\Exception $e) {
            Log::error("Finalize update failed: " . $e->getMessage());
            // ادامه می‌دهیم چون فایل‌ها جایگزین شده‌اند
        }
    }

    private function createBackup($name, $files)
    {
        $backupDir = storage_path("backups/$name");
        if (!File::exists($backupDir)) File::makeDirectory($backupDir, 0755, true);

        // Backup version.json
        if (File::exists(base_path('version.json'))) {
            File::copy(base_path('version.json'), $backupDir . '/version.json');
        }

        foreach ($files as $file) {
            $source = base_path($file);
            if (File::exists($source) && !File::isDirectory($source)) {
                $dest = $backupDir . '/' . $file;
                if (!File::exists(dirname($dest))) File::makeDirectory(dirname($dest), 0755, true);
                File::copy($source, $dest);
            }
        }

        $this->backupDatabase($backupDir . '/database.sql');
    }

    private function backupDatabase($path)
    {
        try {
            $tables = DB::select('SHOW TABLES');
            $dbName = config('database.connections.mysql.database');
            $key = "Tables_in_" . $dbName;
            $sql = "SET FOREIGN_KEY_CHECKS=0;\n\n";
            foreach ($tables as $tableObj) {
                $table = $tableObj->$key;
                $create = DB::select("SHOW CREATE TABLE `{$table}`")[0]->{'Create Table'};
                $sql .= "DROP TABLE IF EXISTS `{$table}`;\n" . $create . ";\n\n";
                $rows = DB::table($table)->get();
                foreach ($rows as $row) {
                    $rowArray = (array)$row;
                    $sql .= "INSERT INTO `{$table}` (`" . implode("`, `", array_keys($rowArray)) . "`) VALUES (" . implode(", ", array_map(fn($v) => is_null($v) ? 'NULL' : "'" . addslashes($v) . "'", array_values($rowArray))) . ");\n";
                }
            }
            $sql .= "\nSET FOREIGN_KEY_CHECKS=1;";
            File::put($path, $sql);
        } catch (\Exception $e) {
            Log::error("DB Backup failed: " . $e->getMessage());
        }
    }
}

