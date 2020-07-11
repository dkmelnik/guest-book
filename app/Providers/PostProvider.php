<?php

namespace App\Providers;

use App\Services\Post\PostService;
use Illuminate\Support\ServiceProvider;

class PostProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Post', function ($app) {
            return new PostService($app);
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
