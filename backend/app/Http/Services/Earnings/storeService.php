<?php

namespace App\Http\Services\Earnings;

use App\Http\Requests\Earnings\FormEarningsRequest;
use App\Http\Services\getDolar;
use App\Models\Earnings;
use Illuminate\Http\JsonResponse;

class storeService
{
    static public function index(FormEarningsRequest $request): JsonResponse
    {
        try {
            $earning = new Earnings();
    
            $dolar = getDolar::getDollarRate();
    
            $earning->type_id = $request->type;
            $earning->condominium_id = $request->tower == 0 ? null : $request->tower;
            $earning->amount_dollars = $request->mount_dollars;
            $earning->dollar_value = $dolar;
    
            if ($request->hasFile('file')) {
                $filename = 'earning_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
                $request->file('file')->storeAs('earnings', $filename, 'public');
                $earning->image = "public/earnings/" . $filename;
            }
    
            $earning->save();
    
            return response()->json(["message" => 'Se ha creado correctamente'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al crear el ingreso'], 500);
        }
    }
}
