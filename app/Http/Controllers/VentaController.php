<?php

namespace App\Http\Controllers;

use App\Events\PedidoEvent;
use App\Http\Requests\VentaStoreRequest;
use App\Http\Resources\ProductoVentaCollection;
use App\Http\Resources\VentaCollection;
use App\Models\Cliente;
use App\Models\Configuracion;
use Exception;
use App\Models\MetodoPago;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Venta;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Elibyy\TCPDF\Facades\TCPDF;
use App\Helpers\NumberLetter;
use App\Http\Requests\VentaUpdateRequest;
use App\Models\Cotizacion;
use App\Models\Envio;
use App\Models\Kardex;
use App\Models\Pago;
use App\Models\Ruta;
use App\Models\User;
use App\Notifications\PedidoNotification;

class VentaController extends Controller
{
  public function __construct()
  {
    //protegiendo el controlador segun el rol
    //$this->middleware(['auth', 'permission:lista-ventas'])->only('index');
    //$this->middleware(['auth', 'permission:crear-ventas'])->only(['store','create']);
    //$this->middleware(['auth', 'permission:editar-ventas'])->only(['update']);
    //$this->middleware(['auth', 'permission:eliminar-ventas'])->only(['destroy']);
  }

  public function index()
  {

    return Inertia::render('Venta/Index', [
      'ventas' => new VentaCollection(
        Venta::orderBy('created_at', 'ASC')
          ->get()
      )
    ]);
  }
  public function create()
  {
    $last = Venta::latest()->first();
    $vendedor = auth()->user();

    if (empty($last)) {
      $codigo = zero_fill(1, 8);
    } else {

      $codigo = zero_fill($last->codigo + 1, 8);
    }

    //Lista cliente
    $lista_clientes = Cliente::get();
    $lista_cliente = Cliente::select('id', 'rfc', 'tipo_cliente', 'nombre')->get();

    $clientes = [];
    foreach ($lista_clientes as $cliente) {
      array_push($clientes, [
        'value' => $cliente->id,
        'label' =>   $cliente->rfc . " - " . $cliente->nombre,
      ]);
    }
    //Lista meetodos de pago
    $lista_metodo = MetodoPago::get();

    $metodos_pago = [];
    foreach ($lista_metodo as $metodo) {
      array_push($metodos_pago, [
        'value' => $metodo->id,
        'label' =>  $metodo->nombre,
      ]);
    }

    return Inertia::render('Venta/Create', [
      'codigo' => $codigo,
      'user_id' => $vendedor->id,
      'vendedor' => $vendedor->name,
      'clientes' => $clientes,
      'lista_clientes' => $lista_cliente,
      'metodos_pago' => $metodos_pago,
      'productos' => new ProductoVentaCollection(
        Producto::orderBy('created_at', 'ASC')
          ->get()
      )
    ]);
  }
  //genera venta a partir de una cotizacion
  public function generar($id)
  {

    //obteniendo datos de cotizacion
    $cotizacion = Cotizacion::findOrFail($id);

    $vendedor = $cotizacion->user->name;
    $det_venta = $cotizacion->detalles_cotizaciones()->with('producto')->get();
    $detalle_productos = [];
    foreach ($det_venta as $det) {
      array_push($detalle_productos, [
        "producto_id" => $det->producto_id,
        "nombre" => $det->producto->nombre,
        "cantidad" => $det->cantidad,
        "precio" => $det->precio,
        "total" => $det->total,
      ]);
    }

    $last = Venta::latest()->first();
    $vendedor_id = $cotizacion->user->id;

    if (empty($last)) {
      $codigo = zero_fill(1, 8);
    } else {

      $codigo = zero_fill($last->codigo + 1, 8);
    }

    //Lista cliente
    $lista_clientes = Cliente::get();
    $lista_cliente = Cliente::select('id', 'rfc', 'tipo_cliente', 'nombre')->get();

    $clientes = [];
    foreach ($lista_clientes as $cliente) {
      array_push($clientes, [
        'value' => $cliente->id,
        'label' =>   $cliente->rfc . " - " . $cliente->nombre,
      ]);
    }
    //Lista meetodos de pago
    $lista_metodo = MetodoPago::get();

    $metodos_pago = [];
    foreach ($lista_metodo as $metodo) {
      array_push($metodos_pago, [
        'value' => $metodo->id,
        'label' =>  $metodo->nombre,
      ]);
    }

    return Inertia::render('Venta/CreateCotizacion', [
      'codigo' => $codigo,
      'user_id' => $vendedor_id,
      'vendedor' => $vendedor,
      'cotizacion' => $cotizacion,
      'clientes' => $clientes,
      'lista_clientes' => $lista_cliente,
      'detalle_productos' => $detalle_productos,
      'metodos_pago' => $metodos_pago,
      'productos' => new ProductoVentaCollection(
        Producto::orderBy('created_at', 'ASC')
          ->get()
      )
    ]);
  }



