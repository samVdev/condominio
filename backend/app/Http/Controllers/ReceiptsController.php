<?php

namespace App\Http\Controllers;

use App\Http\Requests\Receipts\RequestStoreReceipts;
use Illuminate\Http\{Request, JsonResponse};

use App\Http\Services\Receipts\{
    IndexUsersReceiptsService,
    storeReceipts
};



class ReceiptsController extends Controller
{

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
