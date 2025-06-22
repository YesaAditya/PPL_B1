@extends('layouts.Customer')

@section('content')
<form id="transactionForm" action="{{ route('KlikBuatPesanan') }}" method="POST">
    @csrf

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="p-4 bg-white rounded shadow-md max-w-xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Form Transaksi</h1>

        {{-- Alamat Pengiriman --}}
        <div class="mb-6 bg-white p-5 rounded-lg shadow-sm border border-gray-100">
            <h3 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Data Pengiriman
            </h3>

            <div class="space-y-3">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <div>
                        <p class="font-medium text-gray-800">{{ $profil->nama ?? '-' }}</p>
                        <p class="text-gray-600">{{ $profil->no_telepon ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        <p class="text-gray-800">{{ $profil->alamat ?? '-' }}</p>
                        <p class="text-gray-600">{{ $profil->kelurahan ?? '' }}, {{ $profil->kecamatan ?? '' }}</p>
                        <p class="text-gray-600">{{ $profil->kota ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Produk --}}
        <div class="mb-6">
            <h3 class="font-semibold text-lg text-gray-800 mb-4">Produk yang Dibeli</h3>

            <div class="space-y-3" id="product-list">
                @foreach($katalog as $index => $item)
                <div class="flex items-center justify-between bg-white p-4 rounded-lg border border-gray-200 shadow-sm product-item" data-id="{{ $item->id }}">
                    <div class="flex-1 min-w-0">
                        <h4 class="font-medium text-gray-800 truncate">{{ $item->nama_produk }}</h4>
                        <p class="text-sm text-gray-600">Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
                    </div>

                    <div class="flex items-center space-x-3 ml-4">
                        <div class="flex items-center border rounded-md">
                            <button type="button" onclick="decreaseQty({{ $index }})" class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-l-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <input type="number" name="jumlah_produk[]" id="qty-{{ $index }}"
                                value="1" min="1"
                                class="w-12 py-1 text-center border-x border-gray-200 focus:ring-1 focus:ring-blue-500">
                            <button type="button" onclick="increaseQty({{ $index }})" class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-r-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </button>
                        </div>

                        <button type="button" onclick="removeProduct(this)" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>

                    <input type="hidden" name="katalog_id[]" value="{{ $item->id }}">
                    <input type="hidden" name="harga_produk[]" value="{{ $item->harga }}" class="product-price">
                </div>
                @endforeach
            </div>
        </div>

        {{-- Ringkasan Pembayaran --}}
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 mb-6">
            <h3 class="font-semibold text-lg text-gray-800 mb-3">Ringkasan Pembayaran</h3>

            <div class="space-y-2 mb-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal Produk</span>
                    <span class="font-medium">Rp<span id="subtotalProduk">0</span></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Ongkos Kirim (Online)</span>
                    <span class="font-medium">Rp<span id="shippingCost">0</span></span>
                </div>
            </div>

            <div class="border-t border-blue-200 pt-3">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-800">Total Pembayaran</span>
                    <span class="text-xl font-bold text-blue-600">Rp<span id="totalHarga">0</span></span>
                </div>
            </div>
        </div>

        {{-- Hidden Input untuk Metode Pengiriman --}}
        <input type="hidden" name="metodepengiriman_id" value="2"> <!-- ID 2 untuk Online -->
        <input type="hidden" name="statustransaksi_id" value="2">

        {{-- Submit Button --}}
        <button type="submit" id="submitBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">
            Buat Pesanan
        </button>
    </div>
</form>

<!-- Midtrans JS SDK -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script>
    // Daftar ongkir per kota
    const ongkirPerKota = {
        'KABUPATEN PACITAN': 35000,
        'KABUPATEN PONOROGO': 33000,
        'KABUPATEN TRENGGALEK': 29000,
        'KABUPATEN TULUNGAGUNG': 27500,
        'KABUPATEN BLITAR': 23000,
        'KABUPATEN KEDIRI': 27000,
        'KABUPATEN MALANG': 21000,
        'KABUPATEN LUMAJANG': 17000,
        'KABUPATEN JEMBER': 12000,
        'KABUPATEN BANYUWANGI': 18000,
        'KABUPATEN BONDOWOSO': 15000,
        'KABUPATEN SITUBONDO': 17000,
        'KABUPATEN PROBOLINGGO': 25000,
        'KABUPATEN PASURUAN': 23000,
        'KABUPATEN SIDOARJO': 25500,
        'KABUPATEN MOJOKERTO': 25000,
        'KABUPATEN JOMBANG': 27000,
        'KABUPATEN NGANJUK': 28000,
        'KABUPATEN MADIUN': 30000,
        'KABUPATEN MAGETAN': 34000,
        'KABUPATEN NGAWI': 36000,
        'KABUPATEN BOJONEGORO': 32000,
        'KABUPATEN TUBAN': 33500,
        'KABUPATEN LAMONGAN': 29000,
        'KABUPATEN GRESIK': 27000,
        'KABUPATEN BANGKALAN': 30000,
        'KABUPATEN SAMPANG': 32000,
        'KABUPATEN PAMEKASAN': 33000,
        'KABUPATEN SUMENEP': 34500,
        'KOTA KEDIRI': 27000,
        'KOTA BLITAR': 23000,
        'KOTA MALANG': 21000,
        'KOTA PROBOLINGGO': 25000,
        'KOTA PASURUAN': 23000,
        'KOTA MOJOKERTO': 25000,
        'KOTA MADIUN': 30000,
        'KOTA SURABAYA': 26500,
        'KOTA BATU': 21500,
    };

    function calculateShipping(kota, jumlahProduk) {
        if (!kota || kota.trim() === '') {
            console.error('Kota tidak ditemukan');
            return 0;
        }

        const beratKg = Math.ceil(jumlahProduk / 3);
        const normalizedKota = kota.toUpperCase().trim();

        for (const [namaKota, harga] of Object.entries(ongkirPerKota)) {
            if (normalizedKota.includes(namaKota.toUpperCase().trim())) {
                return harga * beratKg;
            }
        }

        return 20000 * beratKg;
    }

    function updateAllCalculations() {
        // Hitung subtotal produk
        let subtotal = 0;
        let totalItems = 0;
        const hargaInputs = document.getElementsByName('harga_produk[]');
        const jumlahInputs = document.getElementsByName('jumlah_produk[]');

        for (let i = 0; i < hargaInputs.length; i++) {
            const harga = parseInt(hargaInputs[i].value) || 0;
            const jumlah = parseInt(jumlahInputs[i].value) || 1;
            subtotal += harga * jumlah;
            totalItems += jumlah;
        }

        // Hitung ongkir otomatis
        const kota = "{{ $profil->kota ?? '' }}";
        const shippingCost = calculateShipping(kota, totalItems);

        // Update tampilan
        document.getElementById('subtotalProduk').textContent = subtotal.toLocaleString('id-ID');
        document.getElementById('shippingCost').textContent = shippingCost.toLocaleString('id-ID');

        // Hitung total akhir
        const total = subtotal + shippingCost;
        document.getElementById('totalHarga').textContent = total.toLocaleString('id-ID');

        return total;
    }

    function increaseQty(index) {
        const qtyInput = document.getElementById('qty-' + index);
        qtyInput.value = parseInt(qtyInput.value) + 1;
        updateAllCalculations();
    }

    function decreaseQty(index) {
        const qtyInput = document.getElementById('qty-' + index);
        if (qtyInput.value > 1) {
            qtyInput.value = parseInt(qtyInput.value) - 1;
            updateAllCalculations();
        }
    }

    function removeProduct(button) {
        const productItem = button.closest('.product-item');
        if (productItem) {
            productItem.remove();
            updateAllCalculations();
        }
    }

    // Handle form submission
    document.getElementById('transactionForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Memproses...';

        const totalAmount = updateAllCalculations();
        const kota = "{{ $profil->kota ?? '' }}";
        const jumlahProduk = document.getElementsByName('jumlah_produk[]').length;

        const formData = new FormData(this);
        formData.append('total_amount', totalAmount);

        //AJAX snap token
        fetch(this.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.snap_token) {
                //Midtrans Snap payment
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = "{{ route('TransaksiCustomer') }}?payment=success";
                    },
                    onPending: function(result) {
                        window.location.href = "{{ route('TransaksiCustomer') }}?payment=pending";
                    },
                    onError: function(result) {
                        window.location.href = "{{ route('ShowDataKatalog') }}?payment=failed";
                    },
                    onClose: function() {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Buat Pesanan';
                    }
                });
            } else {
                alert('Gagal mendapatkan token pembayaran');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Buat Pesanan';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses pembayaran');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Buat Pesanan';
        });
    });

    // Inisialisasi saat dokumen siap
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[name="jumlah_produk[]"]').forEach(input => {
            input.addEventListener('change', updateAllCalculations);
            input.addEventListener('input', function() {
                if (this.value < 1) this.value = 1;
                updateAllCalculations();
            });
        });

        updateAllCalculations();
    });
</script>
@endsection
