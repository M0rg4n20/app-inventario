<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductoVentaCollection extends ResourceCollection
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
                    'imagen_1'=>$row->imagen_1??'',
                    'codigo' => $row->codigo??'',
                    'stock' => $row->stock??'',
                    'precio_compra' => $row->precio_compra??'',
                    'precio_venta' => $row->precio_venta??'',
                    'precio_mayorista' => $row->precio_mayorista??'',
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
