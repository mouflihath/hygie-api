<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Global HTTP middleware — exécuté à chaque requête
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\Cors::class,
    ];

    /**
     * Groupes de middleware
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Alias de middleware pour les routes
     */
    protected $middlewareAliases = [
        // Laravel natif
        'auth'                => \App\Http\Middleware\Authenticate::class,
        'auth.basic'          => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session'        => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers'       => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can'                 => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'               => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm'    => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed'              => \App\Http\Middleware\ValidateSignature::class,
        'throttle'            => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified'            => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // Middleware personnalisés
        'prevent.back.history' => \App\Http\Middleware\PreventBackHistory::class,
        'role'                 => \App\Http\Middleware\CheckRole::class,

        // Anciens middleware (gardés pour ne rien casser)
        'admin'               => \App\Http\Middleware\AdminMiddleware::class,
        'pharmacie'           => \App\Http\Middleware\PharmacieMiddleware::class,
        'livreur'             => \App\Http\Middleware\LivreurMiddleware::class,


    ];
}
