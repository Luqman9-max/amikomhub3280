@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1 space-y-8">
            <span
                class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">#1
                Event Platform</span>
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
                Temukan &amp; Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
            </h1>
            <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
                Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman &amp; cepat dengan
                Midtrans.
            </p>
            <div class="flex gap-4">
                <a href="#events"
                    class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                    Mulai Jelajah
                </a>
                <a href="#"
                    class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                    Cara Pesan
                </a>
            </div>
        </div>
        <div class="flex-1 relative">
            <div
                class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
            </div>
            <div
                class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
            </div>
            <img src="{{ asset('assets/concert.png') }}" alt="Concert"
                class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">

            <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                        <p class="font-bold">Pembayaran Aman via Midtrans</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Grid -->
    <section id="events" class="max-w-7xl mx-auto px-6 py-20">

        <!-- Heading Section -->
        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold mb-2">Event Terdekat</h2>
            <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
        </div>

        <!-- Blok Navigasi Filter Kategori -->
        <div class="mb-10 flex gap-3 justify-center flex-wrap">
            <!-- Rujukan awal navigasi bebas bawaan -->
            <a href="/"
                class="px-5 py-2 rounded-full font-semibold text-sm transition-all duration-200 shadow-sm
                {{ !request()->query('category')
                    ? 'bg-indigo-600 text-white shadow-indigo-200 shadow-md'
                    : 'bg-white border border-slate-200 text-slate-600 hover:border-indigo-400 hover:text-indigo-600' }}">
                Semua Kategori
            </a>

            <!-- Melakukan iterasi nama Tab Kategori dinamis saat jumlah data bertambah -->
            @foreach($categories as $cat)
                <a href="/?category={{ $cat->slug }}"
                    class="px-5 py-2 rounded-full font-semibold text-sm transition-all duration-200 shadow-sm
                    {{ request()->query('category') === $cat->slug
                        ? 'bg-indigo-600 text-white shadow-indigo-200 shadow-md'
                        : 'bg-white border border-slate-200 text-slate-600 hover:border-indigo-400 hover:text-indigo-600' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <!-- Zona Menampilkan Grid List Event -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events as $event)
            <div
                class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
                <div class="relative overflow-hidden aspect-[3/4]">
                    <img src="https://placehold.co/200x600" alt="{{ $event->title }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div
                        class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
                        {{ $event->category->name }}</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">{{ $event->title }}</h3>
                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('d-m-Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t">
                        <span class="text-2xl font-black text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                        <a href="{{ url('event/' . $event->id) }}"
                            class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">Lihat
                            Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Partners & Collaborators Section -->
    <section class="max-w-7xl mx-auto px-6 py-20 border-t border-slate-100 bg-slate-50/30 rounded-[3rem] my-10">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1.5 bg-indigo-50 text-indigo-700 rounded-full text-xs font-bold uppercase tracking-wider mb-3">Kolaborasi Kami</span>
            <h2 class="text-3xl font-extrabold text-slate-900">Partner &amp; Kolaborator</h2>
            <p class="text-slate-500 font-medium mt-2">Didukung oleh berbagai instansi dan partner terpercaya untuk menyukseskan event Anda.</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 justify-center">
            @forelse($partners as $partner)
                <div class="group flex flex-col items-center justify-center p-6 bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center p-2 mb-4 group-hover:bg-indigo-50 transition duration-300 overflow-hidden">
                        <img src="{{ $partner->logo_url }}" alt="Logo {{ $partner->name }}" class="w-full h-full object-contain filter grayscale group-hover:grayscale-0 transition duration-300">
                    </div>
                    <span class="text-sm font-bold text-slate-700 group-hover:text-indigo-600 transition text-center line-clamp-1">{{ $partner->name }}</span>
                </div>
            @empty
                <div class="col-span-full text-center text-slate-500 font-medium py-10">Belum ada partner pendukung.</div>
            @endforelse
        </div>
    </section>
@endsection
