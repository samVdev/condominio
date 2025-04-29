<?php

namespace App\Http\Controllers;

use App\Http\Requests\Expenses\FormExpensesRequest;
use App\Http\Requests\Expenses\editExpensesRequest;
use App\Http\Services\Condominium\getTowersService;
use App\Http\Services\Expenses\deleteService;
use App\Http\Services\Expenses\editService;
use App\Http\Services\Expenses\indexService;
use App\Http\Services\Expenses\showService;
use App\Http\Services\Expenses\storeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CondominiumController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return indexService::index($request);
    }

    public function resume(): JsonResponse
    {
        return getTowersService::get();
    }

    public function towers(): JsonResponse
    {
        return getTowersService::get();
    }

    public function show(string $id): JsonResponse
    {
        return showService::index($id);
    }

    public function store(FormExpensesRequest $request): JsonResponse
    {
         return storeService::index($request);
     } 

    public function edit(editExpensesRequest $request, string $id): JsonResponse
   {
        return editService::index($request, $id);
    } 
    
    public function destroy(string $id): JsonResponse
    {
         return deleteService::destroy($id);
     } 
}