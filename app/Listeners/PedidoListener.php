<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\PedidoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class PedidoListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'Administrador de pedidos')->toArray()
        )->each(function (User $user) use ($event) {
            Notification::send($user,new PedidoNotification($event->envio));
        });
    }
}
