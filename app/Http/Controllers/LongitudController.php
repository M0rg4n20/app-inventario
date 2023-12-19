<?php

namespace App\Http\Controllers;

use App\Http\Requests\LongitudStoreRequest;
use App\Http\Requests\LongitudUpdateRequest;
use App\Http\Resources\LongitudCollection;
use App\Models\Longitud;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;




class LongitudController extends Controller
{
    public function __construct()
    {
        //protegiendo el controlador segun el rol
        //$this->middleware(['auth', 'permission:lista-longitudes'])->only('index');
        //$this->middleware(['auth', 'permission:crear-longitudes'])->only(['store']);
        //$this->middleware(['auth', 'permission:editar-longitudes'])->only(['update']);
        //$this->middleware(['auth', 'permission:editar-longitudes'])->only(['update']);
        //$this->middleware(['auth', 'permission:eliminar-longitudes'])->only(['destroy']);
    }

    public function index()
    {

        return Inertia::render('Longitud/Index', [
            'longitudes' => new LongitudCollection(
                Longitud::orderBy('id', 'ASC')
                    ->get()
            )
        ]);
    }

    public function store(LongitudStoreRequest $request)
    {

        $longitud = Longitud::create($request->all());
        return Redirect::route('longitudes.index');
    }
    public function show($id)
    {
        $longitud = Longitud::findOrFail($id);
        return response()->json([
            "data" => $longitud
        ]);
    }

    public function update(LongitudUpdateRequest $request, $id)
    {
        $longitud = Longitud::findOrFail($id);
        $longitud->update($request->all());
        return Redirect::route('longitudes.index');
    }


    public function destroy($id)
    {
        $longitud = Longitud::find($id);
        $longitud->delete();
        return Redirect::route('longitudes.index');
    }

    public function ordenBy($text,$orden='ASC')
    {

        return response()->json([
            "data" => new LongitudCollection(
                Longitud::orderBy($text,$orden )
                    ->paginate(10)
                    ->appends(Request::all())
            )
        ]);


    }
}
