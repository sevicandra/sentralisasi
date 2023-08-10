<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\adminSatker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin_satker', function (adminSatker $user) {
            return true ;
        });
        
        Gate::define('sys_admin', function (User $user) {
            return $user->is('01') === true && $user->kdsatker === '411792';
        });
        
        Gate::define('plt_admin_satker', function (User $user) {
            return $user->is('02');
        });

        Gate::define('opr_monitoring', function (User $user) {
            return $user->is('03');
        });

        Gate::define('opr_belanja_51', function (User $user) {
            return $user->is('04');
        });

        Gate::define('opr_honor', function (User $user) {
            return $user->is('05');
        });

        Gate::define('adm_server', function (User $user) {
            return $user->is('06') && $user->is('01') === true && $user->kdsatker === '411792';
        });

        Gate::define('opr_spt', function (User $user) {
            return $user->is('07');
        });

        Gate::define('opr_rumdin', function (User $user) {
            return $user->is('08');
        });
    }
}
