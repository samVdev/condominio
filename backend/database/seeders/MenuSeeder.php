<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Menu::create(["title" => "Dashboard", "menu_id" => null, "path" => "dashboard", "icon" => "fas fa-home", "sort" => 1]);

        Menu::create(["title" => "Menus", "menu_id" => null, "path" => "menus", "icon" => "list", "sort" => 2]);

        Menu::create(["title" => "Roles", "menu_id" => null, "path" => "roles", "icon" => "user-secret", "sort" => 3]);

        Menu::create(["title" => "Usuarios", "menu_id" => null, "path" => "users", "icon" => "user", "sort" => 4]);

        Menu::create(["title" => "Servicios", "menu_id" => null, "path" => "services", "icon" => "hand-holding-droplet", "sort" => 5]);

        Menu::create(["title" => "Ingresos", "menu_id" => null, "path" => "earnings", "icon" => "money-bill-trend-up", "sort" => 6]);

        Menu::create(["title" => "Provisiones", "menu_id" => null, "path" => "provisions", "icon" => "sack-dollar", "sort" => 7]);

        Menu::create(["title" => "Gastos", "menu_id" => null, "path" => "expenses", "icon" => "money-bill-transfer", "sort" => 8]);

        Menu::create(["title" => "Facturas", "menu_id" => null, "path" => "factures", "icon" => "receipt", "sort" => 9]);
        
        Menu::create(["title" => "Receipts", "menu_id" => null, "path" => "payments", "icon" => "file-invoice-dollar", "sort" => 10]);

        Menu::create(["title" => "Noticias", "menu_id" => null, "path" => "news", "icon" => "newspaper", "sort" => 11]);

    }
}
