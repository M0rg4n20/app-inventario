<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marca;

class MarcasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $familias =  [
            [ "nombre" => "SM"],
            [ "nombre" => "Nagaraku"],
            [ "nombre" => "Masscaku"],
            [ "nombre" => "Yelix"],
            [ "nombre" => "Tdance"],
            [ "nombre" => "Eyelash"],
        ];

        foreach ($familias as $familia) {
            sleep(1);
            Marca::create($familia);
        }
    }
}
