<?php

namespace App\Http\Controllers;

use App\Http\Requests\Factures\FormFactureRequest;
use App\Http\Services\Factures\deleteService;
use App\Http\Services\Factures\exportExpensesService;
use App\Http\Services\Factures\indexService;
use App\Http\Services\Factures\storeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FacturesController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return indexService::index($request);
    }

    public function store(FormFactureRequest $request): JsonResponse
    {
         return storeService::index($request);
    } 

    /*public function FactureUserPending(Request $request): JsonResponse
    {
         return facturesPendingService::index($request);
    } */


     public function exportExpenses(Request $request)
    {
         return exportExpensesService::index($request);
    } 
    
    public function destroy(string $id): JsonResponse
    {
         return deleteService::destroy($id);
    } 
}
