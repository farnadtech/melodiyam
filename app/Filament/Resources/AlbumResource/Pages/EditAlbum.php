<?php
namespace App\Filament\Resources\AlbumResource\Pages;

use App\Filament\Resources\AlbumResource;
use App\Helpers\Jalali;
use App\Models\Track;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\View\View;

class EditAlbum extends EditRecord
{
    protected static string $resource = AlbumResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    public function getFooter(): ?View
    {
        $album = $this->record;
        if (!$album) return null;

        $tracks = Track::where('album_id', $album->id)
            ->orderBy('track_number')
            ->orderBy('id')
            ->get();

        if ($tracks->isEmpty()) return null;

        $reorderUrl = route('filament.admin.album-track-reorder', ['album' => $album->id]);
        $csrfToken  = csrf_token();

        $rows = $tracks->map(function (Track $t) {
            $jalali = $t->release_date ? Jalali::format($t->release_date, 'Y/m/d') : '';
            return [
                'id'           => $t->id,
                'title'        => e($t->title),
                'track_number' => $t->track_number ?? '—',
                'status'       => $t->status,
                'jalali'       => $jalali,
                'edit_url'     => route('filament.admin.resources.tracks.edit', ['record' => $t->id]),
            ];
        });

        return view('filament.album-track-reorder', compact('rows', 'reorderUrl', 'csrfToken', 'album'));
    }
}
