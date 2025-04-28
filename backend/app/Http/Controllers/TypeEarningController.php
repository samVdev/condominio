<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeEarnings\TypeEarningEditRequest;
use App\Http\Requests\TypeEarnings\TypeEarningStoreRequest;
use App\Http\Services\TypeEarnings\deleteService;
use App\Http\Services\TypeEarnings\editService;
use App\Http\Services\TypeEarnings\getMiniumService;
use App\Http\Services\TypeEarnings\indexService;
use App\Http\Services\TypeEarnings\showService;
use App\Http\Services\TypeEarnings\storeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeEarningController extends Controller
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

    public function store(TypeEarningStoreRequest $request): JsonResponse
    {
         return storeService::index($request);
     } 

    public function edit(TypeEarningEditRequest $request, string $id): JsonResponse
   {
        return editService::index($request, $id);
    } 
    
    public function destroy(string $id): JsonResponse
    {
         return deleteService::destroy($id);
     } 
}
