<?php

namespace App\Http\Controllers;

use App\Http\Requests\board\StoreBoardRequest;
use App\Http\Services\boards\addLinkService;
use App\Http\Services\boards\deleteService;
use App\Http\Services\boards\enableBoardService;
use App\Http\Services\boards\endBoardService;
use App\Http\Services\boards\indexService;
use App\Http\Services\boards\showAptsService;
use App\Http\Services\boards\storeService;
use App\Http\Services\boards\showService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class boardsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return indexService::index($request);
    }

    public function show(string $uuid): JsonResponse
    {
        return showService::index($uuid);
    }

    public function showApt(Request $request, string $uuid): JsonResponse
    {
        return showAptsService::index($request, $uuid);
    }

    public function store(StoreBoardRequest $request): JsonResponse
    {
        return storeService::index($request);
    }

    public function enableBoard(string $uuid): JsonResponse
    {
        return enableBoardService::index($uuid);
    }

    public function addLink(Request $request, string $uuid): JsonResponse
    {
        return addLinkService::index($request, $uuid);
    }

    public function endBoard(Request $request, string $uuid): JsonResponse
    {
        return endBoardService::index($request, $uuid);
    }

    public function destroy(string $uuid): JsonResponse
    {
        return deleteService::destroy($uuid);
    }
}
