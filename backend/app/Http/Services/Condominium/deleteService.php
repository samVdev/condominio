<?php

namespace App\Http\Services\Condominium;

use App\Models\Condominium;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class deleteService
{
    static public function destroy(string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();

            if (!$user || !$user->role || $user->role->id != 1) return response()->json(['message' => 'No tienes permiso'], 403);

            $expense = Condominium::find($id);

            if (!$expense) return response()->json(['message' => 'apartamento no encontrado'], 404);

            if ($expense->image && Storage::exists($expense->image)) Storage::delete($expense->image);

            $expense->delete();
            DB::commit();
            return response()->json(['message' => 'El apartamento ha sido eliminado correctamente'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Apartamento no encontrado'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al eliminar el apartamento.'], 500);
        }
    }
}
