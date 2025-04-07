<?php

namespace App\Http\Controllers;

use Illuminate\Http\{Request, JsonResponse};
use App\Models\User;
use App\Http\Requests\User\{
    StoreUserRequest,
    UpdateUserRequest
};
use App\Http\Services\User\{
    getUserService,
    StoreUserService,
    IndexUserService,
    UpdateUserService,
};

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return IndexUserService::execute($request);            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\User\StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */ 
    public function store(StoreUserRequest $request): JsonResponse
    {
        return StoreUserService::execute($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return App\Http\Resources\UserResource | \Illuminate\Http\Response
     */
    public function show(string $uuid): JsonResponse
    {
        return getUserService::index($uuid);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\User\UpdateUserRequest $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */     
    public function update(UpdateUserRequest $request, String $uuid): JsonResponse
    {
        return UpdateUserService::execute($request, $uuid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {      
        $user = User::where('uuid', $request->uuid)->first();
        if(!$user) return response()->json(['error' => 'Usuario no encontrado'], 404);
        $user->delete();
        return response()->json(204);
    }
}
