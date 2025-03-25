<?php

namespace App\Http\Controllers;

use Illuminate\Http\{Request, JsonResponse};

use App\Http\Services\Receipts\{
    IndexUsersReceiptsService
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
}
