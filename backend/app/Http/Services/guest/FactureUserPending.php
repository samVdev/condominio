<?php

namespace App\Http\Services\guest;

use App\Http\Services\getDolar;
use App\Models\Condominium;
use App\Models\Factures;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FactureUserPending
{
    public static function index(Request $request): JsonResponse
    {
        $dolar = getDolar::getDollarRate();
        $user = auth()->user();
        $condominium_id = $user->persona->condominium_id;

        $apt = Condominium::select('porcent_alicuota')->where('id', $condominium_id)->first();

        $facturesDB = Factures::select([
                'factures.code',
                'factures.created_at',
                'factures.total_dollars',
                'factures.dollar_bcv',
                'factures.porcent_first_five_days',
            ])
            ->whereNotExists(function ($subquery) use ($user) {
                $subquery->select(DB::raw(1))
                    ->from('receipts')
                    ->join('personas', 'receipts.persona_id', '=', 'personas.id')
                    ->join('condominium', 'condominium.id', '=', 'personas.condominium_id')
                    ->join('users', 'users.persona_id', '=', 'personas.id')
                    ->whereColumn('receipts.facture_id', 'factures.id')
                    ->where('users.uuid', $user->uuid);
            })
            ->get();

        $factures = $facturesDB->map(function ($expense) use ($dolar, $apt) {

            $currentDate = Carbon::now();
            $createdAt = Carbon::parse($expense->created_at);
            
            $isWithinFirstFiveDays = $currentDate->diffInDays($createdAt) < 5;

            // esto es sin no se paga en los primeros 31 dias
            $isForMora = $currentDate->diffInDays($createdAt) > 31;
            
            $alicuota = floatval($apt->porcent_alicuota ?? 0);
            $mountDollars = (float) $expense->total_dollars * ($alicuota / 100);
            
            if ($isWithinFirstFiveDays) {
                $discountPercentage = floatval($expense->porcent_first_five_days); 
                $discountAmount = $mountDollars * ($discountPercentage / 100);
                $mountDollars -= $discountAmount;
            }

                
            if ($isForMora) {
                // esto es sin no se paga en los primeros 31 dias
                $aumentAmount = $mountDollars * (5 / 100);
                $mountDollars += $aumentAmount;
            }

            $mountDollars = round($mountDollars, 2);

            $info = [
                'id' => $expense->code,
                'tower' => $expense->Nombre,
                'mount_dollars' => round((float) $expense->total_dollars, 2),
                'dollar_bcv' => round((float) $mountDollars * $dolar, 2),
                'created' => $expense->created_at->format('d/m/Y'),
                'alicuot' => floatval($apt->porcent_alicuota),
                'total' => $mountDollars,
            ];

            if ($isWithinFirstFiveDays) {
                $info['porcent'] = floatval($expense->porcent_first_five_days);
            }

            if ($isForMora) {
                $info['isForMora'] = true;
            }

            return $info;
        })->toArray();

        return response()->json($factures, 200);
    }
}
