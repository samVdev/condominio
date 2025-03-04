<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        \App\Models\User::factory(1)->create([
            'email' => 'user@example.com',
            'persona_id' => 1,
            'email_verified_at' => null,
            'is_admin' => true,
            'role_id' => 1       
          ]
        );
    }
}
