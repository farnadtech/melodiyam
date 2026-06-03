<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LikeNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $target;

    public function __construct($user, $target)
    {
        $this->user = $user;
        $this->target = $target;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $type = match(get_class($this->target)) {
            \App\Models\Track::class => 'آهنگ',
            \App\Models\Album::class => 'آلبوم',
            \App\Models\Podcast::class => 'پادکست',
            \App\Models\Comment::class => 'نظر',
            default => 'محتوا',
        };

        return [
            'type' => 'like',
            'title' => 'لایک جدید',
            'body' => "{$this->user->name} {$type} شما را لایک کرد.",
            'url' => $this->getUrl(),
            'image' => $this->user->avatar,
        ];
    }

    protected function getUrl()
    {
        if ($this->target instanceof \App\Models\Track) return route('track.show', $this->target->slug);
        if ($this->target instanceof \App\Models\Album) return route('album.show', $this->target->slug);
        if ($this->target instanceof \App\Models\Podcast) return route('podcast.show', $this->target->slug);
        if ($this->target instanceof \App\Models\PodcastEpisode) return route('podcast.show', $this->target->podcast->slug);
        return '#';
    }
}
