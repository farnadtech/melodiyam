<?php

namespace App\Filament\Resources\Reposts\Pages;

use App\Filament\Resources\Reposts\RepostResource;
use Filament\Resources\Pages\ManageRecords;

class ManageReposts extends ManageRecords
{
    protected static string $resource = RepostResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
