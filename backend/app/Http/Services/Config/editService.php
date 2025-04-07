<?php

namespace App\Http\Services\Config;

use App\Http\Requests\Config\UpdateConfigRequest;
use App\Models\Config;
use Illuminate\Http\JsonResponse;

class editService
{
    static public function index(UpdateConfigRequest $request): JsonResponse
    {
        $config = Config::where('id', 1)->first();
        $config->name = $request->titu;
        $config->dni = $request->cedu;
        $config->account = $request->cuenta;
        $config->phone = $request->cel;
        $config->bank = $request->banco;
        $config->save();
        return response()->json(["message" => 'Se ha guardado correctamente'], 200);
    }
}
