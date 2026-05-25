<?php

namespace App\Filament\Pages;

use App\Models\Track;
use App\Models\Album;
use App\Models\Artist;
use App\Models\User;
use App\Models\Stream;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class Dashboard extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';
    protected static string | null $title = 'داشبورد مدیریت';

    public function getView(): string
    {
        return 'filament.pages.dashboard';
    }

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

    public function getStats(): array
    {
        return [
            'users' => [
                'label' => 'کاربران',
                'value' => User::count(),
                'icon' => 'heroicon-o-users',
                'color' => 'primary',
                'trend' => User::where('created_at', '>=', now()->subDays(7))->count(),
            ],
            'tracks' => [
                'label' => 'آهنگ‌ها',
                'value' => Track::count(),
                'icon' => 'heroicon-o-musical-note',
                'color' => 'success',
                'trend' => Track::where('created_at', '>=', now()->subDays(7))->count(),
            ],
            'albums' => [
                'label' => 'آلبوم‌ها',
                'value' => Album::count(),
                'icon' => 'heroicon-o-squares-2x2',
                'color' => 'warning',
                'trend' => Album::where('created_at', '>=', now()->subDays(7))->count(),
            ],
            'artists' => [
                'label' => 'هنرمندان',
                'value' => Artist::count(),
                'icon' => 'heroicon-o-microphone',
                'color' => 'danger',
                'trend' => Artist::where('created_at', '>=', now()->subDays(7))->count(),
            ],
            'streams' => [
                'label' => 'پخش‌ها (۷ روز)',
                'value' => Stream::where('created_at', '>=', now()->subDays(7))->count(),
                'icon' => 'heroicon-o-play',
                'color' => 'info',
                'trend' => null,
            ],
            'plays' => [
                'label' => 'کل پخش‌ها',
                'value' => number_format(Track::sum('play_count')),
                'icon' => 'heroicon-o-chart-bar',
                'color' => 'success',
                'trend' => null,
            ],
        ];
    }

    public function getRecentTracks(): array
    {
        return Track::with(['artist', 'album'])
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn ($track) => [
                'id' => $track->id,
                'title' => $track->title,
                'artist' => $track->artist?->display_name ?? '-',
                'cover' => $track->getCoverUrl(),
                'plays' => number_format($track->play_count),
                'created' => $track->created_at->diffForHumans(),
            ])
            ->toArray();
    }

    public function getTopArtists(): array
    {
        return Artist::orderByDesc('total_streams')
            ->limit(5)
            ->get()
            ->map(fn ($artist) => [
                'id' => $artist->id,
                'name' => $artist->display_name,
                'avatar' => $artist->getAvatarUrl(),
                'streams' => number_format($artist->total_streams),
            ])
            ->toArray();
    }

    public function getRecentUsers(): array
    {
        return User::latest()
            ->limit(5)
            ->get()
            ->map(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->getAvatarUrl(),
                'joined' => $user->created_at->diffForHumans(),
            ])
            ->toArray();
    }
}
