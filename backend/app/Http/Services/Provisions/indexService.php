<?php

namespace App\Http\Services\Provisions;

use App\Http\Services\getDolar;
use App\Models\Factures;
use App\Models\Provisions;
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
            $month = $request->input("month");
            $date = $request->input("date");
            $direction = $request->input("direction");
            $sort = $request->input("sort");
            $offset = $request->input("offset");
            $user = $request->input("user");

            $dolarBCV = getDolar::getDollarRate();

            $provisionsDB = Provisions::leftjoin('condominium', 'provisions.condominium_id', 'condominium.id')
                ->join('provision_balances', 'provisions.balance_id', 'provision_balances.id')
                ->join('services', 'service_id', 'services.id')
                ->select(
                    'provisions.id',
                    'service_id',
                    'provisions.condominium_id',
                    'provisions.created_at',
                    'services.service_type',
                    'condominium.Nombre',
                    'provisions.mount',
                    'provisions.number_month',
                    'provisions.facture_id',
                    'provisions.paid'
                );

            if (!empty($search)) {
                $provisionsDB->where(function ($query) use ($search) {
                    $query->where('services.service_type', 'ilike', "%{$search}%")
                        ->orWhere('condominium.Nombre', 'ilike', "%{$search}%");
                });
            }

            $factureTotalUsd = [
                "USD" => 0,
                "BS" => 0
            ];
            if (!empty($month)) {
                $provisionsDB->whereMonth('provisions.created_at', $month);
                //->whereYear('created_at', $createdAt->year);
            }

            if (!empty($facture)) {
                $factureDB = Factures::select('id')->where('code', $facture)->first();

                if ($factureDB) {
                    $totalUSD = (float) $provisionsDB->where('provisions.facture_id', $factureDB->id)->sum('mount');
                    $factureTotalUsd = [
                        "USD" => $totalUSD,
                        "BS" => $totalUSD * $dolarBCV
                    ];
                }

                if ($factureDB) $provisionsDB->where('provisions.facture_id', $factureDB->id);
            }

            if (!empty($date) && in_array($date, ['m', 'w', 'd'])) {
                $provisionsDB->where(function ($query) use ($date) {
                    $dateRanges = [
                        'm' => [now()->startOfMonth(), now()->endOfMonth()],
                        'w' => [now()->startOfWeek(), now()->endOfWeek()],
                        'd' => [now()->startOfDay(), now()->endOfDay()]
                    ];

                    $query->whereBetween('provisions.created_at', $dateRanges[$date]);
                });
            }

            if (!empty($user)) {
                $userCondominium = \DB::table('users')
                    ->join('personas', 'users.persona_id', '=', 'personas.id')
                    ->join('condominium', 'condominium.id', '=', 'personas.condominium_id')
                    ->where('users.uuid', $user)
                    ->value('condominium.condominium_id');

                if ($userCondominium) {
                    $provisionsDB->where('provisions.condominium_id', $userCondominium);
                }

                $provisionsDB->whereNotExists(function ($subquery) use ($user) {
                    $subquery->select(DB::raw(1))
                        ->from('receipts')
                        ->leftJoin('personas', 'receipts.persona_id', '=', 'personas.id')
                        ->join('users', 'users.persona_id', '=', 'personas.id')
                        ->where('users.uuid', $user)
                        ->whereColumn('receipts.facture_id', 'provisions.facture_id');
                });
            }


            if ($sort) {
                $reallySort = '';
                if ($sort == 'created') $reallySort = 'provisions.created_at';
                else if ($sort == 'name') $reallySort = 'services.service_type';
                else if ($sort == 'tower') $reallySort = 'condominium.Nombre';
                else if ($sort == 'amount_dollars') $reallySort = 'provisions.mount';
                else if ($sort == 'month') $reallySort = 'provisions.number_month';
                else if ($sort == 'pay') $reallySort = 'provisions.paid';
                $provisionsDB->orderBy($reallySort, $direction);
            }

            $provisionsDB = $provisionsDB->skip($offset)->take($limit)->get();

            $provisions = $provisionsDB->map(function ($provision) use ($dolarBCV) {
                $price = (float)$provision->mount;

                return [
                    'id' => $provision->id,
                    'name' => $provision->service_type ? $provision->service_type : 'Desconocido',
                    'tower' => $provision->Nombre ? $provision->Nombre : 'Todas las torres',
                    'mount_dollars' => $price,
                    'mount_bs' => $price * $dolarBCV,
                    'month' => $provision->number_month,
                    'facture' => $provision->facture_id ? true : false,
                    'pay' => $provision->paid == $price,
                    'created' => $provision->created_at->format('d/m/Y'),
                ];
            });

            return response()->json([
                "rows" => $provisions,
                "sort" => $request->query("sort"),
                "direction" => $request->query("direction"),
                "month" => $request->query("month"),
                "search" => $request->query("search"),
                'Facture' => $factureTotalUsd['USD'] ? $factureTotalUsd : null
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