  public function store(VentaStoreRequest $request)
  {    
    $last = Venta::latest()->first();
    $vendedor = auth()->user();

    if (empty($last)) {
      $codigo = zero_fill(1, 8);
    } else {

      $codigo = zero_fill($last->codigo + 1, 8);
    }
    DB::beginTransaction();
    try {

      //creando venta
      $venta = Venta::create([
        'codigo' => $codigo,
        'porcentaje_descuento' => $request->porcentaje_descuento,
        'descuento' => $request->descuento ?? 0,
        'neto' => $request->neto ?? 0,
        'saldo' => $request->saldo ?? 0,
        'total' => $request->total ?? 0,
        'estado' => 'COMPLETADO',
        'tipo_pago' => $request->tipo_pago,
        'forma_entrega' => $request->forma_entrega,
        'user_id' => $vendedor->id,
        'cliente_id' => $request->cliente_id
      ]);


      //creando pago
      $pago = Pago::create([
        'monto_efectivo' => $request->monto_efectivo ?? 0,
        'monto_tarjeta' => $request->monto_tarjeta ?? 0,
        'saldo' => $request->saldo ?? 0,
        'num_tarjeta' => $request->num_tarjeta,
        'metodo_pago' => $request->metodo_pago_id == 0 ? null : $request->metodo_pago,
        'tipo_pago' => $request->tipo_pago,
        'forma_entrega' => $request->forma_entrega,
        'venta_id' => $venta->id,
        'user_id' => $venta->user_id,
        'metodo_pago_id' => $request->metodo_pago_id ==0 ? null : $request->metodo_pago_id ,
      ]);
      //creando detalle venta
      foreach ($request->productos as $producto) {

        $venta->detalles_ventas()->create(
          [
            "producto_id" => $producto['producto_id'],
            "precio" => $producto['precio'],
            "cantidad" => $producto['cantidad'],
            "total" => $producto['total'],
          ]
        );
      }
      //relacionando metodo de pago con venta
      //$venta->metodospagos()->sync($request->metodos_pago);

      //actualizando stock producto
      foreach ($request->productos as $producto) {
        $prod = Producto::find($producto['producto_id']);
        $old_stock = $prod->stock;
        $new_stock = $old_stock - $producto['cantidad'];
        $prod->update([
          "stock" => $new_stock
        ]);
        Kardex::create([
          "ticket" => $venta->codigo,
          "cantidad" => $producto['cantidad'],
          "codigo" => $venta->codigo,
          "proveedor" => "",
          "tipo" => "SALIDA VENTA",
          "stock_anterior" => $old_stock,
          "stock_final" => $new_stock,
          "producto_id" => $producto['producto_id'],
          "user_id" => $venta->user_id,
        ]);
      }
      //eliminando cotizacion si escreado desde cotizacion
      if ($request->has('cotizacion_id')) {
        $cotizacion = Cotizacion::find($request->cotizacion_id);
        $cotizacion->delete();
      }


      //creando registro en envio
      $dato_cliente = Cliente::find($venta->cliente_id);
      if ($venta->forma_entrega == "DOMICILIO") {
        $envio = Envio::create([
          'venta_id' => $venta->id,
          'direccion' => $dato_cliente->casa_direccion,
          'colonia' => $dato_cliente->casa_colonia,
          'telefono' => $dato_cliente->telefono,
          'hora' => $request->hora,
          'comentario' => $request->comentario,
          'fecha' => $venta->created_at,

        ]);
        //enviando notificacion a administradores de pedido
        event(new PedidoEvent($envio));

        /** Creando ruta con nombre de colonia */
        $hoy = Carbon::now()->format('Y-m-d');
        $colonia = $dato_cliente->casa_colonia;

        $rutaExistente = Ruta::where('nombre', $colonia)
          ->whereDate('created_at', $hoy)
          ->first();

        if (!$rutaExistente) {
          Ruta::create([
            'nombre' => $colonia,
            'colonias' => $colonia,
          ]);
        }
        /** Fin crear ruta */
      }
      DB::commit();
      return Redirect::route('ventas.index')->with([
        'success' =>  $venta->codigo
      ]);
    } catch (Exception $e) {
      DB::rollBack();
      return [
        'success' => false,
        'message' => $e->getMessage(),
      ];
    }
  }

