<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable = [
        'id',
        'nombre',
        'rfc',
        'email',
        'telefono',
        'casa_direccion',
        'casa_colonia',
        'tipo_cliente',
        'oficina_direccion',
        'oficina_colonia',
        'fecha_nacimiento',
        'lat_casa',
        'lng_casa',
        'place_id_casa',
        'lat_oficina',
        'lng_oficina',
        'place_id_oficina',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class,'cliente_id','id');
    }
}
