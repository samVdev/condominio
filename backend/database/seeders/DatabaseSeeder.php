<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            MenuSeeder::class,
            ApartmentsTableSeeder::class,
            PersonasTableSeeder::class,
            UserSeeder::class,
            ServicesTableSeeder::class,
            //FacturesSeeder::class,
            //ExpensesTableSeeder::class,
            //ReceiptsTableSeeder::class
        ]);
    }
}
