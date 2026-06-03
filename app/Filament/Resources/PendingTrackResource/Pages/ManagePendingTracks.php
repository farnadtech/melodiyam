<?php

namespace App\Filament\Resources\PendingTrackResource\Pages;

use App\Filament\Resources\PendingTrackResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePendingTracks extends ManageRecords
{
    protected static string $resource = PendingTrackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action here, only moderation
        ];
    }
}
