<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\role;
use App\Models\User;
use App\Models\adminSatker;
use App\Models\satker;
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
            return true;
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

        Gate::define('opr_belanja_51_pusat', function (User $user) {
            return $user->is('04') && $user->kdsatker === '411792' && $user->kdunit != null;
        });

        Gate::define('opr_belanja_51_vertikal', function (User $user) {
            return $user->is('04') && $user->kdsatker != '411792';
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

        Gate::define('monitoring', function () {
            return role::active('03');
        });

        Gate::define('belanja_51', function () {
            return role::active('04');
        });

        Gate::define('honorarium', function () {
            return role::active('05');
        });

        Gate::define('spt', function () {
            return role::active('07');
        });

        Gate::define('rumdin', function () {
            return role::active('08');
        });

        Gate::define('wilayah', function ($user, $kdsatker) {
            $satker = satker::where('kdsatker', $kdsatker)->first();
            if ($satker->jnssatker === '2') {
                return true;
            };
        });

        Gate::define('approver_vertikal', function (User $user) {
            return $user->is('09') && $user->kdsatker != '411792';
        });

        Gate::define('approver_pusat', function (User $user) {
            return $user->is('09') && $user->kdsatker === '411792' && $user->kdunit != null;
        });

        Gate::define('admin_pusat', function (User $user) {
            return $user->is('10') && $user->kdsatker != '411792';
        });
    }
}
