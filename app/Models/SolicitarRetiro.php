<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitarRetiro extends Model
{
    use HasFactory;
    protected $table = 'solicitar_retiros';
    protected $fillable = [
        'repartidor_id',
        'monto',
        'estado',
        'comentario',
    ];
}
