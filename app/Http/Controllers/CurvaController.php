<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurvaStoreRequest;
use App\Http\Requests\CurvaUpdateRequest;
use App\Http\Resources\CurvaCollection;
use App\Models\Curva;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;




class CurvaController extends Controller
{
    public function __construct()
    {
        //protegiendo el controlador segun el rol
        //$this->middleware(['auth', 'permission:lista-curvas'])->only('index');
        //$this->middleware(['auth', 'permission:crear-curvas'])->only(['store']);
        //$this->middleware(['auth', 'permission:editar-curvas'])->only(['update']);
        //$this->middleware(['auth', 'permission:editar-curvas'])->only(['update']);
        //$this->middleware(['auth', 'permission:eliminar-curvas'])->only(['destroy']);
    }

    public function index()
    {

        return Inertia::render('Curva/Index', [
            'curvas' => new CurvaCollection(
                Curva::orderBy('id', 'ASC')
                    ->get()
            )
        ]);
    }

    public function store(CurvaStoreRequest $request)
    {

        $curva = Curva::create($request->all());
        return Redirect::route('curvas.index');
    }
    public function show($id)
    {
        $curva = Curva::findOrFail($id);
        return response()->json([
            "data" => $curva
        ]);
    }

    public function update(CurvaUpdateRequest $request, $id)
    {
        $curva = Curva::findOrFail($id);
        $curva->update($request->all());
        return Redirect::route('curvas.index');
    }


    public function destroy($id)
    {
        $curva = Curva::find($id);
        $curva->delete();
        return Redirect::route('curvas.index');
    }

    public function ordenBy($text,$orden='ASC')
    {

        return response()->json([
            "data" => new CurvaCollection(
                Curva::orderBy($text,$orden )
                    ->paginate(10)
                    ->appends(Request::all())
            )
        ]);


    }
}
