<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peso extends Model
{
    use HasFactory;
    protected $table = 'pesos';
    protected $fillable = [
        'id',
        'codigo',
        'comentario',
        'nombre',
    ];
    public function productos(){
        return $this->hasMany(Producto::class);
    }



}
