<?php

namespace App\Http\Services\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Services;


class indexService
{
    static public function index(Request $request): JsonResponse
    {
        $search = $request->input("search");

        $servicesDB = Services::select('id', 'service_type', 'is_for_elevators', 'created_at');

        if (!empty($search)) $servicesDB->where('service_type', 'ilike', "%{$search}%");
        
        $servicesDB = $servicesDB->get();
        
        $services = $servicesDB->map(function ($service) {
            return [
                'id' => $service->id,               
                'name' => $service->service_type,               
                'is_elevator' => $service->is_for_elevators,
                'created' => $service->created_at->format('d/m/Y'),               
            ];
        });

        return response()->json($services, 200);
    }
}
