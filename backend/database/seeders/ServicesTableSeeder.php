<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Services;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear algunos servicios de ejemplo
        $services = [
            ['service_type' => 'Mantenimiento de áreas comunes'],
            ['service_type' => 'Pago de electricidad'],
            ['service_type' => 'Pago de agua'],
            ['service_type' => 'Mantenimiento de piscina'],
            ['service_type' => 'Limpieza de jardines'],
        ];

        foreach ($services as $service) {
            Services::create($service);
        }
    }
}