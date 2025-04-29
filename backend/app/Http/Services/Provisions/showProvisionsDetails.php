<?php

namespace App\Http\Services\Provisions;

use App\Models\ProvisionBalance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class showProvisionsDetails
{
    static public function index(Request $request): JsonResponse
    {
        try {
            $offset = (int)$request->input("offset", 0);
            $limit = (int)$request->input("limit", 10);

            //$provisions = ProvisionBalance::skip($offset)->take($limit)->get();
            $provisions = ProvisionBalance::join('services', 'service_id', 'services.id')
            ->select(
                'current_balance as total',
                'service_type as name',
            )
            ->get();

            return response()->json([
                'rows' => $provisions
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
