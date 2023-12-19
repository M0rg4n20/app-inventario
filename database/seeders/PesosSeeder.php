<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peso;

class PesosSeeder extends Seeder
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

        ];

        foreach ($familias as $familia) {
            Peso::create($familia);
        }
    }
}
