<?php

namespace App\Http\Controllers;

use App\Http\Requests\Provisions\FormProvisionsRequest;
use App\Http\Requests\Provisions\editProvisionsRequest;
use App\Http\Services\Provisions\checkService;
use App\Http\Services\Provisions\deleteService;
use App\Http\Services\Provisions\editService;
use App\Http\Services\Provisions\indexService;
use App\Http\Services\Provisions\showFunds;
use App\Http\Services\Provisions\showProvisionsDetails;
use App\Http\Services\Provisions\showService;
use App\Http\Services\Provisions\storeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProvisionsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return indexService::index($request);
    }

    public function show(string $id): JsonResponse
    {
        return showService::index($id);
    }

    public function showFund(): JsonResponse
    {
        return showFunds::index();
    }

    public function check(string $service_id, string $expense_id): JsonResponse
    {
        $checked = checkService::index($service_id, $expense_id);

        return response()->json([
            'total' => $checked['total'],
            'isForElevator' => $checked['isForElevator'],
        ], 200);
    }

    public function store(FormProvisionsRequest $request): JsonResponse
    {
        return storeService::index($request);
    }

    public function edit(editProvisionsRequest $request, string $id): JsonResponse
    {
        return editService::index($request, $id);
    }

    public function showProvisionsDetails(Request $request): JsonResponse
    {
        return showProvisionsDetails::index($request);
    }

    public function destroy(string $id): JsonResponse
    {
        return deleteService::destroy($id);
    }
}
