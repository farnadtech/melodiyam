<?php

namespace App\Filament\Resources\ArtistSubscriptionResource\Pages;

use App\Filament\Resources\ArtistSubscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtistSubscriptions extends ListRecords
{
    protected static string $resource = ArtistSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label('اشتراک جدید')];
    }
}
