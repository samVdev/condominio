<?php
namespace App\Http\Services\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;


class getUserService
{
    static public function index(string $uuid) : JsonResponse
    {
        $user = User::where('uuid', $uuid)->get();

        

        return response()->json(["message"=> $user], 200);      
    }
}
