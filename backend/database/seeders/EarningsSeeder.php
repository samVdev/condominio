<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class EarningsSeeder extends Seeder
{
    public function run()
{
    $faker = Faker::create();

    DB::table('type_earnings')->insert([
        'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
        'name' => 'AJKSAJS'
    ]);


        $data = [];

        for ($i = 0; $i < 1000000; $i++) {
            $amount = $faker->randomFloat(2, 5, 500); // entre $5 y $500
            $dollarValue = $faker->randomFloat(2, 30, 40); // ejemplo de tasa

            $data[] = [
                'type_id' => 1, // o pon un ID si ya tienes uno
                'condominium_id' => null, // o pon un ID si ya tienes uno
                'facture_id' => null, // o usa uno válido si aplica
                'amount_dollars' => $amount,
                'dollar_value' => $dollarValue,
                'image' => null,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ];

            // Para insertar en lotes de 1000
            if ($i % 1000 == 0 && $i !== 0) {
                DB::table('earnings')->insert($data);
                $data = [];
            }
        }

        // Insertar los últimos registros si quedan
        if (!empty($data)) {
            DB::table('earnings')->insert($data);
        }
    }
}
