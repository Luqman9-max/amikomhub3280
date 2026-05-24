@extends('layouts.admin')
@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Manajemen Partner</h2>
        <a href="{{ route('admin.partners.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded font-semibold hover:bg-indigo-700">
            Tambah Partner
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-5 border border-green-200">{{ session('success') }}</div>
    @endif

    {{-- Search Form --}}
    <form method="GET" action="{{ route('admin.partners.index') }}" class="mb-6 flex gap-4 bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama partner..."
            class="flex-1 px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
        <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-indigo-700 transition text-sm">
            Cari
        </button>
        @if(request('search'))
            <a href="{{ route('admin.partners.index') }}" class="bg-gray-100 text-gray-700 border border-gray-200 px-5 py-2.5 rounded-lg font-semibold hover:bg-gray-200 transition text-sm flex items-center">
                Reset
            </a>
        @endif
    </form>

    <div class="overflow-x-auto">
        <table class="w-full bg-white rounded-lg shadow-sm border border-gray-200 text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="p-4 font-semibold text-gray-600">No</th>
                    <th class="p-4 font-semibold text-gray-600">Logo</th>
                    <th class="p-4 font-semibold text-gray-600">Nama Partner</th>
                    <th class="p-4 font-semibold text-gray-600">URL Logo</th>
                    <th class="p-4 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="p-4 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="p-4">
                        <img src="{{ $partner->logo_url }}"
                             alt="Logo {{ $partner->name }}"
                             class="w-16 h-16 object-contain rounded border border-gray-200 bg-gray-50">
                    </td>
                    <td class="p-4 font-semibold text-gray-800">{{ $partner->name }}</td>
                    <td class="p-4">
                        <a href="{{ $partner->logo_url }}"
                           target="_blank"
                           class="text-indigo-600 hover:underline text-sm">
                            {{ $partner->logo_url }}
                        </a>
                    </td>
                    <td class="p-4 flex gap-2">
                        <a href="{{ route('admin.partners.edit', $partner->id) }}" class="bg-blue-50 text-blue-600 border border-blue-200 px-3 py-1.5 rounded text-sm font-semibold hover:bg-blue-600 hover:text-white transition">Edit</a>
                        <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-100 text-red-600 border border-red-200 px-3 py-1.5 rounded text-sm font-semibold hover:bg-red-600 hover:text-white transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-500 font-medium">Tidak ada partner ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
