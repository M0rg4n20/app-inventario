<?php

namespace App\Providers;

use App\Events\CancelarPedidoEvent;
use App\Events\PedidoEvent;
use App\Listeners\CancelarPedidoListener;
use App\Listeners\PedidoListener;
use App\Models\Curva;
use App\Models\Familia;
use App\Models\Color;
use App\Models\Marca;
use App\Models\SubProducto;
use App\Observers\ColorObserver;
use App\Observers\CurvaObserver;
use App\Observers\FamiliaObserver;
use App\Observers\MarcaObserver;
use App\Observers\SubProductoObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PedidoEvent::class => [
            PedidoListener::class,
        ],
        CancelarPedidoEvent::class => [
            CancelarPedidoListener::class,
        ],
    ];

    protected $observers = [
        Familia::class => [FamiliaObserver::class],
        Marca::class => [MarcaObserver::class],
        SubProducto::class => [SubProductoObserver::class],
        Curva::class => [CurvaObserver::class],
        Color::class => [ColorObserver::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
