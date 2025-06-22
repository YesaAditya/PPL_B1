@extends('layouts.admin')

@section('content')
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<h1 class="text-4xl font-bold text-center mb-10">Katalog Produk</h1>
<div class="flex flex-wrap justify-center gap-5">
    @if($katalogs->isEmpty())
        <div class="text-center text-gray-500 w-full text-lg">
            Belum ada produk di katalog. Silakan tambahkan produk terlebih dahulu.
        </div>
    @else
        @foreach ($katalogs as $product)
            <a href="{{ route('admin.katalog.edit', $product->id) }}"
                class="bg-white w-[200px] rounded-2xl p-3 shadow-md transition duration-300 hover:shadow-lg hover:scale-105">
                <img src="{{ asset('storage/' . $product->foto) }}"
                        alt="{{ $product->nama_produk }}"
                        class="w-full h-40 object-cover rounded-md">
                <p class="text-secondary font-medium mt-2">{{ $product->nama_produk }}</p>
                <p class="text-accent font-medium">RP {{ number_format($product->harga, 0, ',', '.') }}</p>
                <p class="text-gray-500 text-sm">Stok: {{ $product->stok }}</p>
            </a>
        @endforeach
    @endif
</div>

<div class="relative mt-5">
    <a href="{{ route('admin.katalog.create') }}">
        <button class="bg-secondary text-white py-3 px-6 rounded-xl fixed bottom-10 right-10
                    transition-all duration-300 ease-in-out
                    hover:bg-secondary/90 hover:shadow-lg">
            + Tambah Produk
        </button>
    </a>
</div>
@endsection
