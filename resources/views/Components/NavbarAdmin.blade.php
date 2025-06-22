{{-- Enhanced Navbar --}}
<nav class="bg-primary text-white py-4 px-8 flex items-center fixed w-full z-10">
    <div class="font-bold text-3xl pr-5">RDFarm</div>
    <div class="flex flex-1">
        <a href="{{ route('Layouts.admin')}}" class="px-5 py-4 text-white no-underline hover:bg-secondary/20 transition-colors duration-300 ease-in-out {{ request()->is('dashboard') ? 'text-cyan-300' : '' }}">Dashboard</a>
        <a href="{{ route('admin.katalog.index')}}" class="px-5 py-4 text-white no-underline hover:bg-secondary/20 transition-colors duration-300 ease-in-out {{ request()->is('katalog') ? 'text-cyan-300' : '' }}">Katalog</a>
        <div class="relative">
            <button id="transaksiButton" class="px-5 py-4 hover:bg-secondary/20">Transaksi</button>
            <div id="submenuTransaksi" class="absolute bg-primary mt-1 rounded shadow-lg hidden">
                <a href="{{ route('FormKasir')}}" class="block px-5 py-3 hover:bg-secondary/30">Form Kasir</a>
                <a href="{{ route('ShowDataTransaksi')}}" class="block px-5 py-3 hover:bg-secondary/30">Lihat Transaksi Customer</a>
            </div>
        </div>

        <a href="{{route('laporan')}}" class="px-5 py-4 text-white no-underline hover:bg-secondary/20 transition-colors duration-300 ease-in-out {{ request()->is('laporan') ? 'text-cyan-300' : '' }}">Laporan</a>
    </div>
    <div class="flex items-center space-x-4 ml-auto">
        <a href="{{route('KlikNotifikasiAdmin')}}" class="text-white hover:text-cyan-300 transition-colors duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V4a2 2 0 00-4 0v1.083A6 6 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m5 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>

        </a>
        <a href="{{route('KlikAkunAdmin')}}" class="text-white hover:text-cyan-300 transition-colors duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.636 0 5.082.76 7.121 2.05M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </a>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const btn = document.getElementById("transaksiButton");
        const submenu = document.getElementById("submenuTransaksi");

        btn.addEventListener("click", function (event) {
            event.stopPropagation(); // supaya tidak tertutup langsung
            submenu.classList.toggle("hidden");
        });

        document.addEventListener("click", function () {
            submenu.classList.add("hidden");
        });
    });
</script>
