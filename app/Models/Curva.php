<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curva extends Model
{
    use HasFactory;
    protected $table = 'curvas';
    protected $fillable = [
        'id',
        'comentario',
        'nombre',
    ];
    protected $keyType = 'string';


}
