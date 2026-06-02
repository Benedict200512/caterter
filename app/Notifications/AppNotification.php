<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppNotification extends Notification
{
    use Queueable;

    protected $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['database']; // Only using the in-app database channel
    }

    public function toArray($notifiable)
    {
        return [
            'title'   => $this->details['title'],
            'message' => $this->details['message'],
            'url'     => $this->details['url'], // Link to the booking or dashboard
            'type'    => $this->details['type'] ?? 'info', // e.g., 'success', 'danger'
        ];
    }
}