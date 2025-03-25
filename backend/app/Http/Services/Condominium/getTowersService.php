<?php

namespace App\Http\Services\Condominium;

use App\Models\Condominium;
use Illuminate\Http\JsonResponse;


class getTowersService
{
    static public function get(): JsonResponse
    {
        $condominium = Condominium::select('id', 'Nombre')->where('condominium_id', null)->get();
        return response()->json($condominium, 200);
    }
}

