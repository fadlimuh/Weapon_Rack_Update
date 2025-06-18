<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\weapons;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data senjata dengan relasi personel, diurutkan berdasarkan loadCellID
        $statuses = weapons::with('personnel')->orderBy('loadCellID', 'asc')->get();

        $data = $statuses->map(function ($weapon, $index) use ($statuses) {
            // Ambil time_out dari data terakhir sebelum data baru masuk
            $time_out = $index > 0 ? $statuses[$index - 1]->timestamp : null;

            // Ambil time_in dari data saat ini
            $time_in = $weapon->timestamp;

            // Hitung durasi dalam jam dan menit
            $durasi = 'N/A';
            if ($time_out && $time_in) {
                $diffInSeconds = abs(strtotime($time_in) - strtotime($time_out));
                $hours = floor($diffInSeconds / 3600);
                $minutes = floor(($diffInSeconds % 3600) / 60);
                $durasi = "{$hours} jam {$minutes} menit";
            }

            return [
                'id_senjata' => $weapon->loadCellID,
                'nama_pengguna' => $weapon->personnel->nama ?? 'N/A',
                'tanggal' => \Carbon\Carbon::parse($time_in)->format('Y-m-d'),
                'time_in' => \Carbon\Carbon::parse($time_in)->format('H:i:s'),
                'time_out' => $time_out ? \Carbon\Carbon::parse($time_out)->format('H:i:s') : 'N/A',
                'durasi' => $durasi,
                'status' => $time_out ? 'Selesai' : 'Aktif',
            ];
        });

        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     */

        public function store(Request $request)
        {
            // Validasi data yang diterima
            $validatedData = $request->validate([
                'load_cell_id' => 'required|string',
                'personnel_id' => 'required|integer',
                'tanggal' => 'required|date',
                'time_in' => 'required|date_format:H:i:s',
                'time_out' => 'nullable|date_format:H:i:s',
                'duration' => 'nullable|string',
            ]);

            // Simpan data ke database
            $status = Status::create($validatedData);

            // Kembalikan response JSON
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $status,
            ], 201);
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
