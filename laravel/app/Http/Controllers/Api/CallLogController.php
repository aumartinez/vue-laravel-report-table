<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}
