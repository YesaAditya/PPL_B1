<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;


class TransaksiController extends Controller
{
    private $ongkirPerKota = [
        'KABUPATEN PACITAN' => 35000,
        'KABUPATEN PONOROGO' => 33000,
        'KABUPATEN TRENGGALEK' => 29000,
        'KABUPATEN TULUNGAGUNG' => 27500,
        'KABUPATEN BLITAR' => 23000,
        'KABUPATEN KEDIRI' => 27000,
        'KABUPATEN MALANG' => 21000,
        'KABUPATEN LUMAJANG' => 17000,
        'KABUPATEN JEMBER' => 12000,
        'KABUPATEN BANYUWANGI' => 18000,
        'KABUPATEN BONDOWOSO' => 15000,
        'KABUPATEN SITUBONDO' => 17000,
        'KABUPATEN PROBOLINGGO' => 25000,
        'KABUPATEN PASURUAN' => 23000,
        'KABUPATEN SIDOARJO' => 25500,
        'KABUPATEN MOJOKERTO' => 25000,
        'KABUPATEN JOMBANG' => 27000,
        'KABUPATEN NGANJUK' => 28000,
        'KABUPATEN MADIUN' => 30000,
        'KABUPATEN MAGETAN' => 34000,
        'KABUPATEN NGAWI' => 36000,
        'KABUPATEN BOJONEGORO' => 32000,
        'KABUPATEN TUBAN' => 33500,
        'KABUPATEN LAMONGAN' => 29000,
        'KABUPATEN GRESIK' => 27000,
        'KABUPATEN BANGKALAN' => 30000,
        'KABUPATEN SAMPANG' => 32000,
        'KABUPATEN PAMEKASAN' => 33000,
        'KABUPATEN SUMENEP' => 34500,
        'KOTA KEDIRI' => 27000,
        'KOTA BLITAR' => 23000,
        'KOTA MALANG' => 21000,
        'KOTA PROBOLINGGO' => 25000,
        'KOTA PASURUAN' => 23000,
        'KOTA MOJOKERTO' => 25000,
        'KOTA MADIUN' => 30000,
        'KOTA SURABAYA' => 26500,
        'KOTA BATU' => 21500,
    ];

    private function hitungOngkir($kota, $jumlahProduk, $metodePengirimanId)
    {
        // Cek jika metode pengiriman bukan online (id=2)
        if ($metodePengirimanId != 2) {
            return 0;
        }

        // Konversi jumlah produk ke berat (1kg = 3 produk)
        $beratKg = ceil($jumlahProduk / 3);

        // Cari harga ongkir berdasarkan kota
        foreach ($this->ongkirPerKota as $namaKota => $harga) {
            if (strpos(strtoupper($kota), $namaKota) !== false) {
                return $harga * $beratKg;
            }
        }

        // Default jika kota tidak ditemukan
        return 20000 * $beratKg;
    }

    // Form Kasir
    public function ShowFormKasir()
    {
        $katalogs = DB::table('katalog')->get();
        return view('AdminPenjualan.Transaksi.FormKasir', compact('katalogs'));
    }

