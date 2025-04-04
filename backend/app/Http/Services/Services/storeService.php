<?php

namespace App\Http\Services\Services;

use App\Http\Requests\Services\ServiceStoreRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Services;


class storeService
{
    static public function index(ServiceStoreRequest $request): JsonResponse
    {
        $service = new Services;

        $service->service_type = $request->name;
        $service->is_for_elevators = $request->is_elevator;

        $service->save();

        return response()->json(["message" => 'Se ha creado correctamente'], 200);
    }
}
