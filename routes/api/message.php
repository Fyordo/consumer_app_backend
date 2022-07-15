<?php

use Illuminate\Support\Facades\Route;

Route::post('/message/send',  [\App\Http\Controllers\MessageController::class, 'send']);

Route::apiResource('/message', \App\Http\Controllers\MessageController::class);
