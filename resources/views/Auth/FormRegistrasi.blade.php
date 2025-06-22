<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cyan-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-4xl">
        <h1 class="text-2xl font-bold text-gray-800 mb-2 text-center">Registrasi</h1>
        <p class="text-gray-500 mb-6 text-center">
            Lengkapi informasi di bawah ini untuk membuat akun baru
        </p>

        <!-- Notifikasi Error -->
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Notifikasi Sukses -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <form id="registrationForm" method="POST" action="{{ route('KlikRegistrasi') }}" class="mt-4">
            @csrf
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Kolom kiri: Data Pribadi -->
                <div class="flex-1 space-y-4">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                            placeholder="Masukkan nama lengkap"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">No. Handphone</label>
                        <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required
                            placeholder="Masukkan nomor handphone"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            placeholder="Masukkan email"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="password" name="password" required
                            placeholder="Masukkan password"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            placeholder="Masukkan ulang password"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="flex items-center mt-2">
                        <input type="checkbox" id="show-password" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="show-password" class="ml-2 text-sm text-gray-700">Tampilkan kata sandi</label>
                    </div>
                </div>

                <!-- Kolom kanan: Data Alamat -->
                <div class="flex-1 space-y-4">
                    <div>
                        <label for="kota" class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten</label>
                        <select id="kota" name="kota" required
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500">
                            <option value="" selected data-is-old="true">Pilih Kota/Kabupaten</option>
                        </select>
                    </div>

                    <div>
                        <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                        <select id="kecamatan" name="kecamatan" required
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500">
                            <option value="" selected data-is-old="true">Pilih Kecamatan</option>
                        </select>
                    </div>

                    <div>
                        <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-1">Desa/Kelurahan</label>
                        <select id="kelurahan" name="kelurahan" required
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500">
                            <option value="" selected data-is-old="true">Pilih Desa/Kelurahan</option>
                        </select>
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" required
                            placeholder="Masukkan alamat lengkap"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Hidden inputs -->
            <input type="hidden" name="kota_nama" id="kota_nama">
            <input type="hidden" name="kecamatan_nama" id="kecamatan_nama">
            <input type="hidden" name="kelurahan_nama" id="kelurahan_nama">

            <button type="submit"
                class="w-full mt-6 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md shadow-sm transition">
                Submit Registrasi
            </button>
        </form>
    </div>

    <!-- Modal Pop-Up Notifikasi -->
    <div id="successModal" class="fixed inset-0 hidden items-center justify-center bg-cyan-50 bg-opacity-50 z-50">
        <div class="bg-white rounded-lg p-6 max-w-sm w-full shadow-lg text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Tunggu sebentar yaa</h2>
            <p class="text-gray-600 mb-4">Dicek dulu apakah data valid:></p>
            <button id="closeModalButton" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition">
                OK
            </button>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", async function () {
    const kotaSelect = document.getElementById("kota");
    const kecamatanSelect = document.getElementById("kecamatan");
    const kelurahanSelect = document.getElementById("kelurahan");

    const kotaNama = document.getElementById("kota_nama");
    const kecamatanNama = document.getElementById("kecamatan_nama");
    const kelurahanNama = document.getElementById("kelurahan_nama");

    const showPassword = document.getElementById("show-password");
    const password = document.getElementById("password");
    const confirm = document.getElementById("password_confirmation");

    const successModal = document.getElementById("successModal");
    const closeModalButton = document.getElementById("closeModalButton");

    showPassword.addEventListener("change", () => {
        const type = showPassword.checked ? "text" : "password";
        password.type = type;
        confirm.type = type;
    });

    document.getElementById("registrationForm").addEventListener("submit", function (event) {
        const email = document.getElementById("email").value;
        const noTelepon = document.getElementById("no_telepon").value;

        // Validasi email harus @gmail.com
        if (!email.endsWith("@gmail.com")) {
            alert("Email harus diakhiri dengan '@gmail.com'");
            event.preventDefault();
            return;
        }

        // Validasi nomor telepon hanya angka
        if (!/^\d+$/.test(noTelepon)) {
            alert("Nomor telepon hanya boleh berupa angka");
            event.preventDefault();
            return;
        }

        // Jika validasi lolos, tampilkan modal pop-up
        successModal.classList.remove("hidden");
        successModal.classList.add("flex");
    });

    closeModalButton.addEventListener("click", function () {
        successModal.classList.add("hidden");
        window.location.href = "{{route('KlikLogin')}}";
    });

    async function fetchWilayah(url) {
        const response = await fetch(url);
        return await response.json();
    }

    async function loadKota() {
        const data = await fetchWilayah("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/35.json");
        kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
        data.forEach(k => {
            kotaSelect.innerHTML += `<option value="${k.id}">${k.name}</option>`;
        });
    }

    async function loadKecamatan(kotaId) {
        const data = await fetchWilayah(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kotaId}.json`);
        kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        kelurahanSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
        data.forEach(k => {
            kecamatanSelect.innerHTML += `<option value="${k.id}">${k.name}</option>`;
        });
    }

    async function loadKelurahan(kecamatanId) {
        const data = await fetchWilayah(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecamatanId}.json`);
        kelurahanSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
        data.forEach(k => {
            kelurahanSelect.innerHTML += `<option value="${k.id}">${k.name}</option>`;
        });
    }

    kotaSelect.addEventListener("change", () => {
        const selected = kotaSelect.options[kotaSelect.selectedIndex];
        kotaNama.value = selected.text;
        loadKecamatan(kotaSelect.value);
    });

    kecamatanSelect.addEventListener("change", () => {
        const selected = kecamatanSelect.options[kecamatanSelect.selectedIndex];
        kecamatanNama.value = selected.text;
        loadKelurahan(kecamatanSelect.value);
    });

    kelurahanSelect.addEventListener("change", () => {
        const selected = kelurahanSelect.options[kelurahanSelect.selectedIndex];
        kelurahanNama.value = selected.text;
    });

    loadKota();
    });

    </script>

</body>
</html>
