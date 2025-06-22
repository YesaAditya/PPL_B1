<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RDFarm Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }

        /* Smooth scroll padding adjustment */
        html {
            scroll-padding-top: 80px; /* Adjust based on your navbar height */
        }

        .nav-link {
            position: relative;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #7dd3fc;
            transition: width 0.3s ease;
        }

        .nav-link:hover:after {
            width: 100%;
        }

        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Custom scroll behavior */
        section {
            scroll-margin-top: 80px; /* Same as navbar height */
        }
    </style>
</head>
<body class="bg-blue-50">
    {{-- Navbar --}}
    <nav class="bg-[#253a7d] text-white py-4 px-4 md:px-8 flex flex-wrap items-center justify-between fixed w-full z-50 shadow-lg">
        <!-- Logo -->
        <div class="font-bold text-3xl pr-5">RDFarm</div>

        <!-- Mobile menu button -->
        <button id="mobile-menu-button" class="md:hidden p-2 rounded-md text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Desktop Menu -->
        <div class="hidden md:flex md:flex-1 md:items-center">
            <div class="flex">
                <a href="#dashboard" class="px-5 py-4 text-white no-underline nav-link">Dashboard</a>
                <a href="#produk" class="px-5 py-4 text-white no-underline nav-link">Katalog</a>
                <a href="#aboutme" class="px-5 py-4 text-white no-underline nav-link">Tentang</a>
                <a href="#location" class="px-5 py-4 text-white no-underline nav-link">Lokasi</a>
            </div>

            <div class="flex items-center space-x-4 ml-auto">
                <button class="bg-transparent border border-white hover:bg-white hover:text-[#253a7d] text-white px-4 py-1 rounded-full transition-all duration-300">
                    <a href="{{ route('KlikRegistrasi') }}">Registrasi</a>
                </button>
                <button class="bg-white text-[#253a7d] hover:bg-blue-100 px-4 py-1 rounded-full transition-all duration-300 shadow-md">
                    <a href="{{ route('KlikLogin')}}">Login</a>
                </button>
            </div>
        </div>

        <!-- Mobile Menu (hidden by default) -->
        <div id="mobile-menu" class="hidden w-full md:hidden">
            <div class="pt-2 pb-4 space-y-1">
                <a href="#dashboard" class="block px-3 py-2 text-white hover:bg-[#1e3a8a] rounded-md">Dashboard</a>
                <a href="#produk" class="block px-3 py-2 text-white hover:bg-[#1e3a8a] rounded-md">Katalog</a>
                <a href="#aboutme" class="block px-3 py-2 text-white hover:bg-[#1e3a8a] rounded-md">Tentang</a>
                <a href="#location" class="block px-3 py-2 text-white hover:bg-[#1e3a8a] rounded-md">Lokasi</a>
            </div>
            <div class="pt-4 pb-2 border-t border-[#1e3a8a]">
                <a href="{{ route('KlikRegistrasi') }}" class="block w-full text-center px-4 py-2 text-white bg-transparent border border-white hover:bg-white hover:text-[#253a7d] rounded-full transition-all duration-300 mb-2">
                    Registrasi
                </a>
                <a href="{{ route('KlikLogin')}}" class="block w-full text-center px-4 py-2 text-[#253a7d] bg-white hover:bg-blue-100 rounded-full transition-all duration-300 shadow-md">
                    Login
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 px-4 md:px-8 overflow-hidden bg-gradient-to-r from-blue-50 to-blue-100" id="dashboard">
        <div class="pt-24 pb-24 max-w-6xl mx-auto relative z-10 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-12 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold text-[#253a7d] mb-6 leading-tight">
                    Siap Menikmati Susu Segar <span class="text-cyan-600">Berkualitas?</span>
                </h1>
                <p class="text-xl text-[#253a7d] mb-8">
                    Bergabunglah dengan ribuan pelanggan puas kami dan dapatkan produk susu terbaik langsung ke rumah Anda.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('KlikLogin')}}" class="bg-white text-[#253a7d] hover:bg-blue-50 px-6 py-3 rounded-full font-bold transition-colors shadow-lg flex items-center">
                        <i class="fas fa-shopping-cart mr-2"></i> Pesan Sekarang
                    </a>
                    <a href="#location" class="bg-[#253a7d] border-2 border-[#253a7d] text-white hover:bg-[#1e3a8a] px-6 py-3 rounded-full font-bold transition-colors flex items-center">
                        <i class="fas fa-phone-alt mr-2"></i> Hubungi Kami
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <img src="https://images.unsplash.com/photo-1550583724-b2692b85b150?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80"
                    alt="Fresh Milk"
                    class="rounded-xl shadow-2xl w-full max-w-md object-cover h-auto"
                    style="max-height: 350px;">
            </div>
        </div>
    </section>

    {{-- Products Section --}}
    <section class="py-16 px-4 bg-white" id='produk'>
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#253a7d] mb-4">Produk Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Temukan berbagai produk susu segar dan olahan berkualitas tinggi dari peternakan kami</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-12">
                @foreach ($katalogs->take(3) as $product)
                <div class="bg-white rounded-xl overflow-hidden shadow-md product-card border border-gray-100">
                    <a href="{{ route('KlikLogin')}}">
                        <div class="h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $product->foto) }}"
                                alt="{{ $product->nama_produk }}"
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $product->nama_produk }}</h3>
                            <p class="text-blue-600 font-bold mb-2">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Stok: {{ $product->stok }}</span>
                                <button class="bg-[#253a7d] text-white px-4 py-1 rounded-full text-sm hover:bg-[#1e3a8a] transition-colors">
                                    <i class="fas fa-cart-plus mr-1"></i> Beli
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="text-center">
                <a href="#" class="inline-flex items-center text-[#253a7d] font-medium hover:text-[#1e3a8a] border-2 border-[#253a7d] hover:border-[#1e3a8a] px-6 py-3 rounded-full transition-colors">
                    Lihat Semua Produk
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="aboutme" class="py-16 px-4 bg-blue-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#253a7d] mb-4">Tentang RDFarm</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Peternakan sapi perah modern dengan standar kualitas tertinggi</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-semibold mb-6 text-gray-800">Peternakan Modern Berstandar Tinggi</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Rembangan Dairy Farm merupakan peternakan sapi perah modern. Kami berkomitmen untuk menghasilkan susu segar dengan kualitas terbaik melalui proses yang higienis dan berstandar tinggi.
                    </p>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Dengan lebih dari 10 ekor sapi perah unggulan, kami mampu memproduksi lebih dari 200 liter susu segar setiap harinya. Semua proses produksi diawasi secara ketat oleh tim ahli gizi dan dokter hewan kami.
                    </p>

                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <div class="text-blue-600 mb-2">
                                <i class="fas fa-cow text-2xl"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 text-xl">10+</h4>
                            <p class="text-sm text-gray-600">Sapi Perah</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <div class="text-blue-600 mb-2">
                                <i class="fas fa-wine-bottle text-2xl"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 text-xl">200+</h4>
                            <p class="text-sm text-gray-600">Liter/Hari</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1500595046743-cd271d694d30?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Farm 1"
                        class="rounded-xl h-48 w-full object-cover shadow-md hover:shadow-lg transition-shadow">
                    <img src="https://images.unsplash.com/photo-1534338580013-382cf48bd435?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Farm 2"
                        class="rounded-xl h-48 w-full object-cover shadow-md hover:shadow-lg transition-shadow mt-8">
                    <img src="https://images.unsplash.com/photo-1550583724-b2692b85b150?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Farm 3"
                        class="rounded-xl h-48 w-full object-cover shadow-md hover:shadow-lg transition-shadow">
                    <img src="https://images.unsplash.com/photo-1501706362039-c06b2d715385?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Farm 4"
                        class="rounded-xl h-48 w-full object-cover shadow-md hover:shadow-lg transition-shadow mt-8">
                </div>
            </div>
        </div>
    </section>

    {{-- Location Section --}}
    <section id="location" class="py-16 px-4 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#253a7d] mb-4">Lokasi Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Kunjungi peternakan kami untuk melihat langsung proses produksi susu berkualitas</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="space-y-6">
                        <div class="flex items-start bg-blue-50 p-6 rounded-xl">
                            <div class="bg-blue-100 p-3 rounded-full mr-4 flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Alamat</h4>
                                <p class="text-gray-600">Jl. Rembangan, Darungan, Kemuning Lor, Kec. Arjasa, Kabupaten Jember, Jawa Timur 68113</p>
                            </div>
                        </div>

                        <div class="flex items-start bg-blue-50 p-6 rounded-xl">
                            <div class="bg-blue-100 p-3 rounded-full mr-4 flex-shrink-0">
                                <i class="fas fa-clock text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Jam Operasional</h4>
                                <p class="text-gray-600">Senin - Minggu: 09.00 - 16.00 WIB<br>Hari Besar: Tutup</p>
                            </div>
                        </div>

                        <div class="flex items-start bg-blue-50 p-6 rounded-xl">
                            <div class="bg-blue-100 p-3 rounded-full mr-4 flex-shrink-0">
                                <i class="fas fa-phone-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Kontak</h4>
                                <p class="text-gray-600">WhatsApp: 0812 3456 7890<br>Email: admin@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="h-96 bg-gray-200 rounded-xl overflow-hidden shadow-xl relative">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5127.248549468102!2d113.68970416234619!3d-8.084436804711137!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6eb40f5a86bab%3A0xfc4b00d932b43570!2sRembangan%20Dairy%20Farm!5e0!3m2!1sen!2sid!4v1749012488326!5m2!1sen!2sid"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        class="rounded-xl">
                    </iframe>
                    <div class="absolute bottom-4 right-4 bg-white p-3 rounded-lg shadow-md">
                        <a href="https://maps.app.goo.gl/RNo3JjLq7h9aMM299" target="_blank" class="flex items-center text-blue-600 hover:text-blue-800">
                            <i class="fas fa-directions mr-2"></i> Petunjuk Arah
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white pt-16 pb-8 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <div>
                    <div class="flex items-center mb-6">
                        <span class="font-bold text-2xl">RDFarm</span>
                    </div>
                    <p class="text-gray-400 mb-6">Peternakan sapi perah modern berstandar tinggi, menghasilkan susu segar berkualitas untuk kesehatan keluarga</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-6 text-white uppercase">Produk</h3>
                    <ul class="space-y-3">
                        @foreach ($katalogs as $item)
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">{{$item->nama_produk}}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-6 text-white uppercase">Perusahaan</h3>
                    <ul class="space-y-3">
                        <li><a href="#aboutme" class="text-gray-400 hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#location" class="text-gray-400 hover:text-white transition-colors">Lokasi</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-6 text-white uppercase">Kontak</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-gray-400 mt-1 mr-3"></i>
                            <span class="text-gray-400">Jl. Rembangan, Darungan, Kemuning Lor, Kec. Arjasa, Kabupaten Jember, Jawa Timur 68113</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt text-gray-400 mr-3"></i>
                            <span class="text-gray-400">081234567890</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope text-gray-400 mr-3"></i>
                            <span class="text-gray-400">admin@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center">
                <p class="text-gray-400 text-sm">© 2025 Rembangan Dairy Farm. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', function() {
                document.getElementById('mobile-menu').classList.add('hidden');
            });
        });
        // Smooth scroll with offset for fixed navbar
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    const navbarHeight = document.querySelector('nav').offsetHeight;
                    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });

                    // Update URL without jumping
                    if (history.pushState) {
                        history.pushState(null, null, targetId);
                    } else {
                        window.location.hash = targetId;
                    }
                }
            });
        });
    </script>
</body>
</html>