<?php

namespace App\Http\Controllers;

use App\Models\personnels;
use App\Models\tmprfids; // Import model tmprfids
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class apiPersonnelsController extends Controller
{
    /**
     * Menampilkan semua data personnel (paginated)
     */
    public function index()
    {
        try {
            $personnels = personnels::with('tmprfid')->paginate(10); // Eager load tmprfid
            return response()->json([
                'success' => true,
                'data' => $personnels
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data personnel'
            ], 500);
        }
    }

    /**
     * Membuat data personnel baru
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'personnel_id' => 'required|string|unique:personnels,personnel_id',
                'loadCellID' => 'required|integer',
                'nokartu' => 'required|string|exists:tmprfids,nokartu', // Pastikan nokartu ada di tmprfids
                'nama' => 'required|string|max:255',
                'pangkat' => 'required|string|max:255',
                'nrp' => 'required|string|max:50',
                'jabatan' => 'required|string|max:255',
                'kesatuan' => 'required|string|max:255'
            ]);

            // Buat data personnel
            $personnel = personnels::create($validated);

            return response()->json([
                'success' => true,
                'data' => $personnel
            ], Response::HTTP_CREATED);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat personnel: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Menampilkan detail personnel
     */
    public function show($personnel_id)
    {
        try {
            $personnel = personnels::with('tmprfid')->findOrFail($personnel_id); // Eager load tmprfid

            return response()->json([
                'success' => true,
                'data' => $personnel
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data personnel tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data personnel'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mengupdate data personnel
     */
    public function update(Request $request, $personnel_id)
    {
        try {
            $personnel = personnels::findOrFail($personnel_id);

            // Validasi input
            $validated = $request->validate([
                'personnel_id' => 'sometimes|string|unique:personnels,personnel_id,'.$personnel_id.',personnel_id',
                'loadCellID' => 'sometimes|integer',
                'nokartu' => 'sometimes|string|exists:tmprfids,nokartu', // Pastikan nokartu ada di tmprfids
                'nama' => 'sometimes|string|max:255',
                'pangkat' => 'sometimes|string|max:255',
                'nrp' => 'sometimes|string|max:50',
                'jabatan' => 'sometimes|string|max:255',
                'kesatuan' => 'sometimes|string|max:255'
            ]);

            $personnel->update($validated);

            return response()->json([
                'success' => true,
                'data' => $personnel
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data personnel tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate personnel: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Menghapus data personnel
     */
    public function destroy($personnel_id)
    {
        try {
            $personnel = personnels::findOrFail($personnel_id);
            $personnel->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data personnel berhasil dihapus'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data personnel tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus personnel: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
