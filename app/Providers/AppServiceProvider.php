<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;

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
        Schema::defaultStringLength(191);

        // ── Gates de contrôle d'accès par rôle ──────────────────
        Gate::define('admin-access', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('pharmacie-access', function ($user) {
            return $user->role === 'pharmacie';
        });

        Gate::define('livreur-access', function ($user) {
            return $user->role === 'livreur';
        });

        
    }
}
