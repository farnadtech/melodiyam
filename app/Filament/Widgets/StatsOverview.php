<?php

namespace App\Filament\Widgets;

use App\Models\Track;
use App\Models\Album;
use App\Models\Artist;
use App\Models\User;
use App\Models\Stream;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('کاربران', User::count())
                ->description(User::where('created_at', '>=', now()->subDays(7))->count() . ' جدید این هفته')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->icon('heroicon-o-users'),

            Stat::make('آهنگ‌ها', Track::count())
                ->description(Track::where('created_at', '>=', now()->subDays(7))->count() . ' جدید این هفته')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->icon('heroicon-o-musical-note'),

            Stat::make('آلبوم‌ها', Album::count())
                ->description(Album::where('created_at', '>=', now()->subDays(7))->count() . ' جدید این هفته')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning')
                ->icon('heroicon-o-squares-2x2'),

            Stat::make('هنرمندان', Artist::count())
                ->description(Artist::where('created_at', '>=', now()->subDays(7))->count() . ' جدید این هفته')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger')
                ->icon('heroicon-o-microphone'),

            Stat::make('پخش‌های ۷ روز', number_format(Stream::where('created_at', '>=', now()->subDays(7))->count()))
                ->color('info')
                ->icon('heroicon-o-play'),

            Stat::make('کل پخش‌ها', number_format(Track::sum('play_count')))
                ->color('success')
                ->icon('heroicon-o-chart-bar'),
        ];
    }
}
