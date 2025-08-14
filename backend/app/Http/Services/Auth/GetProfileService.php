<?php

namespace App\Http\Services\Auth;

use App\Models\Condominium;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetProfileService
{
    static public function index(): JsonResponse
    {
            $authUser = Auth::user();
            if(!$authUser) return response()->json(['message' => 'No permitido'], 403);
    
            $persona = Auth::user()->persona;

            $condominio = null;
            $tower = null;

            if($persona->condominium_id) {
                $condominio = Condominium::select('Nombre', 'condominium_id')->find($persona->condominium_id);
                if($condominio) $tower = Condominium::select('Nombre')->find($condominio->condominium_id);
            }
    
            $user = [
                "id" => $authUser->id,
                "email" => $authUser->email,
                "name" => $persona->fullName,
                "tel" => $persona->phone,
                'apt' => $condominio ? $condominio->Nombre : 'Sin data',
                'tower' => $tower ? $tower->Nombre : 'Sin data',
            ];
    
            return response()->json($user, 200);
     
    }
}
