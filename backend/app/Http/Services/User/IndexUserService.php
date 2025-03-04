<?php

namespace App\Http\Services\User;

//use App\Http\Resources\UserCollection;
//use App\Http\Resources\UserResource;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class IndexUserService
{

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    static public function execute(Request $request): JsonResponse
    {
        // Initialize query 
        $query = User::query()
        ->join('personas', 'users.persona_id', '=', 'personas.id')
        ->join('condominium', 'personas.condominium_id', '=', 'condominium.id')
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->leftJoin('expenses', 'expenses.condominium_id', '=', 'condominium.condominium_id')
        ->leftJoin('receipts', function ($join) {
            $join->on('receipts.persona_id', '=', 'personas.id')
                 ->on('receipts.gasto_id', '=', 'expenses.id');
        })
        ->select(
            'Nombre',
            'fullName',
            'phone',
            'name',
            'email',
            'users.uuid',
            \DB::raw('COUNT(DISTINCT expenses.id) - COUNT(DISTINCT receipts.gasto_id) AS expenses_no_pagados')
        )
        ->groupBy('Nombre', 'fullName', 'phone', 'name', 'email', 'users.uuid');
    

        // search 
        $search = $request->input("search");
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where("personas.fullName", "like", "%$search%")
                    ->orWhere("roles.name", "like", "%$search%")
                    ->orWhere("users.email", "like", "%$search%")
                    ->orWhere("personas.phone", "like", "%$search%");
            });
        }

        // sort 
        $sort = $request->input("sort");
        $direction = $request->input("direction") == "desc" ? "desc" : "asc";

        if ($sort) {
            $query->orderBy($sort, $direction);
        }

        // get paginated results 
        $users = $query
            ->paginate(10)
            ->appends(request()->query());

        $users->getCollection()->transform(function ($user) {
            return [
                'uuid' => $user->uuid,
                'rol' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'nombre' => $user->fullName,
                'apt' => $user->Nombre,
                'pending_receipts' => $user->expenses_no_pagados,
            ];
        });

        return response()->json([
            "rows" => $users,
            "sort" => $request->query("sort"),
            "direction" => $request->query("direction"),
            "search" => $request->query("search")
        ]);
    }
}
