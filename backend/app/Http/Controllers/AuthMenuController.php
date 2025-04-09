<?php

namespace App\Http\Controllers;

//use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Menu\RecursiveMenuRepository;
use \App\Models\Role;

use function PHPUnit\Framework\isEmpty;

class AuthMenuController extends Controller
{
    public function __invoke()
    {
        if (!Auth::user()) return  response()->json(["message" => "Forbidden"], 403);          

        $user = Auth::user();
        $role = Role::select('menu_ids')->find($user->role_id);   
        $menus = [];
        if (count($role->menu_ids) > 0) {
            $menus = RecursiveMenuRepository::recursive($role->menu_ids);
        }
        return response()->json($menus);       
       
    }
}
