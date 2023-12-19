<?php

namespace App\Http\Controllers;

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
use App\Http\Requests\PagoStoreRequest;
use App\Http\Requests\VentaUpdateRequest;
use App\Models\Cotizacion;
use App\Models\Pago;

class AbonoController extends Controller
{
  public function __construct()
  {
    //protegiendo el controlador segun el rol
    $this->middleware(['auth', 'permission:lista-abonos'])->only('index');
    $this->middleware(['auth', 'permission:crear-abonos'])->only(['store', 'create']);
    //$this->middleware(['auth', 'permission:editar-abonos'])->only(['update']);
    //$this->middleware(['auth', 'permission:eliminar-abonos'])->only(['destroy']);
  }

  public function index()
  {
    $rol = auth()->user()->roles->pluck('name')[0];

    // if($rol=="Super Administrador"){
    return Inertia::render('Abono/Index', $this->getDataIndex());
    /* }else{
            return Inertia::render('Usuarios/Index', [
                //'filters' => Request::all('search'),
                'lista_roles'=>$lista_roles,
                'usuarios' => new UsuarioCollection(
                    User:: where('id','!=',1)->
                    orderBy('id', 'ASC')
                    ->filter(Request::only('search'))
                    ->get())
            ]);*/
  }

  private function getDataIndex()
  {

    
    $lista_abonos = DB::table('pagos as pa')
      ->join('ventas as ve', 've.id', '=', 'pa.venta_id')
      ->join('clientes as cl', 'cl.id', '=', 've.cliente_id')
      ->join('users as us', 'us.id', '=', 'pa.user_id')
      ->select(DB::raw("pa.id,ve.codigo,pa.saldo,pa.monto_efectivo,ve.total,pa.monto_tarjeta,cl.nombre AS cliente,us.name AS usuario, ve.created_at"))
      ->orderBy('pa.created_at', 'asc')
      ->where('pa.tipo_pago', '=', 'ABONO')
      //->where('pa.saldo', '>', '0')
      ->get();
    

   /* $lista_abonos = DB::table('vw_Abonos')  
      ->get();*/


   /* $lista_abonos = DB::table('ventas as v')
      ->join('clientes as c', 'v.cliente_id', '=', 'c.id')
      ->join('users as u', 'v.user_id', '=', 'u.id')
      ->leftJoin('pagos as p', 'v.id', '=', 'p.venta_id')
      ->select(
        'v.id',
        'v.codigo',
        'v.total',
        DB::raw('SUM(p.monto_efectivo) as monto_efectivo'),
        DB::raw('SUM(p.monto_tarjeta) as monto_tarjeta'),
        'c.nombre as cliente',
        'u.name as usuario',
        DB::raw('(v.total - SUM(p.monto_efectivo + p.monto_tarjeta)) as saldo'),
        'v.created_at'
      )
      ->groupBy('v.id', 'v.codigo', 'v.total', 'c.nombre', 'u.name', 'v.created_at')
      ->havingRaw('saldo > 0')
      ->get();
*/
    $lista_ventas = Venta::with('cliente')
      ->whereExists(function ($query) {
        $query->select(DB::raw('SUM(pagos.monto_efectivo + pagos.monto_tarjeta)'))
          ->from('pagos')
          ->whereColumn('pagos.venta_id', 'ventas.id')
          ->havingRaw('SUM(pagos.monto_efectivo + pagos.monto_tarjeta) < ventas.total');
      })->get();

    $ventas = [];
    foreach ($lista_ventas as $venta) {
      array_push($ventas, [
        'value' => $venta->id,
        'label' =>   $venta->codigo . " - " . $venta->cliente->nombre
      ]);
    }

    $lista_metodo = MetodoPago::get();
    $metodos_pago = [];
    foreach ($lista_metodo as $metodo) {
      array_push($metodos_pago, [
        'value' => $metodo->id,
        'label' =>  $metodo->nombre,
      ]);
    }

    return [
      'lista_abonos' => $lista_abonos,
      'metodos_pago' => $metodos_pago,
      'ventas' => $ventas,
      'success' => true,
      'message' => ''
    ];
  }

