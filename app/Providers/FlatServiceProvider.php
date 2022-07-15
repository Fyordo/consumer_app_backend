<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FlatServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Facades\FlatManager', 'App\Services\FlatManagerService');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
