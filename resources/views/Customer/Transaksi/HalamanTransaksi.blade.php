@extends('layouts.Customer')

@section('content')
<div class="p-6 max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-primary">Daftar Transaksi Anda</h1>

    {{-- Filter Status --}}
    <form method="GET" class="mb-6 flex items-center gap-3">
        <label for="status" class="font-medium">Filter Status:</label>
        <select name="status" id="status" onchange="this.form.submit()" class="border border-gray-300 rounded px-3 py-1 focus:outline-none focus:ring focus:ring-blue-300">
            <option value="">-- Semua --</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Dicek</option>
            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Dibatalkan</option>
            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Diproses</option>
            <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>Dikirim</option>
            <option value="5" {{ request('status') == '5' ? 'selected' : '' }}>Selesai</option>
        </select>
    </form>

    {{-- Tabel Transaksi --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-gray-300 rounded-lg shadow">
            <thead>
                <tr class="bg-secondary text-white">
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Metode Pengiriman</th>
                    <th class="p-3 text-left">Detail</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($transaksis as $index => $transaksi)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600 hover:underline"><a href="{{ route('ShowDetailTransaksiCust', ['id' => $transaksi->id]) }}">{{$index +1}}</a></td>
                        <td class="p-3">{{ $transaksi->Tanggal_Transaksi }}</td>
                        <td class="p-3">{{ $transaksi->metode_pengiriman }}</td>
                        <td class="p-3"><a href="{{ route('ShowDetailTransaksiCust', ['id' => $transaksi->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded shadow">Lihat Detail</a></td>
                        <form id="form-detail-{{ $transaksi->id }}" action="{{ route('ShowDetailTransaksi', $transaksi->id) }}" method="GET" style="display: none;">
                            @csrf
                            <input type="hidden" name="from" value="{{ url()->full() }}">
                        </form>
                        <td class="p-3">
                            @if($transaksi->statustransaksi_id == 1)
                                <span class="text-yellow-600 font-semibold">Dicek</span>
                            @elseif($transaksi->statustransaksi_id == 2)
                                <span class="text-blue-600 font-semibold">Dibatalkan</span>
                            @elseif($transaksi->statustransaksi_id == 3)
                                <span class="text-blue-600 font-semibold">Diproses</span>
                            @elseif($transaksi->statustransaksi_id == 4)
                                <span class="text-blue-600 font-semibold">Dikirim</span>
                            @else
                                <span class="text-green-600 font-semibold">Selesai</span>
                            @endif
                        </td>
                        <td class="p-3 text-center">
                            @if($transaksi->statustransaksi_id == 4)
                                <form action="{{ route('KonfirmasiSelesai', $transaksi->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded shadow">
                                        Pesanan Diterima
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
