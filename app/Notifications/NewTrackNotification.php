<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewTrackNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $trackTitle,
        public string $artistName,
        public string $trackUrl
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'آهنگ جدید منتشر شد',
            'message' => "{$this->artistName} آهنگ جدیدی با عنوان {$this->trackTitle} منتشر کرد",
            'track_url' => $this->trackUrl,
            'artist_name' => $this->artistName,
            'track_title' => $this->trackTitle,
        ];
    }
}
