<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Les correspondances entre modèles et politiques (Policies).
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Enregistre les services d'authentification et d'autorisation.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        /**
         * Définition de la porte d'accès pour l'Admin
         * Vérifie si l'utilisateur a le rôle 'admin'
         */
        Gate::define('admin-access', function (User $user) {
            return $user->role === 'admin';
        });

        /**
         * Définition de la porte d'accès pour la Pharmacie
         * Vérifie si l'utilisateur a le rôle 'pharmacie'
         */
        Gate::define('pharmacie-access', function (User $user) {
            return $user->role === 'pharmacie';
        });
    }
}
