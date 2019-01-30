<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     * 
     * LEVEL 1 - Admin
     * LEVEL 2 - HR
     * LEVEL 3 - GUEST
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function($user, $ability) {
            // Don't return (bool) $user->role === 1 because if the condition fails, other gate will not be tested.
            if ((int) $user->role === 1) {
                return true;
            }
        });

        Gate::define('manage-detachments', function($user) {
            return ((int) $user->role) === 1;
        });

        Gate::define('manage-users', function($user) {
            return ((int) $user->role) === 1;
        });

        Gate::define('manage-employees', function($user) {
            return ((int) $user->role) <= 2;
        });
    }
}
