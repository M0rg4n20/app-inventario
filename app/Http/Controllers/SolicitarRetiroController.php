<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitarRetiro;
use Inertia\Inertia;

class SolicitarRetiroController extends Controller
{
  public function index()
  {
    $solicitudes = SolicitarRetiro::join('users', 'solicitar_retiros.repartidor_id', '=', 'users.id')
      ->select('solicitar_retiros.*', 'users.name as repartidor_name')
      ->get();
    return Inertia::render('Retiros/Index', [
      'retiros' => $solicitudes
    ]);
  }

  public function update(Request $request)
  {
    $solicitud = SolicitarRetiro::findOrFail($request->id);
    if ($solicitud) {
      $solicitud->estado = ($request->input('acciones') == 1) ? 'Aprobado' : 'Rechazado';
      if (!empty($request->input('comentario')))
        $solicitud->comentario = $request->input('comentario');

      $solicitud->save();
      return response()->json(["result" => 'success',]);
    } else {
      return response()->json(["result" => 'err', "mensaje" => 'Solicitud no disponible.']);
    }
  }
}
