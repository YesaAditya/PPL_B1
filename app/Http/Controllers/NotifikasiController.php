<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{

    public function ShowDataNotifikasi(){
        if (Auth::user()->role_id === 1) {
            $notifikasiBelumDibaca = DB::table('notifikasis')
                ->join('transaksis', 'notifikasis.transaksi_id', '=', 'transaksis.id')
                ->where(function ($query) {
                    $query->where('notifikasis.pesan_notifikasi', 'like', '%telah melakukan%')
                        ->orWhere('notifikasis.pesan_notifikasi', 'like', '%diterima%');
                })
                ->where('notifikasis.dibaca', false)
                ->orderByDesc('notifikasis.created_at')
                ->select('notifikasis.*')
                ->get();

            $notifikasiSudahDibaca = DB::table('notifikasis')
                ->join('transaksis', 'notifikasis.transaksi_id', '=', 'transaksis.id')
                ->where(function ($query) {
                    $query->where('notifikasis.pesan_notifikasi', 'like', '%telah melakukan%')
                        ->orWhere('notifikasis.pesan_notifikasi', 'like', '%diterima%');
                })
                ->where('notifikasis.dibaca', true)
                ->orderByDesc('notifikasis.created_at')
                ->take(10)
                ->select('notifikasis.*')
                ->get();

        return view('AdminPenjualan.Notifikasi.HalamanNotifikasi', compact('notifikasiBelumDibaca', 'notifikasiSudahDibaca'));

        } else {
            $notifikasiBelumDibaca = DB::table('notifikasis')
                ->join('transaksis', 'notifikasis.transaksi_id', '=', 'transaksis.id')
                ->join('profil', 'transaksis.profil_id', '=', 'profil.id')
                ->where('profil.user_id', Auth::user()->id)
                ->where(function ($query) {
                    $query->where('notifikasis.pesan_notifikasi', 'like', '%dibatalkan%')
                        ->orWhere('notifikasis.pesan_notifikasi', 'like', '%diproses%')
                        ->orWhere('notifikasis.pesan_notifikasi', 'like', '%dikirim%');
                })
                ->where('notifikasis.dibaca', false)
                ->orderByDesc('notifikasis.created_at')
                ->select('notifikasis.*')
                ->get();

            $notifikasiSudahDibaca = DB::table('notifikasis')
                ->join('transaksis', 'notifikasis.transaksi_id', '=', 'transaksis.id')
                ->join('profil', 'transaksis.profil_id', '=', 'profil.id')
                ->where('profil.user_id', Auth::user()->id)
                ->where(function ($query) {
                    $query->where('notifikasis.pesan_notifikasi', 'like', '%dibatalkan%')
                        ->orWhere('notifikasis.pesan_notifikasi', 'like', '%diproses%')
                        ->orWhere('notifikasis.pesan_notifikasi', 'like', '%dikirim%');
                })
                ->where('notifikasis.dibaca', true)
                ->orderByDesc('notifikasis.created_at')
                ->take(10)
                ->select('notifikasis.*')
                ->get();

        return view('Customer.Notifikasi.HalamanNotifikasi', compact('notifikasiBelumDibaca', 'notifikasiSudahDibaca'));
        }
    }

    public function TandaiSudahDibaca($id)
    {
            DB::table('notifikasis')
        ->where('id', $id)
        ->update(['dibaca' => true]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function LihatDanArahkan($id)
    {
        $notifikasi = DB::table('notifikasis')->where('id', $id)->first();

        if ($notifikasi) {
            // Tandai notifikasi sebagai sudah dibaca
            DB::table('notifikasis')
                ->where('id', $id)
                ->update(['dibaca' => true]);

            // Redirect ke detail transaksi sesuai role
            if (Auth::user()->role_id === 1) {
                return redirect()->route('ShowDetailTransaksi', $notifikasi->transaksi_id);
            } else {
                return redirect()->route('ShowDetailTransaksiCust', $notifikasi->transaksi_id);
            }
        }

        return back()->with('error', 'Notifikasi tidak ditemukan.');
    }


}
