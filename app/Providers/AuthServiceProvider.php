<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('can_access',function($user){
            return $user->hasRole('Admin');
        });

        Gate::define('can_delete',function($user){
            return $user->hasRole('Admin');
        });


        Gate::define('can_edit',function($user){
            return $user->hasRole('Admin');
        });


        Gate::define('can_show',function($user){
            return $user->hasRole('Admin');
        });
    }
}