  public function edit($id)
  {


    //Lista cliente
    $lista_clientes = Cliente::get();
    $lista_cliente = Cliente::select('id', 'rfc', 'tipo_cliente', 'nombre')->get();

    $clientes = [];
    foreach ($lista_clientes as $cliente) {
      array_push($clientes, [
        'value' => $cliente->id,
        'label' =>   $cliente->rfc . " - " . $cliente->nombre,
      ]);
    }
    //Lista meetodos de pago
    $lista_metodo = MetodoPago::get();

    $metodos_pago = [];
    foreach ($lista_metodo as $metodo) {
      array_push($metodos_pago, [
        'value' => $metodo->id,
        'label' =>  $metodo->nombre,
      ]);
    }

    //$venta= new VentaResource(Venta::findOrFail($id));
    $venta = Venta::findOrFail($id);
    $vendedor = $venta->user->name;
    $det_venta = $venta->detalles_ventas()->with('producto')->get();
    $pago = $venta->pagos;

    $detalle_productos = [];


    foreach ($det_venta as $det) {
      array_push($detalle_productos, [
        "producto_id" => $det->producto_id,
        "nombre" => $det->producto->nombre,
        "cantidad" => $det->cantidad,
        "precio" => $det->precio,
        "total" => $det->total,
      ]);
    }

    return Inertia::render('Venta/Edit', [

      'vendedor' => $vendedor,
      'clientes' => $clientes,
      'lista_clientes' => $lista_cliente,
      'metodos_pago' => $metodos_pago,
      'venta' => $venta,
      'detalle_productos' => $detalle_productos,
      'pago' => $pago[0],
      'productos' => new ProductoVentaCollection(
        Producto::orderBy('id', 'DESC')
          ->get()
      )
    ]);
  }
  public function update(VentaUpdateRequest $request, $id)
  {
    $venta = Venta::find($id);

    DB::beginTransaction();
    try {

      /** Por solicitud del cliente solo actualizar (cliente y forma de entrega) */

      $venta->cliente_id     = $request->input('cliente_id');
      //$venta->porcentaje_descuento     = $request->input('porcentaje_descuento');
      //$venta->descuento     = $request->input('descuento') ?? 0;
      //$venta->neto     = $request->neto ?? 0;
      //$venta->total     = $request->input('total') ?? 0;
      //$venta->saldo = $request->saldo ?? 0;
      //$venta->tipo_pago = $request->tipo_pago;
      $venta->forma_entrega = $request->forma_entrega;
      $venta->user_id     = $request->user_id;
      $venta->cliente_id     = $request->cliente_id;

      $venta->save();

      //actualizar pago
      $pago = Pago::find($request->pago_id);
      $pago->forma_entrega = $request->forma_entrega;
      /*
      $pago->monto_efectivo = $request->monto_efectivo ?? 0;
      $pago->monto_tarjeta = $request->monto_tarjeta ?? 0;
      $pago->saldo = $request->saldo ?? 0;
      $pago->num_tarjeta = $request->num_tarjeta;
      $pago->saldo = $request->saldo ?? 0;
      $pago->metodo_pago = $request->metodo_pago;
      $pago->tipo_pago = $request->tipo_pago;
      $pago->venta_id = $request->venta_id;
      $pago->user_id     = $request->user_id;
      $pago->metodo_pago_id     = $request->metodo_pago_id;
      */
      $pago->save();

      //eliminando  detalle
      $venta->detalles_ventas()->delete();
      //actualizar detalle venta
      foreach ($request->productos as $producto) {

        $venta->detalles_ventas()->create(
          [
            "producto_id" => $producto['producto_id'],
            "precio" => $producto['precio'],
            "cantidad" => $producto['cantidad'],
            "total" => $producto['total'],
          ]
        );
      }

      //actualizando stock producto
      /*foreach ($request->productos as $producto) {
                $prod = Producto::find($producto['producto_id']);
                $old_stock = $prod->stock;
                $new_stock = $old_stock - $producto['cantidad'];
                $prod->update([
                    "stock" => $new_stock
                ]);
            }*/

      if ($request->forma_entrega == "DOMICILIO") {
        $dato_cliente = Cliente::find($request->cliente_id);
        /** Creando ruta con nombre de colonia */
        $hoy = Carbon::now()->format('Y-m-d');
        $colonia = $dato_cliente->casa_colonia;

        $rutaExistente = Ruta::where('nombre', $colonia)
          ->whereDate('created_at', $hoy)
          ->first();

        if (!$rutaExistente) {
          Ruta::create([
            'nombre' => $colonia,
            'colonias' => $colonia,
          ]);
        }
        /** Fin crear ruta */
      }

      DB::commit();
      return Redirect::route('ventas.index')->with(['success' =>  $venta->codigo]);
    } catch (Exception $e) {
      DB::rollBack();
      return [
        'success' => false,
        'message' => $e->getMessage(),
      ];
    }
  }
  //eliminar
  public function destroy($id)
  {
    $venta = Venta::find($id);

    $venta->delete();
  }

