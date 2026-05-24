<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Menampilkan daftar semua partner menggunakan Eloquent.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $partners = Partner::where('name', 'LIKE', '%' . $search . '%')->get();
        } else {
            $partners = Partner::all();
        }

        return view('admin.partners.index', compact('partners'));
    }

    /**
     * Menampilkan form untuk mendaftarkan partner baru.
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Menyimpan data partner baru dari request ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'     => 'required|string|max:255',
            'logo_url' => 'required|url|max:500',
        ]);

        // Simpan ke database via Eloquent
        Partner::create([
            'name'     => $request->name,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit partner.
     */
    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Memperbarui data partner di database.
     */
    public function update(Request $request, Partner $partner)
    {
        // Validasi input
        $request->validate([
            'name'     => 'required|string|max:255',
            'logo_url' => 'required|url|max:500',
        ]);

        // Perbarui data via Eloquent
        $partner->update([
            'name'     => $request->name,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Data partner berhasil diperbarui!');
    }

    /**
     * Menghapus data partner dari database.
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner berhasil dihapus!');
    }
}
