<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => '/chat'
    ],
    function(){
        Route::post('/send', [App\Http\Controllers\ChatsController::class, 'send']);
    }
);

