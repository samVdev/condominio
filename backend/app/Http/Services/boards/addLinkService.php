<?php

namespace App\Http\Services\boards;

use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class addLinkService
{
    static public function index(Request $request, string $uuid): JsonResponse
    {
        DB::beginTransaction();
        try {
            $boardDB = Board::where('uuid', $uuid)
            ->where('end', false)
            ->first();

            if (!$boardDB) return response()->json(['message' => 'Junta no encontrada'], 404);
            
            $boardDB->link = $request->link;

            $boardDB->save();

            DB::commit();
            return response()->json(["message" => "Se ha agregado el enlace correctamente."], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al agregar el enlace de la junta'], 500);
        }
    }
}
