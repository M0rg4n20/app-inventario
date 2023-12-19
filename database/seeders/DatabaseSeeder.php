<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ConfiguracionSeeder::class);
        $this->call(CategoriasSeeder::class);
        $this->call(CurvaSeeder::class);
        $this->call(MetodoPagosSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(DiferenciadorSeeder::class);
        $this->call(FamiliasSeeder::class);
        $this->call(LongitudSeeder::class);
        $this->call(SubProductosSeeder::class);
        $this->call(MarcasSeeder::class);
        $this->call(PesosSeeder::class);

    }
}
