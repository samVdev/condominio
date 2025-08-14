<?php

namespace App\Http\Services\Factures;

use App\Models\Factures;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class indexService
{
    static public function index(Request $request): JsonResponse
    {
        try {
            
        $offset = (int)$request->input("offset", 0);
        $limit = (int)$request->input("limit", 10);

        $direction = $request->input("direction");
        $sort = $request->input("sort");
        $offset = $request->input("offset");
        $user = $request->input("user");
        $search = $request->input("search");
        $year = $request->input("year");

        $facturesDB = Factures::select(
        'factures.id', 'factures.created_at',
        'factures.total_dollars', 'factures.dollar_bcv', 
        'factures.number_month', 'factures.code', 'factures.porcent_first_five_days'
    );

    if (!empty($year)) {
        $facturesDB->whereYear('factures.created_at', $year);
    }

    if (!empty($search)) {
        $facturesDB->where(function ($query) use ($search) {
            $query->where('factures.code', 'ilike', "%{$search}%");
        });
    }

    if (!empty($user)) {
        $facturesDB->whereNotExists(function ($subquery) use ($user) {
            $subquery->select(DB::raw(1))
                ->from('receipts')
                ->leftJoin('personas', 'receipts.persona_id', '=', 'personas.id')
                ->join('users', 'users.persona_id', '=', 'personas.id')
                ->where('users.uuid', $user)
                ->whereColumn('receipts.facture_id', 'factures.id');
        });
    }
    

    if ($sort) {
        $reallySort = '';
        if($sort == 'created') $reallySort = 'factures.created_at';
        else if($sort == 'tower') $reallySort = 'condominium.Nombre';
        else if($sort == 'month') $reallySort = 'factures.number_month';
        else if($sort == 'mount') $reallySort = 'factures.total_dollars';
        else if($sort == 'dollarBefore') $reallySort = 'factures.dollar_bcv';
        else if($sort == 'porcent') $reallySort = 'factures.porcent_first_five_days';
        
        $facturesDB->orderBy($reallySort, $direction);
    }

        $facturesDB = $facturesDB->skip($offset)->take($limit)->get();
        
        $factures = $facturesDB->map(function ($expense) {
            $price = (float)$expense->total_dollars;
            $bcv = (float)$expense->dollar_bcv;

            return [
                'id' => $expense->id,               
                'month' => $expense->number_month,
                'code' => $expense->code,
                'porcent' => $expense->porcent_first_five_days,
                'mount_dollars' => $price,
                'mount_bs' => $price * $bcv,
                'dollar_bcv' => $bcv,
                'created' => $expense->created_at->format('d/m/Y'),               
            ];
        });

        return response()->json([
            "rows" => $factures,
            "sort" => $request->query("sort"),
            "direction" => $request->query("direction"),
            "search" => $request->query("search"),
            "year" => $request->query("year"),
        ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
