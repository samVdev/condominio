<?php

namespace App\Http\Services\Factures;

use App\Models\Factures;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class facturesPendingService
{
    static public function index(Request $request): JsonResponse
    {
        try { {

                $offset = (int)$request->input("offset", 0);
                $limit = (int)$request->input("limit", 10);

                $direction = $request->input("direction");
                $sort = $request->input("sort");
                $offset = $request->input("offset");
                $user = $request->input("user");

                $facturesDB = Factures::join('condominium', 'factures.condominium_id', 'condominium.id')
                    ->select(
                        'factures.id',
                        'factures.code',
                        'factures.condominium_id',
                        'factures.created_at',
                        'condominium.Nombre',
                        'factures.total_dollars',
                        'factures.dollar_bcv'
                    );



                if (!empty($user)) {
                    $userCondominium = \DB::table('users')
                        ->join('personas', 'users.persona_id', '=', 'personas.id')
                        ->join('condominium', 'condominium.id', '=', 'personas.condominium_id')
                        ->where('users.uuid', $user)
                        ->value('condominium.condominium_id');

                    if ($userCondominium) {
                        $facturesDB->where('factures.condominium_id', $userCondominium);
                    }

                    $facturesDB->whereNotExists(function ($subquery) use ($user) {
                        $subquery->select(DB::raw(1))
                            ->from('receipts')
                            ->leftJoin('personas', 'receipts.persona_id', '=', 'personas.id')
                            ->join('users', 'users.persona_id', '=', 'personas.id')
                            ->where('users.uuid', $user)
                            ->whereColumn('receipts.facture_id', 'factures.facture_id');
                    });
                }


                if ($sort) {
                    $reallySort = '';
                    if ($sort == 'created') $reallySort = 'factures.created_at';
                    else if ($sort == 'tower') $reallySort = 'condominium.Nombre';
                    else if ($sort == 'mount') $reallySort = 'factures.total_dollars';

                    $facturesDB->orderBy($reallySort, $direction);
                }

                $facturesDB = $facturesDB->skip($offset)->take($limit)->get();

                $factures = $facturesDB->map(function ($expense) {
                    $price = (float)$expense->total_dollars;
                    $bcv = (float)$expense->dollar_bcv;

                    return [
                        'id' => $expense->id,
                        'code' => $expense->code,
                        'tower' => $expense->Nombre,
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
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
