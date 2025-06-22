<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            return redirect('/HalamanUtama'); // Ganti dengan rute yang sesuai untuk pengguna yang sudah login
        }

        return $next($request);
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
        $request->session()->regenerate();
        return redirect()->route('HalamanUtama'); // Sesuaikan dengan nama route dashboard
    }

    return back()->withErrors([
        'email' => 'Email atau password salah',
    ])->withInput();
}
}
