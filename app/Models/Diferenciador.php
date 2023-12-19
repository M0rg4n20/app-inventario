<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diferenciador extends Model
{
    use HasFactory;
    protected $table = 'diferenciadores';
    protected $fillable = [
        'id',
        'comentario',
        'nombre',
    ];
    protected $keyType = 'string';


}
