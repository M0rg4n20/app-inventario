<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CotizacionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($row, $key) {
                return [
                    'id' => $row->id,
                    'codigo' => $row->codigo??'',
                    'cliente'=>$row->cliente->nombre??'',
                    'vendedor' => $row->user->name??'',
                    'neto' => number_format($row->neto,2)??'',
                    //'metodos_pago' => $row->metodospagos()->with('ventas')->get()??'',
                    //'tipo_venta' => $row->tipo_venta??'',
                    'total' => number_format($row->total,2)??'',
                    'fecha'=>$row->created_at->format('d/m/Y H:m:s'),
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
