<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubProducto;

class SubProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $familias =  [
            [ "nombre" => "Pestaña 1x1"],
            [ "nombre" => "Pestaña Pre-armada"],
            [ "nombre" => "Pestaña Autofloracion"],
            [ "nombre" => "Pestaña Y"],
            [ "nombre" => "Pestaña W"],

        ];

        foreach ($familias as $familia) {
            sleep(1);
            SubProducto::create($familia);
        }
    }
}
