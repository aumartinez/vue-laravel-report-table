<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CallLogs;

class ChartController extends Controller
{
    //
    public function chart () 
    {
        $query = CallLogs::select('calldate', 'cnam', 'duration')
                ->where('cnam','<>','')
                ->orderBy('calldate', 'desc')
                ->first();

        $latest = date('Y-m-d', strtotime($query->calldate));

        $query = CallLogs::select('calldate','cnam', 'disposition')
                ->where('cnam', '<>', '')
                ->whereDay('calldate', '=', date('d', strtotime($latest)))
                ->whereMonth('calldate', '=', date('m', strtotime($latest)))
                ->whereYear('calldate', '=', date('Y', strtotime($latest)))
                ->get();

        $mapped = $query->map(function ($item){
            return [
                'date' => date('Y-m-d', strtotime($item->calldate)),
                'name' => $item->cnam,
                'disposition' => $item->disposition,
            ];
        });

        $grouped = $mapped->groupBy(['name']);

        $filtered = $grouped->map(function ($item){
            return [
                'date' => $item[0]['date'],
                'name' => $item[0]['name'],
                'answered' => $item->filter(function ($value){
                                return $value['disposition'] === 'ANSWERED';
                            })->count(),
                'noanswered' => $item->filter(function($value){
                                return $value['disposition'] === 'NO ANSWER';
                            })->count(),
                'busy' => $item->filter(function($value){
                                return $value['disposition'] === 'BUSY';
                            })->count(),
                'congestion' => $item->filter(function($value){
                                return $value['disposition'] === 'CONGESTION';
                            })->count(),
            ];
        });

        return response()->json([
            'data' => $filtered->sortBy('name')->values(),
        ]);
    }
}
