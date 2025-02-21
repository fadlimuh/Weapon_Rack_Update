<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Weapons;
use Illuminate\Http\Request;

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

    /**
     * Menyimpan data senjata baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer',
            'weight' => 'nullable|numeric',
        ]);

        $weapon = Weapons::create($validated);
        return response()->json(['success' => true, 'data' => $weapon], 201);
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
            'name' => 'sometimes|string|max:255',
            'status' => 'sometimes|integer',
            'weight' => 'nullable|numeric',
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

