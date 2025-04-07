<?php

namespace App\Http\Services\Config;

use App\Models\Config;
use Illuminate\Http\JsonResponse;

class DolarService
{
    static public function index(): JsonResponse
    {
        $dolar = Config::select('dolar')->find(1);
        return response()->json($dolar, 200);
    }
}
