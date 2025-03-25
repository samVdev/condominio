<?php

namespace App\Http\Services\Services;

use Illuminate\Http\JsonResponse;
use App\Models\Services;
use Illuminate\Http\Request;


class deleteService
{
    static public function destroy(string $id): JsonResponse
    {
        $service = Services::find($id);

        if (!$service)return response()->json(['error' => 'Servicio no encontrado'], 404);

        $service->delete();

        return response()->json(['message' => 'Servicio eliminado correctamente'], 200);
    }
}

