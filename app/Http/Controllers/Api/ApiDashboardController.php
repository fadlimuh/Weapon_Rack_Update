<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Status; // Pastikan model Status di-import
use Illuminate\Http\Request;

class ApiDashboardController extends Controller
{
    /**
     * Menampilkan data dashboard dalam format JSON.
     */
    public function index()
    {
        // Ambil semua data status dari database
        $statuses = Status::with('personnel')->get();

        // Hitung total senjata, personel aktif, dan status terbaru
        $totalWeapons = $statuses->count();
        $totalActivePersonnel = $statuses->unique('loadCellID')->count();
        $totalActiveWeapons = $statuses->where('time_out', null)->count();

        // Format data untuk response JSON
        $data = [
            'success' => true,
            'message' => 'Data dashboard retrieved successfully',
            'data' => [
                'total_weapons' => $totalWeapons,
                'total_active_personnel' => $totalActivePersonnel,
                'total_active_weapons' => $totalActiveWeapons,
                'statuses' => $statuses->map(function ($status) {
                    return [
                        'load_cell_id' => $status->loadCellID,
                        'personnel_name' => $status->personnel->nama_personel ?? 'N/A',
                        'tanggal' => $status->tanggal,
                        'time_in' => $status->time_in,
                        'time_out' => $status->time_out ?? 'Masih aktif',
                        'duration' => $status->duration ?? 'N/A',
                        'status' => $status->time_out ? 'Selesai' : 'Aktif',
                    ];
                }),
            ],
        ];

        // Kembalikan response JSON
        return response()->json($data);
    }
}
