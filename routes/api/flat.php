<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('/flat', \App\Http\Controllers\FlatController::class);
