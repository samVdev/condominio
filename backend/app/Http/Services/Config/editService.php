<?php

namespace App\Http\Services\Config;

use App\Http\Requests\Config\UpdateConfigRequest;
use App\Models\Config;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class editService
{
    static public function index(UpdateConfigRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $config = Config::where('id', 1)->first();
    
            if (!$config) return response()->json(["message" => "Configuración no encontrada"], 404);
            
            $config->name = $request->titu;
            $config->dni = $request->cedu;
            $config->account = $request->cuenta;
            $config->phone = $request->cel;
            $config->bank = $request->banco;
            $config->save();
    
            DB::commit();
            return response()->json(["message" => 'Se ha guardado correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => "Ocurrió un error al guardar la configuración",
            ], 500);
        }
    }
}
