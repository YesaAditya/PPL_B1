<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfilController,
    TransaksiController,
    AkunController,
    RegistrasiController,
    LoginController,
    KatalogController,
    NotifikasiController,
    LaporanController
};

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/
Route::get('/', [AkunController::class, 'ShowHalamanUtama'])->name('ShowHalamanUtama');

/*
|--------------------------------------------------------------------------
| Autentikasi Umum
|--------------------------------------------------------------------------
*/
Route::get('/FormLogin', [LoginController::class, 'showFormLogin'])->name('KlikLogin');
Route::post('/FormLogin', [LoginController::class, 'KlikMasuk']);

Route::get('/FormRegistrasi', [RegistrasiController::class, 'showFormRegistrasi'])->name('KlikRegistrasi');
Route::post('/FormRegistrasi', [RegistrasiController::class, 'KlikLanjut']);

/*
|--------------------------------------------------------------------------
| Middleware Authenticated Users
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/Logout', [AkunController::class, 'Logout'])->name('Logout');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', fn() => view('AdminPenjualan.Dashboard.dashboard'))->name('Layouts.admin');

        // Akun
        Route::get('/akun', [AkunController::class, 'ShowDataAkun'])->name('KlikAkunAdmin');

        // Katalog
        Route::prefix('katalog')->group(function () {
            Route::get('/', [KatalogController::class, 'ShowDataKatalog'])->name('admin.katalog.index');
            Route::get('/tambah', [KatalogController::class, 'ShowFormTambahKatalog'])->name('admin.katalog.create');
            Route::post('/', [KatalogController::class, 'KlikSimpan'])->name('admin.katalog.store');
            Route::get('/{id}/edit', [KatalogController::class, 'ShowFormUbahKatalog'])->name('admin.katalog.edit');
            Route::put('/{id}', [KatalogController::class, 'KlikUbah'])->name('admin.katalog.update');
            Route::delete('/{id}', [KatalogController::class, 'destroy'])->name('admin.katalog.destroy');
            Route::get('/{id}/detail', [KatalogController::class, 'detail'])->name('admin.katalog.detail');
        });

        // Transaksi
        Route::get('/FormKasir', [TransaksiController::class, 'ShowFormKasir'])->name('FormKasir');
        Route::post('/FormKasir/Simpan', [TransaksiController::class, 'KlikSimpan'])->name('KlikSimpan');
        Route::get('/HalamanTransaksi', [TransaksiController::class, 'ShowDataTransaksi'])->name('ShowDataTransaksi');
        Route::get('/transaksi/{id}/detail', [TransaksiController::class, 'ShowDetailTransaksi'])->name('ShowDetailTransaksi');
        Route::post('/UbahStatusTransaksi/{id}', [TransaksiController::class, 'UbahStatusTransaksi'])->name('UbahStatusTransaksi');
        Route::post('/transaksi/batalkan/{id}', [TransaksiController::class, 'batalkanTransaksi']) ->name('batalkanTransaksi') ->middleware('auth');

        // Notifikasi
        Route::get('/notifikasi', [NotifikasiController::class, 'ShowDataNotifikasi'])->name('KlikNotifikasiAdmin');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'showLaporan'])->name('laporan');

    });

    /*
    |--------------------------------------------------------------------------
    | Customer Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('customer')->group(function () {
        // Dashboard
        Route::get('/dashboard', fn() => view('Customer.Dashboard.dashboard'))->name('Layouts.customer');

        // Akun & Profil
        Route::get('/akun', [AkunController::class, 'ShowDataAkun'])->name('KlikAkun');
        Route::post('/akun/verifikasi-password-lama', [AkunController::class, 'KlikLanjut'])->name('akun.verifikasi-password-lama');
        Route::post('/akun/ubah-password', [AkunController::class, 'KlikSimpan'])->name('akun.ubah-password');

        Route::get('/profil', [ProfilController::class, 'ShowDataProfilCustomer'])->name('KlikProfilCustomer');
        Route::put('/profil/update', [ProfilController::class, 'KlikSimpan'])->name('profil.update');

        // Katalog & Pembelian
        Route::get('/HalamanKatalog', [KatalogController::class, 'ShowDataKatalog'])->name('ShowDataKatalog');
        Route::post('/HalamanKatalog/Keranjang', [TransaksiController::class, 'KlikBeliSekarang'])->name('KlikBeliSekarang');

        // Transaksi
        Route::get('/FormTransaksi', [TransaksiController::class, 'ShowFormTransaksi'])->name('ShowFormTransaksi');
        Route::post('/FormTransaksi/Simpan', [TransaksiController::class, 'KlikBuatPesanan'])->name('KlikBuatPesanan');
        Route::get('/TransaksiSaya', [TransaksiController::class, 'ShowDataTransaksi'])->name('TransaksiCustomer');
        Route::get('/TransaksiSaya/{id}/detail', [TransaksiController::class, 'ShowDetailTransaksi'])->name('ShowDetailTransaksiCust');
        Route::post('/TransaksiSaya/Selesai/{id}', [TransaksiController::class, 'UbahStatusTransaksi'])->name('KonfirmasiSelesai');

        // Notifikasi
        Route::get('/notifikasi', [NotifikasiController::class, 'ShowDataNotifikasi'])->name('KlikNotifikasi');
    });

    /*
    |--------------------------------------------------------------------------
    | Notifikasi Umum (Admin & Customer)
    |--------------------------------------------------------------------------
    */
    Route::post('/notifikasi/{id}/baca', [NotifikasiController::class, 'TandaiSudahDibaca'])->name('notifikasi.baca');
    Route::get('/notifikasi/{id}/lihat', [NotifikasiController::class, 'LihatDanArahkan'])->name('notifikasi.lihat');
});

/*
|--------------------------------------------------------------------------
| Midtrans Callback
|--------------------------------------------------------------------------
*/
Route::post('/midtrans-callback', [TransaksiController::class, 'handleCallback'])->name('midtrans.callback');
