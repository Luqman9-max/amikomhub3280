@extends('layouts.admin')

@section('content')
    <header class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black">Manajemen Kategori</h1>
            <p class="text-slate-500 font-medium">Kelola kategori event yang tersedia di platform.</p>
        </div>
        <button
            onclick="openAddModal()"
            class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
            + Tambah Kategori
        </button>
    </header>

    @if($errors->any())
    <div class="bg-red-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded-xl mb-6 shadow-sm">
        <ul class="list-disc list-inside text-sm font-semibold">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-xl mb-6 shadow-sm text-sm font-semibold">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="px-8 py-6 bg-slate-50/50 border-b flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kategori..."
                class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition">
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 bg-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-300 transition flex items-center">
                    Reset
                </a>
            @endif
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4 w-16">No</th>
                        <th class="px-8 py-4">Nama Kategori</th>
                        <th class="px-8 py-4">Jumlah Event</th>
                        <th class="px-8 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t">
                    @forelse($categories as $category)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-8 py-6 font-bold text-slate-400">{{ $loop->iteration }}</td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center font-bold uppercase">
                                    {{ strtoupper(substr($category->name, 0, 1)) }}
                                </div>
                                <p class="font-black text-slate-800">{{ $category->name }}</p>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-bold">{{ $category->events_count }} Event</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex gap-2">
                                <button
                                    onclick="openEditModal('{{ $category->id }}', '{{ addslashes($category->name) }}')"
                                    class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition"
                                    title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua event yang terhubung dengan kategori ini mungkin akan terpengaruh.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition"
                                        title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-6 text-center text-slate-500 font-medium">Tidak ada kategori ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div id="add-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeAddModal()"></div>
        <div class="relative bg-white rounded-3xl p-8 w-full max-w-md shadow-2xl border border-slate-100 transform scale-100 transition-all duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-black text-slate-800">Tambah Kategori</h3>
                <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block mb-2 font-bold text-slate-700 text-sm">Nama Kategori</label>
                    <input type="text" name="name" required placeholder="Contoh: Kuliner, Bisnis"
                        class="w-full px-5 py-3 rounded-2xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeAddModal()"
                        class="px-5 py-3 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 active:scale-95 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div id="edit-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
        <div class="relative bg-white rounded-3xl p-8 w-full max-w-md shadow-2xl border border-slate-100 transform scale-100 transition-all duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-black text-slate-800">Edit Kategori</h3>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="edit-form" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-6">
                    <label class="block mb-2 font-bold text-slate-700 text-sm">Nama Kategori</label>
                    <input type="text" name="name" id="edit-name" required placeholder="Contoh: Kuliner, Bisnis"
                        class="w-full px-5 py-3 rounded-2xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()"
                        class="px-5 py-3 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 active:scale-95 transition">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('add-modal').classList.remove('hidden');
        }
        function closeAddModal() {
            document.getElementById('add-modal').classList.add('hidden');
        }
        function openEditModal(id, name) {
            document.getElementById('edit-modal').classList.remove('hidden');
            document.getElementById('edit-form').action = "{{ url('admin/categories') }}/" + id;
            document.getElementById('edit-name').value = name;
        }
        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }
    </script>
@endsection
