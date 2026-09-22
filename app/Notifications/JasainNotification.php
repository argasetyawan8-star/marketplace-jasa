<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class JasainNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected array $payload
    ) {
    }

    /**
     * Notification ini saat ini disimpan ke database.
     * Broadcast bisa ditambahkan di fase real-time notification nanti.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Payload database notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return $this->payload;
    }

    /**
     * Fallback payload untuk channel/database serialization.
     */
    public function toArray(object $notifiable): array
    {
        return $this->payload;
    }
}
