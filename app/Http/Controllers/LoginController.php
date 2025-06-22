<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showFormLogin()
    {
        return view('Auth.FormLogin');
    }

    // Login
    public function KlikMasuk(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba login
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {

            // Autentikasi berhasil
            $user = auth()->user(); // Ambil user yang sudah login

            if ($user->role_id == 1) {
                return redirect()->route('Layouts.admin');
            } else {
                return redirect()->route('Layouts.customer');
            }


        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->withInput();
    }
}
