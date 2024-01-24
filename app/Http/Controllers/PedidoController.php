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
use Illuminate\Support\Facades\DB;

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
/* 
  
  public function asignar($id = null)
  {
   
    $envio = Envio::findOrFail($id);
  
    //lista repartidores
    $lista_repartidores = User::with('roles')->get()->filter(
      fn ($user) => $user->roles->where('name', 'Repartidor')->toArray()
    );


    $lista_rutas = Ruta::where('created_at', '>=', $this->ini_dia)
      ->where('created_at', '<=', $this->fin_dia)
      ->get();

      
  //  $lista_rutas = Ruta::All(); 

    $lista_rutas = DB::table('vw_rutas as ve')
    ->select(DB::raw("distinct DATE_FORMAT(ve.created_at,'%d/%m/%y') AS fecha,ve.colonia, id"))
    ->where('ve.created_at', '>=', $this->ini_dia)
    ->where('ve.created_at', '<=', $this->fin_dia)
    ->where('ve.colonia', '<=', $envio->colonia)
    ->whereNull('ve.repartidor_id')
    ->distinct()
    ->get();


    $repartidores = [];
    $rutas = [];

    $consecutivo=0;
    foreach ($lista_rutas as $ruta) {
      $consecutivo=$consecutivo + 1;
      array_push($rutas, [
        'value' => $consecutivo,
        'label' =>  $ruta->colonia,
      ]);
    }
    foreach ($lista_repartidores as $repartidor) {
      //Buscamos la cantidad de rutas que tiene el repartidor
      $lista_rutas_asignadas = DB::table('vw_rutas as ve')
      ->select(DB::raw("distinct DATE_FORMAT(ve.created_at,'%d/%m/%y') AS fecha,ve.colonia, id"))
      ->where('ve.created_at', '>=', $this->ini_dia)
      ->where('ve.created_at', '<=', $this->fin_dia)
      ->where('ve.repartidor_id',$repartidor->id)
      ->distinct()
      ->get();
  
      $cantidadrutas= $lista_rutas_asignadas->count();
      array_push($repartidores, [
        'value' => $repartidor->id,
        'label' =>   $repartidor->name,
        'cantidad_rutas'=> $cantidadrutas
      ]);
    }
    return response()->json([
      "envio" => $envio,
      "rutas" => $rutas,
      "repartidores" => $repartidores,

    ]);
 } 
 */
 
  public function asignarindividual($id = null)
  {
    $hoy = Carbon::now()->format('Y-m-d');
    $envio = Envio::findOrFail($id);
    //1. Cargamos todos los repartidores con la cantidad de rutas que tienen para este dia
    //lista repartidores
    $lista_repartidores = User::with('roles')->get()->filter(
      fn ($user) => $user->roles->where('name', 'Repartidor')->toArray()
    );

    $lista_rutas = DB::table('vw_rutas as ve')
    ->select(DB::raw("distinct DATE_FORMAT(ve.created_at,'%d/%m/%y') AS fecha,ve.colonia, id"))
    ->where('ve.created_at', '>=', $this->ini_dia)
    ->where('ve.created_at', '<=', $this->fin_dia)
    ->where('ve.colonia', '<=', $envio->colonia)
    ->whereNull('ve.repartidor_id')
    ->distinct()
    ->get();

    $repartidores = [];
    $rutas = [];

    foreach ($lista_repartidores as $repartidor) {
      //Buscamos la cantidad de rutas que tiene el repartidor
      $lista_rutas_asignadas = DB::table('vw_rutas as ve')
      ->select(DB::raw("distinct DATE_FORMAT(ve.created_at,'%d/%m/%y') AS fecha,ve.colonia, id"))
      ->whereDate('ve.created_at', $hoy)
      ->where('ve.repartidor_id',$repartidor->id)
      ->distinct()
      ->get();
 
    $cantidadrutas= $lista_rutas_asignadas->count();

     array_push($repartidores, [
       'value' => $repartidor->id,
       'label' =>   $repartidor->name,
       'cantidad_rutas'=> $cantidadrutas
     ]);
    }
    return response()->json([
      "envio" => $envio,
      "rutas" => $rutas,
      "repartidores" => $repartidores,

    ]);
  }
 


  public function asignar($id = null)
  {  
    $hoy = Carbon::now()->format('Y-m-d');
    //lista repartidores
    $lista_repartidores = User::with('roles')->get()->filter(
      fn ($user) => $user->roles->where('name', 'Repartidor')->toArray()
    );
   
    //Buscamos las rutsa
    $lista_rutas = Ruta::where('created_at', '>=', $this->ini_dia)
      ->where('created_at', '<=', $this->fin_dia)
      ->get();

      $repartidores = [];
      $rutas = [];
      
      foreach ($lista_repartidores as $repartidor) {
        //Buscamos la cantidad de rutas que tiene el repartidor
        $lista_rutas_asignadas = DB::table('vw_rutas as ve')
        ->select(DB::raw("distinct DATE_FORMAT(ve.created_at,'%d/%m/%y') AS fecha,ve.colonia, id"))
        ->whereDate('ve.created_at', $hoy)
        ->where('ve.repartidor_id',$repartidor->id)
        ->distinct()
        ->get();
   
      $cantidadrutas= $lista_rutas_asignadas->count();
  
       array_push($repartidores, [
         'value' => $repartidor->id,
         'label' =>   $repartidor->name,
         'cantidad_rutas'=> $cantidadrutas
       ]);
      }

 
   /*   $lista_rutas = DB::table('vw_rutas as ve')
    ->select(DB::raw("distinct DATE_FORMAT(ve.created_at,'%d/%m/%y') AS fecha,ve.colonia, id"))
    ->where('ve.created_at', '>=', $this->ini_dia)
    ->where('ve.created_at', '<=', $this->fin_dia)
    //->where('ve.colonia', '<=', $envio->colonia)
    ->whereNull('ve.repartidor_id')
    ->distinct()
    ->get();  */

  //  return $lista_repartidores;


   

    foreach ($lista_rutas as $ruta) {
      array_push($rutas, [
        'value' => $ruta->id,
        'label' =>   $ruta->nombre,
      ]);
    } 
    /* foreach ($lista_repartidores as $repartidor) {
      array_push($repartidores, [
        'value' => $repartidor->id,
        'label' =>   $repartidor->name,
      ]);
    } */
    return response()->json([
   //   "envio" => $envio,
      "rutas" => $rutas,
      "repartidores" => $repartidores,

    ]);
  } 

  
  public function asignarrm($id = null)
  {  
    $hoy = Carbon::now()->format('Y-m-d');
    //lista repartidores
    $lista_repartidores = User::with('roles')->get()->filter(
      fn ($user) => $user->roles->where('name', 'Repartidor')->toArray()
    );  


      $repartidores = [];   
      
      foreach ($lista_repartidores as $repartidor) {
        //Buscamos la cantidad de rutas que tiene el repartidor
        $lista_rutas_asignadas = DB::table('vw_rutas as ve')
        ->select(DB::raw("distinct DATE_FORMAT(ve.created_at,'%d/%m/%y') AS fecha,ve.colonia, id"))
        ->whereDate('ve.created_at', $hoy)
        ->where('ve.repartidor_id',$repartidor->id)
        ->distinct()
        ->get();
   
      $cantidadrutas= $lista_rutas_asignadas->count();
  
       array_push($repartidores, [
         'value' => $repartidor->id,
         'label' =>   $repartidor->name,
         'cantidad_rutas'=> $cantidadrutas
       ]);
      }

 
   /*   $lista_rutas = DB::table('vw_rutas as ve')
    ->select(DB::raw("distinct DATE_FORMAT(ve.created_at,'%d/%m/%y') AS fecha,ve.colonia, id"))
    ->where('ve.created_at', '>=', $this->ini_dia)
    ->where('ve.created_at', '<=', $this->fin_dia)
    //->where('ve.colonia', '<=', $envio->colonia)
    ->whereNull('ve.repartidor_id')
    ->distinct()
    ->get();  */

  //  return $lista_repartidores;


   
    /* foreach ($lista_repartidores as $repartidor) {
      array_push($repartidores, [
        'value' => $repartidor->id,
        'label' =>   $repartidor->name,
      ]);
    } */
    return response()->json([
   //   "envio" => $envio,
      
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

    if (empty($request->ruta_id) || ($request->ruta_id==0) || is_null($request->ruta_id)) {   

      $hoy = Carbon::now()->format('Y-m-d');
      $rutaExistente = Ruta::where('nombre', $request->colonia)
        ->where('repartidor_id', $request->repartidor_id)
        ->whereDate('created_at', $hoy)
        ->first();

      if (!$rutaExistente) {
       
        $nuevaRuta = Ruta::create([
          'nombre' => $request->colonia,
          'colonias' => $request->colonia,
          'repartidor_id' =>  $request->repartidor_id          
        ]);

        $datos = DB::select("call asignarcodigo( $nuevaRuta->id)");
      
        $request->merge(['ruta_id' => $nuevaRuta->id]);
      } else {
     
        $request->merge(['ruta_id' => $rutaExistente->id]);

      }
    }
    /*else{
      //Si esta ruta tiene repartidor null, procedemos a actualizar
      $rutaupdate = Ruta::find($request->ruta_id);
      if ($rutaupdate->repartidor_id == null)
      {
        $rutaupdate->repartidor_id= $request->repartidor_id;
        $rutaupdate->save();
      }    
    }*/

    $envio = Envio::find($id);
  
    $envio->responsable_id = $request->responsable_id;
    $envio->repartidor_id = $request->repartidor_id;
    $envio->ruta_id = $request->ruta_id;
    $envio->estado = 'Asignado';
    $envio->save();

    return Redirect::route('pedidos.index');
  }


/* 
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
 */
  /* public function updateMultiple(RepartidorPedidoMultipleUpdateRequest $request)
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
  } */

  

  public function updateMultiple(RepartidorPedidoMultipleUpdateRequest $request)
  {

    $hoy = Carbon::now()->format('Y-m-d');

   // return $request;
    $ruta_id = $request->ruta_id;  
    $responsable_id = $request->responsable_id;
    $selected_orders = $request->selected_orders;

    $repartidor_id = $request->repartidor_id;
    $rutasseleccionadas = $request->rutasseleccionadas;

    $rutasexistentes = 0;

    foreach($rutasseleccionadas as $rutaseleccionada)
    {
      //verificamos si existe una ruta para este repartidor
      $hoy = Carbon::now()->format('Y-m-d');
      $rutaExistente = Ruta::where('nombre', $rutaseleccionada)
        ->where('repartidor_id', $request->repartidor_id)
        ->whereDate('created_at', $hoy)
        ->first();
      
       // return $rutaExistente;
        if (!$rutaExistente) 
        {
          $ruta = Ruta::create(
            [
                "nombre" => $rutaseleccionada,
                "colonias" => $rutaseleccionada,
                "repartidor_id"=> $request->repartidor_id
            ]
        );
        
        $datos = DB::select("call asignarcodigo( $ruta->id)");
      }   
    }

    return Redirect::route('pedidos.index');

      
 /*    foreach ($selected_orders as $order_id) {
      $envio = Envio::where('id', $order_id)->first();
      if ($envio) {
        $envio->ruta_id = $ruta_id;
        $envio->repartidor_id = $repartidor_id;
        $envio->responsable_id = $responsable_id;
        $envio->estado = 'Asignado';
        $envio->save();
      }
    }
    */
  }

  
  public function updateMultipleRepartidor(RepartidorPedidoMultipleUpdateRequest $request)
  {  
    $hoy = Carbon::now()->format('Y-m-d');

    $ruta_id = $request->ruta_id;  
    $responsable_id = $request->responsable_id;
    $selected_orders = $request->selected_orders;
    $repartidor_id = $request->repartidor_id;

    foreach ($selected_orders as $order_id) {
      $envio = Envio::where('id', $order_id)->first();

      if ($envio) {

        //Buscamos si existe una ruta para esta colonia
        $rutaExistente = Ruta::where('nombre', $envio->colonia)
        ->where('repartidor_id', $request->repartidor_id)
        ->whereDate('created_at', $hoy)
        ->first();

        if (!$rutaExistente) 
        {
          $ruta = Ruta::create(
            [
                "nombre" =>  $envio->colonia,
                "colonias" =>  $envio->colonia,
                "repartidor_id"=> $request->repartidor_id
            ]
        );

        $datos = DB::select("call asignarcodigo( $ruta->id)");
        
        $request->merge(['ruta_id' => $ruta->id]);
        }else
        {
          $request->merge(['ruta_id' => $rutaExistente->id]);
        }

        $envio->ruta_id = $request->ruta_id;
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
