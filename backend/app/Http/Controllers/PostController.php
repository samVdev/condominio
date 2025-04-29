<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\PostEditRequest;
use App\Http\Requests\Posts\PostStoreRequest;
use App\Http\Services\Posts\deleteService;
use App\Http\Services\Posts\editService;
use App\Http\Services\Posts\emailService;
use App\Http\Services\Posts\indexService;
use App\Http\Services\Posts\showService;
use App\Http\Services\Posts\storeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return indexService::index($request);
    }

    public function show(string $id): JsonResponse
    {
        return showService::index($id);
    }

    public function email(string $id): JsonResponse
    {
         return emailService::index($id);
     } 

    public function store(PostStoreRequest $request): JsonResponse
    {
         return storeService::index($request);
     } 

    public function edit(PostEditRequest $request, string $id): JsonResponse
   {
        return editService::index($request, $id);
    } 
    
    public function destroy(string $id): JsonResponse
    {
         return deleteService::destroy($id);
     } 
}
