<?php

namespace App\Http\Controllers;

use App\Models\Weapons;
use Illuminate\Http\Request;

class BoardController extends Controller
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

        // Tampilkan view 'board.index' dan kirim data $boards ke view
        return view('board', compact('boards'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Weapons $board)
    {
        // Tambahkan lampu indikator berdasarkan weight
        $board->indicator = $this->getIndicator($board->weight);

        // Tampilkan view 'board.show' dan kirim data $board ke view
        return view('board.show', compact('board'));
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
