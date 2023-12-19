<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubProducto extends Model
{
    use HasFactory;
    protected $table = 'subproductos';
    protected $fillable = [
        'id',
        'comentario',
        'nombre',
    ];
    protected $keyType = 'string';


}
