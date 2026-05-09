<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle Login Process
     */
    public function authenticate(Request $request)
    {
        // input validation
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // check if the user checklist "remember me"
        $remember = $request->has("remember");

        // authenticate
        if (Auth::attempt($credentials, $remember)) {

            // Security: Regenerate the session ID to prevent session hijacking
            $request->session()->regenerate();

            // Redirect to dashboard (includes the swal_success session captured by SweetAlert in the blade)
            return redirect()->intended('dashboard')
                ->with('swal_success', 'Welcome Back');
        }

        // if login failed, return back to the login page with error
        return back()->withErrors([
            'email' => 'Email or password is wrong.',
        ])->onlyInput('email')
            ->with('swal_error', 'Credentials is not valid, please try again.');
    }

    /**
     * Handle Logout Process
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // delete all of the session data and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
