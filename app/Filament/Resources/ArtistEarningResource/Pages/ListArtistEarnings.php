<?php

namespace App\Filament\Resources\ArtistEarningResource\Pages;

use App\Filament\Resources\ArtistEarningResource;
use App\Models\ArtistEarning;
use App\Models\EarningsSetting;
use App\Models\Track;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListArtistEarnings extends ListRecords
{
    protected static string $resource = ArtistEarningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('backfill')
                ->label('محاسبه درآمد پخش‌های قبلی')
                ->icon('heroicon-o-calculator')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('محاسبه درآمد پخش‌های قبلی')
                ->modalDescription('این عملیات بر اساس تعداد پخش فعلی آهنگ‌ها، درآمد معوق را محاسبه و به کیف پول هنرمندان واریز می‌کند.')
                ->action(function () {
                    $settings = EarningsSetting::getSettings();
                    if (!$settings->is_enabled || $settings->plays_threshold <= 0) {
                        Notification::make()->title('سیستم درآمد فعال نیست')->danger()->send();
                        return;
                    }
                    $tracks = Track::whereHas('artist')->with('artist.user')->get();
                    $processed = 0;
                    $totalDeposited = 0;
                    foreach ($tracks as $track) {
                        $artist = $track->artist;
                        if (!$artist || $track->play_count < $settings->plays_threshold) continue;

                        $milestones  = intdiv($track->play_count, $settings->plays_threshold);
                        $totalEarned = $milestones * $settings->earning_amount_toman;

                        // Check existing aggregate record
                        $existing = ArtistEarning::where('artist_id', $artist->id)
                            ->where('playable_id', $track->id)
                            ->where('playable_type', Track::class)
                            ->first();

                        $alreadyPaid = $existing ? $existing->earning_amount_toman : 0;
                        $toPay = $totalEarned - $alreadyPaid;

                        if ($toPay <= 0) continue;

                        // Upsert one aggregate record
                        $earning = ArtistEarning::updateOrCreate(
                            [
                                'artist_id'     => $artist->id,
                                'playable_id'   => $track->id,
                                'playable_type' => Track::class,
                            ],
                            [
                                'play_count'           => $track->play_count,
                                'earning_amount_toman' => $totalEarned,
                                'status'               => 'paid',
                                'paid_at'              => now(),
                            ]
                        );

                        if ($artist->user) {
                            $wallet = $artist->user->getOrCreateWallet();
                            $wallet->deposit(
                                $toPay,
                                "درآمد پخش (بازگشتی): آهنگ «{$track->title}» | {$track->play_count} پخش",
                                $earning
                            );
                            $totalDeposited += $toPay;
                        }
                        $processed++;
                    }
                    Notification::make()
                        ->title("{$processed} آهنگ پردازش شد — " . number_format($totalDeposited) . " تومان واریز شد")
                        ->success()
                        ->send();
                }),
            Actions\CreateAction::make(),
        ];
    }
}
