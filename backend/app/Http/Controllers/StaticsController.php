<?php

namespace App\Http\Controllers;

use Illuminate\Http\{Request, JsonResponse};

use App\Http\Services\Statics\{
    countendDashService,
    fundReserveService,
};

class StaticsController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        return countendDashService::execute($request);
    }

    public function fundReserve(Request $request): JsonResponse
    {
        return fundReserveService::execute($request);
    }
}
