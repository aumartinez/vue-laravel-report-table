<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CallLogs;
use DataTables;

class CallLogController extends Controller
{
    //
    public function index (Request $request) 
    {
        $data = CallLogs::all();
        return response()->json([
            'data' => $data->values(),
        ]);
    }

    public function pivot (Request $request)
    {
        $query = CallLogs::select('cnam', 'calldate', 'disposition')
                ->where('cnam','<>','')
                ->orderBy('cnam')
                ->get();

        $mapped = $query->map(function ($item){
            return [
                'date' => date('Y-m-d', strtotime($item->calldate)),
                'name' => $item->cnam,
                'disposition' => $item->disposition,
            ];
        });

        $grouped = $mapped->groupBy(['date', 'name']);

        $results = $grouped->map(function($item){
            return [
                $item->map(function($child){
                    return [
                        'date' => $child[0]['date'],
                        'name' => $child[0]['name'],
                        'answered' => $child->filter(function($value){
                                        return $value['disposition'] === 'ANSWERED';
                                    })->count(),
                        'noanswered' => $child->filter(function($value){
                                        return $value['disposition'] === 'NO ANSWER';
                                    })->count(),
                        'busy' => $child->filter(function($value){
                                        return $value['disposition'] === 'BUSY';
                                    })->count(),
                        'congestion' => $child->filter(function($value){
                                        return $value['disposition'] === 'CONGESTION';
                                    })->count(),
                    ];
                }),
            ];
        });

        return response()->json([
            'data' => $results->flatten(2),
        ]);
    }

    public function average (Request $request)
    {
        $agents = CallLogs::select('calldate', 'cnam', 'duration')
                ->where('cnam','<>','')
                ->orderBy('cnam')
                ->get();

        $results = $agents->map(function($item) {
            return [
                'date' => date('Y-m-d', strtotime($item->calldate)),
                'name' => $item->cnam,
                'duration' => $item->duration,
            ];    
        });

        # Grouping by dates and names
        $grouped = $results->groupBy(['date', 'name']);

        # Getting average of duration from nested group
        $average = $grouped->map(function ($item) {
            return [
                $item->map(function ($child) {                    
                    return [
                        'date' => $child[0]['date'],
                        'name' => $child[0]['name'],
                        'average' => $child->avg('duration'),
                    ];
                }),
            ];            
        });

        return response()->json([
            'data' => $average->flatten(2),
        ]);
    }
}
