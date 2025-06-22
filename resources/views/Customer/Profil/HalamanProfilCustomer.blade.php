@extends('layouts.customer', ['hideNavbar' => true])

@section('content')
<div class="flex items-center justify-center min-h-screen bg-lightbg">
    <div class="w-[600px] mt-[-100px]">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="bg-white rounded-lg shadow-md flex p-5">
            <div class="w-[200px] flex flex-col items-center">
                <div class="flex flex-col w-full p-4">
                    <button onclick="openModal('modalEditProfil')"
                        class="p-2 bg-primary rounded text-white cursor-pointer w-full my-1">
                        Ubah Profil
                    </button>
                    <a href="{{ route('KlikAkun') }}">
                        <button class="p-2 bg-primary rounded text-white cursor-pointer w-full my-1">Akun</button>
                    </a>
                </div>
            </div>
            <div class="flex-1 mr-5">
                <div class="mb-3">
                    <label class="block font-semibold">Nama Lengkap</label>
                    <p class="p-2 bg-gray-100 rounded">{{ $profil->nama }}</p>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold">No. Telepon</label>
                    <p class="p-2 bg-gray-100 rounded">{{ $profil->no_telepon ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold">Kabupaten/Kota</label>
                    <p class="p-2 bg-gray-100 rounded">{{ $profil->kota ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold">Kecamatan</label>
                    <p class="p-2 bg-gray-100 rounded">{{ $profil->kecamatan ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold">Kelurahan/Desa</label>
                    <p class="p-2 bg-gray-100 rounded">{{ $profil->kelurahan ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="block font-semibold">Alamat Lengkap</label>
                    <p class="p-2 bg-gray-100 rounded">{{ $profil->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div id="modalEditProfil" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 max-h-[80vh] overflow-y-auto">
        <form id="formEditProfil" action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Edit Profil</h3>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ $profil->nama }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('nama')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">No. Telepon</label>
                        <input type="text" name="no_telepon" value="{{ $profil->no_telepon ?? '' }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('no_telepon')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Wilayah Selector -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Kota/Kabupaten</label>
                        <select id="kota" name="kota" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Kota/Kabupaten</option>
                            @if($profil->kota)
                                <option value="{{ $profil->kota }}" selected data-is-old="true">{{ $profil->kota }}</option>
                            @endif
                        </select>
                        @error('kota')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Kecamatan</label>
                        <select id="kecamatan" name="kecamatan" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Kecamatan</option>
                            @if($profil->kecamatan)
                                <option value="{{ $profil->kecamatan }}" selected data-is-old="true">{{ $profil->kecamatan }}</option>
                            @endif
                        </select>
                        @error('kecamatan')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Kelurahan/Desa</label>
                        <select id="kelurahan" name="kelurahan" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Kelurahan/Desa</option>
                            @if($profil->kelurahan)
                                <option value="{{ $profil->kelurahan }}" selected data-is-old="true">{{ $profil->kelurahan }}</option>
                            @endif
                        </select>
                        @error('kelurahan')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Alamat Lengkap</label>
                        <textarea name="alamat"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="3">{{ $profil->alamat ?? '' }}</textarea>
                        @error('alamat')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                <button type="button" onclick="closeModal('modalEditProfil')"
                    class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi modal
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Script untuk wilayah
    // Script untuk wilayah yang saling terkait
    document.addEventListener("DOMContentLoaded", async function () {
        const kotaSelect = document.getElementById("kota");
        const kecamatanSelect = document.getElementById("kecamatan");
        const kelurahanSelect = document.getElementById("kelurahan");

        // Data yang sudah ada
        const existingData = {
            kota: "{{ $profil->kota ?? '' }}",
            kecamatan: "{{ $profil->kecamatan ?? '' }}",
            kelurahan: "{{ $profil->kelurahan ?? '' }}"
        };

        // Cache untuk data wilayah
        const wilayahCache = {
            kota: [],
            kecamatan: [],
            kelurahan: []
        };

        // Fungsi reset select kecamatan dan kelurahan
        function resetKecamatan() {
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            resetKelurahan();
        }

        function resetKelurahan() {
            kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
        }

        // Fungsi untuk memeriksa apakah opsi sudah ada
        function optionExists(selectElement, value) {
            return Array.from(selectElement.options).some(opt => opt.value === value);
        }

        async function loadKota() {
            try {
                const response = await fetch("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/35.json");
                const data = await response.json();
                wilayahCache.kota = data;

                // Reset select kota
                kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';

                // Tambahkan opsi baru
                data.forEach(kota => {
                    const option = new Option(kota.name, kota.name);
                    option.dataset.id = kota.id;
                    kotaSelect.add(option);
                });

                // Set nilai yang sudah ada jika ada
                if (existingData.kota) {
                    kotaSelect.value = existingData.kota;
                    await loadKecamatan(existingData.kota);
                }
            } catch (error) {
                console.error("Gagal memuat data kota:", error);
                if (existingData.kota) {
                    const option = new Option(existingData.kota, existingData.kota);
                    option.dataset.isOld = "true";
                    kotaSelect.add(option);
                    kotaSelect.value = existingData.kota;
                }
            }
        }

        async function loadKecamatan(kotaName) {
            try {
                const kota = wilayahCache.kota.find(k => k.name === kotaName);
                if (!kota) {
                    resetKecamatan();
                    return;
                }

                const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kota.id}.json`);
                const data = await response.json();
                wilayahCache.kecamatan = data;

                // Reset select kecamatan
                kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

                // Tambahkan opsi baru
                data.forEach(kec => {
                    const option = new Option(kec.name, kec.name);
                    option.dataset.id = kec.id;
                    kecamatanSelect.add(option);
                });

                // Set nilai yang sudah ada jika ada dan masih valid
                if (existingData.kecamatan && data.some(k => k.name === existingData.kecamatan)) {
                    kecamatanSelect.value = existingData.kecamatan;
                    await loadKelurahan(existingData.kecamatan);
                } else if (kecamatanSelect.querySelector('[data-is-old]')) {
                    kecamatanSelect.value = existingData.kecamatan;
                }
            } catch (error) {
                console.error("Gagal memuat data kecamatan:", error);
                resetKecamatan();
                if (existingData.kecamatan) {
                    const option = new Option(existingData.kecamatan, existingData.kecamatan);
                    option.dataset.isOld = "true";
                    kecamatanSelect.add(option);
                    kecamatanSelect.value = existingData.kecamatan;
                }
            }
        }

        async function loadKelurahan(kecamatanName) {
            try {
                const kecamatan = wilayahCache.kecamatan.find(k => k.name === kecamatanName);
                if (!kecamatan) {
                    resetKelurahan();
                    return;
                }

                const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecamatan.id}.json`);
                const data = await response.json();
                wilayahCache.kelurahan = data;

                // Reset select kelurahan
                kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';

                // Tambahkan opsi baru
                data.forEach(kel => {
                    const option = new Option(kel.name, kel.name);
                    kelurahanSelect.add(option);
                });

                // Set nilai yang sudah ada jika ada dan masih valid
                if (existingData.kelurahan && data.some(k => k.name === existingData.kelurahan)) {
                    kelurahanSelect.value = existingData.kelurahan;
                } else if (kelurahanSelect.querySelector('[data-is-old]')) {
                    kelurahanSelect.value = existingData.kelurahan;
                }
            } catch (error) {
                console.error("Gagal memuat data kelurahan:", error);
                resetKelurahan();
                if (existingData.kelurahan) {
                    const option = new Option(existingData.kelurahan, existingData.kelurahan);
                    option.dataset.isOld = "true";
                    kelurahanSelect.add(option);
                    kelurahanSelect.value = existingData.kelurahan;
                }
            }
        }

        // Event listeners
        kotaSelect.addEventListener("change", async () => {
            if (kotaSelect.value) {
                await loadKecamatan(kotaSelect.value);
            } else {
                resetKecamatan();
            }
        });

        kecamatanSelect.addEventListener("change", async () => {
            if (kecamatanSelect.value) {
                await loadKelurahan(kecamatanSelect.value);
            } else {
                resetKelurahan();
            }
        });

        // Inisialisasi
        await loadKota();
    });
</script>
@endsection
