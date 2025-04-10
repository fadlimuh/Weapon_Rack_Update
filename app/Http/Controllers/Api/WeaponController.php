<?php
namespace App\Http\Controllers\Api;

use App\Models\Weapons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class WeaponController extends Controller
{
    /**
     * Menampilkan semua data senjata.
     */
    public function index()
    {
        $weapons = Weapons::all();
        return response()->json(['success' => true, 'data' => $weapons]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'loadCellID' => 'required|integer',
            'slaveNumber' => 'required|integer',
            'status' => 'required|integer',
            'weight' => 'required|numeric|min:-1', // Izinkan nilai negatif jika perlu
            'rackNumber' => 'required|string|max:255',
        ]);

        try {
            $weapon = Weapons::updateOrCreate(
                ['loadCellID' => $validated['loadCellID']], // Kolom unik
                [
                    'slaveNumber' => $validated['slaveNumber'],
                    'status' => $validated['status'],
                    'weight' => $validated['weight'],
                    'rackNumber' => $validated['rackNumber'],
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $weapon,
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data:', [
                'error' => $e->getMessage(),
                'input' => $request->all(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    /**
     * Menampilkan detail senjata berdasarkan ID.
     */
    public function show($id)
    {
        $weapon = Weapons::findOrFail($id);
        return response()->json(['success' => true, 'data' => $weapon]);
    }

    /**
     * Memperbarui data senjata berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $weapon = Weapons::findOrFail($id);
        $validated = $request->validate([
            'loadCellID' => 'sometimes|string|max:255',
            'slaveNumber' => 'sometimes|integer',
            'status' => 'sometimes|integer',
            'weight' => 'sometimes|numeric',
            'rackNumber' => 'sometimes|string|max:255',
        ]);
        $weapon->update($validated);
        return response()->json(['success' => true, 'data' => $weapon]);
    }

    /**
     * Menghapus data senjata berdasarkan ID.
     */
    public function destroy($id)
    {
        $weapon = Weapons::findOrFail($id);
        $weapon->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }
}
