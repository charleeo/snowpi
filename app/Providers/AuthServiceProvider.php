<?php

namespace App\Providers;

use App\Models\RestaurantOperator;
use App\Policies\RestaurantOperatorPolicy;
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
        
            Passport::tokensExpireIn(now()->addDays(15));
            Passport::refreshTokensExpireIn(now()->addDays(30));
            Passport::personalAccessTokensExpireIn(now()->addMonths(1));
           
            Passport::tokensCan([
                'admin'=>'Access Admin Backend',
                'user'=>'Access users App',
            ]);

            // Passport::setDefaultScope(['user']);
    }
}
