<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoUpdateRequest;
use App\Http\Requests\RepartidorPedidoMultipleUpdateRequest;
use App\Http\Requests\RepartidorPedidoUpdateRequest;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Envio;
use App\Models\Ruta;
use App\Models\User;

class PedidoController extends Controller
{
  private $ini_dia;
  private $fin_dia;
  public function __construct()
  {
    //protegiendo el controlador segun el rol
    //$this->middleware(['auth', 'permission:lista-pedidos'])->only('index');
    //$this->middleware(['auth', 'permission:crear-pedidos'])->only(['store','create']);
    //$this->middleware(['auth', 'permission:editar-pedidos'])->only(['update']);
    //$this->middleware(['auth', 'permission:eliminar-pedidos'])->only(['destroy']);
    $this->ini_dia = Carbon::now()->startOfDay();
    $this->fin_dia = Carbon::now()->endOfDay();
  }

  public function index()
  {

    $pedidos = Envio::with('venta.detalles_ventas.producto', 'venta.cliente', 'responsable')
      ->whereNull('repartidor_id')
      ->where('created_at', '>=', $this->ini_dia)
      ->where('created_at', '<=', $this->fin_dia)
      ->get();

    return Inertia::render('Pedido/Index', [
      'pedidos' => $pedidos
    ]);
  }


  public function asignar($id = null)
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

  public function show($id)
  {
    $cliente = Envio::findOrFail($id);
    return response()->json([
      "data" => $cliente
    ]);
  }

  public function update(RepartidorPedidoUpdateRequest $request, $id)
  {
    if (empty($request->ruta_id) && !empty($request->colonia)) {
      $hoy = Carbon::now()->format('Y-m-d');
      $rutaExistente = Ruta::where('nombre', $request->colonia)
        ->whereDate('created_at', $hoy)
        ->first();

      if (!$rutaExistente) {
        $nuevaRuta = Ruta::create([
          'nombre' => $request->colonia,
          'colonias' => $request->colonia,
        ]);
        $request->merge(['ruta_id' => $nuevaRuta->id]);
      } else {
        $request->merge(['ruta_id' => $rutaExistente->id]);
      }
    }

    $envio = Envio::find($id);
    $envio->responsable_id = $request->responsable_id;
    $envio->repartidor_id = $request->repartidor_id;
    $envio->ruta_id = $request->ruta_id;
    $envio->estado = 'Asignado';
    $envio->save();
    return Redirect::route('pedidos.index');
  }

  public function updateMultiple(RepartidorPedidoMultipleUpdateRequest $request)
  {
    $ruta_id = $request->ruta_id;
    $repartidor_id = $request->repartidor_id;
    $responsable_id = $request->responsable_id;
    $selected_orders = $request->selected_orders;
    foreach ($selected_orders as $order_id) {
      $envio = Envio::where('id', $order_id)->first();
      if ($envio) {
        $envio->ruta_id = $ruta_id;
        $envio->repartidor_id = $repartidor_id;
        $envio->responsable_id = $responsable_id;
        $envio->estado = 'Asignado';
        $envio->save();
      }
    }
    return Redirect::route('pedidos.index');
  }

  public function updatePedido(PedidoUpdateRequest $request, $id)
  {
    $envio = Envio::find($id);
    $envio->telefono = $request->telefono;
    $envio->fecha = $request->fecha;
    $envio->comentario = $request->comentario;
    $envio->hora = $request->hora;
    $envio->save();
    return Redirect::route('pedidos.index');
  }
}
