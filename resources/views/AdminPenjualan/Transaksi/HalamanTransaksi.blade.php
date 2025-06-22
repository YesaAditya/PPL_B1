@extends('layouts.Admin')

@section('content')
<div class="p-6 max-w-6xl mx-auto bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Data Transaksi</h1>

    <form method="GET" action="{{ route('ShowDataTransaksi') }}" class="mb-6 flex items-center gap-4 bg-gray-50 p-4 rounded-lg">
        <label for="status" class="text-sm font-medium text-gray-700">Filter Status:</label>
        <select name="status" id="status" onchange="this.form.submit()"
                class="border border-gray-300 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            <option value="">-- Semua --</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Dicek</option>
            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Dibatalkan</option>
            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Diproses</option>
            <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>Dikirim</option>
            <option value="5" {{ request('status') == '5' ? 'selected' : '' }}>Selesai</option>
        </select>
    </form>

    <div class="overflow-x-auto rounded-lg border border-gray-900 shadow-sm">
        <table class="min-w-full divide-y divide-gray-900">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Kode Pembayaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Metode Pengiriman</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Detail</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Status Transaksi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Ubah Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($transaksis as $index => $trx)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600 hover:underline">
                        <a href="{{ route('ShowDetailTransaksi', ['id' => $trx->id]) }}">
                            {{ $index + 1 }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $trx->Kode_Pembayaran }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $trx->Tanggal_Transaksi }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $trx->metode_pengiriman }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><a href="{{ route('ShowDetailTransaksi', ['id' => $trx->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded shadow">Lihat Detail</a></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($trx->statustransaksi_id == 1) bg-yellow-100 text-yellow-800
                            @elseif($trx->statustransaksi_id == 2) bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ $trx->status_transaksi }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if ($trx->statustransaksi_id == 1) {{-- Dicek --}}
                            <form action="{{ route('UbahStatusTransaksi', $trx->id) }}" method="POST">
                                @csrf
                                <select name="statustransaksi_id"
                                        onchange="this.form.submit()"
                                        class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Pilih Aksi --</option>
                                    <option value="2">Tandai Dibatalkan</option>
                                    <option value="3">Tandai Diproses</option>
                                </select>
                            </form>
                        @elseif ($trx->statustransaksi_id == 3) {{-- Diproses --}}
                            <button onclick="bukaModalResi('{{ route('UbahStatusTransaksi', $trx->id) }}')"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-sm transition">
                                Tandai Dikirim
                            </button>
                        @else
                            <p class="text-center">-</p>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal Input Resi -->
        <div id="modalResi" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 hidden">
            <div class="bg-white p-6 rounded-lg w-full max-w-md shadow-lg">
                <h2 class="text-lg font-semibold mb-4">Masukkan Nomor Resi</h2>
                <form id="formResi" method="POST">
                    @csrf
                    <input type="hidden" name="statustransaksi_id" value="4">
                    <div class="mb-4">
                        <label for="nomor_resi" class="block text-sm font-medium text-gray-700">Nomor Resi:</label>
                        <input type="text" name="nomor_resi" id="nomor_resi" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="tutupModalResi()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function bukaModalResi(formActionUrl) {
        const modal = document.getElementById('modalResi');
        const form = document.getElementById('formResi');
        modal.classList.remove('hidden');
        form.action = formActionUrl;
        document.body.classList.add('overflow-hidden');
    }

    function tutupModalResi() {
        document.getElementById('modalResi').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>


@endsection
