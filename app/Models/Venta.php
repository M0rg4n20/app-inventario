<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use  HasFactory;

    protected $table = 'ventas';
    protected $fillable = [
        'id',
        'codigo',
        'descuento',
        'porcentaje_descuento',
        'neto',
        'total',
        'saldo',
        'estado',
        'tipo_pago',
        'forma_entrega',
        'user_id',
        'cliente_id',
        'created_at'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function detalles_ventas()
    {
        return $this->hasMany(VentaDetalle::class);
    }
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    /*1er argumento -- clase del modelo relacionado
    2do argumento -- nombre de la tabla pivote-intermedio
    3er argumento -- FK de esta modelo "mapeado"
    3to argumento -- FK del otro modelo relacionado*/

    public function metodospagos()
    {
        return $this->belongsToMany(MetodoPago::class, 'venta_metodopago', 'venta_id', 'metodo_pago_id')
        ->as('pagos')
            ->withPivot('monto', 'tarjeta');
    }
}
