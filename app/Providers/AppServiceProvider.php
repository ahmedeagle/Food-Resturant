<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       //$this->forceHttps();
    }



    // Force HTTPS protocol
        private function forceHttps()
        {
                  //$this->app['request']->server->set('HTTPS', true);
    
        }
    
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
