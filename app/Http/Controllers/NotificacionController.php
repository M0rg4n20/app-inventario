<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

class NotificacionController extends Controller
{

    public function __construct()
    {
        //protegiendo el controlador segun el rol
        //$this->middleware(['auth', 'permission:lista-pedidos'])->only('index');
        //$this->middleware(['auth', 'permission:crear-pedidos'])->only(['store','create']);
        //$this->middleware(['auth', 'permission:editar-pedidos'])->only(['update']);
        //$this->middleware(['auth', 'permission:eliminar-pedidos'])->only(['destroy']);
    }

    public function marcarPedidoLeido($id,$tipo)
    {
        $notification = auth()->user()->notifications->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        if($tipo=="envio"){
            return Redirect::route('envios.index');
        }else{
            return Redirect::route('pedidos.index');

        }
    }
}
