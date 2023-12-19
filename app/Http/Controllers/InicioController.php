<?php

namespace App\Http\Controllers;


use App\Models\Categoria;
use App\Models\Cliente;
use Carbon\Carbon;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class InicioController extends Controller
{
    public function index()
    {

        $primerDiaMes = Carbon::now()->startOfMonth()->toDateString();
        $ultimoDiaMes = Carbon::now()->endOfMonth()->toDateString();
        $diasMes = Carbon::now()->daysInMonth;

        $total_clientes = Cliente::count();
        $total_categorias = Categoria::count();
        $total_productos = Producto::count();
        $total_ventas = Venta::select('total')->sum('total');


        //datos grafico ventas
        $consulta_ventas = DB::table('ventas as ve')
            ->select(DB::raw("ve.created_at, SUM(ve.total) AS total,DATE_FORMAT(ve.created_at,'%d/%m/%y') AS fecha"))
            ->when(Request::input('inicio'), function ($query, $search) {
                $query->whereDate('ve.created_at', '>=', $search);
            })
            ->when(Request::input('fin'), function ($query, $search) {
                $query->whereDate('ve.created_at', '<=', $search);
            })
            ->where('ve.created_at', '>=', $primerDiaMes)
            ->where('ve.created_at', '<=', $ultimoDiaMes)
            ->orderBy('fecha', 'asc')
            ->groupBy('fecha')
            ->get();

        //return $consulta_ventas;

        $datos_grafico_ventas = [];
        foreach ($consulta_ventas as $consulta_venta) {
            array_push(
                $datos_grafico_ventas,
                [
                    "categoria" => $consulta_venta->fecha,
                    "datos" => $consulta_venta->total,
                ]
            );
        }
        $datos_grafico_ventas = [
            "categoria" => array_column($datos_grafico_ventas, "categoria"),
            "datos" => array_column($datos_grafico_ventas, "datos"),
        ];


        //Productos más vendidos
        $cantidad_produc_vendidos = VentaDetalle::sum('cantidad');
        $consulta_vendidos = DB::table('venta_detalles as vd')
            ->join('productos as prod', 'prod.id', '=', 'vd.producto_id')
            ->select(DB::raw("sum(cantidad) AS cantidad,vd.producto_id,prod.nombre,prod.imagen_1"))
            ->orderBy('cantidad', 'desc')
            ->whereDate('vd.created_at', '>=', $primerDiaMes)
            ->whereDate('vd.created_at', '<=', $ultimoDiaMes)
            ->when(Request::input('inicio'), function ($query, $search) {
                $query->whereDate('vd.created_at', '>=', $search);
            })
            ->when(Request::input('fin'), function ($query, $search) {
                $query->whereDate('vd.created_at', '<=', $search);
            })
            ->take(10)
            ->groupBy('producto_id')
            ->get();

        $datos_grafico_vendidos = [];

        $vendedores_mas_ventas = [];
        $clientes_mas_compras = [];

        foreach ($consulta_vendidos as $consulta_vend) {
            array_push($datos_grafico_vendidos, [
                "categoria" => $consulta_vend->nombre,
                "datos" => $consulta_vend->cantidad,
                "imagen" =>  $consulta_vend->imagen_1,
                "porcentaje" => number_format($consulta_vend->cantidad / $cantidad_produc_vendidos * 100, 1) . "%",
                "tabla" => [
                    "nombre" => $consulta_vend->nombre,
                    "imagen" => $consulta_vend->imagen_1,
                    "porcentaje" => number_format($consulta_vend->cantidad / $cantidad_produc_vendidos * 100, 1) . " %",
                ]
            ]);
        }
        $datos_grafico_vendidos = [
            "categoria" => array_column($datos_grafico_vendidos, "categoria"),
            "datos" => array_column($datos_grafico_vendidos, "datos"),
            "imagen" => array_column($datos_grafico_vendidos, "imagen"),
            "porcentaje" => array_column($datos_grafico_vendidos, "porcentaje"),
            "tabla" => array_column($datos_grafico_vendidos, "tabla"),

        ];

        //ultimos productos agregado
        $ultimos_productos = Producto::select('id', 'nombre', 'precio_venta', 'imagen_1')
            ->orderBy("id", "DESC")->take(10)->get();

        //vendedores con mas ventas
        $vendedores_ventas_mas = DB::table('ventas as ve')
            ->select(DB::raw("ve.user_id,SUM(ve.total) AS total,
            (SELECT us.name FROM users AS us WHERE ve.user_id = us.id) as nombre"))
            ->take(5)
            ->whereDate('ve.created_at', '>=', $primerDiaMes)
            ->whereDate('ve.created_at', '<=', $ultimoDiaMes)
            ->when(Request::input('inicio'), function ($query, $search) {
                $query->whereDate('ve.created_at', '>=', $search);
            })
            ->when(Request::input('fin'), function ($query, $search) {
                $query->whereDate('ve.created_at', '<=', $search);
            })
            ->groupBy('ve.user_id')
            ->orderBy('ve.user_id', 'asc')
            ->get();

        foreach ($vendedores_ventas_mas as $vendedor) {
            array_push($vendedores_mas_ventas, [
                "categoria" => $vendedor->nombre,
                "datos" => $vendedor->total,
            ]);
        }

        $vendedores_mas_ventas = [
            "categoria" => array_column($vendedores_mas_ventas, "categoria"),
            "datos" => array_column($vendedores_mas_ventas, "datos"),
        ];

        //clientes con mas compras
        $clientes_compras_mas = DB::table('ventas as ve')
            ->select(DB::raw("ve.cliente_id,SUM(ve.total) AS total,
            (SELECT cl.nombre FROM clientes AS cl WHERE ve.cliente_id = cl.id) as cliente"))
            ->take(5)
            ->whereDate('ve.created_at', '>=', $primerDiaMes)
            ->whereDate('ve.created_at', '<=', $ultimoDiaMes)
            ->when(Request::input('inicio'), function ($query, $search) {
                $query->whereDate('ve.created_at', '>=', $search);
            })
            ->when(Request::input('fin'), function ($query, $search) {
                $query->whereDate('ve.created_at', '<=', $search);
            })
            ->groupBy('ve.cliente_id')
            ->orderBy('ve.cliente_id', 'asc')
            ->get();



        foreach ($clientes_compras_mas as $vendedor) {
            array_push($clientes_mas_compras, [
                "categoria" => $vendedor->cliente,
                "datos" => $vendedor->total,
            ]);
        }

        $clientes_mas_compras = [
            "categoria" => array_column($clientes_mas_compras, "categoria"),
            "datos" => array_column($clientes_mas_compras, "datos"),
        ];


        return Inertia::render('Inicio', [
            'total_ventas' => number_format($total_ventas, 2),
            'total_clientes' => $total_clientes,
            'total_categorias' => $total_categorias,
            'total_productos' => $total_productos,
            'ultimos_productos' => $ultimos_productos,
            'datos_grafico_ventas' => $datos_grafico_ventas,
            'datos_grafico_vendidos' => $datos_grafico_vendidos,
            'vendedores_mas_ventas' => $vendedores_mas_ventas,
            'clientes_mas_compras' => $clientes_mas_compras,
        ]);
    }
}
