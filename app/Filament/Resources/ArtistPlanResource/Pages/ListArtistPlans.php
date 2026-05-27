<?php

namespace App\Filament\Resources\ArtistPlanResource\Pages;

use App\Filament\Resources\ArtistPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtistPlans extends ListRecords
{
    protected static string $resource = ArtistPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label('پلن جدید')];
    }
}
