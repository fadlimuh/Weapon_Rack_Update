<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\personnels;

class PersonnelsController extends Controller
{
    /**
     * Menampilkan semua data personel.
     */
    public function index()
    {
        $personnels = personnels::with('weapon')->get();
        return response()->json(['success' => true, 'data' => $personnels]);
    }

    /**
     * Menampilkan detail personel berdasarkan ID.
     */
    public function show($id)
    {
        $personnel = personnels::with('weapon')->find($id);

        if (!$personnel) {
            return response()->json(['success' => false, 'message' => 'Personnel not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $personnel]);
    }

    /**
     * Menyimpan data personel baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'personnel_id' => 'required|numeric|unique:personnels,personnel_id',
            'loadCellID' => 'required|string|exists:weapons,loadCellID',
            'nokartu' => 'required|numeric|exists:tmprfids,nokartu',
            'nama' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
            'nrp' => 'required|string|max:255|unique:personnels,nrp',
            'jabatan' => 'required|string|max:255',
            'kesatuan' => 'required|string|max:255',
        ]);

        $personnel = personnels::create($validatedData);

        return response()->json(['success' => true, 'data' => $personnel], 201);
    }

    /**
     * Memperbarui data personel berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $personnel = personnels::find($id);

        if (!$personnel) {
            return response()->json(['success' => false, 'message' => 'Personnel not found'], 404);
        }

        $validatedData = $request->validate([
            'loadCellID' => 'sometimes|required|string|exists:weapons,loadCellID',
            'nokartu' => 'sometimes|required|numeric|exists:tmprfids,nokartu',
            'nama' => 'sometimes|required|string|max:255',
            'pangkat' => 'sometimes|required|string|max:255',
            'nrp' => 'sometimes|required|string|max:255|unique:personnels,nrp,' . $id . ',personnel_id',
            'jabatan' => 'sometimes|required|string|max:255',
            'kesatuan' => 'sometimes|required|string|max:255',
        ]);

        $personnel->update($validatedData);

        return response()->json(['success' => true, 'data' => $personnel]);
    }

    /**
     * Menghapus data personel berdasarkan ID.
     */
    public function destroy($id)
    {
        $personnel = personnels::find($id);

        if (!$personnel) {
            return response()->json(['success' => false, 'message' => 'Personnel not found'], 404);
        }

        $personnel->delete();

        return response()->json(['success' => true, 'message' => 'Personnel deleted successfully']);
    }
}
