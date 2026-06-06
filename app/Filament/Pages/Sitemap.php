<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Placeholder;
use Filament\Schemas\Components\Actions as SchemaActions;

class Sitemap extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-globe-alt';
    protected static string | \UnitEnum | null $navigationGroup = 'تنظیمات سیستم';
    protected static ?string $title = 'سئو و نقشه سایت';
    protected static ?string $navigationLabel = 'سئو و نقشه سایت';
    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.sitemap';

    public function generateSitemap(): void
    {
        Artisan::call('sitemap:generate');
        
        Notification::make()
            ->title('نقشه سایت با موفقیت تولید شد ✅')
            ->success()
            ->send();
    }
}
