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
        
            Passport::personalAccessTokensExpireIn(Carbon::now()->addDays(config('const.personal_token_expires_in')));
            // Passport::refreshTokensExpireIn(Carbon::now()->addMonth(1));
            // Passport::tokensExpireIn(Carbon::now()->addRealWeeks(2));
    }
}
