@extends('layouts.admin')

@section('content')
<div class="p-6">
    <!-- Filter -->
    <form method="GET" action="{{ route('laporan') }}" class="mb-6 flex flex-wrap gap-4 items-center">
        <label>
            <select name="filter" class="border rounded px-3 py-1">
                <option value="hari" {{ $filter == 'hari' ? 'selected' : '' }}>Harian</option>
                <option value="bulan" {{ $filter == 'bulan' ? 'selected' : '' }}>Bulanan</option>
                <option value="tahun" {{ $filter == 'tahun' ? 'selected' : '' }}>Tahunan</option>
            </select>
        </label>
        <label>
            <input type="{{ $filter == 'hari' ? 'date' : ($filter == 'bulan' ? 'month' : 'number') }}" 
                    name="tanggal" 
                    value="{{ $tanggal }}" 
                    class="border rounded px-3 py-1" 
                    min="2000"
                    max="2100">
        </label>
        <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Tampilkan</button>
    </form>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white shadow p-4 rounded text-center">
            <h2 class="text-xl font-bold">Jumlah Transaksi</h2>
            <p class="text-2xl">{{ $jumlahTransaksi }}</p>
        </div>
        <div class="bg-white shadow p-4 rounded text-center">
            <h2 class="text-xl font-bold">Produk Terjual</h2>
            <p class="text-2xl">{{ $jumlahProdukTerjual }}</p>
        </div>
        <div class="bg-white shadow p-4 rounded text-center">
            <h2 class="text-xl font-bold">Pendapatan Kotor</h2>
            <p class="text-2xl">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Grafik -->
    <div class="bg-white p-4 shadow rounded mb-6">
        <h3 class="text-lg font-bold mb-2">Grafik Penjualan</h3>
        <canvas id="grafikTransaksi"></canvas>
    </div>

    <!-- Produk Terlaris -->
    <div class="bg-white p-4 shadow rounded">
        <h3 class="text-lg font-bold mb-4">Produk Terlaris</h3>
        <table class="w-full text-left table-auto">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nama Produk</th>
                    <th class="px-4 py-2">Jumlah Terjual</th>
                    <th class="px-4 py-2">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produkTerlaris as $i => $produk)
                <tr>
                    <td class="px-4 py-2">{{ $i + 1 }}</td>
                    <td class="px-4 py-2">{{ $produk->nama_produk }}</td>
                    <td class="px-4 py-2">{{ $produk->total_terjual }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($produk->total_pendapatan, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikTransaksi').getContext('2d');
    const data = {
        labels: {!! json_encode($grafikTransaksi->pluck('periode')) !!},
        datasets: [
            {
                label: 'Jumlah Transaksi',
                data: {!! json_encode($grafikTransaksi->pluck('jumlah_transaksi')) !!},
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                fill: false,
                tension: 0.4
            },
            {
                label: 'Jumlah Produk',
                data: {!! json_encode($grafikTransaksi->pluck('jumlah_produk')) !!},
                borderColor: 'rgba(16, 185, 129, 1)',
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                fill: false,
                tension: 0.4
            }
        ]
    };

    new Chart(ctx, {
        type: 'line',
        data: data,
    });
</script>
@endsection
