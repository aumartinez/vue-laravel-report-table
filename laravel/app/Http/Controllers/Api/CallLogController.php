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
        $agents = CallLogs::select('cnam', 'calldate', 'disposition')
                ->where('cnam','<>','')
                ->orderBy('cnam')
                ->get();

        $results = $agents->map(function($item) {
            return [
                'date' => date('Y-m-d', strtotime($item->calldate)),
                'name' => $item->cnam,
                'answered' => $this->countRecords($item, 'ANSWERED'),
                'noanswered' => $this->countRecords($item, 'NO ANSWER'),
                'busy' => $this->countRecords($item, 'BUSY'),
                'congestion' => $this->countRecords($item, 'CONGESTION'),
            ];    
        });

        # Grouping by dates
        $grouped = $results->groupBy('date');

        # Filtering duplicates
        $filtered = $grouped->map(function($item){
            return $item->unique('name');
        });        

        $filtered = $filtered->flatten(1);        
        return response()->json([
            'data' => $filtered->values(),
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

    protected function countRecords ($item, $disposition) {
        $count = CallLogs::select('disposition')
                ->whereDay('calldate','=', date('d', strtotime($item->calldate)))
                ->whereMonth('calldate', '=', date('m', strtotime($item->calldate)))
                ->whereYear('calldate', '=', date('Y', strtotime($item->calldate)))
                ->where('cnam', '=', $item->cnam)
                ->where('disposition','=', $disposition)
                ->count();

        return $count;
    }
}
