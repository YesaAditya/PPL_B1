@extends('layouts.Admin')

@section('content')
<form action="{{ Route('KlikSimpan') }}" method="POST">
    @csrf

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif


    <div class="p-6 bg-white rounded-xl">
        <h1 class="text-2xl font-bold mb-6">Kasir</h1>

        <div id="produk-terpilih-container" class="mb-6">
            <table class="w-full text-left border-collapse" id="produk-terpilih-table">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Produk</th>
                        <th class="px-4 py-2">Harga Satuan</th>
                        <th class="px-4 py-2">Jumlah</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="produk-terpilih-body">
                    <tr id="pesan-kosong">
                        <td colspan="5" class="text-center text-gray-500 py-4">Belum ada produk dipilih.</td>
                    </tr>
                </tbody>
            </table>
            <div class="text-right mt-2 font-semibold hidden" id="total-harga-wrapper">
                Total Semua: <span id="total-harga">Rp0</span>
            </div>
        </div>

        <button type="button" onclick="openModal()" class="bg-green-600 text-white px-4 py-2 rounded mb-4 w-full">
            + Tambah Produk
        </button>

        <div class="flex justify-end">
            <button type="submit" class="flex justify-end bg-blue-600 text-white px-6 py-2 rounded shadow-md hover:bg-blue-700">
                Buat Pesanan
            </button>
        </div>
    </div>
</form>

<!-- Modal Produk -->
<div id="modalProduk" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded w-full max-w-xl">
        <h2 class="text-xl font-bold mb-4">Pilih Produk</h2>
        <form id="formProduk">
            <div class="space-y-2 max-h-64 overflow-y-auto">

                @foreach($katalogs as $katalog)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="produk[]" value="{{ $katalog->id }}"
                            data-nama="{{ $katalog->nama_produk }}"
                            data-harga="{{ $katalog->harga }}">
                        <span>{{ $katalog->nama_produk }} - Rp{{ number_format($katalog->harga, 0, ',', '.') }}</span>
                    </label>
                @endforeach
            </div>
            <div class="mt-4 text-right">
                <button type="button" onclick="tutupModal()" class="mr-2 px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="button" onclick="simpanProduk()" class="px-4 py-2 bg-blue-600 text-white rounded">OK</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modalProduk').classList.remove('hidden');
    }

    function tutupModal() {
        document.getElementById('modalProduk').classList.add('hidden');
    }

    function simpanProduk() {
        const checkboxes = document.querySelectorAll('#formProduk input[name="produk[]"]:checked');
        const tbody = document.getElementById('produk-terpilih-body');
        const totalWrapper = document.getElementById('total-harga-wrapper');
        const pesanKosong = document.getElementById('pesan-kosong');

        let produkDitambahkan = false;

        checkboxes.forEach(cb => {
            if (document.getElementById('row-' + cb.value)) return;

            produkDitambahkan = true;

            const id = cb.value;
            const nama = cb.dataset.nama;
            const harga = parseInt(cb.dataset.harga);

            const row = document.createElement('tr');
            row.id = 'row-' + id;

            row.innerHTML = `
                <td class="px-4 py-2">${nama}
                    <input type="hidden" name="produk_terpilih[]" value="${id}">
                </td>
                <td class="px-4 py-2">Rp${harga.toLocaleString('id-ID')}</td>
                <td class="px-4 py-2 flex items-center gap-1">
                    <button type="button" onclick="ubahJumlah(${id}, -1, ${harga})"
                        class="bg-gray-300 px-2 py-1 rounded">-</button>
                    <input type="number" name="jumlah_produk[${id}]" id="jumlah-${id}" value="1"
                        min="1" class="w-12 text-center border rounded">
                    <button type="button" onclick="ubahJumlah(${id}, 1, ${harga})"
                        class="bg-gray-300 px-2 py-1 rounded">+</button>
                </td>
                <td class="px-4 py-2">
                    <span id="label-harga-${id}">Rp${harga.toLocaleString('id-ID')}</span>
                    <input type="hidden" name="harga_total[${id}]" id="harga-${id}" value="${harga}">
                </td>
                <td class="px-4 py-2 text-center">
                    <button type="button" onclick="hapusProduk(${id})" class="text-red-600 hover:text-red-800">
                        🗑️
                    </button>
                </td>
            `;

            tbody.appendChild(row);
        });

        if (produkDitambahkan) {
            if (pesanKosong) pesanKosong.remove();
            totalWrapper.classList.remove('hidden');
        }

        updateTotalHargaKeseluruhan();
        tutupModal();
    }

    function hapusProduk(id) {
        const row = document.getElementById('row-' + id);
        if (row) {
            row.remove();
            updateTotalHargaKeseluruhan();

            const tbody = document.getElementById('produk-terpilih-body');
            const totalWrapper = document.getElementById('total-harga-wrapper');

            if (tbody.querySelectorAll('tr[id^="row-"]').length === 0) {
                tampilkanPesanKosong();
                totalWrapper.classList.add('hidden');
            }
        }
    }

    function ubahJumlah(id, delta, hargaSatuan) {
        const jumlahInput = document.getElementById('jumlah-' + id);
        let jumlah = parseInt(jumlahInput.value);

        jumlah = isNaN(jumlah) ? 1 : jumlah + delta;
        if (jumlah < 1) jumlah = 1;

        jumlahInput.value = jumlah;

        const total = hargaSatuan * jumlah;
        document.getElementById('harga-' + id).value = total;
        document.getElementById('label-harga-' + id).textContent = 'Rp' + total.toLocaleString('id-ID');

        updateTotalHargaKeseluruhan();
    }

    function updateTotalHargaKeseluruhan() {
        const hargaInputs = document.querySelectorAll('input[id^="harga-"]');
        let total = 0;

        hargaInputs.forEach(input => {
            total += parseInt(input.value);
        });

        document.getElementById('total-harga').textContent = 'Rp' + total.toLocaleString('id-ID');
    }

    function tampilkanPesanKosong() {
        const tbody = document.getElementById('produk-terpilih-body');
        const rowKosong = document.createElement('tr');
        rowKosong.id = 'pesan-kosong';
        rowKosong.innerHTML = `
            <td colspan="5" class="text-center text-gray-500 py-4">Belum ada produk dipilih.</td>
        `;
        tbody.appendChild(rowKosong);

    document.querySelector('form').addEventListener('submit', function(e) {
        const inputProduk = document.querySelectorAll('input[name="produk_terpilih[]"]');
        if (inputProduk.length === 0) {
            e.preventDefault();
            alert('Silakan pilih minimal satu produk terlebih dahulu!');
        }
    });

    }
</script>
@endsection
