<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FollowNotification extends Notification
{
    use Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'follow',
            'title' => 'دنبال‌کننده جدید',
            'body' => "{$this->user->name} شما را دنبال کرد.",
            'url' => '#', // Profile URL
            'image' => $this->user->avatar,
        ];
    }
}
