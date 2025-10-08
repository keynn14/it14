<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectPrincipal
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isPrincipal()) {
            return redirect()->route('principal.dashboard');
        }

        return $next($request);
    }
}