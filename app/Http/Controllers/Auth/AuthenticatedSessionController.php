<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
                 // $request->authenticate();

                 // $request->session()->regenerate();

                // return redirect()->intended(RouteServiceProvider::HOME);
                // Attempt authentication
                if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                    throw ValidationException::withMessages([
                        'email' => __('auth.failed'),
                    ]);
                }

             // Regenerate session to prevent session fixation
             $request->session()->regenerate();

             // Refresh the user instance to get the latest data from DB
             $user = Auth::user()->refresh();


            // Check if the vendor's status is not approved
            if ($user->role === 'vendor' && $user->status !== 'approved') {
                Auth::logout();
                return redirect('/login')->with('error', 'Your vendor account is pending admin approval.');
            }

            // Redirect based on user role
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === 'vendor') {
                return redirect()->intended('/vendor/dashboard');
            }

            // Default fallback for general users
            return redirect()->intended('/');

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
