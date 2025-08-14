<?php

namespace App\Http\Controllers;

use App\Http\Services\guest\AccountService;
use App\Http\Services\guest\DashboardCount;
use App\Http\Services\guest\EarningsFacture;
use App\Http\Services\guest\ExpensesFacture;
use App\Http\Services\guest\FactureUserCompletedService;
use App\Http\Services\guest\FactureUserPending;
use App\Http\Services\guest\ProvisionsFacture;

use App\Http\Services\guest\boardsActService;
use App\Http\Services\guest\disconnectBoardLiveService;
use App\Http\Services\guest\getBoardLiveService;
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

     public function ProvisionsFacture(Request $request): JsonResponse
     {
          return ProvisionsFacture::index($request);
     }

     public function EarningsFacture(Request $request): JsonResponse
     {
          return EarningsFacture::index($request);
     }

     public function DashboardCount(): JsonResponse
     {
          return DashboardCount::index();
     }

     public function Account(): JsonResponse
     {
          return AccountService::index();
     }

     // boards Guest

     public function boardsAct(Request $request): JsonResponse
     {
          return boardsActService::index($request);
     }

     public function getBoard(string $uuid): JsonResponse
     {
          return getBoardLiveService::index($uuid);
     }

     public function disconnectBoard(Request $request, string $uuid): JsonResponse
     {
          return disconnectBoardLiveService::index($request, $uuid);
     }
}
