<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Ruta extends Model
{
    use HasFactory;
    protected $table = 'rutas';

    protected $fillable = [
        'id',
        'nombre',
        'colonias',
        'repartidor_id'
    ];

    public function envios()
    {
        return $this->hasMany(Envio::class);
    }
}
