<?php

namespace App\Http\Services\Expenses;

use App\Models\Expenses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class deleteService
{
    static public function destroy(string $id): JsonResponse
    {

        $isSuperAdmin = auth()->user()->role->id == 1; // superAdmin

        if (!$isSuperAdmin)return response()->json(['message' => 'No tienes permiso'], 400);

        $expense = Expenses::find($id);

        if (!$expense)return response()->json(['error' => 'Gasto no encontrado'], 404);

        if ($expense->image && Storage::exists($expense->image)) {
            Storage::delete($expense->image);
        }

        $expense->delete();

        return response()->json(['message' => 'El Gasto ha sido eliminado correctamente'], 200);
    }
}

