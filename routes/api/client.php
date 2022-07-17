<?php

use Illuminate\Support\Facades\Route;

Route::get('/client/flats', [\App\Http\Controllers\ClientController::class, 'getMyFlats']);
Route::get('/client/recommendations', [\App\Http\Controllers\ClientController::class, 'getRequestRecommendations']);
Route::get('/client/flat/recommendation', [\App\Http\Controllers\ClientController::class, 'getFlatRecommendation']);
Route::get('/client/recommendations/ai', [\App\Http\Controllers\ClientController::class, 'getAIRecommendations']);
Route::apiResource('/client/flat', \App\Http\Controllers\ClientFlatController::class);
Route::apiResource('/client', \App\Http\Controllers\ClientController::class);
