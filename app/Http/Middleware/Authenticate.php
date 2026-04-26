<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
   protected function redirectTo(Request $request): ?string
{
    if (! $request->expectsJson()) {
        // Si l'URL demandée contient "pharmacie", on renvoie vers le login pharmacie
      
        return route('login');
    }
    return null;
}
}
