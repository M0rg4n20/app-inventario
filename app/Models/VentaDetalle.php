<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    use  HasFactory;

    protected $table = 'venta_detalles';
    protected $fillable = [
        'id',
        'venta_id',
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

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);

    }

}
