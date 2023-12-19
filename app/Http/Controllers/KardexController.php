<?php

namespace App\Http\Controllers;

use App\Http\Requests\DevolucionStoreRequest;
use App\Http\Requests\EntradaStoreRequest;
use App\Http\Requests\RepartidorPedidoUpdateRequest;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Envio;
use App\Models\Kardex;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use App\Models\Ruta;
use App\Models\User;
use Exception;

class KardexController extends Controller
{
    private $ini_dia;
    private $fin_dia;
    public function __construct()
    {
        //protegiendo el controlador segun el rol
        //$this->middleware(['auth', 'permission:kardex'])->only('index');
        //$this->middleware(['auth', 'permission:kardex-entrada'])->only(['store','create']);
        //$this->middleware(['auth', 'permission:kardex-salida'])->only(['update']);
        $this->ini_dia = Carbon::now()->startOfDay();
        $this->fin_dia = Carbon::now()->endOfDay();
    }

    public function index()
    {

        $productos = Kardex::with('producto','user')->orderBy('id','desc')->get();
        return Inertia::render('Kardex/Index', [
            'productos' => $productos

        ]);
    }

    public function entrada()
    {
        $lista_productos = Producto::select('id', 'nombre', 'codigo')->get();
        $productos = [];
        foreach ($lista_productos as $prod) {
            array_push($productos, [
                'value' => $prod->id,
                'label' =>  $prod->codigo . " | " . $prod->nombre,
            ]);
        }

        return Inertia::render('Kardex/Entrada', [
            'productos' => $productos
        ]);
    }

    public function guardarEntrada(EntradaStoreRequest $request)
    {
        $producto = Producto::find($request->producto_id);
        DB::beginTransaction();
        try {
            $stock_anterior = $producto->stock;
            Kardex::create([
                "ticket" => $request->ticket,
                "cantidad" => $request->cantidad,
                "codigo" => $request->codigo,
                "proveedor" => $request->proveedor,
                "tipo" => "ENTRADA",
                "stock_anterior" => $stock_anterior,
                "stock_final" => $stock_anterior + $request->cantidad,
                "producto_id" => $request->producto_id,
                "comentario" => $request->comentario,
                "user_id" => $request->user_id,
            ]);

            $producto->stock =  $stock_anterior + $request->cantidad;
            $producto->save();
            DB::commit();
            return Redirect::route('kardex.index');
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function devolucion()
    {
        $lista_productos = Producto::select('id', 'nombre', 'codigo')->get();
        $productos = [];
        foreach ($lista_productos as $prod) {
            array_push($productos, [
                'value' => $prod->id,
                'label' =>  $prod->codigo . " | " . $prod->nombre,
            ]);
        }

        return Inertia::render('Kardex/Devolucion', [
            'productos' => $productos
        ]);
    }


    public function guardarDevolucion(DevolucionStoreRequest $request)
    {
        $producto = Producto::find($request->producto_id);
        DB::beginTransaction();
        try {
            $stock_anterior = $producto->stock;
            $stock_f=0;
            if($request->tipo=="SALIDA POR DEVOLUCIÓN"){
                $stock_f=$stock_anterior + $request->cantidad;
            }else{
                $stock_f=$stock_anterior - $request->cantidad;
            }

            Kardex::create([
                "ticket" => $request->ticket,
                "cantidad" => $request->cantidad,
                "codigo" => $request->codigo,
                "proveedor" => $request->proveedor,
                "tipo" => $request->tipo,
                "stock_anterior" => $stock_anterior,
                "stock_final" => $stock_f,
                "producto_id" => $request->producto_id,
                "comentario" => $request->comentario,
                "user_id" => $request->user_id,
            ]);

            $producto->stock =  $stock_f;
            $producto->save();
            DB::commit();
            return Redirect::route('kardex.index');
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
