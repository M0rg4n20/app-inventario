<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MetodoPago;

class MetodoPagosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias =  [

            [ "nombre" => "EFECTIVO"],
            [ "nombre" => "TARJETA DE DEBITO / CREDITO"],
            [ "nombre" => "EFECTIVO Y TARJETA"]

        ];

        foreach ($categorias as $categoria) {
            MetodoPago::create($categoria);
        }
    }
}
