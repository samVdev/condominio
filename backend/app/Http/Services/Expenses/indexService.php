<?php

namespace App\Http\Services\Expenses;

use App\Http\Services\getDolar;
use App\Models\Expenses;
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
    
            $search = $request->input("search");
            $facture = $request->input("facture");
            $date = $request->input("date");
            $direction = $request->input("direction");
            $sort = $request->input("sort");
            $user = $request->input("user");
    
            $dolarBCV = getDolar::getDollarRate();
    
            $expensesDB = Expenses::join('services', 'service_id', 'services.id')
                ->leftjoin('condominium', 'expenses.condominium_id', 'condominium.id')
                ->select(
                    'expenses.id', 'service_id', 'expenses.condominium_id', 
                    'expenses.created_at', 'services.service_type', 'condominium.Nombre',
                    'expenses.amount_dollars', 'expenses.dollar_value', 'image', 'expenses.facture_id'
                );
    
            if (!empty($search)) {
                $expensesDB->where(function ($query) use ($search) {
                    $query->where('services.service_type', 'ilike', "%{$search}%")
                          ->orWhere('condominium.Nombre', 'ilike', "%{$search}%");
                });
            }
    
            $factureTotalUsd = ["USD" => 0, "BS" => 0];
    
            if (!empty($facture)) {
                $factureDB = Factures::select('id')->where('code', $facture)->first();
    
                if ($factureDB) {
                    $totalUSD = (float) $expensesDB->where('expenses.facture_id', $factureDB->id)->sum('amount_dollars');
                    $factureTotalUsd = [
                        "USD" => $totalUSD,
                        "BS" => $totalUSD * $dolarBCV
                    ];
    
                    $expensesDB->where('expenses.facture_id', $factureDB->id);
                }
            }
    
            if (!empty($date) && in_array($date, ['m', 'w', 'd'])) {
                $expensesDB->where(function ($query) use ($date) {
                    $dateRanges = [
                        'm' => [now()->startOfMonth(), now()->endOfMonth()],
                        'w' => [now()->startOfWeek(), now()->endOfWeek()],
                        'd' => [now()->startOfDay(), now()->endOfDay()]
                    ];
                    $query->whereBetween('expenses.created_at', $dateRanges[$date]);
                });
            }
    
            if (!empty($user)) {
                $userCondominium = \DB::table('users')
                    ->join('personas', 'users.persona_id', '=', 'personas.id')
                    ->join('condominium', 'condominium.id', '=', 'personas.condominium_id')
                    ->where('users.uuid', $user)
                    ->value('condominium.condominium_id');
    
                if ($userCondominium) {
                    $expensesDB->where('expenses.condominium_id', $userCondominium);
                }
    
                $expensesDB->whereNotExists(function ($subquery) use ($user) {
                    $subquery->select(DB::raw(1))
                        ->from('receipts')
                        ->leftJoin('personas', 'receipts.persona_id', '=', 'personas.id')
                        ->join('users', 'users.persona_id', '=', 'personas.id')
                        ->where('users.uuid', $user)
                        ->whereColumn('receipts.facture_id', 'expenses.facture_id');
                });
            }
    
            if ($sort) {
                $sortColumns = [
                    'created' => 'expenses.created_at',
                    'name' => 'services.service_type',
                    'tower' => 'condominium.Nombre',
                    'mount' => 'expenses.amount_dollars',
                    'dollarBefore' => 'expenses.dollar_value'
                ];
    
                if (array_key_exists($sort, $sortColumns)) {
                    $expensesDB->orderBy($sortColumns[$sort], $direction ?? 'asc');
                }
            }
    
            $expensesDB = $expensesDB->skip($offset)->take($limit)->get();
    
            $expenses = $expensesDB->map(function ($expense) {
                $price = (float)$expense->amount_dollars;
                $bcv = (float)$expense->dollar_value;
    
                return [
                    'id' => $expense->id,
                    'name' => $expense->service_type ?? 'Desconocido',
                    'tower' => $expense->Nombre ?? 'Todas las torres',
                    'mount_dollars' => $price,
                    'mount_bs' => $price * $bcv,
                    'dollarBefore' => $expense->dollar_value,
                    'image' => $expense->image,
                    'facture' => $expense->facture_id ? true : false,
                    'created' => $expense->created_at->format('d/m/Y'),
                ];
            });
    
            return response()->json([
                "rows" => $expenses,
                "sort" => $sort,
                "direction" => $direction,
                "search" => $search,
                'Facture' => $factureTotalUsd['USD'] ? $factureTotalUsd : null
            ], 200);
    
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
