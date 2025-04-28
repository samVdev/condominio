<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Config;

class ConfigSeeder extends Seeder
{
    public function run()
    {
        Config::create([
            'dolar' => 0,
            'name' => 'Juan Pérez',
            'dni' => '12345678',
            'account' => '01234567890123456789',
            'bank' => 'venezuela',
            'phone' => '0000',
        ]);
    }
}
