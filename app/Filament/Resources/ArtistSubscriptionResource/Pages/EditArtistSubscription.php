<?php

namespace App\Filament\Resources\ArtistSubscriptionResource\Pages;

use App\Filament\Resources\ArtistSubscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtistSubscription extends EditRecord
{
    protected static string $resource = ArtistSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
