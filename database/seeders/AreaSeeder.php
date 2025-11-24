<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            ['id_area' => 1, 'nombre_area' => 'Administrativa'],
            ['id_area' => 2, 'nombre_area' => 'Construcción y Mantenimiento'],
            ['id_area' => 3, 'nombre_area' => 'Tecnología y Sistemas'],
            ['id_area' => 4, 'nombre_area' => 'Salud y Bienestar'],
            ['id_area' => 5, 'nombre_area' => 'Educación y Formación'],
            ['id_area' => 6, 'nombre_area' => 'Servicios Generales'],
            ['id_area' => 7, 'nombre_area' => 'Industrial y Manufactura'],
            ['id_area' => 8, 'nombre_area' => 'Comercial y Ventas'],
            ['id_area' => 9, 'nombre_area' => 'Arte y Diseño'],
        ];

        DB::table('areas')->insert($areas);
    }
}
