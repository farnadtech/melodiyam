<?php

namespace App\Filament\Resources\ArtistEarningResource\Pages;

use App\Filament\Resources\ArtistEarningResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtistEarning extends EditRecord
{
    protected static string $resource = ArtistEarningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
