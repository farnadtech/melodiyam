<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;

class Sitemap extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-globe-alt';
    protected static string | \UnitEnum | null $navigationGroup = 'تنظیمات سیستم';
    protected static ?string $title = 'سئو و نقشه سایت';
    protected static ?string $navigationLabel = 'سئو و نقشه سایت';
    protected static ?int $navigationSort = 10; // Put it at the end of the group

    protected string $view = 'filament.pages.sitemap';

    public function generateSitemap(): void
    {
        try {
            Artisan::call('sitemap:generate');
            
            Notification::make()
                ->title('نقشه سایت با موفقیت تولید شد ✅')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Notification::make()
                ->title('خطا در تولید نقشه سایت ❌')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
