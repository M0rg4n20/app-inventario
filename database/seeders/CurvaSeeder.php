<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curva;

class CurvaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $familias =  [
            ["id"=>"00","nombre" => "-"],
            ["id"=>"01","nombre" => "A"],
            ["id"=>"02","nombre" => "B"],

        ];

        foreach ($familias as $familia) {
            sleep(1);
            Curva::create($familia);
        }
    }
}
