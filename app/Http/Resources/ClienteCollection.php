<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClienteCollection extends ResourceCollection
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
                    'nombre' => $row->nombre,
                    'rfc'=>$row->rfc??'',
                    'email' => $row->email??'',
                    'telefono' => $row->telefono,
                    'casa_direccion' => $row->casa_direccion??'',
                    'casa_colonia' => $row->casa_colonia??'',
                    'oficina_direccion' => $row->oficina_direccion??'',
                    'tipo_cliente' => $row->tipo_cliente??'',
                    'oficina_colonia' => $row->oficina_colonia??'',
                    'total_compras' => $row->total_compras??0,
                    'ultima_compra' => $row->ultima_compra??0,
                    //'fecha_nacimiento'=>Carbon::createFromFormat('YYYY-mm-dd', $row->fecha_nacimiento)->format('d/m/Y'),
                    'fecha_nacimiento'=>Carbon::parse($row->fecha_nacimiento)->format('d/m/Y'),
                    'created_at'=>$row->created_at->format('d/m/Y H:m:s'),
                    /* 'lat' => $row->lat??'',
                    'lng' => $row->lng??'',
                    'place_id' => $row->place_id??'', */
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
