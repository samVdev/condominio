<?php

namespace Database\Seeders;

use App\Models\Factures;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FacturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Factures::create([
            'fecha' => Carbon::now()->subMonths(rand(0, 12)), // Fecha aleatoria en el último año
            'porcent_first_five_days' => rand(5, 10), // Porcentaje aleatorio entre 5% y 10%
            'total_dollars' => 300, // Total en dólares aleatorio entre 100 y 200
            'dollar_bcv' => 66.7, // Tasa aleatoria de dólar BCV
            'number_month' => 1, // Tasa aleatoria de dólar BCV
        ]);
    }
}
