<?php

namespace App\Http\Services\Condominium;

use App\Models\Condominium;
use Illuminate\Http\JsonResponse;

class getTowersService
{
    static public function get(): JsonResponse
    {
        try {
            $condominium = Condominium::select('id', 'Nombre as name')->where('condominium_id', null)->get();
            return response()->json($condominium, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
