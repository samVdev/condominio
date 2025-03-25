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
            'suspend' => false,
            'persona_id' => 1,
            'email_verified_at' => null,
            'is_admin' => true,
            'role_id' => 1    
          ]
        );

        \App\Models\User::factory(1)->create([
            'email' => 'aaa@example.com',
            'suspend' => false,
            'persona_id' => 2,
            'email_verified_at' => null,
            'is_admin' => true,
            'role_id' => 2       
          ]
        );

        \App\Models\User::factory(1)->create([
            'email' => 'useer@example.com',
            'suspend' => false,
            'persona_id' => 3,
            'email_verified_at' => null,
            'is_admin' => true,
            'role_id' => 1       
          ]
        );

        \App\Models\User::factory(1)->create([
            'email' => 'asd@example.com',
            'suspend' => false,
            'persona_id' => 4,
            'email_verified_at' => null,
            'is_admin' => true,
            'role_id' => 1       
          ]
        );

        \App\Models\User::factory(1)->create([
            'email' => '3242@example.com',
            'suspend' => false,
            'persona_id' => 5,
            'email_verified_at' => null,
            'is_admin' => true,
            'role_id' => 1       
          ]
        );

        \App\Models\User::factory(1)->create([
            'email' => '324aaa2@example.com',
            'suspend' => false,
            'persona_id' => 6,
            'email_verified_at' => null,
            'is_admin' => true,
            'role_id' => 1       
          ]
        );
    }
}
