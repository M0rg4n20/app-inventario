<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvioHistorico extends Model
{
    use HasFactory;
    protected $fillable = [
        'repartidor_id',
        'pedido_id',
        'estado_id',
        'puntos',
        'observacion',
    ];

    public function pedido()
    {
        return $this->belongsTo(Envio::class, 'pedido_id', 'id');
    }

    public function estadoPedido()
    {
        return $this->belongsTo(EstadoDePedido::class, 'estado_id');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }
}
