<?php

namespace App\Http\Controllers;

use App\Http\Requests\Condominium\FormCondominiumRequest;
use App\Http\Requests\Condominium\editCondominiumRequest;
use App\Http\Services\Condominium\countService;
use App\Http\Services\Condominium\getTowersService;
use App\Http\Services\Condominium\deleteService;
use App\Http\Services\Condominium\editService;
use App\Http\Services\Condominium\getAptsService;
use App\Http\Services\Condominium\indexService;
use App\Http\Services\Condominium\showService;
use App\Http\Services\Condominium\storeService;
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
        return countService::index();
    }

    public function towers(): JsonResponse
    {
        return getTowersService::get();
    }

    public function Apts(string $id = ''): JsonResponse
    {
        return getAptsService::get($id);
    }


    public function show(string $id): JsonResponse
    {
        return showService::index($id);
    }

    public function store(FormCondominiumRequest $request): JsonResponse
    {
        return storeService::index($request);
    }

    public function edit(editCondominiumRequest $request, string $id): JsonResponse
    {
        return editService::index($request, $id);
    }


    public function destroy(string $id): JsonResponse
    {
        return deleteService::destroy($id);
    }
}
