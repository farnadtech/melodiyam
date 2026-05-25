<?php
namespace App\Filament\Resources\PlaylistResource\Pages;
use App\Filament\Resources\PlaylistResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
class ListPlaylists extends ListRecords
{
    protected static string $resource = PlaylistResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}
