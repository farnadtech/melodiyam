<?php

namespace App\Filament\Resources\ArtistSubscriptionResource\Pages;

use App\Filament\Resources\ArtistSubscriptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArtistSubscription extends CreateRecord
{
    protected static string $resource = ArtistSubscriptionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['granted_by'] = auth()->id();
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
