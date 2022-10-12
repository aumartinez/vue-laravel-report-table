<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CallLogController;
use App\Http\Controllers\Api\PivotController;
use App\Http\Controllers\Api\AverageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/v1/data', [CallLogController::class, 'data']);
Route::get('/v1/pivot', [PivotController::class, 'pivot']);
Route::get('/v1/average', [AverageController::class, 'average']);
