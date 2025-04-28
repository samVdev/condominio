<?php

namespace App\Http\Services\Config;

use App\Models\Config;
use Illuminate\Http\JsonResponse;

class DolarService
{
    static public function index(): JsonResponse
    {
        try {
            $dolar = Config::select('dolar')->find(1);
            return response()->json($dolar, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
