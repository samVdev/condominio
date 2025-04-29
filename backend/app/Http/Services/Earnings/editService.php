<?php

namespace App\Http\Services\Earnings;

use App\Http\Requests\Earnings\editEarningsRequest;
use App\Http\Services\getDolar;
use App\Models\Earnings;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class editService
{
    static public function index(editEarningsRequest $request, string $id): JsonResponse
    {
        DB::beginTransaction(); 

        try {
            $earning = Earnings::where('id', $id)->first();
    
            if (!$earning || $earning->facture_id) return response()->json(['message' => 'Ingreso no encontrado'], 404);
    
            $dolar = getDolar::getDollarRate();
    
            $earning->type_id = $request->type;
            $earning->condominium_id = $request->tower;
            $earning->amount_dollars = $request->mount_dollars;
            $earning->dollar_value = $dolar;
    
            if ($request->hasFile('file')) {
                if ($earning->image && Storage::exists($earning->image)) {
                    Storage::delete($earning->image);
                }
    
                $filename = 'earning_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
                $request->file('file')->storeAs('earnings', $filename, 'public');
                $earning->image = "public/earnings/" . $filename;
            }
    
            $earning->save();
    
            DB::commit();
    
            return response()->json(["message" => 'Se ha editado correctamente'], 200);
    
        } catch (\Exception $e) {
            DB::rollBack(); 
            return response()->json([
                'message' => 'Ocurrió un error al editar el ingreso'
            ], 500);
        }
    }
}
