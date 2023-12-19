<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    use  HasFactory;

    protected $table = 'envios';
    protected $fillable = [
        'id',
        'estado',
        'comentario',
        'direccion',
        'colonia',
        'telefono',
        'fecha',
        'hora',
        'orden',
        'venta_id',
        'responsable_id',
        'repartidor_id',
        'ruta_id',
        'created_at'
    ];


    public function repartidor()
    {
        return $this->belongsTo(User::class);
    }

    public function responsable()
    {
        return $this->belongsTo(User::class);
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
    public function ruta()
    {
        return $this->belongsTo(Ruta::class);
    }




}
