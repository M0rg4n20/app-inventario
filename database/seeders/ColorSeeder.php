<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
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
            ["id"=>"99","nombre" => "Color"],
            ["id"=>"98","nombre" => "Transparente"],
            ["id"=>"01","nombre" => "Negro"],
            ["id"=>"02","nombre" => "Café"],

        ];

        foreach ($familias as $familia) {
            sleep(1);
            Color::create($familia);
        }
    }
}
