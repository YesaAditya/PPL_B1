<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Profil;
use Illuminate\Support\Facades\Hash;

class RegistrasiController extends Controller
{
    public function showFormRegistrasi()
    {
        return view('Auth.FormRegistrasi');
    }

    public function KlikLanjut(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|regex:/^[^@]+@gmail\.com$/|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_telepon' => ['required', 'regex:/^[0-9]+$/', 'min:10', 'max:13'],
            'kota_nama' => 'required|string|max:255',
            'kecamatan_nama' => 'required|string|max:255',
            'kelurahan_nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
        ]);

        DB::beginTransaction();
        //dd($request);
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Profil::create([
            'nama' => $validated['nama'],
            'user_id' => $user->id,
            'no_telepon' => $validated['no_telepon'],
            'alamat' => $validated['alamat'],
            'kota' => $validated['kota_nama'],
            'kecamatan' => $validated['kecamatan_nama'],
            'kelurahan' => $validated['kelurahan_nama'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::commit();

        return redirect()->route('KlikLogin')->with('success', 'Registrasi berhasil! Silakan login');
    }
}
