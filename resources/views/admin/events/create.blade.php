@extends('layouts.admin')
@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Form Tambah Event</h2>

    @if($errors->any())
    <div class="bg-red-50 border border-red-300 text-red-700 p-4 rounded-lg mb-6">
        <p class="font-semibold mb-1">⚠️ Terdapat kesalahan pada data yang dimasukkan:</p>
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mt-2">
        @csrf

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Judul Event</label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} p-2.5 rounded focus:ring focus:ring-indigo-200" required>
            @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Kategori Event</label>
            <select name="category_id" class="w-full border border-gray-300 p-2.5 rounded focus:ring focus:ring-indigo-200" required>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Deskripsi Pendek</label>
            <textarea name="description" class="w-full border {{ $errors->has('description') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} p-2.5 rounded focus:ring focus:ring-indigo-200" rows="3">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-4">
            <div>
                <label class="block mb-2 font-medium text-gray-700">Tanggal & Waktu</label>
                <input type="datetime-local" name="date" value="{{ old('date') }}" class="w-full border {{ $errors->has('date') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} p-2.5 rounded" required>
                @error('date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-2 font-medium text-gray-700">Harga Tiket (Rp)</label>
                <input type="number" name="price" value="{{ old('price') }}" min="0" class="w-full border {{ $errors->has('price') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} p-2.5 rounded" required>
                @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-2 font-medium text-gray-700">Kapasitas Stok</label>
                <input type="number" name="stock" value="{{ old('stock') }}" min="1" class="w-full border {{ $errors->has('stock') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} p-2.5 rounded" required>
                @error('stock') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-medium text-gray-700">Lokasi / Gedung</label>
            <input type="text" name="location" value="{{ old('location') }}" class="w-full border {{ $errors->has('location') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} p-2.5 rounded" required>
            @error('location') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-medium text-gray-700">Poster Event (Opsional)</label>
            <input type="file" name="poster" accept="image/*" class="w-full border {{ $errors->has('poster') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} p-2.5 rounded">
            @error('poster') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end border-t pt-4">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-2.5 rounded font-semibold hover:bg-indigo-700 shadow">Simpan Data</button>
        </div>
    </form>
</div>
@endsection