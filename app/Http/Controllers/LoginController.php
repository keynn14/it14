<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        if ($user->isPrincipal()) {
            return redirect()->route('principal.dashboard');
        }
        
        return redirect()->route('dashboard');
    }

    protected function redirectTo()
    {
        if (auth()->user()->isPrincipal()) {
            return route('principal.dashboard');
        }
        
        return route('dashboard');
    }
}