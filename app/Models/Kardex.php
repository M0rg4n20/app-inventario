<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use  HasFactory;

    protected $table = 'kardex';
    protected $fillable = [
        'id',
        'cantidad',
        'comentario',
        'ticket',
        'stock_anterior',
        'stock_final',
        'codigo',
        'proveedor',
        'tipo',
        'producto_id',
        'user_id',
        'created_at'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }




}
