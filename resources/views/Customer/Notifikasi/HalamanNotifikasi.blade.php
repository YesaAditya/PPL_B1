@extends('Layouts.Customer')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Notifikasi Saya</h2>
        <div class="text-sm text-gray-500">
            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ $notifikasiBelumDibaca->count() }} Belum dibaca</span>
        </div>
    </div>

    <!-- Unread Notifications -->
    <div class="mb-10">
        <div class="flex items-center mb-4">
            <h4 class="text-lg font-semibold text-gray-700">Belum Dibaca</h4>
            <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $notifikasiBelumDibaca->count() }}</span>
        </div>

        @forelse ($notifikasiBelumDibaca as $notif)
        <div class="bg-white border-l-4 border-blue-500 rounded-lg shadow-sm hover:shadow-md transition-shadow mb-3">
            <div class="p-4 flex justify-between items-start">
                <a href="{{ route('notifikasi.lihat', $notif->id) }}" class="flex-1 group">
                    <p class="text-gray-800 group-hover:text-blue-600 transition-colors">{{ $notif->pesan_notifikasi }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</p>
                </a>
                <form action="{{ route('notifikasi.baca', $notif->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-1" title="Tandai sudah dibaca">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-gray-50 rounded-lg p-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <p class="mt-3 text-gray-600">Tidak ada notifikasi baru</p>
        </div>
        @endforelse
    </div>

    <!-- Read Notifications -->
    <div>
        <h4 class="text-lg font-semibold text-gray-700 mb-4">Sudah Dibaca</h4>

        @forelse ($notifikasiSudahDibaca as $notif)
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow mb-3">
            <a href="{{ route('ShowDetailTransaksiCust', $notif->transaksi_id) }}" class="block p-4 group">
                <p class="text-gray-600 group-hover:text-blue-600 transition-colors">{{ $notif->pesan_notifikasi }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</p>
            </a>
        </div>
        @empty
        <div class="bg-gray-50 rounded-lg p-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="mt-3 text-gray-600">Tidak ada riwayat notifikasi</p>
        </div>
        @endforelse
    </div>

</div>
@endsection
