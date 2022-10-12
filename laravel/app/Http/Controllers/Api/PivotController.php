<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CallLogs;

class PivotController extends Controller
{
    //
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

        # Grouping by date and names
        $grouped = $mapped->groupBy(['date', 'name']);

        # Mapping dispositions fields for each returned name
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
}
