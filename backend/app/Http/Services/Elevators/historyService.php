<?php

namespace App\Http\Services\Elevators;

use App\Models\ElevatorDamageHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class historyService
{
    static public function index(Request $request): JsonResponse
    {
        try {
            $offset = (int)$request->input("offset", 0);
            $limit = (int)$request->input("limit", 10);
            $search = $request->input("search");
            $status = $request->input("status");
            $elevator = $request->input("elevator");
            $direction = $request->input("direction");
            $sort = $request->input("sort");
    
            $ElevatorsHistoryDB = ElevatorDamageHistory::from('elevator_damage_histories')
                ->leftJoin('elevators', 'elevators.id', '=', 'elevator_damage_histories.elevator_id')
                ->join('condominium', 'elevators.condominium_id', '=', 'condominium.id')
                ->leftjoin('expenses', 'elevator_damage_histories.expense_id', '=', 'expenses.id')
                ->select('condominium.Nombre', 'number', 'description', 'status', 'elevators.number', 'elevator_damage_histories.created_at', 'expenses.image',  'elevator_damage_histories.image as historyElevator');
    
            if (!empty($elevator)) {
                $ElevatorsHistoryDB->where(function ($query) use ($elevator) {
                    $query->where('elevator_damage_histories.elevator_id', '=', $elevator);
                });
            } 

            if (!empty($search)) {
                $ElevatorsHistoryDB->where(function ($query) use ($search) {
                    $query->where('elevators.number', 'ilike', "%{$search}%")
                        ->orWhere('condominium.Nombre', 'ilike', "%{$search}%");
                });
            }

            if (!empty($status)) {
                $statusIf = $status == 'D' ? false : true;
            
                $subQuery = ElevatorDamageHistory::selectRaw('MAX(id) as id')
                    ->where('status', '=', $statusIf)
                    ->groupBy('elevator_id');
            
                $ElevatorsHistoryDB->whereIn('elevator_damage_histories.id', $subQuery);
            }
            

            if ($sort) {
                $sortColumns = [
                    'number' => 'number',
                    'tower' => 'condominium.id',
                ];
    
                if (array_key_exists($sort, $sortColumns)) {
                    $ElevatorsHistoryDB->orderBy($sortColumns[$sort], $direction ?? 'asc');
                }
            } else {
                $ElevatorsHistoryDB->orderBy('elevator_damage_histories.id','desc');
            }
    
            $ElevatorsHistoryDB = $ElevatorsHistoryDB->skip($offset)->take($limit)->get();
    
            $Elevators = $ElevatorsHistoryDB->map(function ($Elevators) {
                return [
                    'elevator' => $Elevators->number,
                    'tower' => $Elevators->Nombre,
                    'description' => $Elevators->description,
                    'date' => $Elevators->created_at,
                    'status' => $Elevators->status,
                    'image' => $Elevators->image,
                    'historyElevator' => $Elevators->historyElevator
                ];
            });
    
            return response()->json([
                "rows" => $Elevators,
                "sort" => $sort,
                "direction" => $direction,
                "search" => $search,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
