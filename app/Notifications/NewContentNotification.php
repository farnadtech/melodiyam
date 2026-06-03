<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewContentNotification extends Notification
{
    use Queueable;

    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $ownerName = $this->content->artist?->display_name ?? $this->content->user?->name;
        $type = match(get_class($this->content)) {
            \App\Models\Track::class => 'آهنگ',
            \App\Models\Album::class => 'آلبوم',
            \App\Models\Podcast::class => 'پادکست',
            default => 'محتوا',
        };

        return [
            'type' => 'new_content',
            'title' => 'محتوای جدید',
            'body' => "{$ownerName} یک {$type} جدید منتشر کرد: {$this->content->title}",
            'url' => $this->getUrl(),
            'image' => $this->content->cover_image,
        ];
    }

    protected function getUrl()
    {
        if ($this->content instanceof \App\Models\Track) return route('track.show', $this->content->slug);
        if ($this->content instanceof \App\Models\Album) return route('album.show', $this->content->slug);
        if ($this->content instanceof \App\Models\Podcast) return route('podcast.show', $this->content->slug);
        if ($this->content instanceof \App\Models\PodcastEpisode) return route('podcast.show', $this->content->podcast->slug);
        return '#';
    }
}
