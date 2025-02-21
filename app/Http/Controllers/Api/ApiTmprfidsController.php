<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tmprfid;
use App\Models\tmprfids;
use Illuminate\Http\Request;

class apiTmprfidsController extends Controller
{
    /**
     * Menyimpan data tmprfid yang dikirim dari hardware.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nokartu' => 'required|string|max:255',
        ]);

        // Hapus data tmprfid yang lama (jika ada)
        tmprfids::truncate();

        // Simpan data baru ke database
        $tmprfid = tmprfids::create([
            'nokartu' => $request->nokartu,
        ]);

        // Kembalikan response JSON
        return response()->json([
            'success' => true,
            'message' => 'Data tmprfid berhasil disimpan.',
            'data' => $tmprfid,
        ], 201);
    }
}
