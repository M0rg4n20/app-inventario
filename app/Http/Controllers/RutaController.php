<?php

namespace App\Http\Controllers;

use App\Http\Requests\RutaStoreRequest;
use App\Http\Requests\PesoUpdateRequest;
use App\Http\Resources\RutaCollection;
use App\Models\Ruta;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;

class RutaController extends Controller
{
    private $ini_dia;
    private $fin_dia;
    public function __construct()
    {
        //protegiendo el controlador segun el rol
        //$this->middleware(['auth', 'permission:lista-rutas'])->only('index');
        //$this->middleware(['auth', 'permission:crear-rutas'])->only(['store']);
        //$this->middleware(['auth', 'permission:editar-rutas'])->only(['update']);
        //$this->middleware(['auth', 'permission:editar-rutas'])->only(['update']);
        //$this->middleware(['auth', 'permission:eliminar-rutas'])->only(['destroy']);
        $this->ini_dia = Carbon::now()->startOfDay();
        $this->fin_dia = Carbon::now()->endOfDay();
    }

    public function index()
    {

        return Inertia::render('Ruta/Index', [
            'rutas' => new RutaCollection(
                Ruta::orderBy('id', 'ASC')
                    ->where('created_at', '>=', $this->ini_dia)
                    ->where('created_at', '<=', $this->fin_dia)
                    ->get()
            )
        ]);
    }

    public function store(RutaStoreRequest $request)
    {

        $ruta = Ruta::create(
            [
                "nombre" => $request->nombre,
                "colonias" => implode(',', $request->colonias)
            ]
        );
        return Redirect::back();
    }
    public function show($id)
    {
        $ruta = Ruta::findOrFail($id);
        return response()->json([
            "data" => $ruta
        ]);
    }

    public function update(PesoUpdateRequest $request, $id)
    {
        $ruta = Ruta::findOrFail($id);
        $ruta->update($request->all());
        return Redirect::route('rutas.index');
    }


    public function test()
    {

        $rutas = Ruta::orderBy('id', 'ASC')
            ->where('created_at', '>=', $this->ini_dia)
            ->where('created_at', '<=', $this->fin_dia)
            ->get();

        $lista_colonias = DB::table('ventas as ve')
            ->select(DB::raw("distinct DATE_FORMAT(ve.created_at,'%d/%m/%y') AS fecha,(SELECT p.casa_colonia FROM clientes AS p WHERE ve.cliente_id = p.id) as colonia"))
            ->where('ve.created_at', '>=', $this->ini_dia)
            ->where('ve.created_at', '<=', $this->fin_dia)
            ->distinct()
            ->get();


        $lista_rutas = DB::table('rutas as ru')
            ->select(DB::raw("ru.colonias, ru.created_at"))
            ->where('ru.created_at', '>=', $this->ini_dia)
            ->where('ru.created_at', '<=', $this->fin_dia)
            ->distinct()
            ->get();

        $colonias = [];
        $rutas = [];
        $colonia_libres = [];
        foreach ($lista_colonias as $colonia) {
            array_push($colonias, $colonia->colonia);
        }
        foreach ($lista_rutas as $ru) {
            array_push($rutas, $ru->colonias);
        }


        $buqueda = implode(',', $rutas);
        foreach ($colonias as $colonia) {
            //echo json_encode(["data2"=>[$colonia->colonia]]);

            //echo json_encode(explode(',',$ruta));
            //echo json_encode(array_filter((array)$ruta,$colonia));

            /*if(array_intersect($colonia,explode(',',$ruta))){
                array_push($colonia_libres, $colonia);
            }*/
            //echo json_encode($colonia->colonia).$key;
            //echo "\r\n";
            //echo json_encode($colonia);
            //echo "</br>";
            $pos = strpos($buqueda, $colonia);
            //echo $pos;
            //echo "\r";
            if ($pos === false) {
                array_push($colonia_libres, $colonia);
                //echo "The string '$colonia' was found in the string '$buqueda'";
                //  echo " and exists at position $pos";
            } else {
                //echo "The string '$colonia' was not found in the string '$buqueda'";
            }
            /*if(in_array($colonia->colonia,$ruta->colonias)){

                    array_push($colonias, $colonia->colonia[$key2]);
                }*/
        }

        return $colonia_libres;
    }

    public function colonias()
    {
        /*$lista_colonias = DB::table('ventas as ve')
            ->select(DB::raw("distinct DATE_FORMAT(ve.created_at,'%d/%m/%y') AS fecha,(SELECT p.casa_colonia FROM clientes AS p WHERE ve.cliente_id = p.id) as colonia"))
            ->where('ve.created_at', '>=', $this->ini_dia)
            ->where('ve.created_at', '<=', $this->fin_dia)
            ->distinct()
            ->get();*/

            $lista_colonias = DB::table('envios as ve')
            ->select(DB::raw("distinct DATE_FORMAT(ve.created_at,'%d/%m/%y') AS fecha,ve.colonia"))
            ->where('ve.created_at', '>=', $this->ini_dia)
            ->where('ve.created_at', '<=', $this->fin_dia)
            ->distinct()
            ->get();

        $lista_rutas = DB::table('rutas as ru')
            ->select(DB::raw("ru.colonias, ru.created_at"))
            ->where('ru.created_at', '>=', $this->ini_dia)
            ->where('ru.created_at', '<=', $this->fin_dia)
            ->distinct()
            ->get();

        $colonias = [];
        $rutas = [];
        $colonia_libres = [];
        foreach ($lista_colonias as $colonia) {
            array_push($colonias, $colonia->colonia);
        }
        foreach ($lista_rutas as $ru) {
            array_push($rutas, $ru->colonias);
        }


        $buqueda = implode(',', $rutas);
        foreach ($colonias as $colonia) {

            $pos = strpos($buqueda, $colonia);

            if ($pos === false) {
                array_push($colonia_libres, $colonia);
            }
        }

        return response()->json([
            "data" => $colonia_libres

        ]);
    }

    public function destroy($id)
    {
        $ruta = Ruta::find($id);
        $ruta->delete();
        return Redirect::route('rutas.index');
    }

    public function ordenBy($text, $orden = 'ASC')
    {

        return response()->json([
            "data" => new RutaCollection(
                Ruta::orderBy($text, $orden)
                    ->paginate(10)
                    ->appends(Request::all())
            )
        ]);
    }
}
