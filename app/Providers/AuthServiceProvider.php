<?php

namespace App\Providers;

use App\Models\RestaurantOperator;
use App\Policies\RestaurantOperatorPolicy;
use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        RestaurantOperator::class => RestaurantOperatorPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // for API auth
            Passport::routes();
        
            Passport::personalAccessTokensExpireIn(Carbon::now()->addMinutes(30));
            Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
            // Passport::tokensExpireIn(Carbon::now()->addMinutes(4));
            // Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
    }
}
