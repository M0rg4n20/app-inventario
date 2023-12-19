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
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class,'cliente_id','id');
    }
}
