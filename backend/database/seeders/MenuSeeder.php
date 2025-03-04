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
    
        Menu::create([ "title" => "Dashboard"   , "menu_id" => null, "path" => "dashboard"  , "icon" => "fas fa-home"    , "sort" => 1 ]); // id 1

        Menu::create([ "title" => "Menus"       , "menu_id" => null   , "path" => "menus"       , "icon" => "list"       , "sort" => 2 ]); // id 7 
     
        Menu::create([ "title" => "Roles"       , "menu_id" => null   , "path" => "roles"       , "icon" => "user-secret"       , "sort" => 3 ]); // id 8
        
        Menu::create([ "title" => "Users"       , "menu_id" => null   , "path" => "users"       , "icon" => "user"        , "sort" => 4 ]); // id 9

    }
}