  public function store(PagoStoreRequest $request)
  {
    $last_pago = Pago::where('venta_id', '=', $request->venta_id)->latest()->first();
    $ultimo_saldo = $last_pago->saldo;
    $forma_entrega = $last_pago->forma_entrega;

    $saldo_actual = $ultimo_saldo - ($request->monto_efectivo + $request->monto_tarjeta);

    $venta = Venta::find($request->venta_id);
    $vendedor = auth()->user();
    //dd($venta);

    if ($saldo_actual < 0) {
      $data = $this->getDataIndex();
      $data['success'] = false;
      $data['message'] = 'El monto de pago excede el total pendiente. Saldo (' . $last_pago->saldo . '). Abono (' . ($request->monto_efectivo + $request->monto_tarjeta) . ')';
      return Inertia::render('Abono/Index', $data);
    }

    DB::beginTransaction();
    try {
      //creando pago
      $pago = Pago::create([
        'monto_efectivo' => $request->monto_efectivo ?? 0,
        'monto_tarjeta' => $request->monto_tarjeta ?? 0,
        'saldo' => $saldo_actual,
        'num_tarjeta' => $request->num_tarjeta,
        'metodo_pago' => $request->metodo_pago,
        'tipo_pago' => $request->tipo_pago,
        'forma_entrega' => $forma_entrega,
        'venta_id' => $request->venta_id,
        'user_id' => $vendedor->id,
        'metodo_pago_id' => $request->metodo_pago_id,
      ]);
      //actualizando saldo venta
      $venta->saldo = $saldo_actual;

      DB::commit();
      $data = $this->getDataIndex();
      $data['success'] = true;
      $data['message'] = 'Pago registrado';
      return Inertia::render('Abono/Index', $data);
    } catch (Exception $e) {
      DB::rollBack();
      return [
        'success' => false,
        'message' => $e->getMessage(),
      ];
    }
  }

  public function generarTicket($id)
  {
    $medidas = array(74, 105);
    /*
    $venta = Venta::where("codigo", "=", $id)->get()[0];
    */
    $venta = Venta::with('pagos')->where('codigo', $id)->first();

    if (!empty($venta)) {
      $totalPagos = $venta->pagos->sum(function ($pago) {
        return $pago->monto_efectivo + $pago->monto_tarjeta;
      });

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

      $lista_abonos = DB::table('pagos as pa')
        ->join('ventas as ve', 've.id', '=', 'pa.venta_id')
        ->select(DB::raw("pa.id, ve.codigo, pa.saldo, pa.monto_efectivo, ve.total, pa.monto_tarjeta, pa.metodo_pago, pa.tipo_pago, ve.created_at"))
        ->orderBy('pa.created_at', 'asc')
        ->where('pa.venta_id', '=', $venta->id)
        ->where(function ($query) {
          $query->where('pa.monto_efectivo', '>', 0)
            ->orWhere('pa.monto_tarjeta', '>', 0);
        })
        ->get();

      $pdf = new TCPDF('P', 'mm', $medidas, true, 'UTF-8', false);
      $pdf::setPrintHeader(false);
      $pdf::setPrintFooter(false);
      $pdf::SetFont('helvetica', '', 7);

      $pdf::SetMargins(2, 6, 2, true);
      $pdf::SetAutoPageBreak(true, 0);
      $pdf::AddPage('P', $medidas);
      $pdf::setImageScale(1);
      $pdf::setJPEGQuality(100);

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
        'relacion_pagos' => $lista_abonos,
        'venta_descuento' => $venta_descuento,
        'venta_total' => $venta_total,
        'total_pagos' => $totalPagos,
        'venta_neto' => $venta_neto,
        'metodo_pago' => $metodo_pago,
        'monto_efectivo' => $monto_efectivo,
        'monto_tarjeta' => $monto_tarjeta,
        'metodo_pago_id' => $metodo_pago_id,
        'saldo' => $saldo,
        'tipo_pago' => $tipo_pago,
        'total_literal' => $total_literal,
      ];
      //dd($lista_abonos);
      $fileName = 'abonos-' . $codigo . '.pdf';
      $html = view()->make('pdfs.abonos', $data)->render();
      $pdf::writeHTML($html, true, false, true, false, '');
      $pdf::Output($fileName, 'I');
    } else {
      return Redirect::route('abonos.index');
    }
  }
}
