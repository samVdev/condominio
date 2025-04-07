<?php

namespace App\Http\Services\Expenses;

use App\Http\Requests\Expenses\FormExpensesRequest;
use App\Http\Services\getDolar;
use App\Models\Expenses;
use Illuminate\Http\JsonResponse;

class storeService
{
    static public function index(FormExpensesRequest $request): JsonResponse
    {
        $expense = new Expenses();

        $dolar = getDolar::getDollarRate();

        $expense->service_id = $request->service;
        $expense->condominium_id = $request->tower == 0 ? null : $request->tower;
        $expense->amount_dollars = $request->mount_dollars;
        $expense->dollar_value = $dolar;

        if ($request->hasFile('file'))  {
            $filename = 'expense_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('expenses', $filename, 'public');
            $expense->image = "public/expenses/" . $filename;
        }

        $expense->save();

        return response()->json(["message" => 'Se ha creado correctamente'], 200);
    }
}
