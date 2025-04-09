<?php

namespace App\Http\Controllers;

use App\Http\Services\guest\DashboardCount;
use App\Http\Services\guest\ExpensesFacture;
use App\Http\Services\guest\FactureUserCompletedService;
use App\Http\Services\guest\FactureUserPending;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function FactureUserPending(Request $request): JsonResponse
    {
         return FactureUserPending::index($request);
    } 

    public function FactureUserCompleted(Request $request): JsonResponse
    {
         return FactureUserCompletedService::index($request);
    } 

    public function ExpensesFacture(Request $request): JsonResponse
    {
         return ExpensesFacture::index($request);
    } 

    public function DashboardCount(): JsonResponse
    {
         return DashboardCount::index();
    } 
}
