<?php

namespace App\Http\Services\TypeEarnings;

use App\Http\Requests\TypeEarnings\TypeEarningStoreRequest;
use Illuminate\Http\JsonResponse;
use App\Models\TypeEarning;


class storeService
{
    static public function index(TypeEarningStoreRequest $request): JsonResponse
    {
        try {
            $type = new TypeEarning;
            $type->name = $request->name;
            $type->save();
            return response()->json(["message" => 'Se ha creado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al crear el tipo de ingreso'
            ], 500);
        }
        
    }
}
