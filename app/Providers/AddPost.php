<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AddPost extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('AddPost', function ($app) {
            return new AddPost($app);
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
