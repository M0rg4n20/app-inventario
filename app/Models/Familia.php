<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Familia extends Model
{
    use HasFactory;
    protected $table = 'familias';
    protected $fillable = [
        'id',
        'comentario',
        'nombre',
    ];
    public $incrementing = true;
    //protected $primaryKey ="id";
    protected $keyType = 'string';


}
