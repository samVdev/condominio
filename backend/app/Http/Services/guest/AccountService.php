<?php

namespace App\Http\Services\guest;

use App\Models\Config;
use Illuminate\Http\JsonResponse;

class AccountService
{
    static public function index(): JsonResponse
    {
        try {
            $config = Config::select('account', 'dni', 'name', 'bank')->find(1);
        
            if (!$config) return response()->json(['message' => 'Configuración no encontrada'], 404);
        
            return response()->json([
                'cuenta' => $config->account,
                //'cedu' => $config->dni, // Descomenta si lo necesitas
                'titu' => $config->name,
                'banco' => $config->bank,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al obtener la configuración',
            ], 500);
        }
        
    }
}
