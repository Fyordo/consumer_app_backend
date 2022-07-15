<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('/client/flat', \App\Http\Controllers\ClientFlatController::class);
Route::apiResource('/client', \App\Http\Controllers\ClientController::class);
