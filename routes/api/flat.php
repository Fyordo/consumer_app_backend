<?php

use Illuminate\Support\Facades\Route;

Route::get('/flat/graph/{flat}', [\App\Http\Controllers\FlatController::class, 'graph']);
Route::apiResource('/flat', \App\Http\Controllers\FlatController::class);
