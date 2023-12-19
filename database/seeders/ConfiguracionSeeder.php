<?php

namespace Database\Seeders;

use App\Models\Configuracion;
use Illuminate\Database\Seeder;
use App\Models\Longitud;

class ConfiguracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configuraciones =  [
            ["slug"=>"contrasena-aplicar-descuento","key" => "Contraseña aplicar descuento","value"=>"1998"],
            ["slug"=>"tienda-rfc","key" => "Tienda rfc","value"=>"XXXX8X091X46X"],
            ["slug"=>"tienda-direccion","key" => "Tienda dirección","value"=>"Av, Calz de las Americas Nte No 2131,Burócrata"],
            ["slug"=>"tienda-ciudad","key" => "Tienda ciudad","value"=>"Culiacán Rosales"],

        ];

        foreach ($configuraciones as $configuracion) {

            Configuracion::create($configuracion);
        }
    }
}
