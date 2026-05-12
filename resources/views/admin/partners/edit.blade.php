@extends('layouts.admin')
@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Partner</h2>

    @if($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-5 border border-red-200">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST"
          class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mt-2">
        @csrf
        @method('PUT')

        {{-- Input: Nama Partner --}}
        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Nama Partner</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $partner->name) }}"
                   placeholder="Contoh: PT. Maju Bersama"
                   class="w-full border border-gray-300 p-2.5 rounded focus:ring focus:ring-indigo-200"
                   required>
        </div>

        {{-- Dropdown: Pilih Logo URL --}}
        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Logo URL</label>
            <select name="logo_url_preset"
                    id="logo_url_preset"
                    class="w-full border border-gray-300 p-2.5 rounded focus:ring focus:ring-indigo-200 mb-2"
                    onchange="syncLogoUrl(this.value)">
                <option value="">-- Pilih ukuran placeholder --</option>
                <option value="https://placehold.co/100x100">100 × 100 px</option>
                <option value="https://placehold.co/150x150">150 × 150 px</option>
                <option value="https://placehold.co/200x200">200 × 200 px (default)</option>
                <option value="https://placehold.co/250x250">250 × 250 px</option>
                <option value="https://placehold.co/300x200">300 × 200 px (landscape)</option>
                <option value="custom">URL Kustom...</option>
            </select>

            {{-- Input URL manual —terisi otomatis dari dropdown, bisa diubah bebas --}}
            <input type="url"
                   name="logo_url"
                   id="logo_url"
                   value="{{ old('logo_url', $partner->logo_url) }}"
                   placeholder="https://placehold.co/200x200"
                   class="w-full border border-gray-300 p-2.5 rounded focus:ring focus:ring-indigo-200"
                   required>
            <p class="text-xs text-gray-400 mt-1">Pilih dari dropdown atau ketik URL gambar logo secara langsung.</p>
        </div>

        {{-- Preview Logo --}}
        <div class="mb-6">
            <label class="block mb-2 font-medium text-gray-700">Preview Logo</label>
            <img id="logo_preview"
                 src="{{ $partner->logo_url }}"
                 alt="Preview Logo"
                 class="w-24 h-24 object-contain rounded border border-gray-200 bg-gray-50">
        </div>

        <div class="flex justify-between items-center border-t pt-4">
            <a href="{{ route('admin.partners.index') }}"
               class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                ← Kembali ke Daftar Partner
            </a>
            <button type="submit"
                    class="bg-indigo-600 text-white px-8 py-2.5 rounded font-semibold hover:bg-indigo-700 shadow">
                Perbarui Data
            </button>
        </div>
    </form>
</div>

<script>
    function syncLogoUrl(value) {
        const input = document.getElementById('logo_url');
        if (value && value !== 'custom') {
            input.value = value;
            updatePreview(value);
        }
    }

    function updatePreview(url) {
        const preview = document.getElementById('logo_preview');
        preview.src = url || 'https://placehold.co/200x200';
    }

    // Update preview setiap kali input URL diubah manual
    document.getElementById('logo_url').addEventListener('input', function () {
        updatePreview(this.value);
    });
</script>
@endsection
