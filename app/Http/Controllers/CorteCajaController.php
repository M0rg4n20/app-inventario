<?php

namespace App\Http\Controllers;


use App\Models\Venta;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class CorteCajaController extends Controller
{
  public function __construct()
  {
    //protegiendo el controlador segun el rol
    //$this->middleware(['auth', 'permission:ver-cortecaja'])->only('index');

  }
  public function index()
  {
    $user_id = auth()->user();
    $ventas =  Venta::orderBy('id', 'DESC')->get();
    $l_fechas = Venta::orderBy('id', 'ASC')->get();
    $lista_fechas = [];
    foreach ($l_fechas as $fecha) {
      array_push($lista_fechas, ["name" => $fecha->created_at->format('d/m/Y')]);
    }
    $hoy = date("d/m/Y");

    $nuevo = array_values(array_unique($lista_fechas, SORT_REGULAR));
    $rol = auth()->user()->roles->pluck('name')[0];
  
  if  ($rol =="Administrador de pedidos" || $rol =="Administrador" || $rol =="Ventas")
  {
    if  ($rol =="Administrador de pedidos" )
    {
    $datos = DB::table('pagos as pa')
      ->join('ventas as ve', 've.id', '=', 'pa.venta_id')
      ->join('users as us', 'us.id', '=', 'pa.user_id')
      ->select(DB::raw("pa.id, ve.codigo,us.name AS vendedor,ve.neto,ve.descuento,pa.saldo,ve.total,pa.metodo_pago,pa.metodo_pago_id,pa.monto_efectivo,pa.monto_tarjeta,pa.tipo_pago,pa.forma_entrega,
         DATE_FORMAT(pa.created_at ,'%d/%m/%Y %H:%i:%s') AS fecha" )
        )
      ->orderBy('fecha', 'desc')
   //   ->where('pa.user_id', '=', $user_id->id)
   ->where('ve.forma_entrega', '=', 'DOMICILIO')
   ->where('pa.tipo_pago', '=', 'ABONO')
      ->get();
    }

    if  ($rol =="Ventas")
    {
    $datos = DB::table('pagos as pa')
      ->join('ventas as ve', 've.id', '=', 'pa.venta_id')
      ->join('users as us', 'us.id', '=', 'pa.user_id')
      ->select(DB::raw("pa.id, ve.codigo,us.name AS vendedor,ve.neto,ve.descuento,pa.saldo,ve.total,pa.metodo_pago,pa.metodo_pago_id,pa.monto_efectivo,pa.monto_tarjeta,pa.tipo_pago,pa.forma_entrega,
         DATE_FORMAT(pa.created_at ,'%d/%m/%Y %H:%i:%s') AS fecha" )
        )
      ->orderBy('fecha', 'desc')
   //   ->where('pa.user_id', '=', $user_id->id)
      //->where('ve.forma_entrega', '=', 'INMEDIATA')
       ->where('pa.tipo_pago', '<>', 'ABONO')
      ->get();
    }

    if  ($rol =="Administrador")
    {
    $datos = DB::table('pagos as pa')
      ->join('ventas as ve', 've.id', '=', 'pa.venta_id')
      ->join('users as us', 'us.id', '=', 'pa.user_id')
      ->select(DB::raw("pa.id, ve.codigo,us.name AS vendedor,ve.neto,ve.descuento,pa.saldo,ve.total,pa.metodo_pago,pa.metodo_pago_id,pa.monto_efectivo,pa.monto_tarjeta,pa.tipo_pago,pa.forma_entrega,
         DATE_FORMAT(pa.created_at ,'%d/%m/%Y %H:%i:%s') AS fecha" )
        )
      ->orderBy('fecha', 'desc')
   //   ->where('pa.user_id', '=', $user_id->id)
    //  ->where('ve.forma_entrega', '=', 'INMEDIATA')
      ->get();
    }
//return    $datos;
    return Inertia::render('CorteCaja/Index', [
      'cortecaja' => $datos,
      'hoy' => $hoy,
      'lista_fechas' => $nuevo
    ]);
  }else
  {
    
    $datos = DB::table('pagos as pa')
      ->join('ventas as ve', 've.id', '=', 'pa.venta_id')
      ->join('users as us', 'us.id', '=', 'pa.user_id')
      ->select(DB::raw("pa.id, ve.codigo,us.name AS vendedor,ve.neto,ve.descuento,pa.saldo,ve.total,pa.metodo_pago,pa.metodo_pago_id,pa.monto_efectivo,pa.monto_tarjeta,pa.tipo_pago,pa.forma_entrega,
         DATE_FORMAT(pa.created_at ,'%d/%m/%Y %H:%i:%s') AS fecha" )
        )
      ->orderBy('fecha', 'desc')
      ->where('pa.user_id', '=', $user_id->id)
      //->where('pa.tipo_pago', '=', 'ABONO')
      ->get();

//return    $datos;
    return Inertia::render('CorteCaja/Index', [
      'cortecaja' => $datos,
      'hoy' => $hoy,
      'lista_fechas' => $nuevo
    ]);
  }
}

}

function php_console_log( $data, $comment = NULL ) {	
  $output='';	
  if(is_string($comment))
      $output .= "<script>console.warn( '$comment' );";
  elseif($comment!=NULL)
      $comment==NULL;//Si se pasa algo que no sea un string se pone a NULL para que no de problemas
  if ( is_array( $data ) ) {
      if($comment==NULL)
          $output .= "<script>console.warn( 'Array PHP:' );";
      $output .= "console.log( '[" . implode( ',', $data) . "]' );</script>";
  } else if ( is_object( $data ) ) {
      $data    = var_export( $data, TRUE );
      $data    = explode( "\n", $data );
      if($comment==NULL)
          $output .= "<script>console.warn( 'Objeto PHP:' );";
      foreach( $data as $line ) {
          if ( trim( $line ) ) {
              $line    = addslashes( $line );
              $output .= "console.log( '{$line}' );";
          }
      }
      $output.="</script>";
  } else {
      if($comment==NULL)
          $output .= "<script>console.warn( 'Valor de variable PHP:' );";
      $output .= "console.log( '$data' );</script>";
  }
      
  echo $output;
}