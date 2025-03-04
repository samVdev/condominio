<?php

namespace App\Http\Controllers;

use Illuminate\Http\{Request, JsonResponse};
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;


use App\Http\Services\Statics\{
    countendDashService,
};



class StaticsController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        return countendDashService::execute($request);

    }

}
