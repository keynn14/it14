<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
public function store(Request $request): RedirectResponse
{
    if ($request->user()->hasVerifiedEmail()) {
        // Redirect principals to their dashboard
        if ($request->user()->role === 'principal') {
            return redirect()->route('principal.dashboard');
        }
        return redirect()->intended(route('dashboard', absolute: false));
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
}
}