  //descuento
  public function descuento(Request $request)
  {
    $validated = $request->validate([
      'descuento' => 'required',
      'contrasena' => 'required',
    ]);
    $configuracion = Configuracion::where('value', '=', $request->contrasena)->get();
    if (count($configuracion) > 0) {
    } else {

      throw ValidationException::withMessages([
        'contrasena' => __('Contraseña Inválida'),
      ]);
    }
  }

  public function generarTicket($id)
  {
    $medidas = array(74, 105); // Ajustar aqui segun los milimetros necesarios;

    /*datos*/
    $venta = Venta::where("codigo", "=", $id)->get()[0];

    if (!empty($venta)) {
      $rfc = $venta->cliente->rfc;
      $cliente = $venta->cliente->nombre;
      $codigo = $venta->codigo;
      $vendedor = $venta->user->name;
      $today = date("d/m/Y H:i:s");
      $creado = Carbon::createFromFormat('Y-m-d H:i:s', $venta->created_at)->format('d/m/Y H:i:s');
      $logo = public_path() . '/images/logo-example.jpg';

      $datos_empresa = Configuracion::whereIn('slug', ['tienda-rfc', 'tienda-direccion', 'tienda-ciudad'])->get();
      $detalle_venta = $venta->detalles_ventas()->with('producto')->get();
      $venta_total = $venta->total;
      $venta_descuento = $venta->descuento;
      $venta_neto = $venta->neto;
      $saldo = $venta->saldo;
      $tipo_pago = $venta->pagos[0]->tipo_pago ?? '';
      $total_literal = NumberLetter::convertToLetter($venta->total);
      $metodo_pago = $venta->pagos[0]->metodo_pago ?? '';
      $metodo_pago_id = $venta->pagos[0]->metodo_pago_id ?? '';
      $monto_efectivo = $venta->pagos[0]->monto_efectivo ?? '';
      $monto_tarjeta = $venta->pagos[0]->monto_tarjeta ?? '';


      //$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      //$pdf::AddPage('P',$medidas); //tamaño recibo
      $pdf = new TCPDF('P', 'mm', $medidas, true, 'UTF-8', false);
      $pdf::setPrintHeader(false);
      $pdf::setPrintFooter(false);
      $pdf::SetFont('helvetica', '', 7);

      $pdf::SetMargins(2, 6, 2, true);
      $pdf::SetAutoPageBreak(true, 0);
      $pdf::AddPage('P', $medidas); //tamaño recibo
      $pdf::setImageScale(1);
      $pdf::setJPEGQuality(100);
      //$pdf::Image(public_path() . '/images/logo-example.jpg', 22, 3, 30, 10, 'JPG', '#', '', true, 100, '', false, false, 0, false, false, false);        // set margins


      $data = [
        'tipo_documento' => 'Ticket',
        'hoy' => $today,
        'codigo' => $codigo,
        'cliente' => $cliente,
        'rfc' => $rfc,
        'vendedor' => $vendedor,
        'creado' => $creado,
        'datos_empresa' => $datos_empresa,
        'logo' => $logo,
        'detalle_venta' => $detalle_venta,
        'venta_descuento' => $venta_descuento,
        'venta_total' => $venta_total,
        'venta_neto' => $venta_neto,
        'metodo_pago' => $metodo_pago,
        'monto_efectivo' => $monto_efectivo,
        'monto_tarjeta' => $monto_tarjeta,
        'metodo_pago_id' => $metodo_pago_id,
        'saldo' => $saldo,
        'tipo_pago' => $tipo_pago,
        'total_literal' => $total_literal,
      ];
      //dd($data);
      $fileName = 'factura-' . $codigo . '.pdf';
      $html = view()->make('pdfs.ticket', $data)->render();

      //$pdf::writeHTML($html, false, false, false, false, '');
      $pdf::writeHTML($html, true, false, true, false, '');

      $pdf::Output($fileName, 'I');
    } else {

      return Redirect::route('ventas.index');
    }
  }
}
