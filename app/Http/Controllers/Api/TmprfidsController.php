<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tmprfids;
use Illuminate\Http\Request;

class TmprfidsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tmprfids = tmprfids::all();
        return response()->json([
            'success' => true,
            'data' => $tmprfids
        ], 200);
    }

    /**
     * Store or update nokartu based on the request from a specific IP.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nokartu' => 'required|string',
        ]);

        // Periksa apakah request berasal dari IP 192.168.1.10
        if ($request->ip() !== '192.168.1.10') {
            return response()->json([
                'success' => false,
                'message' => 'Akses hanya diizinkan dari IP 192.168.1.10.'
            ], 403);
        }

        // Cari data tmprfid yang ada (jika ada)
        $tmprfid = tmprfids::firstOrNew([]); // Ambil data pertama atau buat baru jika tidak ada

        // Update nilai nokartu
        $tmprfid->nokartu = $request->nokartu;
        $tmprfid->save();

        return response()->json([
            'success' => true,
            'message' => 'Data nokartu berhasil diperbarui.',
            'data' => $tmprfid
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $tmprfid = tmprfids::find($id);

        if (!$tmprfid) {
            return response()->json([
                'success' => false,
                'message' => 'Data tmprfid tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $tmprfid
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $tmprfid = tmprfids::find($id);

        if (!$tmprfid) {
            return response()->json([
                'success' => false,
                'message' => 'Data tmprfid tidak ditemukan.'
            ], 404);
        }

        // Validasi input
        $validatedData = $request->validate([
            'nokartu' => 'required|string',
        ]);

        // Update nilai nokartu
        $tmprfid->nokartu = $request->nokartu;
        $tmprfid->save();

        return response()->json([
            'success' => true,
            'message' => 'Data tmprfid berhasil diperbarui.',
            'data' => $tmprfid
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $tmprfid = tmprfids::find($id);

        if (!$tmprfid) {
            return response()->json([
                'success' => false,
                'message' => 'Data tmprfid tidak ditemukan.'
            ], 404);
        }

        $tmprfid->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data tmprfid berhasil dihapus.'
        ], 200);
    }
}
