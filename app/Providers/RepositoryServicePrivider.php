<?php

namespace App\Providers;
use App\Repositories\RestaurantRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServicePrivider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(RestaurantRepository::class);
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