    public function KlikSimpan(Request $request)
    {
        DB::beginTransaction();
            if (!is_array($request->produk_terpilih) || count($request->produk_terpilih) === 0) {
                return redirect()->route('FormKasir')->with('error', 'Silakan pilih minimal satu produk terlebih dahulu.');}

        foreach ($request->produk_terpilih as $katalogId) {
            $jumlah = (int) $request->jumlah_produk[$katalogId];
            $katalog = DB::table('katalog')->where('id', $katalogId)->first();

            if (!$katalog) {
                DB::rollBack();
                return redirect()->route('FormKasir')->with('error', 'Produk dengan ID ' . $katalogId . ' tidak ditemukan.');
            }

            if ($jumlah > $katalog->stok) {
                DB::rollBack();
                return redirect()->route('FormKasir')->with('error', 'Stok produk "' . $katalog->nama_produk . '" tidak mencukupi. Stok tersisa: ' . $katalog->stok);
            }
        }

        $transaksiId = DB::table('transaksis')->insertGetId([
            'profil_id' => 1,
            'metodepengiriman_id' => 1,
            'statustransaksi_id' => 3,
            'tanggal_transaksi' => now(),
            'Kode_Pembayaran' => 'offline',
            // 'total_harga' => $hargaTotal = array_sum($request->harga_total),
            'biaya_pengiriman' => 0,
            'nomor_resi' => 'offline',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        foreach ($request->produk_terpilih as $katalogId) {
            DB::table('detail_transaksis')->insert([
                'katalog_id' => $katalogId,
                'transaksi_id' => $transaksiId,
                'Jumlah_Produk' => $request->jumlah_produk[$katalogId],
                'Harga' => $request->harga_total[$katalogId],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('katalog')->where('id', $katalogId)->decrement('stok', $request->jumlah_produk[$katalogId]);
        }

        DB::commit();
        return redirect()->route('FormKasir')->with('success', 'Transaksi berhasil disimpan.');
    }



    // Membuat Data Transaksi Customer

    public function KlikBeliSekarang(Request $request)
    {
        $request->session()->put('keranjang', $request->input('katalog'));
        return redirect()->route('ShowFormTransaksi');
    }

    public function ShowFormTransaksi(Request $request)
    {
        $keranjang = $request->session()->get('keranjang', []);

        // Jika keranjang kosong, redirect ke katalog dengan pesan error
        if (empty($keranjang)) {
            return redirect()->route('ShowDataKatalog')->with('error', 'Produk masih 0, mohon untuk mengisi produk.');
        }

        // Ambil data user yang sedang login
        $user = Auth::user();

        // Ambil data profil dari user
        $profil = $user->profil;

        $MetodePengiriman = DB::table('metode_pengirimans')->get();
        $katalog = DB::table('katalog')->whereIn('id', $keranjang)->get();

        return view('Customer.Transaksi.FormTransaksi', compact('katalog', 'MetodePengiriman', 'profil'));
    }


    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function KlikBuatPesanan(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi input
            $request->validate([
                'katalog_id' => 'required|array|min:1',
                'jumlah_produk' => 'required|array|size:'.count($request->katalog_id),
                'harga_produk' => 'required|array|size:'.count($request->katalog_id),
            ]);

            // Cek stok produk
            foreach ($request->katalog_id as $index => $id) {
                $jumlah = (int) $request->jumlah_produk[$index];
                $katalog = DB::table('katalog')->where('id', $id)->first();

                if ($jumlah > $katalog->stok) {
                    throw new \Exception('Stok produk "' . $katalog->nama_produk . '" tidak mencukupi. Stok tersisa: ' . $katalog->stok);
                }
            }

            $user = Auth::user();
            $profilId = $user->profil->id;

            // Hitung total harga
            $totalHargaProduk = 0;
            $totalItems = 0;
            $items = [];

            foreach ($request->katalog_id as $index => $id) {
                $jumlah = (int) $request->jumlah_produk[$index];
                $hargaSatuan = (int) $request->harga_produk[$index];
                $katalog = DB::table('katalog')->where('id', $id)->first();

                $totalHargaProduk += $jumlah * $hargaSatuan;
                $totalItems += $jumlah;

                $items[] = [
                    'id' => $id,
                    'price' => $hargaSatuan,
                    'quantity' => $jumlah,
                    'name' => $katalog->nama_produk
                ];

                // Kurangi stok produk
                DB::table('katalog')
                    ->where('id', $id)
                    ->decrement('stok', $jumlah);
            }

            // Hitung ongkir (selalu online)
            $ongkir = $this->hitungOngkir(
                $user->profil->kota,
                $totalItems,
                2 // ID 2 untuk metode pengiriman online
            );

            // Tambahkan ongkir sebagai item terpisah
            if ($ongkir > 0) {
                $items[] = [
                    'id' => 'ONGKIR',
                    'price' => $ongkir,
                    'quantity' => 1,
                    'name' => 'Ongkos Kirim'
                ];
            }

            $totalHarga = $totalHargaProduk + $ongkir;

            // Generate kode pembayaran unik
            $kodePembayaran = 'TRX-' . time() . rand(100, 999);

            // Langsung simpan transaksi ke database dengan status 'pending' (1)
            $transaksiId = DB::table('transaksis')->insertGetId([
                'profil_id' => $profilId,
                'metodepengiriman_id' => 2,
                'statustransaksi_id' => 1, // Status: dicek
                'Kode_Pembayaran' => $kodePembayaran,
                'Tanggal_Transaksi' => now(),
                // 'total_harga' => $totalHargaProduk,
                'biaya_pengiriman' => $ongkir,
                'nomor_resi' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Simpan detail transaksi
            foreach ($request->katalog_id as $index => $id) {
                $jumlah = (int) $request->jumlah_produk[$index];
                $hargaSatuan = (int) $request->harga_produk[$index];

                DB::table('detail_transaksis')->insert([
                    'transaksi_id' => $transaksiId,
                    'katalog_id' => $id,
                    'Jumlah_Produk' => $jumlah,
                    'Harga' => $hargaSatuan,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $nama_profil = Auth::user()->profil->nama;
            DB::table('notifikasis')->insert([
                'transaksi_id' => $transaksiId,
                'pesan_notifikasi' => 'Customer ' . $nama_profil . ' telah melakukan transaksi',
                'dibaca' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Generate Snap Token
            $snapToken = Snap::getSnapToken([
                'transaction_details' => [
                    'order_id' => $kodePembayaran,
                    'gross_amount' => $totalHarga,
                ],
                'customer_details' => [
                    'first_name' => $user->profil->nama,
                    'email' => $user->email,
                    'phone' => $user->profil->no_telepon ?? '',
                ],
                'item_details' => $items,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'redirect_url' => route('TransaksiCustomer')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi gagal: ' . $e->getMessage()
            ], 500);
        }
    }


    // Melihat Transaksi Admin dan customer
    public function ShowDataTransaksi(Request $request)
    {
        if ($request->has('from')) {
            session()->flash('from_transaksi', $request->input('from'));
        }
        if (Auth::user()->role_id === 1) {
            $semua_status = DB::table('status_transaksis')->get();
            $status = $request->input('status');
            $query = DB::table('transaksis')
                ->join('metode_pengirimans', 'transaksis.metodepengiriman_id', '=', 'metode_pengirimans.id')
                ->join('status_transaksis', 'transaksis.statustransaksi_id', '=', 'status_transaksis.id')
                ->select(
                    'transaksis.*',
                    'metode_pengirimans.metode_pengiriman as metode_pengiriman',
                    'status_transaksis.status_transaksi as status_transaksi'
                );

            if ($status) {
                $query->where('transaksis.statustransaksi_id', $status);
            }

            $transaksis = $query->get();
            return view('AdminPenjualan.Transaksi.HalamanTransaksi', compact('transaksis', 'semua_status', 'status'));
        } else {
            $user = Auth::user();
            $profilId = $user->profil->id;

            $query = DB::table('transaksis')
            ->join('metode_pengirimans', 'transaksis.metodepengiriman_id', '=', 'metode_pengirimans.id')
            ->join('status_transaksis', 'transaksis.statustransaksi_id', '=', 'status_transaksis.id')
            ->select(
                'transaksis.*',
                'metode_pengirimans.metode_pengiriman as metode_pengiriman',
                'status_transaksis.status_transaksi as status_transaksi'
            )
            ->where('transaksis.profil_id', $profilId); // filter berdasarkan profil_id

            if ($request->has('status') && $request->status != '') {
                $query->where('transaksis.statustransaksi_id', $request->status);
            }

            $transaksis = $query->get();
            return view('Customer.Transaksi.HalamanTransaksi', compact('transaksis'));
        }
    }

    // Halaman detail transaksi admin dan customer
    public function ShowDetailTransaksi($id)
    {
        $transaksi = DB::table('transaksis')
            ->leftJoin('status_transaksis', 'transaksis.statustransaksi_id', '=', 'status_transaksis.id')
            ->leftJoin('metode_pengirimans', 'transaksis.metodepengiriman_id', '=', 'metode_pengirimans.id')
            ->leftJoin('profil', 'transaksis.profil_id', '=', 'profil.id') // join ke profil
            ->where('transaksis.id', $id)
            ->select(
                'transaksis.*',
                'status_transaksis.status_transaksi',
                'metode_pengirimans.metode_pengiriman',
                'profil.nama',
                'profil.no_telepon',
                'profil.kota',
                'profil.kelurahan',
                'profil.kecamatan',
                'profil.alamat'
            )
            ->first();

        $detail_transaksi = DB::table('detail_transaksis')
            ->join('katalog', 'detail_transaksis.katalog_id', '=', 'katalog.id')
            ->where('transaksi_id', $id)
            ->select('detail_transaksis.*', 'katalog.nama_produk', 'katalog.harga as harga_satuan')
            ->get();

        if (Auth::user()->role_id === 1) {
            return view('AdminPenjualan.Transaksi.HalamanDetailTransaksi', compact('transaksi', 'detail_transaksi'));
        } else {
            return view('Customer.Transaksi.HalamanDetailTransaksi', compact('transaksi', 'detail_transaksi'));
        }
    }

    public function batalkanTransaksi($id)
    {
        DB::beginTransaction();
        
        try {
            // Dapatkan data transaksi
            $transaksi = DB::table('transaksis')->where('id', $id)->first();
            
            if (!$transaksi) {
                throw new \Exception('Transaksi tidak ditemukan');
            }

            // Hanya bisa membatalkan transaksi dengan status tertentu
            if (!in_array($transaksi->statustransaksi_id, [1, 2, 3])) { // 1: Pending, 2: Diproses, 3: Dikirim
                throw new \Exception('Transaksi tidak dapat dibatalkan karena status sudah final');
            }

            // Dapatkan semua detail transaksi
            $details = DB::table('detail_transaksis')
                ->where('transaksi_id', $id)
                ->get();

            // Kembalikan stok untuk setiap produk
            foreach ($details as $detail) {
                DB::table('katalog')
                    ->where('id', $detail->katalog_id)
                    ->increment('stok', $detail->Jumlah_Produk);
            }

            // Update status transaksi menjadi Dibatalkan (id=2)
            DB::table('transaksis')
                ->where('id', $id)
                ->update([
                    'statustransaksi_id' => 2, // Dibatalkan
                    'updated_at' => now()
                ]);

            // Tambahkan notifikasi
            DB::table('notifikasis')->insert([
                'transaksi_id' => $id,
                'pesan_notifikasi' => 'Transaksi #' . $transaksi->Kode_Pembayaran . ' telah dibatalkan. Stok produk telah dikembalikan.',
                'dibaca' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Transaksi berhasil dibatalkan dan stok produk telah dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }

    // Mengubahstatus admin
    public function UbahStatusTransaksi(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $transaksi = DB::table('transaksis')->where('id', $id)->first();

            if (!$transaksi) {
                throw new \Exception('Transaksi tidak ditemukan');
            }

            // Untuk Admin
            if ($user->role_id === 1) {
                $request->validate([
                    'statustransaksi_id' => 'required|numeric|exists:status_transaksis,id',
                    'nomor_resi' => 'nullable|string|max:100'
                ]);

                $status = $request->input('statustransaksi_id');
                $dataUpdate = ['statustransaksi_id' => $status];

                // Jika mengubah ke status Dibatalkan (2), kembalikan stok
                if ($status == 2) {
                    $details = DB::table('detail_transaksis')
                        ->where('transaksi_id', $id)
                        ->get();

                    foreach ($details as $detail) {
                        DB::table('katalog')
                            ->where('id', $detail->katalog_id)
                            ->increment('stok', $detail->Jumlah_Produk);
                    }
                }

                // Jika mengubah ke status Dikirim (4), tambahkan nomor resi jika ada
                if ($status == 4 && $request->filled('nomor_resi')) {
                    $dataUpdate['nomor_resi'] = $request->input('nomor_resi');
                }

                DB::table('transaksis')->where('id', $id)->update($dataUpdate);

                // Buat notifikasi
                $pesan = $this->generateAdminNotification($status, $transaksi->Kode_Pembayaran);
                DB::table('notifikasis')->insert([
                    'transaksi_id' => $id,
                    'pesan_notifikasi' => $pesan,
                    'dibaca' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::commit();
                return redirect()->route('ShowDataTransaksi')->with('success', 'Status transaksi berhasil diubah!');
            }
            // Untuk Customer
            else {
                // Customer hanya bisa mengubah status dari Dikirim (4) ke Diterima (5)
                if ($transaksi->statustransaksi_id == 4) {
                    DB::table('transaksis')->where('id', $id)->update([
                        'statustransaksi_id' => 5,
                        'updated_at' => now()
                    ]);

                    DB::table('notifikasis')->insert([
                        'transaksi_id' => $id,
                        'pesan_notifikasi' => 'Customer ' . $user->profil->nama . ' telah menerima pesanan #' . $transaksi->Kode_Pembayaran,
                        'dibaca' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    DB::commit();
                    return redirect()->route('ShowDataTransaksi')->with('success', 'Status transaksi berhasil diubah!');
                } else {
                    throw new \Exception('Anda tidak dapat mengubah status transaksi ini');
                }
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    private function generateAdminNotification($status, $kodePembayaran)
    {
        $statusMessages = [
            1 => 'Transaksi #' . $kodePembayaran . ' menunggu pembayaran',
            2 => 'Transaksi #' . $kodePembayaran . ' telah dibatalkan. Stok produk telah dikembalikan',
            3 => 'Transaksi #' . $kodePembayaran . ' sedang diproses',
            4 => 'Transaksi #' . $kodePembayaran . ' telah dikirim',
            5 => 'Transaksi #' . $kodePembayaran . ' telah diterima customer'
        ];

        return $statusMessages[$status] ?? 'Status transaksi #' . $kodePembayaran . ' telah diperbarui';
    }


    // public function KlikBuatPesanan(Request $request)
    // {
    //     DB::beginTransaction();

    //     try {
    //         // Validasi input
    //         $request->validate([
    //             'metodepengiriman_id' => 'required|exists:metode_pengirimans,id',
    //             'katalog_id' => 'required|array|min:1',
    //             'jumlah_produk' => 'required|array|size:'.count($request->katalog_id),
    //             'harga_produk' => 'required|array|size:'.count($request->katalog_id),
    //         ]);

    //         // Cek stok produk
    //         foreach ($request->katalog_id as $index => $id) {
    //             $jumlah = (int) $request->jumlah_produk[$index];
    //             $katalog = DB::table('katalog')->where('id', $id)->first();

    //             if ($jumlah > $katalog->stok) {
    //                 throw new \Exception('Stok produk "' . $katalog->nama_produk . '" tidak mencukupi. Stok tersisa: ' . $katalog->stok);
    //             }
    //         }

    //         $profilId = Auth::user()->profil->id;
    //         $nama_profil = Auth::user()->profil->nama;
    //         $user = Auth::user();

    //         // Hitung total harga
    //         $totalHargaProduk = 0;
    //         $totalItems = 0;
    //         $items = [];

    //         foreach ($request->katalog_id as $index => $id) {
    //             $jumlah = (int) $request->jumlah_produk[$index];
    //             $hargaSatuan = (int) $request->harga_produk[$index];
    //             $katalog = DB::table('katalog')->where('id', $id)->first();

    //             $totalHargaProduk += $jumlah * $hargaSatuan;
    //             $totalItems += $jumlah;

    //             $items[] = [
    //                 'id' => $id,
    //                 'price' => $hargaSatuan,
    //                 'quantity' => $jumlah,
    //                 'name' => $katalog->nama_produk
    //             ];
    //         }

    //         // Pastikan ongkir 0 jika metode pengiriman offline
    //         $metodePengiriman = DB::table('metode_pengirimans')
    //             ->where('id', $request->metodepengiriman_id)
    //             ->first();

    //         $ongkir = 0;
    //         $showOngkir = false;

    //         if ($metodePengiriman && $metodePengiriman->id == 2) { // Hanya untuk pengiriman online
    //             $ongkir = $this->hitungOngkir(
    //                 $user->profil->kota,
    //                 $totalItems,
    //                 $request->metodepengiriman_id
    //             );
    //             $showOngkir = true;
    //         }

    //         // Tambahkan ongkir sebagai item terpisah jika ada
    //         if ($showOngkir && $ongkir > 0) {
    //             $items[] = [
    //                 'id' => 'ONGKIR',
    //                 'price' => $ongkir,
    //                 'quantity' => 1,
    //                 'name' => 'Ongkos Kirim'
    //             ];
    //         }

    //         $totalHarga = $totalHargaProduk + $ongkir;

    //         // Buat transaksi
    //         $transaksiId = DB::table('transaksis')->insertGetId([
    //             'profil_id' => $profilId,
    //             'metodepengiriman_id' => 2,
    //             'statustransaksi_id' => 1, // Status awal: menunggu pembayaran
    //             'Kode_Pembayaran' => 'TRX-' . time() . rand(100, 999),
    //             'Tanggal_Transaksi' => now(),
    //             'total_harga' => $totalHargaProduk,
    //             'biaya_pengiriman' => $ongkir,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);

    //         // Simpan detail transaksi
    //         foreach ($request->katalog_id as $index => $id) {
    //             $jumlah = (int) $request->jumlah_produk[$index];
    //             $hargaSatuan = (int) $request->harga_produk[$index];

    //             DB::table('detail_transaksis')->insert([
    //                 'transaksi_id' => $transaksiId,
    //                 'katalog_id' => $id,
    //                 'Jumlah_Produk' => $jumlah,
    //                 'Harga' => $jumlah * $hargaSatuan,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ]);

    //             DB::table('katalog')->where('id', $id)->decrement('stok', $jumlah);
    //         }

    //         // Generate Snap Token (tanpa konfigurasi manual)
    //         $snapToken = Snap::getSnapToken([
    //             'transaction_details' => [
    //                 'order_id' => 'TRX-' . $transaksiId,
    //                 'gross_amount' => $totalHarga,
    //             ],
    //             'customer_details' => [
    //                 'first_name' => $user->profil->nama,
    //                 'email' => $user->email,
    //                 'phone' => $user->profil->no_telepon ?? '',
    //             ],
    //             'item_details' => $items,
    //         ]);

    //         // Update transaksi dengan snap token
    //         // DB::table('transaksis')->where('id', $transaksiId)->update([
    //         //     'snap_token' => $snapToken
    //         // ]);

    //         DB::commit();

    //         // Hapus session keranjang
    //         $request->session()->forget('keranjang');

    //         // Redirect ke halaman pembayaran dengan snap token
    //         return redirect()->route('payment.page', ['snap_token' => $snapToken]);

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->route('TransaksiCustomer')
    //             ->with('error', 'Transaksi gagal: ' . $e->getMessage());
    //     }
    // }

    // public function showPaymentPage(Request $request)
    // {
    //     $snapToken = $request->query('snap_token');
    //     return view('Customer.Transaksi.PaymentPage', compact('snapToken'));
    // }

    // public function handleCallback(Request $request)
    // {
    //     $notif = new Notification();

    //     DB::beginTransaction();
    //     try {
    //         $transaction = $notif->transaction_status;
    //         $orderId = $notif->order_id;

    //         // Ekstrak ID transaksi dari order_id (format: TRX-123)
    //         $transaksiId = str_replace('TRX-', '', $orderId);

    //         if ($transaction == 'settlement') {
    //             // Pembayaran berhasil
    //             DB::table('transaksis')->where('id', $transaksiId)->update([
    //                 'statustransaksi_id' => 2, // Status: diproses
    //                 'updated_at' => now()
    //             ]);

    //             DB::commit();

    //             // Redirect ke halaman transaksi dengan notifikasi sukses
    //             return redirect()->route('ShowDataTransaksi')
    //                 ->with('success', 'Pembayaran berhasil! Pesanan sedang diproses.');
    //         } else if ($transaction == 'cancel' || $transaction == 'expire') {
    //             // Pembayaran gagal
    //             DB::table('transaksis')->where('id', $transaksiId)->update([
    //                 'statustransaksi_id' => 5, // Status: dibatalkan
    //                 'updated_at' => now()
    //             ]);

    //             // Kembalikan stok produk
    //             $details = DB::table('detail_transaksis')
    //                 ->where('transaksi_id', $transaksiId)
    //                 ->get();

    //             foreach ($details as $detail) {
    //                 DB::table('katalog')
    //                     ->where('id', $detail->katalog_id)
    //                     ->increment('stok', $detail->Jumlah_Produk);
    //             }

    //             DB::commit();

    //             // Redirect ke halaman katalog dengan notifikasi error
    //             return redirect()->route('ShowDataKatalog')
    //                 ->with('error', 'Pembayaran gagal atau dibatalkan.');
    //         }

    //         DB::commit();
    //         return response()->json(['status' => 'success']);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->route('ShowDataKatalog')
    //             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //     }
    // }
}
