<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use  HasFactory;

    protected $table = 'productos';
    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'codigo',
        'codigo_barra',
        'imagen_1',
        'imagen_2',
        'stock',
        'precio_compra',
        'precio_venta',
        'precio_mayorista',
        'porcentaje_venta',
        'porcentaje_mayorista',
        'check_mayorista',
        'check_venta',
        'ventas',
        'categoria_id',
        'familia_id',
        'subproducto_id',
        'marca_id',
        'peso_id',
        'longitud_id',
        'curva_id',
        'color_id',
        'diferenciador_id',
    ];


    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }
    public function peso(){
        return $this->belongsTo(Peso::class);
    }
    public function longitud(){
        return $this->belongsTo(Longitud::class);
    }


    public function detalles_ventas()
    {
        return $this->hasMany(VentaDetalle::class);
    }
}
