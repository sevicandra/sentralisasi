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

        Gate::define('sys_admin', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('01') === true && $user->kdsatker == '411792';
        });

        Gate::define('plt_admin_satker', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('02');
        });

        Gate::define('opr_monitoring', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('03');
        });

        Gate::define('opr_belanja_51', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('04');
        });

        Gate::define('opr_belanja_51_pusat', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('04') && $user->kdsatker && $user->kdunit != null;
        });

        Gate::define('opr_belanja_51_vertikal', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('04') && $user->kdsatker != '411792';
        });

        Gate::define('opr_honor', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('05');
        });

        Gate::define('adm_server', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('06') && $role->contains('01') === true && $user->kdsatker;
        });

        Gate::define('opr_spt', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('07');
        });

        Gate::define('opr_rumdin', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('08');
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

        Gate::define('approver_vertikal', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('09') && $user->kdsatker != '411792';
        });

        Gate::define('approver_pusat', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('09') && $user->kdsatker && $user->kdunit != null;
        });

        Gate::define('admin_pusat', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('10') && $user->kdsatker != '411792';
        });

        Gate::define('common_expense', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('12');
        });

        Gate::define('admin_common_expense', function ($user, $role) {
            $role = collect(json_decode($role, true));
            return $role->contains('13');
        });
    }
}
