<?php

namespace App\Http\Controllers;

use App\Http\Requests\Earnings\FormEarningsRequest;
use App\Http\Requests\Earnings\editEarningsRequest;

use App\Http\Services\Earnings\deleteService;
use App\Http\Services\Earnings\editService;
use App\Http\Services\Earnings\indexService;
use App\Http\Services\Earnings\showService;
use App\Http\Services\Earnings\storeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EarningsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return indexService::index($request);
    }

    public function show(string $id): JsonResponse
    {
        return showService::index($id);
    }

    public function store(FormEarningsRequest $request): JsonResponse
    {
         return storeService::index($request);
     } 

    public function edit(editEarningsRequest $request, string $id): JsonResponse
   {
        return editService::index($request, $id);
    } 
    
    public function destroy(string $id): JsonResponse
    {
         return deleteService::destroy($id);
     } 
}
