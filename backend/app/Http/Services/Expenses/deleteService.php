<?php

namespace App\Http\Services\Expenses;

use App\Http\Services\Provisions\checkService;
use App\Models\Expenses;
use App\Models\ProvisionBalance;
use App\Models\Provisions;
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

            $expense = Expenses::where('facture_id', null)->find($id);

            if(!$expense || $expense->facture_id) return response()->json(['message' => 'El gasto no se ha encontrado'], 404);

            if ($expense->image && Storage::exists($expense->image)) Storage::delete($expense->image);

            $provision = checkService::index($expense->service_id, $expense->id);

            if (count($provision['ids']) > 0) {
                $provDBs = Provisions::whereIn('id', $provision['ids'])->get();
                $firstProvision = $provDBs->first();
                ProvisionBalance::find($firstProvision->balance_id)->increment('current_balance', $expense->mount_prov);
            }
    
            $expense->delete();
            DB::commit();
            return response()->json(['message' => 'El Gasto ha sido eliminado correctamente'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gasto no encontrado'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al eliminar el gasto.'], 500);
        }
    }
}
