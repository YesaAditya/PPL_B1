@extends('layouts.customer', ['hideNavbar' => true])

@section('content')
<div class="mt-20 flex justify-center items-center bg-[#f0f4f8]">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-[#2c3e50] mb-6 text-center">Informasi Akun</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="text" value="{{ $user->email }}"
                    class="w-full p-2 border rounded bg-gray-100" readonly>
            </div>

            <div class="pt-4">
                <button onclick="openModal('modalPasswordLama')"
                    class="mb-3 block w-full bg-[#2c3e50] text-white text-center py-2 px-4 rounded hover:bg-[#34495e] transition">
                    Ubah Password
                </button>

                <form action="{{ route('Logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full bg-red-700 text-white text-center py-2 px-4 rounded hover:bg-red-600 transition">
                        Logout
                    </button>
                </form>
            </div>

            <!-- Modal Password Lama -->
            <div id="modalPasswordLama" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
                    <form id="formPasswordLama" action="{{ route('akun.verifikasi-password-lama') }}" method="POST">
                        @csrf
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Verifikasi Password Lama</h3>
                            <input type="password" name="current_password" placeholder="Password Lama"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <div id="errorPasswordLama" class="mt-2 text-red-600 text-sm hidden"></div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                            <button type="button" onclick="closeModal('modalPasswordLama')"
                                class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Lanjut
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Password Baru -->
            <div id="modalPasswordBaru" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
                    <form id="formPasswordBaru" action="{{ route('akun.ubah-password') }}" method="POST">
                        @csrf
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Password Baru</h3>

                            <div class="space-y-4">
                                <div>
                                    <input type="password" name="new_password" id="newPassword" placeholder="Password Baru"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <div id="errorNewPassword" class="mt-1 text-red-600 text-sm hidden"></div>
                                </div>

                                <div>
                                    <input type="password" name="new_password_confirmation" id="confirmPassword" placeholder="Konfirmasi Password"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <div id="errorConfirmPassword" class="mt-1 text-red-600 text-sm hidden"></div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                            <button type="button" onclick="closeModal('modalPasswordBaru')"
                                class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

    // Validasi password baru
    document.getElementById('formPasswordBaru').addEventListener('submit', function(e) {
        e.preventDefault();

        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const errorNew = document.getElementById('errorNewPassword');
        const errorConfirm = document.getElementById('errorConfirmPassword');

        // Reset error
        errorNew.classList.add('hidden');
        errorConfirm.classList.add('hidden');

        let valid = true;

        if (newPassword.length < 8) {
            errorNew.textContent = 'Password minimal 8 karakter';
            errorNew.classList.remove('hidden');
            valid = false;
        }

        if (newPassword !== confirmPassword) {
            errorConfirm.textContent = 'Konfirmasi password tidak sama';
            errorConfirm.classList.remove('hidden');
            valid = false;
        }

        if (valid) {
            this.submit();
        }
    });

    // Handle response dari server
    @if(session('verifikasi_berhasil'))
        window.addEventListener('load', () => {
            openModal('modalPasswordBaru');
        });
    @endif

    @if(session('error_password_lama'))
        window.addEventListener('load', () => {
            const errorDiv = document.getElementById('errorPasswordLama');
            errorDiv.textContent = '{{ session('error_password_lama') }}';
            errorDiv.classList.remove('hidden');
            openModal('modalPasswordLama');
        });
    @endif
</script>
@endsection
