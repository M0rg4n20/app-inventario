<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias =  [
            [ "nombre" => "Equipos Electromecánicos"],
            [ "nombre" => "Taladros"],
            [ "nombre" => "Andamios"],
            [ "nombre" => "Generadores de energía"],
            [ "nombre" => "Equipos para construcción"],
            [ "nombre" => "Martillos mecánicos"],
            [ "nombre" => "Hamburguesas"],
            [ "nombre" => "Entradas"],
            [ "nombre" => "Bebidas"]
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
