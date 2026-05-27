<?php

namespace App\Filament\Resources\ArtistPlanResource\Pages;

use App\Filament\Resources\ArtistPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtistPlan extends EditRecord
{
    protected static string $resource = ArtistPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
