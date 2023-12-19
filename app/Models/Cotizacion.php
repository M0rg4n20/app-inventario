<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use  HasFactory;

    protected $table = 'cotizaciones';
    protected $fillable = [
        'id',
        'nombre',
        'codigo',
        'impuesto',
        'descuento',
        'porcentaje_descuento',
        'neto',
        'abono',
        'total',
        'user_id',
        'cliente_id',
        'tipo_venta',
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

    public function detalles_cotizaciones()
    {
        return $this->hasMany(CotizacionDetalle::class);
    }

    /*1er argumento -- clase del modelo relacionado
    2do argumento -- nombre de la tabla pivote-intermedio
    3er argumento -- FK de esta modelo "mapeado"
    3to argumento -- FK del otro modelo relacionado*/


}
