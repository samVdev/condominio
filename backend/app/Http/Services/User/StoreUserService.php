<?php
namespace App\Http\Services\User;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use App\Models\Personas;
use Illuminate\Http\JsonResponse;

class StoreUserService
{
  
    static public function execute(StoreUserRequest $request): JsonResponse
    {
        try {
            $persona = new Personas();
            $persona->fullName = $request->name;
            $persona->phone = $request->phone;
            $persona->condominium_id = $request->apt_id;
            $persona->save();
        
            $user = new User();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role_id = $request->role_id;
            $user->persona_id = $persona->id;
            $user->suspend = $request->suspend;
        
            $user->save();
        
            return response()->json(["message" => "Se ha creado con exito"], 201);
        
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al crear el usuario'
            ], 500);
        }        
    }

}
