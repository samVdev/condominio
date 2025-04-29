<?php

namespace App\Http\Services\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;


class getUserService
{
    static public function index(string $uuid): JsonResponse
    {
        try {
            $user = User::with(['persona' => function($query) {
                $query->select('id', 'fullName', 'phone', 'condominium_id');
            }])
            ->select('email', 'persona_id', 'role_id', 'suspend')
            ->where('uuid', $uuid)
            ->first();
        
            if (!$user) return response()->json(['message' => 'Usuario no encontrado'], 404);
        
            $data = [
                "email" => $user->email ?? '',
                'name' => $user->persona->fullName ?? '',
                'phone' => $user->persona->phone ?? '',
                'apt_id' => $user->persona->condominium_id ?? '0',
                'suspend' => $user->suspend,
                'role_id' => $user->role_id ?? '0'
            ];
        
            return response()->json($data, 200);
        
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al obtener los datos del usuario'
            ], 500);
        }
        
    }
}
