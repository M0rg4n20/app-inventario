<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;
    protected $table = 'metodos_pagos';
    protected $fillable = [
        'id',
        'nombre',
    ];

    /*1er argumento -- clase del modelo relacionado
    2do argumento -- nombre de la tabla pivote-intermedio
    3er argumento -- FK de esta modelo "mapeado"
    3to argumento -- FK del otro modelo relacionado*/

    public function ventas()
    {
        return $this->belongsToMany(Venta::class,'venta_metodopago','metodo_pago_id','venta_id')
        ->withPivot('monto','tarjeta');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

}
