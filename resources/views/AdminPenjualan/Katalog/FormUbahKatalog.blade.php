@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<h1 class="text-3xl font-bold text-center mb-10">Edit Produk</h1>

<form action="{{ route('admin.katalog.update', $katalog->id) }}" method="POST" enctype="multipart/form-data" id="editProductForm" class="max-w-xl mx-auto bg-white p-10 rounded-2xl shadow-md">
    @csrf
    @method('PUT')

    {{-- Nama Produk --}}
    <div class="mb-6">
        <label for="nama_produk" class="block mb-2 font-medium text-secondary">Nama Produk</label>
        <input type="text" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $katalog->nama_produk) }}" required
            class="w-full border border-gray-300 p-3 rounded-md focus:ring-2 focus:ring-accent focus:outline-none">
    </div>

    {{-- Deskripsi --}}
    <div class="mb-6">
        <label for="deskripsi" class="block mb-2 font-medium text-secondary">Deskripsi Produk</label>
        <textarea id="deskripsi" name="deskripsi" rows="3" required
            class="w-full border border-gray-300 p-3 rounded-md focus:ring-2 focus:ring-accent focus:outline-none">{{ old('deskripsi', $katalog->deskripsi) }}</textarea>
    </div>

    {{-- Harga --}}
    <div class="mb-6">
        <label for="harga" class="block mb-2 font-medium text-secondary">Harga (Rp)</label>
        <input type="number" id="harga" name="harga" value="{{ old('harga', $katalog->harga) }}" required
            class="w-full border border-gray-300 p-3 rounded-md focus:ring-2 focus:ring-accent focus:outline-none">
    </div>

    {{-- Stok --}}
    <div class="mb-6">
        <label for="stok" class="block mb-2 font-medium text-secondary">Stok</label>
        <input type="number" id="stok" name="stok" value="{{ old('stok', $katalog->stok) }}" required
            class="w-full border border-gray-300 p-3 rounded-md focus:ring-2 focus:ring-accent focus:outline-none">
    </div>

    {{-- Foto --}}
    <div class="mb-6">
        <label for="foto" class="block mb-2 font-medium text-secondary">Gambar Produk</label>
        <input type="file" id="fotoInput" name="foto" accept="image/*" 
            class="w-full border border-gray-300 p-3 rounded-md bg-white">
        <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah gambar (Max 2MB, format: JPEG/PNG)</p>
        
        {{-- Error message --}}
        <div id="fileError" class="text-red-500 text-sm mt-1 hidden"></div>
        
        {{-- Image preview container --}}
        <div id="imagePreviewContainer" class="mt-4 flex items-center space-x-4">
            @if($katalog->foto)
                {{-- Current image --}}
                <div class="relative">
                    <img src="{{ asset('storage/' . $katalog->foto) }}" alt="Foto Lama" 
                        class="w-32 h-32 object-cover rounded-md shadow border">
                    <span class="absolute top-0 left-0 bg-gray-800 text-white text-xs px-2 py-1 rounded-br-md">Foto Saat Ini</span>
                </div>
                
                {{-- New image preview (hidden by default) --}}
                <div id="newImagePreview" class="hidden relative">
                    <img id="previewImage" src="#" alt="Preview Gambar Baru" 
                        class="w-32 h-32 object-cover rounded-md shadow border">
                    <span class="absolute top-0 left-0 bg-blue-600 text-white text-xs px-2 py-1 rounded-br-md">Foto Baru</span>
                </div>
            @else
                {{-- Only show new preview if no existing image --}}
                <div id="newImagePreview" class="hidden">
                    <img id="previewImage" src="#" alt="Preview Gambar" 
                        class="w-32 h-32 object-cover rounded-md shadow border">
                </div>
            @endif
        </div>
    </div>

    <button type="submit" class="bg-secondary text-white px-6 py-3 rounded-lg hover:bg-secondary/90 transition">
        Perbarui Produk
    </button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fotoInput = document.getElementById('fotoInput');
    const fileError = document.getElementById('fileError');
    const previewImage = document.getElementById('previewImage');
    const newImagePreview = document.getElementById('newImagePreview');
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
                if (newImagePreview) newImagePreview.classList.add('hidden');
                return;
            }


            if (file.size > maxSize) {
                fileError.textContent = 'Ukuran file melebihi 2MB. Silakan pilih file yang lebih kecil.';
                fileError.classList.remove('hidden');
                fotoInput.value = '';
                if (newImagePreview) newImagePreview.classList.add('hidden');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                if (newImagePreview) newImagePreview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            if (newImagePreview) newImagePreview.classList.add('hidden');
        }
    });
    
    document.getElementById('editProductForm').addEventListener('submit', function(e) {
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