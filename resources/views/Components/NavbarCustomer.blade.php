<nav class="bg-[#253a7d] text-white py-4 px-4 sm:px-8 flex items-center fixed w-full z-10">
    <div class="flex items-center justify-between w-full">
        <!-- Logo and mobile menu button -->
        <div class="flex items-center">
            <div class="font-bold text-2xl md:text-3xl pr-5">RDFarm</div>

            <!-- Mobile menu button (hidden on desktop) -->
            <button class="md:hidden text-white focus:outline-none" id="mobile-menu-button">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Links (hidden on mobile) -->
        <div class="hidden md:flex flex-1">
            <a href="{{ route('Layouts.customer')}}" class="px-5 py-4 text-white no-underline hover:bg-[#071952]/20 transition-colors duration-300 ease-in-out relative">
                Dashboard
                <span class="{{ request()->is('dashboard') ? 'underline' : '' }} underline-offset-8 decoration-2 decoration-cyan-300"></span>
            </a>
            <a href="{{ route('ShowDataKatalog')}}" class="px-5 py-4 text-white no-underline hover:bg-[#071952]/20 transition-colors duration-300 ease-in-out relative">
                Katalog
                <span class="{{ request()->is('HalamanKatalog') ? 'underline' : '' }} underline-offset-8 decoration-2 decoration-cyan-300"></span>
            </a>
            <a href="{{ route("TransaksiCustomer")}}" class="px-5 py-4 text-white no-underline hover:bg-[#071952]/20 transition-colors duration-300 ease-in-out relative">
                Transaksi
                <span class="{{ request()->is('TransaksiSaya') ? 'underline' : '' }} underline-offset-8 decoration-2 decoration-cyan-300"></span>
            </a>
        </div>

        <!-- Right side icons -->
        <div class="flex items-center space-x-4">
            <a href="{{route('KlikNotifikasi')}}" class="text-white hover:text-cyan-300 transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V4a2 2 0 00-4 0v1.083A6 6 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m5 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </a>
            <a href="{{ route('KlikProfilCustomer') }}" class="text-white hover:text-cyan-300 transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.636 0 5.082.76 7.121 2.05M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </a>
        </div>
    </div>
</nav>

<!-- Mobile menu (hidden by default) -->
<div id="mobile-menu" class="md:hidden hidden fixed top-16 left-0 right-0 bg-[#253a7d] text-white z-10 shadow-lg">
    <div class="flex flex-col">
        <a href="/dashboard" class="px-8 py-4 text-white no-underline hover:bg-[#071952]/20 transition-colors duration-300 ease-in-out border-b border-[#071952]/20 {{ request()->is('dashboard') ? 'border-b-2 border-cyan-300' : '' }}">
            Dashboard
        </a>
        <a href="/HalamanKatalog" class="px-8 py-4 text-white no-underline hover:bg-[#071952]/20 transition-colors duration-300 ease-in-out border-b border-[#071952]/20 {{ request()->is('HalamanKatalog') ? 'border-b-2 border-cyan-300' : '' }}">
            Katalog
        </a>
        <a href="/TransaksiSaya" class="px-8 py-4 text-white no-underline hover:bg-[#071952]/20 transition-colors duration-300 ease-in-out border-b border-[#071952]/20 {{ request()->is('TransaksiSaya') ? 'border-b-2 border-cyan-300' : '' }}">
            Transaksi
        </a>
    </div>
</div>

<script>
    // Mobile menu toggle functionality
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });
</script>
