<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
public function __invoke(Request $request): RedirectResponse|View
{
    if ($request->user()->hasVerifiedEmail()) {
        // Redirect principals to their dashboard
        if ($request->user()->role === 'principal') {
            return redirect()->route('principal.dashboard');
        }
        return redirect()->intended(route('dashboard', absolute: false));
    }

    return view('auth.verify-email');
}
}
