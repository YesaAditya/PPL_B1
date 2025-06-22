@extends('layouts.Customer')

@section('content')
<div class="p-4 bg-white rounded shadow-md max-w-xl mx-auto text-center">
    <div class="text-green-500 mb-4">
        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
    </div>
    <h1 class="text-2xl font-bold mb-2">Pembayaran Berhasil</h1>
    <p class="mb-4">Terima kasih telah berbelanja dengan kami.</p>
    <p class="mb-2">ID Transaksi: <span class="font-semibold">{{ $order_id }}</span></p>
    <a href="{{ route('ShowDataKatalog') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded inline-block mt-4">
        Kembali ke Beranda
    </a>
</div>
@endsection