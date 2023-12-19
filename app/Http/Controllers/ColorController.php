<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorStoreRequest;
use App\Http\Requests\ColorUpdateRequest;
use App\Http\Resources\ColorCollection;
use App\Models\Color;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;




class ColorController extends Controller
{
    public function __construct()
    {
        //protegiendo el controlador segun el rol
        //$this->middleware(['auth', 'permission:lista-colores'])->only('index');
        //$this->middleware(['auth', 'permission:crear-colores'])->only(['store']);
        //$this->middleware(['auth', 'permission:editar-colores'])->only(['update']);
        //$this->middleware(['auth', 'permission:editar-colores'])->only(['update']);
        //$this->middleware(['auth', 'permission:eliminar-colores'])->only(['destroy']);
    }

    public function index()
    {

        return Inertia::render('Color/Index', [
            'colores' => new ColorCollection(
                Color::orderBy('id', 'ASC')
                    ->get()
            )
        ]);
    }

    public function store(ColorStoreRequest $request)
    {
        $last = Color::latest()->first();
        if(empty($last)){
            $request->merge(["id"=>zero_fill(0,2)]);
        }else{
            $request->merge(["id"=>zero_fill($last->id+1,2)]);
        }
        $curva = Color::create($request->all());
        return Redirect::route('colores.index');
    }
    public function show($id)
    {
        $curva = Color::findOrFail($id);
        return response()->json([
            "data" => $curva
        ]);
    }

    public function update(ColorUpdateRequest $request, $id)
    {
        $curva = Color::findOrFail($id);
        $curva->update($request->all());
        return Redirect::route('colores.index');
    }


    public function destroy($id)
    {
        $curva = Color::find($id);
        $curva->delete();
        return Redirect::route('colores.index');
    }

    public function ordenBy($text,$orden='ASC')
    {

        return response()->json([
            "data" => new ColorCollection(
                Color::orderBy($text,$orden )
                    ->paginate(10)
                    ->appends(Request::all())
            )
        ]);


    }
}
