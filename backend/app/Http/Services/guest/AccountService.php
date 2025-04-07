<?php

namespace App\Http\Services\guest;

use App\Models\Config;
use Illuminate\Http\JsonResponse;

class AccountService
{
    static public function index(): JsonResponse
    {
        $config = Config::select('account', 'dni', 'name', 'bank')->find(1);

        return response()->json([
            'cuenta' => $config->account,
            //'cedu' => $config->cedula,
            'titu' => $config->name,
            'banco' => $config->bank,
        ], 200);
    }
}
