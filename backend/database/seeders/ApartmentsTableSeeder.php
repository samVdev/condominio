<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Condominium;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear 4 torres
        $torres = [
            'Torre A',
            'Torre B',
            'Torre C',
            'Torre D',
        ];

        foreach ($torres as $torre) {
            // Crear la torre
            $torreRecord = Condominium::create([
                'Nombre' => $torre,
                'condominium_id' => null,
                'size' => '2xl',
                'porcent_alicuota' => '0'
            ]);

            // Crear 10 departamentos para cada torre
            for ($i = 1; $i <= 10; $i++) {
                Condominium::create([
                    'Nombre' => 'Apt ' . $i,
                    'condominium_id' => $torreRecord->id, 
                    'size' => '2xl',
                    'porcent_alicuota' => '2'
                ]);
            }
        }
    }
}