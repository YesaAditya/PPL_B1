<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function showLaporan(Request $request)
    {
        // Default filter bulan ini
        $filter = $request->input('filter', 'bulan');
        $tanggal = $request->input('tanggal', date('Y-m'));
        
        // Parse tanggal berdasarkan filter
        if ($filter == 'hari') {
            $startDate = Carbon::parse($tanggal)->startOfDay();
            $endDate = Carbon::parse($tanggal)->endOfDay();
            $groupByFormat = '%Y-%m-%d';
        } elseif ($filter == 'bulan') {
            $startDate = Carbon::parse($tanggal)->startOfMonth();
            $endDate = Carbon::parse($tanggal)->endOfMonth();
            $groupByFormat = '%Y-%m-%d';
        } else { // tahun
            $startDate = Carbon::parse($tanggal)->startOfYear();
            $endDate = Carbon::parse($tanggal)->endOfYear();
            $groupByFormat = '%Y-%m';
        }
        
        // 1a. Statistik Ringkasan
        // Jumlah transaksi
        $jumlahTransaksi = DB::table('transaksis')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->count();
        
        // Jumlah produk terjual
        $jumlahProdukTerjual = DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->whereBetween('transaksis.tanggal_transaksi', [$startDate, $endDate])
            ->sum('detail_transaksis.Jumlah_Produk');
        
        // 1b. Total pendapatan kotor
        $totalPendapatan = DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->whereBetween('transaksis.tanggal_transaksi', [$startDate, $endDate])
            ->sum('detail_transaksis.Harga');
        
        // 1c. Produk terlaris
        $produkTerlaris = DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->join('katalog', 'detail_transaksis.katalog_id', '=', 'katalog.id')
            ->whereBetween('transaksis.tanggal_transaksi', [$startDate, $endDate])
            ->select(
                'katalog.nama_produk',
                DB::raw('SUM(detail_transaksis.Jumlah_Produk) as total_terjual'),
                DB::raw('SUM(detail_transaksis.Harga) as total_pendapatan')
            )
            ->groupBy('katalog.nama_produk')
            ->orderByDesc('total_terjual')
            ->limit(10)
            ->get();
        
        // Data untuk grafik
        $grafikTransaksi = DB::table('transaksis')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->select(
                DB::raw("DATE_FORMAT(tanggal_transaksi, '".$groupByFormat."') as periode"),
                DB::raw('COUNT(*) as jumlah_transaksi'),
                DB::raw('SUM((SELECT SUM(Jumlah_Produk) FROM detail_transaksis WHERE transaksi_id = transaksis.id)) as jumlah_produk')
            )
            ->groupBy('periode')
            ->orderBy('periode')
            ->get();
        
        return view('AdminPenjualan.HalamanLaporan', compact(
            'jumlahTransaksi',
            'jumlahProdukTerjual',
            'totalPendapatan',
            'produkTerlaris',
            'grafikTransaksi',
            'filter',
            'tanggal'
        ));
    }
}