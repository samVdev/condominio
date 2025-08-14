<?php

namespace App\Http\Controllers;

use App\Http\Requests\Elevators\FormElevatorsRequest;
use App\Http\Requests\Elevators\editElevatorsRequest;
use App\Http\Services\Elevators\countService;
use App\Http\Services\Elevators\deleteService;
use App\Http\Services\Elevators\editService;
use App\Http\Services\Elevators\getMinService;
use App\Http\Services\Elevators\indexService;
use App\Http\Services\Elevators\showService;
use App\Http\Services\Elevators\storeService;
use App\Http\Services\Elevators\historyService;
use App\Http\Services\Elevators\reportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ElevatorsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return indexService::index($request);
    }

    public function getMin(Request $request): JsonResponse
    {
        return getMinService::index($request);
    }

    public function resume(): JsonResponse
    {
        return countService::index();
    }

    // elevators
    public function historyService(Request $request): JsonResponse
    {
        return historyService::index($request);
    }


    public function show(string $id): JsonResponse
    {
        return showService::index($id);
    }

    public function store(FormElevatorsRequest $request): JsonResponse
    {
        return storeService::index($request);
    }

    public function edit(editElevatorsRequest $request, string $id): JsonResponse
    {
        return editService::index($request, $id);
    }

    public function reportService(Request $request, string $id): JsonResponse
    {
        return reportService::index($request, $id);
    }

    public function destroy(string $id): JsonResponse
    {
        return deleteService::destroy($id);
    }
}
