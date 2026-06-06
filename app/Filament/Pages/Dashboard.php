<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;

class Dashboard extends BaseDashboard
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'داشبورد مدیریت';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('add_track')
                ->label('آهنگ جدید')
                ->icon('heroicon-o-plus')
                ->url(route('filament.admin.resources.tracks.create'))
                ->color('success'),

            Action::make('add_artist')
                ->label('هنرمند جدید')
                ->icon('heroicon-o-plus')
                ->url(route('filament.admin.resources.artists.create'))
                ->color('primary'),

            Action::make('view_site')
                ->label('مشاهده سایت')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(url('/'))
                ->openUrlInNewTab()
                ->color('gray'),
        ];
    }
}
