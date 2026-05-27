<?php

namespace App\Filament\Resources\AdvertisementResource\Pages;

use App\Filament\Resources\AdvertisementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAdvertisement extends CreateRecord
{
    protected static string $resource = AdvertisementResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['type'] ?? '') === 'audio') {
            if (!empty($data['audio_media_path'])) $data['media_path'] = $data['audio_media_path'];
            if (!empty($data['audio_media_url']))  $data['media_url']  = $data['audio_media_url'];
        } elseif (($data['type'] ?? '') === 'banner') {
            if (!empty($data['banner_media_path'])) $data['media_path'] = $data['banner_media_path'];
            if (!empty($data['banner_media_url']))  $data['media_url']  = $data['banner_media_url'];
        }
        unset($data['audio_media_path'], $data['audio_media_url'], $data['banner_media_path'], $data['banner_media_url']);
        return $data;
    }
}
