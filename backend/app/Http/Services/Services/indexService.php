<?php

namespace App\Http\Services\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Services;


class indexService
{
    static public function index(Request $request): JsonResponse
    {
        try {
            $search = $request->input("search");
            $offset = (int)$request->input("offset", 0);
            $limit = (int)$request->input("limit", 10);
            $direction = $request->input("direction");
            $sort = $request->input("sort");

            $servicesDB = Services::select('id', 'service_type', 'is_for_elevators', 'created_at');

            if (!empty($search)) $servicesDB->where('service_type', 'ilike', "%{$search}%");

            $servicesDB = $servicesDB->skip($offset)->take($limit)->get();

            $services = $servicesDB->map(function ($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->service_type,
                    'is_elevator' => $service->is_for_elevators,
                    'created' => $service->created_at->format('d/m/Y'),
                ];
            });

            return response()->json([
                "rows" => $services,
                "sort" => $sort,
                "direction" => $direction,
                "search" => $search,
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
