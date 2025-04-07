<?php

namespace App\Http\Services\Receipts;

use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class IndexReceiptsService
{

    static public function execute(Request $request): JsonResponse
    {

        $offset = $request->input("offset", 0);
        $limit = $request->input("limit", 10);
        $search = $request->input("search");
        $facture = $request->input("facture");
        $status = $request->input("status");
        $sort = $request->input("sort");
        $direction = $request->input("direction") == "desc" ? "desc" : "asc";

        $query = Receipt::join('personas', 'receipts.persona_id', '=', 'personas.id')
                ->join('condominium', 'personas.condominium_id', '=', 'condominium.id')
                ->join('factures', 'factures.id', '=', 'receipts.facture_id')
                ->leftJoin('users', 'receipts.user_id', '=', 'users.id')
                ->leftJoin('personas as user', 'users.persona_id', '=', 'user.id')
                ->select(
                    'receipts.id',
                    'Nombre',
                    'personas.fullName',
                    'personas.phone',
                    'factures.code',
                    'accepted',
                    'receipts.withMora',
                    'receipts.referencia',
                    'receipts.dolarBCV',
                    'receipts.withDays',
                    'receipts.total_pagado',
                    'receipts.cedula',
                    'receipts.created_at',
                    'factures.total_dollars',
                    'factures.porcent_first_five_days',
                    'user.fullName as user'
                );
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where("personas.fullName", "ilike", "%$search%")
                    ->orWhere("receipts.cedula", "ilike", "%$search%")
                    ->orWhere("receipts.referencia", "ilike", "%$search%")
                    ->orWhere("factures.code", "ilike", "%$search%")
                    ->orWhere("personas.phone", "ilike", "%$search%");
            });
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

        if($status && ($status == 'a' || $status == 'n')) {
            $value = $status == 'a' ? true : false;
            $query->where("accepted", "=", $status == 'a');
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
                'recibe_id' => $user->id,
                'nombre' => $user->fullName,
                'phone' => $user->phone,
                'apt' => $user->Nombre,
                'mora' => $user->withMora,
                'days' => $user->withDays,
                'payment' => $user->total_pagado,
                'cedula' => $user->cedula,
                'dolarBCV' => round($user->total_pagado * $user->dolarBCV, 2),
                'referencia' => $user->referencia,
                'porcent' => (int) $user->porcent_first_five_days,
                'factura' => $user->code,
                'date' => $user->created_at,
                'accepted' => $user->accepted,
                'user' => $user->user
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
    }
}
