<?php

namespace App\Notifications;

use App\Models\Envio;
use Illuminate\Bus\Queueable;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PedidoNotification extends Notification
{
    use Queueable;
    private $envio;
    private $venta;
    /**
     * Create a new notification instance.
     */
    public function __construct(Envio $envio)
    {
        $this->envio=$envio;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
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
    public function toArray(object $notifiable): array
    {
        $this->venta = Envio::with('venta')
        ->where('venta_id','=',$this->envio->venta_id)
        ->get()[0];
        return [
            "envio"=>$this->envio->id,
            "descripcion"=>"Se ha creado el pedido Nº",
            "codigo"=>$this->venta->venta->codigo,
            "tipo"=>"pedido",
            "time"=>$this->envio->created_at,
        ];
    }
}
