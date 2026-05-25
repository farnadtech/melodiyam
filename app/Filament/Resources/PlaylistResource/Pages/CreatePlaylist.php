<?php
namespace App\Filament\Resources\PlaylistResource\Pages;
use App\Filament\Resources\PlaylistResource;
use Filament\Resources\Pages\CreateRecord;
class CreatePlaylist extends CreateRecord
{
    protected static string $resource = PlaylistResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function afterCreate(): void
    {
        $ids = $this->data['track_ids'] ?? [];
        if (!empty($ids)) {
            $sync = [];
            foreach (array_values($ids) as $pos => $id) {
                $sync[$id] = ['position' => $pos, 'added_by' => auth()->id()];
            }
            $this->record->tracks()->sync($sync);
            $this->record->recalculate();
        }
    }
}
