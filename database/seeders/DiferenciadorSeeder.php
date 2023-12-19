<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Diferenciador;

class DiferenciadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $familias =  [
            ["id"=>"000","nombre" => "-"],
            ["id"=>"001","nombre" => "Liquido"],
            ["id"=>"002","nombre" => "3D","comentario"=>"Pestaña Pre-armada"],
            ["id"=>"003","nombre" => "4D","comentario"=>"Pestaña Pre-armada"],

        ];

        foreach ($familias as $familia) {
            sleep(1);
            Diferenciador::create($familia);
        }
    }
}
