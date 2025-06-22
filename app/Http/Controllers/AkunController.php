<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\DataAkun\User;


class AkunController extends Controller
{
    public function Logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function ShowHalamanUtama()
    {
        $katalogs = DB::table('katalog')->get();
        return view('layouts.HalamanUtama', compact('katalogs'));
    }

    public function ShowDataAkun()
    {
        $user = Auth::user();
        if (Auth::user()->role_id === 1) {
            return view('AdminPenjualan.Akun.HalamanAkun', compact('user'));
        } else {
            return view('Customer.Akun.HalamanAkun', [
                'title' => 'Informasi Akun',
                'user' => $user,
                'hideNavbar' => true
            ]);
        }
    }

    public function KlikLanjut(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return redirect()->back()->with('error_password_lama', 'Password lama tidak sesuai');
        }

        // Beri flag session untuk lanjut ke tahap 2
        return redirect()->back()->with('verifikasi_berhasil', true);
    }

    public function KlikSimpan(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:8|confirmed',
        ]);

        DB::table('users')
            ->where('id', Auth::id())
            ->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('KlikAkun')->with('success', 'Password berhasil diperbarui!');
    }

}
