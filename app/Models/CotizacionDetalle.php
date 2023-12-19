<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionDetalle extends Model
{
    use  HasFactory;

    protected $table = 'cotizacion_detalles';
    protected $fillable = [
        'id',
        'cotizacion_id',
        'producto_id',
        'precio',
        'cantidad',
        'stock',
        'total',

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);

    }

}
