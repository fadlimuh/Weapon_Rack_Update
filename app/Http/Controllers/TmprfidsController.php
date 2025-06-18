<?php

namespace App\Http\Controllers;

use App\Models\tmprfids;
use Illuminate\Http\Request;

class TmprfidsController extends Controller
{
    /**
     * Menampilkan semua data tmprfid.
     */
    public function index()
    {
        // Ambil semua data tmprfid dari database
        $tmprfids = tmprfids::all();

        // Tampilkan view
        return view('tmprfids.index', compact('tmprfids'));
    }

    /**
     * Menampilkan form untuk membuat data baru.
     */
    public function create()
    {
        return view('tmprfids.create');
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nokartu' => 'required|string|unique:tmprfids,nokartu',
            'data_lain' => 'nullable|string', // Sesuaikan dengan kolom lain di tabel
        ]);

        // Simpan data ke database
        tmprfids::create($validatedData);

        return redirect()->route('tmprfids.index')->with('success', 'Data tmprfid berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data tmprfid tertentu.
     */
    public function show($nokartu)
    {
        $tmprfid = tmprfids::where('nokartu', $nokartu)->firstOrFail();

        return view('tmprfids.show', compact('tmprfid'));
    }

    /**
     * Menampilkan form untuk mengedit data tmprfid.
     */
    public function edit($nokartu)
    {
        $tmprfid = tmprfids::where('nokartu', $nokartu)->firstOrFail();

        return view('tmprfids.edit', compact('tmprfid'));
    }

    /**
     * Memperbarui data tmprfid di database.
     */
    public function update(Request $request, $nokartu)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nokartu' => 'required|string|unique:tmprfids,nokartu,' . $nokartu . ',nokartu',
            'data_lain' => 'nullable|string', // Sesuaikan dengan kolom lain di tabel
        ]);

        // Perbarui data di database
        $tmprfid = tmprfids::where('nokartu', $nokartu)->firstOrFail();
        $tmprfid->update($validatedData);

        return redirect()->route('tmprfids.index')->with('success', 'Data tmprfid berhasil diperbarui.');
    }

    /**
     * Menghapus data tmprfid dari database.
     */
    public function destroy($nokartu)
    {
        // Hapus data tmprfid berdasarkan nokartu
        tmprfids::where('nokartu', $nokartu)->delete();

        return redirect()->route('tmprfids.index')->with('success', 'Data tmprfid berhasil dihapus.');
    }
}
