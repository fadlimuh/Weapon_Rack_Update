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
        // Logging data request sebelum validasi
        Log::info('Data request sebelum validasi:', $request->all());

        // Validasi input
        $validated = $request->validate([
            'loadCellID' => 'required|integer',
            'slaveNumber' => 'required|integer',
            'status' => 'required|integer',
            'weight' => 'required|numeric|min:-1', // Izinkan nilai negatif jika perlu
            'rackNumber' => 'required|string|max:255',
        ]);

        try {
            // Logging data yang divalidasi
            Log::info('Data yang divalidasi:', $validated);

            // Simpan atau perbarui data
            $weapon = Weapons::updateOrCreate(
                ['loadCellID' => $validated['loadCellID']], // Kolom unik
                [
                    'slaveNumber' => $validated['slaveNumber'],
                    'status' => $validated['status'],
                    'weight' => $validated['weight'],
                    'rackNumber' => $validated['rackNumber'],
                    'timestamp' => now(), // Tambahkan timestamp saat menyimpan
                ]
            );

            // Logging data yang berhasil disimpan
            Log::info('Data berhasil disimpan:', ['data' => $weapon]);

            // Kembalikan response sukses
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $weapon,
            ]);
        } catch (QueryException $qe) {
            // Tangani error database
            Log::error('Kesalahan database:', [
                'error' => $qe->getMessage(),
                'sql' => $qe->getSql(),
                'bindings' => $qe->getBindings(),
            ]);
            return response()->json([
                'success' => false,
                'message' => $qe->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            // Tangani error umum
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
