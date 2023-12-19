<?php

namespace App\Http\Controllers;

use App\Http\Requests\PesoStoreRequest;
use App\Http\Requests\PesoUpdateRequest;
use App\Http\Resources\PesoCollection;
use App\Models\Peso;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;




class PesoController extends Controller
{
    public function __construct()
    {
        //protegiendo el controlador segun el rol
        //$this->middleware(['auth', 'permission:lista-pesos'])->only('index');
        //$this->middleware(['auth', 'permission:crear-pesos'])->only(['store']);
        //$this->middleware(['auth', 'permission:editar-pesos'])->only(['update']);
        //$this->middleware(['auth', 'permission:editar-pesos'])->only(['update']);
        //$this->middleware(['auth', 'permission:eliminar-pesos'])->only(['destroy']);
    }

    public function index()
    {

        return Inertia::render('Peso/Index', [
            'pesos' => new PesoCollection(
                Peso::orderBy('id', 'ASC')
                    ->get()
            )
        ]);
    }

    public function store(PesoStoreRequest $request)
    {

        $peso = Peso::create($request->all());
        return Redirect::route('pesos.index');
    }
    public function show($id)
    {
        $peso = Peso::findOrFail($id);
        return response()->json([
            "data" => $peso
        ]);
    }

    public function update(PesoUpdateRequest $request, $id)
    {
        $peso = Peso::findOrFail($id);
        $peso->update($request->all());
        return Redirect::route('pesos.index');
    }


    public function destroy($id)
    {
        $peso = Peso::find($id);
        $peso->delete();
        return Redirect::route('pesos.index');
    }

    public function ordenBy($text,$orden='ASC')
    {

        return response()->json([
            "data" => new PesoCollection(
                Peso::orderBy($text,$orden )
                    ->paginate(10)
                    ->appends(Request::all())
            )
        ]);


    }
}
