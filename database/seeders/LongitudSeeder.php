<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Longitud;

class LongitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $familias =  [
            ["codigo"=>"000","nombre" => "-"],
            ["codigo"=>"999","nombre" => "MIX"],

        ];

        foreach ($familias as $familia) {
            sleep(1);
            Longitud::create($familia);
        }
    }
}
