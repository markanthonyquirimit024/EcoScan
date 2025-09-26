<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->ensureIsNotRateLimited($request);

        // ✅ Validate input
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // ✅ Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ✅ Clear failed attempts if login successful
            RateLimiter::clear($this->throttleKey($request));

            return redirect()->intended(route('home'))
                             ->with('success', 'Welcome back!');
        }

        // ❌ Wrong credentials → increment failed attempts
        RateLimiter::hit($this->throttleKey($request));

        return back()->withErrors([
            'email' => 'Invalid Credentials. Please try again.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }


    // ✅ Rate Limiting Helpers
    protected function ensureIsNotRateLimited(Request $request)
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => "Too many login attempts. Please try again in $seconds seconds.",
        ]);
    }

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')).'|'.$request->ip();
    }
}
