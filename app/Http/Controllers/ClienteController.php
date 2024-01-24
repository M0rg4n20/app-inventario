<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteUpdateRequest;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Resources\ClienteCollection;
use App\Http\Resources\ClienteResource;
use App\Models\Cliente;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Faker;



class ClienteController extends Controller
{
  public function __construct()
  {
    //protegiendo el controlador segun el rol
    //$this->middleware(['auth', 'permission:lista-clientes'])->only('index');
    //$this->middleware(['auth', 'permission:crear-clientes'])->only(['store']);
    //$this->middleware(['auth', 'permission:editar-clientes'])->only(['update']);
  }

  public function index()
  {

    return Inertia::render('Clientes/Index', [
      'clientes' => new ClienteCollection(
        Cliente::orderBy('id', 'ASC')
          ->get()
      )
    ]);
  }

  public function store(ClientStoreRequest $request)
  {
    //return $request;
    $faker = Faker\Factory::create();
    $request->merge([
      //"email"=> $faker->unique()->email,
      //"fecha_nacimiento"=> now()
    ]);
    $cliente = Cliente::create($request->all());
    //return Redirect::route('clientes.index');
  }
  public function show($id)
  {
    $cliente = Cliente::findOrFail($id);
    return response()->json([
      "data" => $cliente
    ]);
  }

  public function update(ClienteUpdateRequest $request, $id)
  {
    $cliente = Cliente::findOrFail($id);
    $cliente->update($request->all());
    return Redirect::route('clientes.index');
  }


  public function destroy($id)
  {
    $cliente = Cliente::find($id);
    $cliente->delete();
    return Redirect::route('clientes.index');
  }
}
