<?php
namespace App\Filament\Resources\PlaylistResource\Pages;
use App\Filament\Resources\PlaylistResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
class EditPlaylist extends EditRecord
{
    protected static string $resource = PlaylistResource::class;
    protected function getHeaderActions(): array { return [DeleteAction::make()]; }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['track_ids'] = $this->record->tracks->pluck('id')->toArray();
        return $data;
    }

    protected function afterSave(): void
    {
        $ids = $this->data['track_ids'] ?? [];
        $sync = [];
        foreach (array_values($ids) as $pos => $id) {
            $sync[$id] = ['position' => $pos, 'added_by' => auth()->id()];
        }
        $this->record->tracks()->sync($sync);
        $this->record->recalculate();
    }
}
