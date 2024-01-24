<?php

namespace App\Http\Controllers;

use App\Events\CancelarPedidoEvent;
use App\Http\Requests\EnvioUpdateRequest;
use App\Http\Requests\RepartidorPedidoUpdateRequest;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Envio;
use App\Models\Ruta;
use App\Models\User;
use Illuminate\Http\Request;

class EnvioController extends Controller
{
  private $ini_dia;
  private $fin_dia;
  public function __construct()
  {
    //protegiendo el controlador segun el rol
    //$this->middleware(['auth', 'permission:lista-envios'])->only('index');
    //$this->middleware(['auth', 'permission:crear-envios'])->only(['store','create']);
    //$this->middleware(['auth', 'permission:editar-envios'])->only(['update']);
    //$this->middleware(['auth', 'permission:eliminar-envios'])->only(['destroy']);
    $this->ini_dia = Carbon::now()->startOfDay();
    $this->fin_dia = Carbon::now()->endOfDay();
  }

  public function index()
  {
    $hoy = Carbon::today();
    /*$pedidos = Envio::with('venta.detalles_ventas.producto', 'venta.cliente', 'responsable','ruta','repartidor')
        ->whereNotNull('repartidor_id')
        //->where('created_at', '>=', $this->ini_dia)
        //->where('created_at', '<=', $this->fin_dia)
        ->get();*/
    $pedidos = Envio::with(['venta' => function ($query) {
      $query->select('id', 'user_id', 'cliente_id')->with(['detalles_ventas' => function ($query) {
        $query->select('id', 'producto_id', 'venta_id', 'cantidad')->with(['producto' => function ($query) {
          $query->select('id', 'nombre', 'codigo_barra');
        }]);
      }])->with(['cliente' => function ($query) {
        $query->select('id', 'nombre');
      }]);
    }])->select(
      'id',
      'venta_id',
      'ruta_id',
      'repartidor_id',
      'comentario',
      'estado',
      'fecha',
      'hora',
      'orden',
      'telefono',
      'colonia',
      'direccion'
    )->with(['ruta' => function ($query) {
      $query->select('id', 'nombre', 'colonias');
    }])
      ->with(['repartidor' => function ($query) {
        $query->select('id', 'name');
      }])->whereNotNull('repartidor_id')
      //->whereNot('estado', 'Entregado')
      ->orderBy('orden')
      ->get();

      $pedidosNow = Envio::with(['venta' => function ($query) {
        $query->select('id', 'user_id', 'cliente_id')->with(['detalles_ventas' => function ($query) {
          $query->select('id', 'producto_id', 'venta_id', 'cantidad')->with(['producto' => function ($query) {
            $query->select('id', 'nombre', 'codigo_barra');
          }]);
        }])->with(['cliente' => function ($query) {
          $query->select('id', 'nombre');
        }]);
      }])->select(
        'id',
        'venta_id',
        'ruta_id',
        'repartidor_id',
        'comentario',
        'estado',
        'fecha',
        'hora',
        'orden',
        'telefono',
        'colonia',
        'direccion'
      )->with(['ruta' => function ($query) {
        $query->select('id', 'nombre', 'colonias');
      }])
        ->with(['repartidor' => function ($query) {
          $query->select('id', 'name');
        }])->whereNotNull('repartidor_id')
        ->whereDate('fecha', '=', $hoy)
        //->whereNot('estado', 'Entregado')
        ->orderBy('orden')
        ->get();

    //return $pedidosNow;
    return Inertia::render('Envio/Index', [
      'pedidos' => $pedidos,
      'pedidosNow'=>$pedidosNow

    ]);
  }

  public function show($id)
  {
    $cliente = Envio::findOrFail($id);
    return response()->json([
      "data" => $cliente
    ]);
  }
  public function update(EnvioUpdateRequest $request, $id)
  {
    $envio = Envio::find($id);
    $envio->responsable_id = $request->responsable_id;
    $envio->repartidor_id = $request->repartidor_id;
    $envio->ruta_id = $request->ruta_id;
    $envio->telefono = $request->telefono;
    $envio->estado = $request->estado;
    $envio->fecha = $request->fecha;
    $envio->hora = $request->hora;
    $envio->comentario = $request->comentario;
    $envio->save();
    if ($request->estado == "Cancelado") {
      event(new CancelarPedidoEvent($envio));
    }
    return Redirect::route('envios.index');
  }
  public function asignar($id)
  {

    $envio = Envio::find($id);

    //lista repartidores
    $lista_repartidores = User::with('roles')->get()->filter(
      fn ($user) => $user->roles->where('name', 'Repartidor')->toArray()
    );

    $lista_rutas = Ruta::where('created_at', '>=', $this->ini_dia)
      ->where('created_at', '<=', $this->fin_dia)
      ->get();

    $repartidores = [];
    $rutas = [];

    foreach ($lista_rutas as $ruta) {
      array_push($rutas, [
        'value' => $ruta->id,
        'label' =>   $ruta->nombre,
      ]);
    }
    foreach ($lista_repartidores as $repartidor) {
      array_push($repartidores, [
        'value' => $repartidor->id,
        'label' =>   $repartidor->name,
      ]);
    }
    return response()->json([
      "envio" => $envio,
      "rutas" => $rutas,
      "repartidores" => $repartidores,
    ]);
  }

  public function saveOrder(Request $request)
  {
    $data = $request->input('order');
    foreach ($data as $item) {
      $envio = Envio::find($item['id']);
      if ($envio) {
        $envio->orden = $item['order'];
        $envio->save();
      }
    }
    return response()->json(['message' => 'Orden guardado exitosamente']);
  }
}
