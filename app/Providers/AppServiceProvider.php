<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        Gate::define('access-admin', function ($user) {
            return in_array($user->role, ['admin']);
        });

        Gate::define('access-petugas-farmasi', function ($user) {
            return in_array($user->role, ['petugas-farmasi']);
        });

        Gate::define('access-petugas-puskesmas', function ($user) {
            return in_array($user->role, ['petugas-puskesmas']);
        });

        Gate::define('access-admin-farmasi', function ($user) {
            return in_array($user->role, ['admin', 'petugas-farmasi']);
        });

        Gate::define('access-admin-puskesmas', function ($user) {
            return in_array($user->role, ['admin', 'petugas-puskesmas']);
        });

        Gate::define('access-admin-farmasi-puskesmas', function ($user) {
            return in_array($user->role, ['admin', 'petugas-farmasi', 'petugas-puskesmas']);
        });

        Gate::define('access-farmasi-puskesmas', function ($user) {
            return in_array($user->role, ['petugas-farmasi', 'petugas-puskesmas']);
        });
    }
}
