<?php
namespace App\Http\Services\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Personas;
use App\Models\User;


class UpdateUserService
{
    static public function execute(UpdateUserRequest $request, String $uuid) : JsonResponse
    {
        try {
            $data = $request->all();
        
            $user = User::where('uuid', $uuid)->first();
        
            if (!$user) return response()->json(['message' => 'Usuario no encontrado'], 404);
            
            if (isset($data["password"]) && $data["password"]) {
                $data["password"] = Hash::make($data["password"]);
            } else {
                unset($data["password"]);
            }
        
            $persona = $user->persona;
            if ($persona) {
                $persona->fullName = $request->name;
                $persona->phone = $request->phone;
                $persona->condominium_id = $request->apt_id;
                $persona->save();
            }
        
            $user->email = $request->email;
            if (isset($data["password"])) {
                $user->password = $data["password"];
            }
            $user->role_id = $request->role_id;
            $user->suspend = $request->suspend;
            $user->save();
        
            return response()->json(["message" => "Usuario actualizado con exito"], 200);
        
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al actualizar el usuario'
            ], 500);
        }
           
    }
    
}
