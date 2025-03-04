<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Expenses;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Crear algunos gastos de ejemplo
        $expenses = [
            [
                'service_id' => 1, // Asegúrate de que este ID exista en la tabla services
                'condominium_id' => 1, // Selecciona un condominio aleatorio
                'amount_dollars' => 150.00,
                'dollar_value' => 4.50,
                'porcent_first_five_days' => 4.50,
            ],
            [
                'service_id' => 2,
                'condominium_id' => 12,
                'amount_dollars' => 200.00,
                'dollar_value' => 4.50,
                'porcent_first_five_days' => 4.50,
            ],
            [
                'service_id' => 3,
                'condominium_id' => 1,
                'amount_dollars' => 100.00,
                'dollar_value' => 4.50,
                'porcent_first_five_days' => 4.50,
            ],
            [
                'service_id' => 4,
                'condominium_id' => 34,
                'amount_dollars' => 250.00,
                'dollar_value' => 4.50,
                'porcent_first_five_days' => 4.50,
            ],
            [
                'service_id' => 5,
                'condominium_id' => 1,
                'amount_dollars' => 80.00,
                'dollar_value' => 4.50,
                'porcent_first_five_days' => 4.50,
            ],
        ];

        foreach ($expenses as $expense) {
            Expenses::create($expense);
        }
    }
}