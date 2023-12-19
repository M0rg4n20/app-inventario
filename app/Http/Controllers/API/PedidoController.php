<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Envio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\EnvioHistorico;
use App\Models\EstadoDePedido;
use App\Models\Pago;
use App\Models\SolicitarRetiro;
use App\Models\Venta;
use Laravel\Sanctum\PersonalAccessToken;
use App\Notifications\SolicitudRetiroNotification;

class PedidoController extends BaseController
{
  public function lista(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'repartidor_id' => 'required',
    ]);

    if ($validator->fails()) {
      return $this->sendError('Error de validación', $validator->errors());
    }
    $token = $request->header('Authorization');
    $hasHeader = $request->hasHeader('Authorization');

    if (empty($hasHeader)) {
      return $this->sendError('Authorization no especificado', [], 422);
    }

    $token = explode('Bearer ', $token);
    if (empty($token[1]) || empty($token = PersonalAccessToken::findToken($token[1]))) {
      return $this->sendError('Token es inválido', [], 422);
    }

    $lista_envio = Envio::with(
      'venta.detalles_ventas.producto',
      'venta.cliente',
      'venta.user',
      'venta.pagos',
      'responsable',
      'ruta',
      'repartidor'
    )->where('repartidor_id', '=', $request->repartidor_id)->get();

    $pedidos = [];
    $productos = [];
    foreach ($lista_envio as $value) {

      foreach ($value->venta->detalles_ventas as $detalle) {
        array_push($productos, [
          "id" => $detalle->producto_id,
          "nombre" => $detalle->producto->nombre,
          "imagen" => $detalle->producto->imagen_1,
          "cantidad" => $detalle->cantidad,
          "precio" => $detalle->precio,
          "total" => $detalle->total,
        ]);
      }
      $havePagos = (count($value->venta->pagos) > 0) ? true : false;
      array_push($pedidos, [
        "pedido_id" => $value->id,
        "cliente_id" => $value->venta->cliente_id ?? '',
        "cliente" => $value->venta->cliente->nombre ?? '',
        "vendedor_id" => $value->venta->user_id ?? '',
        "vendedor" => $value->venta->user->name ?? '',
        "responsable_id" => $value->responsable_id ?? '',
        "responsable" => $value->responsable->name ?? '',
        "repartidor_id" => $value->repartidor_id ?? '',
        "repartidor" => $value->repartidor->name ?? '',
        "codigo" => $value->venta->codigo ?? '',
        "productos" => $productos ?? [],
        "impuesto" => $value->venta->impuesto,
        "descuento" => $value->venta->descuento,
        "neto" => $value->venta->neto,
        "total" => $value->venta->total,
        "abono" => ($havePagos) ? ($value->venta->pagos[0]->monto_efectivo == 0 ? $value->venta->pagos[0]->monto_tarjeta : $value->venta->pagos[0]->monto_efectivo) : 0,
        "saldo" => ($havePagos) ? ($value->venta->pagos[0]->saldo ?? 0) : 0,
        "metodo_pago" => ($havePagos) ? ($value->venta->pagos[0]->metodo_pago ?? '') : 0,
        "fecha" => $value->fecha ?? '',
        "ruta" => $value->ruta->nombre ?? '',
        "estado" => $value->estado ?? '',
        "comentario" => $value->comentario ?? '',
        "direccion" => $value->direccion ?? '',
        "colonia" => $value->colonia ?? '',
        "telefono" => $value->telefono,
        "efectivo" => ($havePagos) ? ($value->venta->pagos[0]->monto_efectivo) : 0,
        "tarjeta" => ($havePagos) ? ($value->venta->pagos[0]->monto_tarjeta) : 0,
      ]);
      $productos = [];
    }

    return $this->sendResponse(
      [
        "url" => url('/'),
        "pedidos" => $pedidos,
      ],
      'Pedidos recibidos'
    );
  }

  public function actualizarPedido(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'pedido_id' => 'required|exists:envios,id',
        'status' => 'required|in:Entregado,Cancelado,Pendiente,Asignado,Reprogramado',
        'efectivo' => 'numeric',
        'credito' => 'numeric',
        'debito' => 'numeric',
        'transferencia' => 'numeric',
        'numero_tarjeta' => 'numeric',
      ]);

      if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => 'Error de validación'], 500);
      }

      $token = $request->header('Authorization');
      $hasHeader = $request->hasHeader('Authorization');

      if (empty($hasHeader)) {
        return $this->sendError('Authorization no especificado', [], 422);
      }

      $token = explode('Bearer ', $token);
      if (empty($token[1]) || empty($token = PersonalAccessToken::findToken($token[1]))) {
        return $this->sendError('Token es inválido', [], 422);
      }

      $pedido = Envio::find($request->pedido_id);
      if (!$pedido) {
        return response()->json(['error' => 'Pedido no encontrado'], 404);
      }

      $pedido->estado = $request->status;
      $pedido->save();

      $estadoPedido = EstadoDePedido::where('nombre', $request->status)->first();
      $puntos = $estadoPedido ? $estadoPedido->puntos : 0;

      EnvioHistorico::create([
        'repartidor_id' => $pedido->repartidor_id,
        'pedido_id' => $pedido->id,
        'estado_id' => $estadoPedido->id,
        'puntos' => $puntos,
        'observacion' => '',
      ]);

      //creando pago
      $efectivo = $request->efectivo ?? 0;
      $credito = $request->credito ?? 0;
      $debito = $request->debito ?? 0;
      $transferencia = $request->transferencia ?? 0;

      $metodosPago = ["NA", "EFECTIVO", "TARJETA DE DEBITO / CREDITO", "EFECTIVO Y TARJETA"];
      $metodoPago = 0;
      if ($efectivo > 0)
        $metodoPago = 1;

      if ($credito > 0 || $debito > 0 || $transferencia > 0)
        $metodoPago = 2;

      if ($efectivo > 0 && ($credito > 0 || $debito > 0 || $transferencia > 0))
        $metodoPago = 3;

       //Actualizamos el saldo
      $venta = Venta::find($pedido->venta_id);
      if (!$venta) {
        return response()->json(['error' => 'Venta no encontrado'], 404);
      }

      $venta->saldo = $venta->saldo  - $credito - $debito - $transferencia - $efectivo;
      $venta->save();

      Pago::create([
        'monto_efectivo' => $efectivo,
        'monto_tarjeta' => $credito + $debito + $transferencia,
        'saldo' => $venta->saldo ,
        'num_tarjeta' => $request->numero_tarjeta,
        'metodo_pago' => $metodosPago[$metodoPago],
        'tipo_pago' => 'ABONO',
        'forma_entrega' => 'DOMICILIO',
        'venta_id' => $pedido->venta_id,
        'user_id' => $pedido->repartidor_id,
        'metodo_pago_id' => $metodoPago,
      ]);   

      return response()->json(['success' => true]);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
  }

  public function historico(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'repartidor_id' => 'required',
      ]);

      if ($validator->fails()) {
        return response()->json(['error' => 'Error de validación'], 400);
      }

      $token = $request->header('Authorization');
      $hasHeader = $request->hasHeader('Authorization');

      if (empty($hasHeader)) {
        return $this->sendError('Authorization no especificado', [], 422);
      }

      $token = explode('Bearer ', $token);
      if (empty($token[1]) || empty($token = PersonalAccessToken::findToken($token[1]))) {
        return $this->sendError('Token es inválido', [], 422);
      }

      $repartidor_id = $request->repartidor_id;
      $historicoPedidos = EnvioHistorico::with(['pedido.venta.detalles_ventas.producto', 'estadoPedido', 'venta'])
        ->where('repartidor_id', $repartidor_id)
        ->where('estado_id', 1)
        ->whereDate('created_at', now()->toDateString())
        ->get();

      return response()->json(['pedidos' => $historicoPedidos]);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }

  public function solicitarRetiro(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'repartidor_id' => 'required',
        'monto' => 'required',
      ]);

      if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => 'Error de validación'], 500);
      }

      $token = $request->header('Authorization');
      $hasHeader = $request->hasHeader('Authorization');

      if (empty($hasHeader)) {
        return $this->sendError('Authorization no especificado', [], 422);
      }

      $token = explode('Bearer ', $token);
      if (empty($token[1]) || empty($token = PersonalAccessToken::findToken($token[1]))) {
        return response()->json(['success' => false, 'message' => 'Token es inválido'], 422);
      }

      $repartidor_id = $request->repartidor_id;
      // Buscar el último retiro aprobado del usuario
      $ultimoRetiroAprobado = SolicitarRetiro::where('repartidor_id', $repartidor_id)
        ->where('estado', 'Aprobado')
        ->orderBy('created_at', 'desc')
        ->first();


      // Obtener la fecha del último retiro aprobado
      $fechaUltimoRetiro = ($ultimoRetiroAprobado) ? $ultimoRetiroAprobado->created_at : now()->toDateString();

      // Verificar si existe una solicitud de retiro pendiente desde la fecha del último retiro aprobado
      $solicitudPendiente = SolicitarRetiro::where('repartidor_id', $repartidor_id)
        ->where('estado', 'Pendiente')
        ->whereDate('created_at', '>=', $fechaUltimoRetiro)
        ->first();

      if ($solicitudPendiente) {
        return response()->json(['success' => false, 'message' => 'Tiene una solicitud de retiro pendiente'], 422);
      }

      // Calcular la suma de puntos desde la fecha del último retiro aprobado
      $sumaPuntosHoy = EnvioHistorico::whereDate('created_at', '>=', $fechaUltimoRetiro)
        ->where('estado_id', 1)
        ->where('repartidor_id', $repartidor_id)
        ->sum('puntos');

      if ($sumaPuntosHoy >= $request->monto) {
        $solicitudRetiro = SolicitarRetiro::create([
          'repartidor_id' => $repartidor_id,
          'monto' => $request->monto,
          'estado' => 'Pendiente',
          'comentario' => null
        ]);

        // Código para enviar una notificación de solicitud de retiro
        $repartidor = User::find($request->repartidor_id);
        $repartidor->notify(new SolicitudRetiroNotification($solicitudRetiro));

        return response()->json(['success' => true]);
      } else {
        return response()->json(['success' => false, 'message' => 'El monto solicitado supera los puntos disponibles. (' . $sumaPuntosHoy . ')'], 422);
      }
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }
}
