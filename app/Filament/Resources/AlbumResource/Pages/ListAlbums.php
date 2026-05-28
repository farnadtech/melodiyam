<?php

namespace App\Filament\Resources\AlbumResource\Pages;

use App\Filament\Resources\AlbumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListAlbums extends ListRecords
{
    protected static string $resource = AlbumResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('همه'),
            'pending' => Tab::make('در انتظار تایید')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'pending'))
                ->badge(\App\Models\Album::where('status', 'pending')->count()),
            'published' => Tab::make('منتشر شده')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'published')),
            'draft' => Tab::make('پیش‌نویس')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'draft')),
        ];
    }
}
