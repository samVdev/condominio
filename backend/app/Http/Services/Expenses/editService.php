<?php

namespace App\Http\Services\Expenses;

use App\Http\Requests\Expenses\editExpensesRequest;
use App\Http\Services\getDolar;
use App\Models\Expenses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class editService
{
    static public function index(editExpensesRequest $request, string $id): JsonResponse
    {
        $expense = Expenses::where('id', $id)->first();

        $dolar = getDolar::getDollarRate();

        $expense->service_id = $request->service;
        $expense->condominium_id = $request->tower;
        $expense->amount_dollars = $request->mount_dollars;
        $expense->dollar_value = $dolar;
        
        if ($request->hasFile('file')) {
            if ($expense->image && Storage::exists($expense->image)) {
                Storage::delete($expense->image);
            }
    
            $filename = 'expense_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('expenses', $filename, 'public');
            $expense->image = "public/expenses/" . $filename;
        }

        $expense->save();

        return response()->json(["message" => 'Se ha editado correctamente'], 200);
    }
}
