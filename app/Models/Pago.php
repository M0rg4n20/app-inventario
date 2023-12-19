<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use  HasFactory;

    protected $table = 'pagos';
    protected $fillable = [
        'id',
        'monto_efectivo',
        'monto_tarjeta',
        'saldo',
        'num_tarjeta',
        'metodo_pago',
        'tipo_pago',
        'forma_entrega',
        'venta_id',
        'user_id',
        'metodo_pago_id',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venta()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function metodos_pagos()
    {
        return $this->belongsTo(MetodoPago::class);
    }


}
