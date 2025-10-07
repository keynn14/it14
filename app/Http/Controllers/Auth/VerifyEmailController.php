<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
public function __invoke(EmailVerificationRequest $request): RedirectResponse
{
    if ($request->user()->hasVerifiedEmail()) {
        // Redirect principals to their dashboard
        if ($request->user()->role === 'principal') {
            return redirect()->route('principal.dashboard');
        }
        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }

    if ($request->user()->markEmailAsVerified()) {
        event(new Verified($request->user()));
    }

    // Redirect principals to their dashboard
    if ($request->user()->role === 'principal') {
        return redirect()->route('principal.dashboard');
    }

    return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
}
}
