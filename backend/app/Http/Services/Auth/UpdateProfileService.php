<?php

namespace App\Http\Services\Auth;

use App\Http\Requests\Auth\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UpdateProfileService
{
    static public function index(UpdateProfileRequest $request): JsonResponse
    {
        $authUser = Auth::user();
        if (!$authUser) {
            return response()->json(['message' => 'No permitido'], 403);
        }
    
        $persona = $authUser->persona;
        
        $authUser->update([
            'email' => $request->email,
        ]);
    
        $persona->update([
            'fullName' => $request->name,
            'phone'    => $request->tel,
        ]);
    
        return response()->json([
            'message' => 'Perfil actualizado con éxito',
        ], 200);
    }
    
}
