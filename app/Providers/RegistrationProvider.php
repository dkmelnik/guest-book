<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Register\RegistrationService;

class RegistrationProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Register', function ($app) {
            return new RegistrationService($app);
        });
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
