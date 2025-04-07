<?php

namespace App\Http\Controllers;

use App\Http\Requests\Receipts\ReceiptActionsRequest;
use App\Http\Requests\Receipts\RequestStoreReceipts;
use Illuminate\Http\{Request, JsonResponse};

use App\Http\Services\Receipts\{
    ActionsReceiptService,
    IndexReceiptsService,
    IndexUsersReceiptsService,
    storeReceipts
};



class ReceiptsController extends Controller
{

    public function index (Request $request): JsonResponse
    {
        return IndexReceiptsService::execute($request);
    }

    public function actions (ReceiptActionsRequest $request): JsonResponse
    {
        return ActionsReceiptService::execute($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function receiptsUsers(Request $request): JsonResponse
    {
        return IndexUsersReceiptsService::execute($request);
    }

    public function storeReceipt(RequestStoreReceipts $request, $id): JsonResponse
    {
        return storeReceipts::execute($request, $id);
    }
}
