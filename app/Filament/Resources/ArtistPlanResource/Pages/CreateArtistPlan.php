<?php

namespace App\Filament\Resources\ArtistPlanResource\Pages;

use App\Filament\Resources\ArtistPlanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArtistPlan extends CreateRecord
{
    protected static string $resource = ArtistPlanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
