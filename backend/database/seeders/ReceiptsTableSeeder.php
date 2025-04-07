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
        $receipts = [
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],


            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],

            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],

            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],

            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],


            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],

            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],

            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],

            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],

            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 150.00,
                'cedula' => '12345678',
                'referencia' => '123456',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 200.00,
                'cedula' => '87654321',
                'referencia' => '654321',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 100.00,
                'cedula' => '11223344',
                'referencia' => '112233',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 250.00,
                'cedula' => '44332211',
                'referencia' => '334455',
                'accepted' => false,
                'facture_id' => 1
            ],
            [
                'persona_id' => 6,
                'total_pagado' => 80.00,
                'cedula' => '55667788',
                'referencia' => '778899',
                'accepted' => false,
                'facture_id' => 1
            ],

        ];



        foreach ($receipts as $receipt) {
            Receipt::create($receipt);
        }
    }
}
