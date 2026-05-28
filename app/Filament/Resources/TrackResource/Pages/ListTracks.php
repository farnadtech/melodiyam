<?php

namespace App\Filament\Resources\TrackResource\Pages;

use App\Filament\Resources\TrackResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Schemas\Components\Tabs\Tab;

class ListTracks extends ListRecords
{
    protected static string $resource = TrackResource::class;

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
                ->badge(\App\Models\Track::where('status', 'pending')->count()),
            'published' => Tab::make('منتشر شده')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'published')),
            'draft' => Tab::make('پیش‌نویس')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'draft')),
        ];
    }
}
