<?php

namespace App\Http\Services\Config;

use App\Models\Config;
use Illuminate\Http\JsonResponse;

class indexService
{
    static public function index(): JsonResponse
    {
        $config = Config::select('account', 'dni', 'dolar', 'name', 'bank', 'phone')->find(1);

        return response()->json([
            'cuenta' => $config->account,
            'cedu' => $config->dni,
            'titu' => $config->name,
            'banco' => $config->bank,
            'cel' => $config->phone,
            'dolarBcv' => $config->dolar,
        ], 200);
    }
}
