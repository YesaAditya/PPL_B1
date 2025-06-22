@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md p-6">
        <h1 class="text-2xl font-bold text-secondary mb-6">Tambah Produk Baru</h1>

        <form action="{{ route('admin.katalog.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf

            <!-- Nama Produk -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent" required>
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent" required>{{ old('deskripsi') }}</textarea>
            </div>

            <!-- Harga dan Stok -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2">Harga (Rp)</label>
                    <input type="number" name="harga" min="0" step="0.01" value="{{ old('harga') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Stok</label>
                    <input type="number" name="stok" min="0" value="{{ old('stok') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent" required>
                </div>
            </div>

            <!-- Foto Produk -->
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Foto Produk</label>
                <input type="file" name="foto" id="fotoInput" accept="image/*" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-accent" required>
                <p class="text-sm text-gray-500 mt-1">Format: JPEG/PNG (Max 2MB)</p>
                <div id="fileError" class="text-red-500 text-sm mt-1 hidden"></div>
                <div id="filePreview" class="mt-2 hidden">
                    <img id="previewImage" class="h-32 rounded-lg border" src="#" alt="Preview gambar">
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" class="bg-secondary hover:bg-secondary/90 text-white px-6 py-2 rounded-lg transition duration-300">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fotoInput = document.getElementById('fotoInput');
    const fileError = document.getElementById('fileError');
    const filePreview = document.getElementById('filePreview');
    const previewImage = document.getElementById('previewImage');
    const maxSize = 2 * 1024 * 1024; // 2MB in bytes

    fotoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        fileError.classList.add('hidden');
        
        if (file) {

            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                fileError.textContent = 'Format file tidak valid. Harus JPEG/PNG.';
                fileError.classList.remove('hidden');
                fotoInput.value = '';
                filePreview.classList.add('hidden');
                return;
            }

            if (file.size > maxSize) {
                fileError.textContent = 'Ukuran file melebihi 2MB. Silakan pilih file yang lebih kecil.';
                fileError.classList.remove('hidden');
                fotoInput.value = '';
                filePreview.classList.add('hidden');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                filePreview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            filePreview.classList.add('hidden');
        }
    });

    document.getElementById('productForm').addEventListener('submit', function(e) {
        const file = fotoInput.files[0];
        
        if (file && file.size > maxSize) {
            e.preventDefault();
            fileError.textContent = 'Ukuran file melebihi 2MB. Silakan pilih file yang lebih kecil.';
            fileError.classList.remove('hidden');
            return false;
        }
    });
});
</script>

@endsection