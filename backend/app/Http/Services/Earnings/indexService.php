<?php

namespace App\Http\Services\Earnings;

use App\Http\Services\getDolar;
use App\Models\Earnings;
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
            $month = $request->input("month");
            $direction = $request->input("direction");
            $sort = $request->input("sort");
            $offset = $request->input("offset");
            $user = $request->input("user");

            $dolarBCV = getDolar::getDollarRate();

            $earningsDB = Earnings::join('type_earnings', 'type_id', 'type_earnings.id')
                ->leftjoin('condominium', 'earnings.condominium_id', 'condominium.id')
                ->select(
                    'earnings.id',
                    'type_id',
                    'earnings.condominium_id',
                    'earnings.created_at',
                    'type_earnings.name',
                    'condominium.Nombre',
                    'earnings.amount_dollars',
                    'earnings.dollar_value',
                    'image',
                    'earnings.facture_id'
                );

            if (!empty($month)) {
                $earningsDB->whereMonth('earnings.created_at', $month);
            }

            if (!empty($search)) {
                $earningsDB->where(function ($query) use ($search) {
                    $query->where('type_earnings.name', 'ilike', "%{$search}%")
                        ->orWhere('condominium.Nombre', 'ilike', "%{$search}%");
                });
            }

            $factureTotalUsd = [
                "USD" => 0,
                "BS" => 0
            ];

            if (!empty($facture)) {
                $factureDB = Factures::select('id')->where('code', $facture)->first();

                if ($factureDB) {
                    $totalUSD = (float) $earningsDB->where('earnings.facture_id', $factureDB->id)->sum('amount_dollars');
                    $factureTotalUsd = [
                        "USD" => $totalUSD,
                        "BS" => $totalUSD * $dolarBCV
                    ];
                }

                if ($factureDB) $earningsDB->where('earnings.facture_id', $factureDB->id);
            }

            if (!empty($date) && in_array($date, ['m', 'w', 'd'])) {
                $earningsDB->where(function ($query) use ($date) {
                    $dateRanges = [
                        'm' => [now()->startOfMonth(), now()->endOfMonth()],
                        'w' => [now()->startOfWeek(), now()->endOfWeek()],
                        'd' => [now()->startOfDay(), now()->endOfDay()]
                    ];

                    $query->whereBetween('earnings.created_at', $dateRanges[$date]);
                });
            }

            if (!empty($user)) {
                $userCondominium = \DB::table('users')
                    ->join('personas', 'users.persona_id', '=', 'personas.id')
                    ->join('condominium', 'condominium.id', '=', 'personas.condominium_id')
                    ->where('users.uuid', $user)
                    ->value('condominium.condominium_id');

                if ($userCondominium) {
                    $earningsDB->where('earnings.condominium_id', $userCondominium);
                }

                $earningsDB->whereNotExists(function ($subquery) use ($user) {
                    $subquery->select(DB::raw(1))
                        ->from('receipts')
                        ->leftJoin('personas', 'receipts.persona_id', '=', 'personas.id')
                        ->join('users', 'users.persona_id', '=', 'personas.id')
                        ->where('users.uuid', $user)
                        ->whereColumn('receipts.facture_id', 'earnings.facture_id');
                });
            }


            if ($sort) {
                $reallySort = '';
                if ($sort == 'created') $reallySort = 'earnings.created_at';
                else if ($sort == 'name') $reallySort = 'services.service_type';
                else if ($sort == 'tower') $reallySort = 'condominium.Nombre';
                else if ($sort == 'mount') $reallySort = 'earnings.amount_dollars';
                else if ($sort == 'dollarBefore') $reallySort = 'earnings.dollar_value';

                $earningsDB->orderBy($reallySort, $direction);
            }

            $earningsDB = $earningsDB->skip($offset)->take($limit)->get();

            $earnings = $earningsDB->map(function ($earning) {
                $price = (float)$earning->amount_dollars;
                $bcv = (float)$earning->dollar_value;

                return [
                    'id' => $earning->id,
                    'name' => $earning->name ? $earning->name : 'Desconocido',
                    'tower' => $earning->Nombre ? $earning->Nombre : 'Todas las torres',
                    'mount_dollars' => $price,
                    'mount_bs' => $price * $bcv,
                    'dollarBefore' => $earning->dollar_value,
                    'image' => $earning->image,
                    'facture' => $earning->facture_id ? true : false,
                    'created' => $earning->created_at->format('d/m/Y'),
                ];
            });

            return response()->json([
                "rows" => $earnings,
                "sort" => $request->query("sort"),
                "direction" => $request->query("direction"),
                "search" => $request->query("search"),
                "month" => $request->query("month"),
                'Facture' => $factureTotalUsd['USD'] ? $factureTotalUsd : null
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
