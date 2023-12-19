<?php

namespace App\Http\Controllers;


use App\Http\Requests\CotizacionStoreRequest;
use App\Http\Resources\ProductoVentaCollection;
use App\Http\Resources\CotizacionCollection;
use App\Models\Cliente;
use App\Models\Configuracion;
use Exception;
use App\Models\MetodoPago;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Cotizacion;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Elibyy\TCPDF\Facades\TCPDF;
use App\Helpers\NumberLetter;
use App\Http\Requests\CotizacionUpdateRequest;


class CotizacionController extends Controller
{
  public function __construct()
  {
    //protegiendo el controlador segun el rol
    //$this->middleware(['auth', 'permission:lista-cotizaciones'])->only('index');
    //$this->middleware(['auth', 'permission:crear-cotizaciones'])->only(['store','create']);
    //$this->middleware(['auth', 'permission:editar-cotizaciones'])->only(['update']);
    //$this->middleware(['auth', 'permission:eliminar-cotizaciones'])->only(['destroy']);
  }

  public function index()
  {

    return Inertia::render('Cotizacion/Index', [
      'cotizaciones' => new CotizacionCollection(
        Cotizacion::orderBy('created_at', 'ASC')
          ->get()
      )
    ]);
  }

  public function create()
  {
    $last = Cotizacion::latest()->first();
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
        'label' =>   $cliente->rfc . " | " . $cliente->nombre,
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

    return Inertia::render('Cotizacion/Create', [
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



  public function store(CotizacionStoreRequest $request)
  {
    //dd($request);
    $last = Cotizacion::latest()->first();
    $vendedor = auth()->user();

    if (empty($last)) {
      $codigo = zero_fill(1, 8);
    } else {

      $codigo = zero_fill($last->codigo + 1, 8);
    }
    DB::beginTransaction();
    try {

      //creando cotizacion
      $venta = Cotizacion::create([
        'user_id' => $vendedor->id,
        'cliente_id' => $request->cliente_id,
        'codigo' => $codigo,
        'impuesto' => $request->impuesto,
        'porcentaje_descuento' => $request->porcentaje_descuento,
        'descuento' => $request->descuento,
        'neto' => $request->neto,
        'abono' => $request->abono,
        'total' => $request->total,
        //'tipo_venta' => $request->tipo_venta,
      ]);
      //creando detalle cotizacion
      foreach ($request->productos as $key => $producto) {

        $venta->detalles_cotizaciones()->create(
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
      /*
            foreach ($request->productos as $producto) {
                $prod = Producto::find($producto['producto_id']);
                $old_stock = $prod->stock;
                $new_stock = $old_stock - $producto['cantidad'];
                $prod->update([
                    "stock" => $new_stock
                ]);
            }*/

      DB::commit();
      return Redirect::route('cotizaciones.index')->with([
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
        'label' =>   $cliente->rfc . " | " . $cliente->nombre,
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


    $venta = Cotizacion::findOrFail($id);
    $vendedor = $venta->user->name;
    $det_venta = $venta->detalles_cotizaciones()->with('producto')->get();
    //$pagos = $venta->metodospagos;
    $detalle_productos = [];
    //$detalle_pagos = [];

    foreach ($det_venta as $det) {
      array_push($detalle_productos, [
        "producto_id" => $det->producto_id,
        "nombre" => $det->producto->nombre,
        "cantidad" => $det->cantidad,
        "precio" => $det->precio,
        "total" => $det->total,
      ]);
    }
    /*foreach ($pagos as $pago) {
            array_push($detalle_pagos, [
                "metodo_pago_id" => $pago->pagos->metodo_pago_id,
                "tarjeta" => $pago->pagos->tarjeta,
                "monto" => $pago->pagos->monto,
            ]);
        }*/

    //return $detalle_productos;
    return Inertia::render('Cotizacion/Edit', [

      'vendedor' => $vendedor,
      'clientes' => $clientes,
      'lista_clientes' => $lista_cliente,
      //'metodos_pago' => $metodos_pago,
      'cotizacion' => $venta,
      'detalle_productos' => $detalle_productos,
      //'detalle_pagos' => $detalle_pagos,
      'productos' => new ProductoVentaCollection(
        Producto::orderBy('id', 'DESC')
          ->get()
      )
    ]);
  }

  public function update(CotizacionUpdateRequest $request, $id)
  {
    $venta = Cotizacion::find($id);

    DB::beginTransaction();
    try {

      $venta->cliente_id     = $request->input('cliente_id');
      $venta->impuesto     = $request->input('impuesto');
      $venta->porcentaje_descuento     = $request->input('porcentaje_descuento');
      $venta->descuento     = $request->input('descuento');
      $venta->neto     = $request->input('neto');
      $venta->abono     = $request->input('abono');
      $venta->total     = $request->input('total');
      $venta->tipo_venta     = $request->input('tipo_venta');

      $venta->save();

      //eliminando  detalle
      $venta->detalles_cotizaciones()->delete();
      //actualizar detalle venta
      foreach ($request->productos as $key => $producto) {

        $venta->detalles_cotizaciones()->create(
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
      /*foreach ($request->productos as $producto) {
                $prod = Producto::find($producto['producto_id']);
                $old_stock = $prod->stock;
                $new_stock = $old_stock - $producto['cantidad'];
                $prod->update([
                    "stock" => $new_stock
                ]);
            }*/

      DB::commit();
      return Redirect::route('cotizaciones.index')->with(['success' =>  $venta->codigo]);
    } catch (Exception $e) {
      DB::rollBack();
      return [
        'success' => false,
        'message' => $e->getMessage(),
      ];
    }
  }

  public function destroy($id)
  {
    $venta = Cotizacion::find($id);

    $venta->delete();
  }


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
    $venta = Cotizacion::where("codigo", "=", $id)->get()[0];

    if (!empty($venta)) {
      $rfc = $venta->cliente->rfc;
      $cliente = $venta->cliente->nombre;
      $codigo = $venta->codigo;
      $vendedor = $venta->user->name;
      $today = date("d/m/Y H:i:s");
      $creado = Carbon::createFromFormat('Y-m-d H:i:s', $venta->created_at)->format('d/m/Y H:i:s');
      $logo = public_path() . '/images/logo-example.jpg';

      $datos_empresa = Configuracion::whereIn('slug', ['tienda-rfc', 'tienda-direccion', 'tienda-ciudad'])->get();
      $detalle_venta = $venta->detalles_cotizaciones()->with('producto')->get();
      $venta_total = $venta->total;
      $venta_descuento = $venta->descuento;
      $venta_neto = $venta->neto;
      $tipo_venta = $venta->tipo_venta;
      $total_literal = NumberLetter::convertToLetter($venta->total);
      $metodos_pago = ""; //$venta->metodospagos()->with('ventas')->get();

      //dd($total_literal);
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


      $metodo_pago = '';
      $data = [
        'tipo_documento' => 'Cotización',
        'hoy' => $today,
        'codigo' => $codigo,
        'cliente' => $cliente,
        'rfc' => $rfc,
        'vendedor' => $vendedor,
        'creado' => $creado,
        'datos_empresa' => $datos_empresa,
        'logo' => $logo,
        'metodo_pago' => $metodo_pago,
        'saldo' => 0,
        'detalle_venta' => $detalle_venta,
        'venta_descuento' => $venta_descuento,
        'venta_total' => $venta_total,
        'venta_neto' => $venta_neto,
        'metodos_pago' => $metodos_pago,
        'tipo_venta' => $tipo_venta,
        'total_literal' => $total_literal,
        'metodo_pago_id' => '',
        'tipo_pago' => ''
      ];
      $fileName = 'cotizacion-' . $codigo . '.pdf';
      $html = view()->make('pdfs.ticket', $data)->render();

      //$pdf::writeHTML($html, false, false, false, false, '');
      $pdf::writeHTML($html, true, false, true, false, '');

      $pdf::Output($fileName, 'I');
    } else {

      return Redirect::route('cotizaciones.index');
    }
  }
}
