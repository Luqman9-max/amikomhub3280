@extends('layouts.admin')

@section('content')
    <header class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black">Laporan Transaksi</h1>
            <p class="text-slate-500 font-medium">Pantau arus kas dan penjualan tiket Anda secara real-time.</p>
        </div>
        <div class="flex gap-4">
            <button
                class="px-6 py-3 border-2 border-slate-200 rounded-2xl font-bold hover:bg-white hover:border-indigo-600 hover:text-indigo-600 transition">
                Ekspor Excel
            </button>
            <button
                class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition">
                Unduh PDF
            </button>
        </div>
    </header>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <form method="GET" action="{{ route('admin.transactions') }}" class="px-8 py-6 bg-slate-50/50 border-b flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-[300px] flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Order ID, Nama, atau Email..."
                    class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition uppercase text-sm font-medium tracking-wide">
            </div>
            <div class="flex gap-2">
                <select name="status"
                    class="px-5 py-3 rounded-xl border-slate-200 border bg-white outline-none text-sm font-bold">
                    <option value="Semua Status" {{ request('status') == 'Semua Status' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Success" class="text-green-600" {{ request('status') == 'Success' ? 'selected' : '' }}>Success</option>
                    <option value="Pending" class="text-orange-600" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Expired" class="text-rose-600" {{ request('status') == 'Expired' ? 'selected' : '' }}>Expired</option>
                </select>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition text-sm">
                    Terapkan
                </button>
                @if(request('search') || (request('status') && request('status') != 'Semua Status'))
                    <a href="{{ route('admin.transactions') }}" class="px-6 py-3 bg-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-300 transition flex items-center text-sm">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4">Order ID</th>
                        <th class="px-8 py-4">Detail Pembeli</th>
                        <th class="px-8 py-4">Event</th>
                        <th class="px-8 py-4">Tgl Transaksi</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4 text-right">Total Tagihan</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-8 py-6">
                            <span
                                class="font-mono font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg text-sm">#{{ $trx->order_id }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <p class="font-bold text-slate-800">{{ $trx->customer_name }}</p>
                            <p class="text-xs text-slate-500">{{ $trx->customer_email }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <p class="font-medium text-slate-700">{{ $trx->event->title ?? '-' }}</p>
                        </td>
                        <td class="px-8 py-6 text-sm text-slate-500">
                            {{ $trx->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-8 py-6">
                            @if(strtolower($trx->status) == 'success')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase ring-1 ring-green-200">Success</span>
                            @elseif(strtolower($trx->status) == 'pending')
                                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase ring-1 ring-orange-200">Pending</span>
                            @else
                                <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold uppercase ring-1 ring-rose-200">{{ $trx->status }}</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right font-black text-slate-900">
                            @if($trx->total_price > 0)
                                Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                            @else
                                <span class="text-slate-400 font-bold uppercase text-xs bg-slate-100 px-2.5 py-1 rounded-lg">Gratis</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center text-slate-500 font-medium">
                            <div class="flex flex-col items-center justify-center gap-2 py-4">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="font-bold text-slate-700">Tidak ada data transaksi ditemukan</p>
                                <p class="text-xs text-slate-400">Silakan sesuaikan kata kunci pencarian atau filter status Anda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-8 py-6 bg-slate-50/50 border-t flex justify-between items-center">
            <p class="text-sm text-slate-500 font-medium">Menampilkan {{ $transactions->count() }} transaksi</p>
            <div class="flex gap-2">
                <button
                    class="px-4 py-2 border rounded-xl hover:bg-white transition text-sm font-bold opacity-50 cursor-not-allowed">Previous</button>
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-xl shadow-md text-sm font-bold">1</button>
                <button
                    class="px-4 py-2 border rounded-xl hover:bg-white transition text-sm font-bold opacity-50 cursor-not-allowed">Next</button>
            </div>
        </div>
    </div>
@endsection