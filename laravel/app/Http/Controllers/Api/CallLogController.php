<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CallLogs;

class CallLogController extends Controller
{
    //
    public function data (Request $request) 
    {
        $data = CallLogs::all();
        return response()->json([
            'data' => $data->values(),
        ]);
    }
}
