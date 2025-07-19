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
            'fullName' => 'SUPERADMIN',
            'phone' => 'test',
            'condominium_id' => null
        ]);

        /*Personas::create([
            'fullName' => 'María Gómez',
            'phone' => '987654321',
            'condominium_id' => 6
        ]);

        Personas::create([
            'fullName' => 'Pablo Gómez',
            'phone' => '987654321',
            'condominium_id' => 14,
        ]);


        Personas::create([
            'fullName' => 'JUan Gómez',
            'phone' => '987654321',
            'condominium_id' => 28,
        ]);



        Personas::create([
            'fullName' => 'Valeria Gómez',
            'phone' => '987654321',
            'condominium_id' => 15,
        ]);


        Personas::create([
            'fullName' => 'Jenifer Gómez',
            'phone' => '987654321',
            'condominium_id' => 20,
        ]);
*/

    }
}