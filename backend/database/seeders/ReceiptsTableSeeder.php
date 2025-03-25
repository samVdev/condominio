<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Receipt;
use App\Models\Personas; // Asegúrate de importar el modelo Person
use App\Models\Expenses; // Asegúrate de importar el modelo Expense

class ReceiptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$personas = Personas::all();
        $gastos = Expenses::all();

        $receipts = [
            [
                'persona_id' => $personas->random()->id,
                'total_pagado' => 150.00,
                'gasto_id' => $gastos->random()->id,
                'porcentaje_alicuota' => 2.5,
                'cedula' => '12345678',
                'referencia' => '123456',
            ],
            [
                'persona_id' => $personas->random()->id,
                'total_pagado' => 200.00,
                'gasto_id' => $gastos->random()->id,
                'porcentaje_alicuota' => 3.0,
                'cedula' => '87654321',
                'referencia' => '654321',
            ],
            [
                'persona_id' => $personas->random()->id,
                'total_pagado' => 100.00,
                'gasto_id' => $gastos->random()->id,
                'porcentaje_alicuota' => 1.5,
                'cedula' => '11223344',
                'referencia' => '112233',
            ],
            [
                'persona_id' => $personas->random()->id,
                'total_pagado' => 250.00,
                'gasto_id' => $gastos->random()->id,
                'porcentaje_alicuota' => 4.0,
                'cedula' => '44332211',
                'referencia' => '334455',
            ],
            [
                'persona_id' => $personas->random()->id,
                'total_pagado' => 80.00,
                'gasto_id' => $gastos->random()->id,
                'porcentaje_alicuota' => 2.0,
                'cedula' => '55667788',
                'referencia' => '778899',
            ],
        ];

        foreach ($receipts as $receipt) {
            Receipt::create($receipt);
        }*/
    }
}