<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiferenciadorStoreRequest;
use App\Http\Requests\DiferenciadorUpdateRequest;
use App\Http\Resources\DiferenciadorCollection;
use App\Models\Diferenciador;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;




class DiferenciadorController extends Controller
{
    public function __construct()
    {
        //protegiendo el controlador segun el rol
        //$this->middleware(['auth', 'permission:lista-diferenciadores'])->only('index');
        //$this->middleware(['auth', 'permission:crear-diferenciadores'])->only(['store']);
        //$this->middleware(['auth', 'permission:editar-diferenciadores'])->only(['update']);
        //$this->middleware(['auth', 'permission:editar-diferenciadores'])->only(['update']);
        //$this->middleware(['auth', 'permission:eliminar-diferenciadores'])->only(['destroy']);
    }

    public function index()
    {

        return Inertia::render('Diferenciador/Index', [
            'diferenciadores' => new DiferenciadorCollection(
                Diferenciador::orderBy('id', 'ASC')
                    ->get()
            )
        ]);
    }

    public function store(DiferenciadorStoreRequest $request)
    {
        $last = Diferenciador::latest()->first();
        if(empty($last)){
            $request->merge(["id"=>zero_fill(0,3)]);
        }else{
            $request->merge(["id"=>zero_fill($last->id+1,3)]);
        }
        $curva = Diferenciador::create($request->all());
        return Redirect::route('diferenciadores.index');
    }
    public function show($id)
    {
        $curva = Diferenciador::findOrFail($id);
        return response()->json([
            "data" => $curva
        ]);
    }

    public function update(DiferenciadorUpdateRequest $request, $id)
    {
        $curva = Diferenciador::findOrFail($id);
        $curva->update($request->all());
        return Redirect::route('diferenciadores.index');
    }


    public function destroy($id)
    {
        $curva = Diferenciador::find($id);
        $curva->delete();
        return Redirect::route('diferenciadores.index');
    }

    public function ordenBy($text,$orden='ASC')
    {

        return response()->json([
            "data" => new DiferenciadorCollection(
                Diferenciador::orderBy($text,$orden )
                    ->paginate(10)
                    ->appends(Request::all())
            )
        ]);


    }
}
