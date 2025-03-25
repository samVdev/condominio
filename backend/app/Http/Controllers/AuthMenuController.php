<?php

namespace App\Http\Controllers;

//use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Menu\RecursiveMenuRepository;
use \App\Models\Role;


class AuthMenuController extends Controller
{
    public function __invoke()
    {
        if (!Auth::user()) return  response()->json(["message" => "Forbidden"], 403);          

        $user = Auth::user();
        $role = Role::select('menu_ids')->find($user->role_id);           
        $menus = RecursiveMenuRepository::recursive($role->menu_ids);
        return response()->json($menus);       
       
    }
}
