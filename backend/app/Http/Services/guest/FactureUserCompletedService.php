<?php

namespace App\Http\Services\guest;

use App\Http\Services\getDolar;
use App\Models\Condominium;
use App\Models\Receipt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FactureUserCompletedService
{
    public static function index(Request $request): JsonResponse
    {
        $offset = (int) $request->input("offset", 0);
        $limit = (int) $request->input("limit", 10);
        $dolar = getDolar::getDollarRate();
        $user = auth()->user();
        $condominium_id = $user->persona->condominium_id;

        $apt = Condominium::select('porcent_alicuota')->where('id', $condominium_id)->first();

        $facturesDB = Receipt::join('factures', 'receipts.facture_id', '=', 'factures.id')
        ->join('personas', 'receipts.persona_id', '=', 'personas.id')
        ->join('users', 'users.persona_id', '=', 'personas.id')
        ->select([
            'receipts.id',
            'receipts.facture_id',
            'receipts.persona_id',
            'receipts.accepted',
            'factures.code',
            'factures.created_at',
            'factures.total_dollars',
            'factures.dollar_bcv',
            'factures.porcent_first_five_days',
        ])
        ->where('users.uuid', $user->uuid) // Filtra por el usuario autenticado
        ->offset($offset)
        ->limit($limit)
        ->get();
    

        $factures = $facturesDB->map(function ($expense) use ($dolar, $apt) {

            $currentDate = Carbon::now();
            $createdAt = Carbon::parse($expense->created_at);
            
            $isWithinFirstFiveDays = $currentDate->diffInDays($createdAt) < 5;
            
            $alicuota = floatval($apt->porcent_alicuota ?? 0);
            $mountDollars = (float) $expense->total_dollars * ($alicuota / 100);
            
            if ($isWithinFirstFiveDays) {
                $discountPercentage = floatval($expense->porcent_first_five_days); 
                $discountAmount = $mountDollars * ($discountPercentage / 100);
                $mountDollars -= $discountAmount;
            }

            $info = [
                'id' => $expense->code,
                'tower' => $expense->Nombre,
                'mount_dollars' => (float) $expense->total_dollars,
                'dollar_bcv' => (float) $mountDollars * $dolar,
                'created' => $expense->created_at->format('d/m/Y'),
                'alicuot' => floatval($apt->porcent_alicuota),
                'total' => $mountDollars,
                'payment' => $expense->accepted == false ? 'pending' : 'accepted',
            ];

            if ($isWithinFirstFiveDays) {
                $info['porcent'] = floatval($expense->porcent_first_five_days);
            }

            return $info;
        })->toArray();

        return response()->json([
            "rows" => $factures,
            "sort" => $request->query("sort"),
            "direction" => $request->query("direction"),
            "search" => $request->query("search"),
        ], 200);
    }
}
