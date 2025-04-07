<?php

namespace App\Http\Controllers;

use App\Http\Requests\Config\UpdateConfigRequest;
use Illuminate\Http\JsonResponse;

use App\Http\Services\Config\indexService;
use App\Http\Services\Config\editService;
use App\Http\Services\getDolar;
use App\Http\Services\Config\DolarService;

class ConfigController extends Controller
{
    public function index(): JsonResponse
    {
        return indexService::index();
    }

    public function getDolar(): JsonResponse
    {
        return DolarService::index();
    }

    public function edit(UpdateConfigRequest $request): JsonResponse
    {
        return editService::index($request);
    }

    public function updateDollar(): JsonResponse
    {
        return response()->json([
            'newMount' => getDolar::updateDollarRate()
        ]);
    }
}
