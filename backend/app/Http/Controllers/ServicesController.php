<?php

namespace App\Http\Controllers;

use App\Http\Requests\Services\ServiceRequest;
use App\Http\Services\Services\deleteService;
use App\Http\Services\Services\editService;
use App\Http\Services\Services\getMiniumService;
use App\Http\Services\Services\indexService;
use App\Http\Services\Services\showService;
use App\Http\Services\Services\storeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return indexService::index($request);
    }

    public function getMinium(): JsonResponse
    {
        return getMiniumService::index();
    }

    public function show(string $id): JsonResponse
    {
        return showService::index($id);
    }

    public function store(ServiceRequest $request): JsonResponse
    {
         return storeService::index($request);
     } 

    public function edit(ServiceRequest $request, string $id): JsonResponse
   {
        return editService::index($request, $id);
    } 
    
    public function destroy(string $id): JsonResponse
    {
         return deleteService::destroy($id);
     } 
}
