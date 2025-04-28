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
use Illuminate\Support\Facades\Hash;

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
        // if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {

        //     throw ValidationException::withMessages([
        //         'email' => __('auth.failed'),
        //     ]);
        // }

        //$request->session()->regenerate();

        //$user = Auth::user()->refresh();

        // Check if the vendor's status is not approved
        // if ($user->role === 'vendor' && $user->status !== 'approved') {
        //     Auth::logout();
        //     return redirect('/login')->with('error', 'Your vendor account is pending admin approval.');
        // }

        // Redirect based on user role
        // if ($user->role === 'admin') {
        //     return redirect()->intended('/admin/dashboard');
        // } elseif ($user->role === 'vendor') {
        //     return redirect()->intended('/vendor/dashboard');
        // }

        // Default fallback for general users
        // redirect()->intended('/');

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Check password based on role
        if ($user->role === 'admin') {
            if (!Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }
        } elseif ($user->role === 'vendor') {
            if ($user->password !== $request->password) {
                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }
        } else {
            // If role is unknown, fail login
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Login the user manually
        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        $user = Auth::user()->refresh();

        if ($user->role === 'vendor' && $user->status !== 'approved') {
            Auth::logout();
            return redirect('/login')->with('error', 'Your vendor account is pending admin approval.');
        }

        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->role === 'vendor') {
            return redirect()->intended('/vendor/dashboard');
        }

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
