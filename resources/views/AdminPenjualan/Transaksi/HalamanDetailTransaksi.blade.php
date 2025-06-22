@extends('layouts.Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <a href="{{ session('from_transaksi', url()->previous()) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        Kembali
    </a>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white">
            <h2 class="text-2xl font-bold">Detail Transaksi</h2>
            <p class="text-blue-100">ID Transaksi: {{ $transaksi->id }}</p>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Informasi Customer
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama:</span>
                            <span class="font-medium">{{ $transaksi->nama }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Telepon:</span>
                            <span class="font-medium">{{ $transaksi->no_telepon }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Alamat:</p>
                            <p class="font-medium">{{ $transaksi->alamat }}, {{ $transaksi->kelurahan }}, {{ $transaksi->kecamatan }}, {{ $transaksi->kota }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        Informasi Transaksi
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal:</span>
                            <span class="font-medium">{{ $transaksi->Tanggal_Transaksi }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium capitalize px-2 py-1 rounded-full text-xs
                                @if($transaksi->statustransaksi_id == 1) bg-yellow-100 text-yellow-800
                                @elseif($transaksi->statustransaksi_id == 2) bg-blue-100 text-blue-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ $transaksi->status_transaksi }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Metode Pengiriman:</span>
                            <span class="font-medium">{{ $transaksi->metode_pengiriman }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                        </svg>
                        Pembayaran
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kode:</span>
                            <span class="font-medium">{{ $transaksi->Kode_Pembayaran }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Produk:</span>
                            <span class="font-medium">Rp{{ number_format($detail_transaksi->sum(function($item) { return $item->Jumlah_Produk * $item->harga_satuan;} ), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Biaya Pengiriman:</span>
                            <span class="font-medium">Rp{{ number_format($transaksi->biaya_pengiriman, 0, ',', '.' )}}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Pembayaran:</span>
                            <span class="font-medium">Rp{{ number_format($detail_transaksi->sum(function($item) { return $item->Jumlah_Produk * $item->harga_satuan;} ) + ($transaksi->biaya_pengiriman), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Resi Paxel:</span>
                            <span class="font-medium">{{ $transaksi->nomor_resi }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Produk Dipesan</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($detail_transaksi as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->nama_produk }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                {{ $item->Jumlah_Produk }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                                Rp{{ number_format($item->Jumlah_Produk * $item->harga_satuan, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Total</td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-gray-900">
                                Rp{{ number_format($detail_transaksi->sum(function($item) { return $item->Jumlah_Produk * $item->harga_satuan; }), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if (auth()->user()->role_id == 1)
                <div class="mt-6 pt-6 border-t border-gray-200">

                    {{-- Jika status masih 1 (Menunggu Konfirmasi) --}}
                    @if ($transaksi->statustransaksi_id == 1)
                        <form action="{{ route('UbahStatusTransaksi', $transaksi->id) }}" method="POST">
                            @csrf
                            @method('POST')

                            <label for="statustransaksi_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Pilih Status Transaksi:
                            </label>
                            <select name="statustransaksi_id" id="statustransaksi_id"
                                class="block w-full max-w-xs rounded-md border-gray-300 shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500 mb-4">
                                <option value="2">Dibatalkan</option>
                                <option value="3">Diproses</option>
                            </select>

                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-1a1 1 0 011-1h2a1 1 0 011 1v1a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1V5a1 1 0 00-1-1H3z" />
                                </svg>
                                Ubah Status
                            </button>
                        </form>
                    @endif

                    {{-- Jika status sudah 3 (Diproses), tampilkan tombol ubah ke 4 (Dikirim) --}}
                    @if ($transaksi->statustransaksi_id == 3)
                        <form action="{{ route('UbahStatusTransaksi', $transaksi->id) }}" method="POST" class="mt-4">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="statustransaksi_id" value="4">
                            <button type="button" onclick="bukaModalResi('{{ route('UbahStatusTransaksi', $transaksi->id) }}')"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z" />
                                </svg>
                                Ubah Status ke Dikirim
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </div>

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
