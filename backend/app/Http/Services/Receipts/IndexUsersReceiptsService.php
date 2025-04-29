<?php

namespace App\Http\Services\Receipts;

//use App\Http\Resources\UserCollection;
//use App\Http\Resources\UserResource;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class IndexUsersReceiptsService
{

    static public function execute(Request $request): JsonResponse
    {
        try {
            $offset = $request->input("offset", 0);
            $limit = $request->input("limit", 10);
            $search = $request->input("search");
            $sort = $request->input("sort");
            $facture = $request->input("facture");
            $tower = $request->input("tower");
            $direction = $request->input("direction") == "desc" ? "desc" : "asc";

            $query = User::query()
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->join('condominium', 'personas.condominium_id', '=', 'condominium.id')
                ->join('condominium as tower', 'condominium.condominium_id', '=', 'tower.id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->leftJoin('factures', function ($join) {
                    $join->on('factures.id', '>', \DB::raw('0'));
                })
                ->leftJoin('receipts', function ($join) {
                    $join->on('receipts.persona_id', '=', 'personas.id')
                        ->on('receipts.facture_id', '=', 'factures.id')
                        ->where('receipts.accepted', true);
                })
                ->select(
                    'tower.Nombre as tower',
                    'condominium.Nombre',
                    'fullName',
                    'phone',
                    'name',
                    'email',
                    'users.uuid',
                    \DB::raw('COUNT(DISTINCT factures.id) - COUNT(DISTINCT receipts.facture_id) AS expenses_no_pagados')
                )
                ->groupBy('tower.Nombre', 'condominium.Nombre', 'fullName', 'phone', 'name', 'email', 'users.uuid');

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where("personas.fullName", "ilike", "%$search%")
                        ->orWhere("roles.name", "ilike", "%$search%")
                        ->orWhere("users.email", "ilike", "%$search%")
                        ->orWhere("personas.phone", "ilike", "%$search%");
                });
            }

            if ($tower) {
                $columnMapTower = [
                    'A' => 1,
                    'B' => 12,
                    'C' => 23,
                    'D' => 34,
                ];
                if (isset($columnMapTower[$tower])) {
                    $query->where('tower.Nombre', "Torre $tower");
                    $query->havingRaw('COUNT(DISTINCT factures.id) - COUNT(DISTINCT receipts.facture_id) > 0');
                }
            }

            if ($facture) {
                $query->whereExists(function ($subquery) use ($facture) {
                    $subquery->select(DB::raw(1))
                        ->from('factures')
                        ->where('factures.id', $facture);
                })
                    ->whereRaw("
                NOT EXISTS (
                    SELECT 1 
                    FROM receipts 
                    WHERE receipts.persona_id = personas.id 
                    AND receipts.facture_id = ?
                )
            ", [$facture]);
            }



            if ($sort) {
                $columnMap = [
                    'name' => 'fullName',
                    'email' => 'email',
                    'phone' => 'phone',
                    'apt' => 'condominium.Nombre',
                    'tower' => 'tower.Nombre',
                    'recibos' => 'expenses_no_pagados',
                    'rol' => 'name'
                ];
                if (isset($columnMap[$sort])) {
                    $query->orderBy($columnMap[$sort], $direction);
                }
            }

            $users = $query->skip($offset)->take($limit)->get();

            $users = $users->map(function ($user) {
                return [
                    'uuid' => $user->uuid,
                    'email' => $user->email,
                    'nombre' => $user->fullName,
                    'phone' => $user->phone,
                    'tower' => $user->tower,
                    'apt' => $user->Nombre,
                    'pending_receipts' => $user->expenses_no_pagados,
                ];
            });

            // Retornar la respuesta con paginación
            return response()->json([
                "rows" => $users,
                "offset" => $offset,
                "limit" => $limit,
                "sort" => $sort,
                "direction" => $direction,
                "search" => $search
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
