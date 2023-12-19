<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaStoreRequest;
use App\Http\Requests\CategoriaUpdateRequest;
use App\Http\Resources\CategoriaCollection;
use App\Models\Categoria;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;



class CategoriaController extends Controller
{
    public function __construct()
    {
        //protegiendo el controlador segun el rol
        //$this->middleware(['auth', 'permission:lista-categorias'])->only('index');
        //$this->middleware(['auth', 'permission:crear-categorias'])->only(['store']);
        //$this->middleware(['auth', 'permission:editar-categorias'])->only(['update']);
        //$this->middleware(['auth', 'permission:editar-categorias'])->only(['update']);
        //$this->middleware(['auth', 'permission:eliminar-categorias'])->only(['destroy']);
    }

    public function index()
    {

        return Inertia::render('Categoria/Index', [
            'categorias' => new CategoriaCollection(
                Categoria::orderBy('id', 'ASC')
                    ->paginate()
                    ->appends(Request::all())
            )
        ]);
    }

    public function store(CategoriaStoreRequest $request)
    {

        $categoria = Categoria::create($request->all());
        return Redirect::route('categorias.index');
    }
    public function show($id)
    {
        //dd($id);
        $categoria = Categoria::findOrFail($id);
        return response()->json([
            "data" => $categoria
        ]);
    }

    public function update(CategoriaUpdateRequest $request, $id):RedirectResponse
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());
        return Redirect::route('categorias.index');

    }


    public function destroy($id)
    {
        $categoria = Categoria::find($id);
        $categoria->delete();
        return Redirect::route('categorias.index');
    }
}
