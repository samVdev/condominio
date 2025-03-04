<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Personas; // Asegúrate de importar el modelo

class PersonasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear datos de ejemplo
        Personas::create([
            'fullName' => 'Juan Pérez',
            'phone' => '123456789',
            'condominium_id' => 1, 
        ]);

        Personas::create([
            'fullName' => 'María Gómez',
            'phone' => '987654321',
            'condominium_id' => 1,
        ]);

    }
}