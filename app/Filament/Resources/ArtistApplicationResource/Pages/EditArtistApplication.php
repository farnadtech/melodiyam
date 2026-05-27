<?php

namespace App\Filament\Resources\ArtistApplicationResource\Pages;

use App\Filament\Resources\ArtistApplicationResource;
use App\Models\Artist;
use App\Models\ArtistApplication;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditArtistApplication extends EditRecord
{
    protected static string $resource = ArtistApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function resolveRecord(int|string $key): ArtistApplication
    {
        return ArtistApplication::with('user')->findOrFail($key);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['reviewed_by'] = auth()->id();
        $data['reviewed_at'] = now();
        return $data;
    }

    protected function afterSave(): void
    {
        $record = $this->record;

        if ($record->status === 'approved') {
            $user = $record->user;

            // ساخت Artist profile اگر وجود ندارد
            if (!$user->artist) {
                $displayName = $record->data['stage_name']
                    ?? $record->data['display_name']
                    ?? $record->data['name']
                    ?? $user->name;

                Artist::create([
                    'user_id'             => $user->id,
                    'display_name'        => $displayName,
                    'verification_status' => 'approved',
                    'verified_at'         => now(),
                ]);
            }

            // تغییر نوع حساب کاربر به artist
            $user->update(['type' => 'artist']);

            Notification::make()
                ->title('درخواست تأیید شد و حساب هنرمند ایجاد گردید.')
                ->success()
                ->send();
        }
    }
}
