<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CallLogs;

class AverageController extends Controller
{
    //
    public function average (Request $request)
    {
        $query = CallLogs::select('calldate', 'cnam', 'duration')
                ->where('cnam','<>','')
                ->orderBy('cnam')
                ->get();

        $results = $query->map(function($item) {
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
