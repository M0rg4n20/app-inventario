<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Familia;

class FamiliasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $familias =  [
            [ "nombre" => "Pestaña"],
            [ "nombre" => "Adhesivo"],
            [ "nombre" => "Herramienta"],
            [ "nombre" => "Removeedor"],
            [ "nombre" => "Primer"],
            [ "nombre" => "Insumo"],
            [ "nombre" => "Sellador"],
            [ "nombre" => "Limpiador"],
            [ "nombre" => "Electrónico"],
            [ "nombre" => "Organizador"],
            [ "nombre" => "Rizado de pestaña"],
            [ "nombre" => "Diseño de ceja"],
            [ "nombre" => "Pigmento"],
            [ "nombre" => "Tratamientos"],
            [ "nombre" => "Utileria"],

        ];

        foreach ($familias as $familia) {
            sleep(1);
            Familia::create($familia);
        }
    }
}
