<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        $batchSize = 500; // tamaño de lote
        $totalRecords = 1000000; // cantidad total de registros

        for ($i = 0; $i < $totalRecords; $i += $batchSize) {
            $data = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $data[] = [
                    'service_id' => 2, // Asigna un ID de servicio aleatorio
                    'condominium_id' => null, // o asigna un ID si aplica
                    'amount_dollars' => $faker->randomFloat(2, 5, 500), // Gasto aleatorio entre $5 y $500
                    'dollar_value' => $faker->randomFloat(2, 30, 40), // Valor del dólar aleatorio
                    'image' => null, // O asigna una imagen si aplica
                    'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                    'updated_at' => now(),
                ];
            }

            DB::table('expenses')->insert($data);
        }
    }
}
