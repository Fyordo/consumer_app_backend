<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;

/**
 * @OA\Info(
 *     title="ConsumerApp API",
 *     version="1.0"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function metaData(Request $request){
        return [
            'meta' => [
                'route' => URL::current(),
                'version' => env('API_VERSION'),
                'app' => env('APP_ENV')
            ]
        ];
    }

    public function checkSensor(){
        Artisan::call('sensor:check');

        return response()->json([]);
    }
}
