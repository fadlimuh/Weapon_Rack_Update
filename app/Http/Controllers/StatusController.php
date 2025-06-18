<?php

namespace App\Http\Controllers;

use App\Models\personnels;
use App\Models\Status; // Sesuaikan dengan nama model yang benar
use App\Models\weapons;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // Ambil loadcellid dari tabel personnels
        $loadcell_id = personnels::pluck('loadCellID');

        // Ambil loadcellid dari tabel weapons
        $loadcell_id = $loadcell_id->merge(weapons::pluck('loadCellID'));

        // Ambil semua data status dari database
        $statuses = Status::whereIn('loadCellID', $loadcell_id)
            ->with(['personnel' => function ($query) {
                $query->select('loadCellID', 'nama'); // Ambil hanya kolom yang diperlukan
            }, 'personnel.weapon'])
            ->get();

        // Kirim data ke view dashboard
        return view('dashboard', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Status $status)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        //
    }
}
