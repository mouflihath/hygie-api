<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si utilisateur connecté
        if (!auth()->check()) {
        return redirect('/'); // pas connecté → accueil
    }

    if (auth()->user()->role !== 'admin') {
        abort(403); // accès interdit
    }

    return $next($request);

    }
}
