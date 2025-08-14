<?php

namespace App\Http\Services\boards;

use App\Http\Requests\board\StoreBoardRequest;
use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class storeService
{
    static public function index(StoreBoardRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $board = new board();
            $board->name = $request->nombre;
            $board->description = $request->descripcion;
            $board->meeting_date = $request->fecha;
            $board->is_active = false;
            $board->save();

            DB::commit();
            return response()->json(["message" => "Se ha guardado correctamente."], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al crear la junta'], 500);
        }
    }
}
