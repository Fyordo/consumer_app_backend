<?php

use Illuminate\Support\Facades\Route;

Route::get('/client/flats', [\App\Http\Controllers\ClientController::class, 'getMyFlats']);
Route::get('/client/recommendations', [\App\Http\Controllers\ClientController::class, 'getRecommendations']);
Route::apiResource('/client/flat', \App\Http\Controllers\ClientFlatController::class);
Route::apiResource('/client', \App\Http\Controllers\ClientController::class);
