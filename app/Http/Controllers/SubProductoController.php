<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubProductoStoreRequest;
use App\Http\Requests\SubProductoUpdateRequest;
use App\Http\Resources\SubProductoCollection;
use App\Models\SubProducto;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;




class SubProductoController extends Controller
{
    public function __construct()
    {
        //protegiendo el controlador segun el rol
        //$this->middleware(['auth', 'permission:lista-subproductos'])->only('index');
        //$this->middleware(['auth', 'permission:crear-subproductos'])->only(['store']);
        //$this->middleware(['auth', 'permission:editar-subproductos'])->only(['update']);
        //$this->middleware(['auth', 'permission:editar-subproductos'])->only(['update']);
        //$this->middleware(['auth', 'permission:eliminar-subproductos'])->only(['destroy']);
    }

    public function index()
    {

        return Inertia::render('SubProducto/Index', [
            'subproductos' => new SubProductoCollection(
                SubProducto::orderBy('id', 'ASC')
                    ->get()
            )
        ]);
    }

    public function store(SubProductoStoreRequest $request)
    {

        $categoria = SubProducto::create($request->all());
        return Redirect::route('subproductos.index');
    }
    public function show($id)
    {
        $categoria = SubProducto::findOrFail($id);
        return response()->json([
            "data" => $categoria
        ]);
    }

    public function update(SubProductoUpdateRequest $request, $id)
    {
        $categoria = SubProducto::findOrFail($id);
        $categoria->update($request->all());
        return Redirect::route('subproductos.index');
    }


    public function destroy($id)
    {
        $categoria = SubProducto::find($id);
        $categoria->delete();
        return Redirect::route('subproductos.index');
    }

    public function ordenBy($text,$orden='ASC')
    {

        return response()->json([
            "data" => new SubProductoCollection(
                SubProducto::orderBy($text,$orden )
                    ->paginate(10)
                    ->appends(Request::all())
            )
        ]);


    }
}
