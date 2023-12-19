<?php

namespace App\Http\Controllers;

use App\Http\Requests\FamiliaStoreRequest;
use App\Http\Requests\FamiliaUpdateRequest;
use App\Http\Resources\FamiliaCollection;
use App\Models\Familia;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;




class FamiliaController extends Controller
{
    public function __construct()
    {
        //protegiendo el controlador segun el rol
        //$this->middleware(['auth', 'permission:lista-familias'])->only('index');
        //$this->middleware(['auth', 'permission:crear-familias'])->only(['store']);
        //$this->middleware(['auth', 'permission:editar-familias'])->only(['update']);
        //$this->middleware(['auth', 'permission:editar-familias'])->only(['update']);
        //$this->middleware(['auth', 'permission:eliminar-familias'])->only(['destroy']);
    }

    public function index()
    {


        return Inertia::render('Familia/Index', [
            'familias' => new FamiliaCollection(
                Familia::orderBy('id', 'ASC')->get()
            )
        ]);
    }

    public function store(FamiliaStoreRequest $request)
    {

        $categoria = Familia::create($request->all());
        return Redirect::route('familias.index');
    }
    public function show($id)
    {
        $categoria = Familia::findOrFail($id);
        return response()->json([
            "data" => $categoria
        ]);
    }

    public function update(FamiliaUpdateRequest $request, $id)
    {
        $categoria = Familia::findOrFail($id);
        $categoria->update($request->all());
        return Redirect::route('familias.index');
    }


    public function destroy($id)
    {
        $categoria = Familia::find($id);
        $categoria->delete();
        return Redirect::route('familias.index');
    }

    public function ordenBy($text,$orden='ASC')
    {

        return response()->json([
            "data" => new FamiliaCollection(
                Familia::orderBy($text,$orden )
                    ->paginate(10)
                    ->appends(Request::all())
            )
        ]);


    }
}
