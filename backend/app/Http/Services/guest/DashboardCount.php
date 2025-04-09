<?php

namespace App\Http\Services\guest;

use App\Models\Factures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardCount
{
    public static function index(): JsonResponse
    {
        $user = auth()->user();

        $facturesDB = Factures::select([
                'factures.code',
                'factures.condominium_id',
                'factures.created_at',
                'condominium.Nombre',
                'factures.total_dollars',
                'factures.dollar_bcv'
            ])
            ->whereNotExists(function ($subquery) use ($user) {
                $subquery->select(DB::raw(1))
                    ->from('receipts')
                    ->join('personas', 'receipts.persona_id', '=', 'personas.id')
                    ->join('users', 'users.persona_id', '=', 'personas.id')
                    ->whereColumn('receipts.facture_id', 'factures.id')
                    ->where('users.uuid', $user->uuid);
            })
            ->count();

        $paidFactures = Factures::join('receipts', 'factures.id', '=', 'receipts.facture_id')
            ->join('personas', 'receipts.persona_id', '=', 'personas.id')
            ->join('users', 'users.persona_id', '=', 'personas.id')
            ->where('receipts.accepted', true)
            ->where('users.uuid', $user->uuid)
            ->count();

        return response()->json([
            "pending" => $facturesDB,
            "payment" => $paidFactures,
            "total" => $facturesDB + $paidFactures,
        ], 200);
    }
}
