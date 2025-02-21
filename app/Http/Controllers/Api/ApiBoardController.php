<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Weapons;
use Illuminate\Http\Request;

class ApiBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data weapons dari database
        $boards = Weapons::all();

        // Tambahkan lampu indikator berdasarkan weight
        $boards->transform(function ($board) {
            $board->indicator = $this->getIndicator($board->weight);
            return $board;
        });

        // Kembalikan response JSON
        return response()->json([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'data' => $boards,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Cari data berdasarkan ID
        $board = Weapons::find($id);

        // Jika data tidak ditemukan, kembalikan response 404
        if (!$board) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
            ], 404);
        }

        // Tambahkan lampu indikator berdasarkan weight
        $board->indicator = $this->getIndicator($board->weight);

        // Kembalikan response JSON
        return response()->json([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'data' => $board,
        ]);
    }

    /**
     * Fungsi untuk menentukan lampu indikator berdasarkan weight.
     */
    private function getIndicator($weight)
    {
        if ($weight <= 0) {
            return [
                'color' => 'red',
                'status' => 0,
            ];
        } elseif ($weight > 3000 && $weight <= 4000) {
            return [
                'color' => 'yellow',
                'status' => 1,
            ];
        } elseif ($weight > 4000) {
            return [
                'color' => 'green',
                'status' => 2,
            ];
        }
    }
}
