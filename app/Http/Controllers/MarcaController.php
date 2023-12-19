<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaStoreRequest;
use App\Http\Requests\MarcaUpdateRequest;
use App\Http\Resources\MarcaCollection;
use App\Models\Marca;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;




class MarcaController extends Controller
{
    public function __construct()
    {
        //protegiendo el controlador segun el rol
        //$this->middleware(['auth', 'permission:lista-marcas'])->only('index');
        //$this->middleware(['auth', 'permission:crear-marcas'])->only(['store']);
        //$this->middleware(['auth', 'permission:editar-marcas'])->only(['update']);
        //$this->middleware(['auth', 'permission:editar-marcas'])->only(['update']);
        //$this->middleware(['auth', 'permission:eliminar-marcas'])->only(['destroy']);
    }

    public function index()
    {

        return Inertia::render('Marca/Index', [
            'marcas' => new MarcaCollection(
                Marca::orderBy('id', 'ASC')
                    ->get()
            )
        ]);
    }

    public function store(MarcaStoreRequest $request)
    {

        $categoria = Marca::create($request->all());
        return Redirect::route('marcas.index');
    }
    public function show($id)
    {
        $categoria = Marca::findOrFail($id);
        return response()->json([
            "data" => $categoria
        ]);
    }

    public function update(MarcaUpdateRequest $request, $id)
    {
        $categoria = Marca::findOrFail($id);
        $categoria->update($request->all());
        return Redirect::route('marcas.index');
    }


    public function destroy($id)
    {
        $categoria = Marca::find($id);
        $categoria->delete();
        return Redirect::route('marcas.index');
    }

    public function ordenBy($text,$orden='ASC')
    {

        return response()->json([
            "data" => new MarcaCollection(
                Marca::orderBy($text,$orden )
                    ->paginate(10)
                    ->appends(Request::all())
            )
        ]);


    }
}
