<?php

namespace App\Notifications;

use App\Models\SolicitarRetiro;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolicitudRetiroNotification extends Notification
{
    use Queueable;
    private $solicitudRetiro;

    /**
     * Create a new notification instance.
     */
    public function __construct(SolicitarRetiro $solicitudRetiro)
    {
        $this->solicitudRetiro = $solicitudRetiro;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Se ha creado una nueva solicitud de retiro con ID ' . $this->solicitudRetiro->id,
            'solicitud_retiro_id' => $this->solicitudRetiro->id,
            'user_id' => $this->solicitudRetiro->repartidor_id,
        ];
    }
}
