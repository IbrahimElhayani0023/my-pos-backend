<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/user',fn(Request $request)=> $request->user());
});
Route::apiResource('/products', \App\Http\Controllers\ProductController::class);
Route::apiResource('/orders', \App\Http\Controllers\OrderController::class)->except(['update','destroy']);
Route::apiResource('/costumers', \App\Http\Controllers\CostumerController::class);