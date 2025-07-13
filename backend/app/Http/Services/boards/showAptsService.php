<?php

namespace App\Http\Services\boards;

use App\Models\Board;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class showAptsService
{
    static public function index(Request $request, string $uuid): JsonResponse
    {
        $boardDB = Board::with(['asistentes.persona.condominium'])
            ->where('uuid', $uuid)->first();

        if (!$boardDB) return response()->json(['message' => 'Junta no encontrada'], 404);

        $offset = $request->input("offset", 0);
        $limit = $request->input("limit", 10);
        $search = $request->input("search");
        $sort = $request->input("sort");
        $direction = $request->input("direction") == "desc" ? "desc" : "asc";

        $query = User::query()
            ->leftJoin('board_participants', function ($join) use ($boardDB) {
                $join->on('users.id', '=', 'board_participants.user_id')
                    ->where('board_participants.board_id', '=', $boardDB->id);
            })
            ->join('personas', 'users.persona_id', '=', 'personas.id')
            ->join('condominium', 'personas.condominium_id', '=', 'condominium.id')
            ->select(
                'condominium.Nombre',
                'fullName',
                'board_participants.id as participant_id'
            );

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where("personas.fullName", "ilike", "%$search%")
                    ->orWhere("users.email", "ilike", "%$search%")
                    ->orWhere("personas.phone", "ilike", "%$search%");
            });
        }

        $users = $query->skip($offset)->take($limit)->get();

        $users = $users->map(function ($user) {
            return [
                'nombre' => $user->fullName,
                'apt' => $user->Nombre,
                'connected' => $user->participant_id !== null
            ];
        });

        $totalUsuarios = User::query()
            ->join('personas', 'users.persona_id', '=', 'personas.id')
            //->where('personas.condominium_id', $boardDB->asistentes->first()->persona->condominium_id ?? null)
            ->count();

        $totalAsistentes = DB::table('board_participants')
            ->where('board_id', $boardDB->id)
            ->count();

        $porcentajeAsistencia = $totalUsuarios > 0
            ? round(($totalAsistentes / $totalUsuarios) * 100, 2)
            : 0;

        return response()->json([
            "rows" => $users,
            "porcent" => $porcentajeAsistencia,
            "offset" => $offset,
            "limit" => $limit,
            "sort" => $sort,
            "direction" => $direction,
            "search" => $search
        ]);
    }
}
