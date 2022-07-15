<?php

use Illuminate\Support\Facades\Route;

Route::get('/client/flats', [\App\Http\Controllers\ClientController::class, 'getMyFlats']);
Route::apiResource('/client/flat', \App\Http\Controllers\ClientFlatController::class);
Route::apiResource('/client', \App\Http\Controllers\ClientController::class);
