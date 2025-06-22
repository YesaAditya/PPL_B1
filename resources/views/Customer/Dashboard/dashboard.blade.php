@extends('layouts.customer')

@section('title', 'Dashboard Customer')

@section('content')
<section class="py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Halo, Customer!</h1>
            <p class="text-lg text-gray-600">Apa yang ingin Anda lakukan hari ini?</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Buat Transaksi -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform hover:scale-105">
                <div class="p-6">
                    <div class="flex items-center justify-center bg-blue-100 rounded-full w-16 h-16 mb-4 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">Buat Transaksi</h3>
                    <p class="text-gray-600 text-center mb-4">Mulai transaksi baru untuk pembelian produk</p>
                    <a href="{{ route('ShowDataKatalog') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-md transition">Mulai</a>
                </div>
            </div>

            <!-- Lihat Katalog -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform hover:scale-105">
                <div class="p-6">
                    <div class="flex items-center justify-center bg-green-100 rounded-full w-16 h-16 mb-4 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">Lihat Katalog</h3>
                    <p class="text-gray-600 text-center mb-4">Jelajahi produk yang tersedia</p>
                    <a href="{{ route('ShowDataKatalog') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-md transition">Lihat</a>
                </div>
            </div>

            <!-- Lihat Transaksi -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform hover:scale-105">
                <div class="p-6">
                    <div class="flex items-center justify-center bg-purple-100 rounded-full w-16 h-16 mb-4 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">Lihat Transaksi</h3>
                    <p class="text-gray-600 text-center mb-4">Lihat riwayat transaksi Anda</p>
                    <a href="{{ route('TransaksiCustomer') }}" class="block w-full bg-purple-600 hover:bg-purple-700 text-white text-center py-2 px-4 rounded-md transition">Lihat</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
