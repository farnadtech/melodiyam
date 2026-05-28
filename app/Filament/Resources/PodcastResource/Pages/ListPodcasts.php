<?php

namespace App\Filament\Resources\PodcastResource\Pages;

use App\Filament\Resources\PodcastResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListPodcasts extends ListRecords
{
    protected static string $resource = PodcastResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('همه'),
            'pending' => Tab::make('در انتظار تایید')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'pending'))
                ->badge(\App\Models\Podcast::where('status', 'pending')->count()),
            'published' => Tab::make('منتشر شده')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'published')),
            'draft' => Tab::make('پیش‌نویس')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'draft')),
        ];
    }
}
