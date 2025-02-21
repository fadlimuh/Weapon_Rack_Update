<?php

namespace App\Http\Controllers;

use App\Models\tmprfids;
use Illuminate\Http\Request;

class TmprfidsController extends Controller
{
    /**
     * Menampilkan data tmprfid.
     */
    public function index()
    {
        // Ambil data tmprfid dari database
        $tmprfid = tmprfids::first();

        // Tampilkan view
        return view('tmprfids.index', compact('tmprfid'));
    }

    public function destroy($nokartu)
    {
    // Hapus data tmprfid berdasarkan nokartu
    tmprfids::where('nokartu', $nokartu)->delete();

    return redirect()->route('tmprfids.index')->with('success', 'Data tmprfid berhasil dihapus.');
    }
}
