<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function ShowDataProfilCustomer()
    {
        $user = auth()->user();
        $profil = $user->profil;

        return view('Customer.Profil.HalamanProfilCustomer', [
            'title' => 'Profil Saya',
            'profil' => $profil,
            'hideNavbar' => true
        ], compact('user'));
    }

    public function KlikSimpan(Request $request)
    {
        try{
            $request->validate([
                'nama' => 'required|string|max:255',
                'no_telepon' => ['required', 'regex:/^[0-9]+$/', 'min:10', 'max:13'],
                'alamat' => 'required|string',
                'kota' => 'required|string',
                'kecamatan' => 'required|string',
                'kelurahan' => 'required|string',
                'foto_profil' => 'nullable|image|max:2048'
            ]);

            $user = Auth::user();
            $profil = $user->profil;

            $profil->nama = $request->nama;
            $profil->no_telepon = $request->no_telepon;
            $profil->kota = $request->kota;
            $profil->kecamatan = $request->kecamatan;
            $profil->kelurahan = $request->kelurahan;
            $profil->alamat = $request->alamat;

            $profil->save();

            return redirect()->route('KlikProfilCustomer')->with('success', 'Profil berhasil diperbarui!');
        } 
        
        catch (\Exception $e) {
            return back()->with('error', 'Mohon masukkan data yang sesuai');
        }
    }
}
