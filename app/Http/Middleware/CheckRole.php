<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Add detailed logging
        Log::info('CheckRole Middleware Debug:', [
            'user_id' => $request->user() ? $request->user()->id : 'No user',
            'user_email' => $request->user() ? $request->user()->email : 'No email',
            'user_role' => $request->user() ? $request->user()->role : 'No role',
            'expected_role' => $role,
            'url' => $request->fullUrl()
        ]);

        if (! $request->user()) {
            Log::warning('No authenticated user');
            abort(403, 'Not authenticated.');
        }

        if ($request->user()->role !== $role) {
            Log::warning('Role mismatch', [
                'actual' => $request->user()->role,
                'expected' => $role
            ]);
            abort(403, 'Unauthorized action. Your role: ' . $request->user()->role . ', Required: ' . $role);
        }

        return $next($request);
    }
}