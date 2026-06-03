<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    use Queueable;

    protected $eventKey;
    protected $message;
    protected $params;

    public function __construct($eventKey, $message, $params = [])
    {
        $this->eventKey = $eventKey;
        $this->message = $message;
        $this->params = $params;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'event_key' => $this->eventKey,
            'message' => $this->message,
            'params' => $this->params,
        ];
    }
}
