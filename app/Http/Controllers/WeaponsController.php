<?php

namespace App\Http\Controllers;

use App\Models\weapons;
use App\Http\Requests\StoreweaponsRequest;
use App\Http\Requests\UpdateweaponsRequest;

class WeaponsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data senjata dari database
        $weapons = weapons::all();

        // Array untuk menyimpan data yang sudah dikelompokkan
        $groupedWeapons = [];

        // Loop melalui setiap senjata dan kelompokkan berdasarkan rackNumber
        foreach ($weapons as $weapon) {
            $rackNumber = $weapon->rackNumber;

            // Jika rackNumber belum ada di array, buat entry baru
            if (!isset($groupedWeapons[$rackNumber])) {
                $groupedWeapons[$rackNumber] = [
                    'rackNumber' => $rackNumber,
                    'loadCells' => [],
                    'status' => [],
                    'weight' => [],
                ];
            }

            // Tambahkan data loadCells, status, dan weight ke array yang sesuai
            $groupedWeapons[$rackNumber]['loadCells'] = array_merge(
                $groupedWeapons[$rackNumber]['loadCells'],
                explode(',', $weapon->loadCells)
            );
            $groupedWeapons[$rackNumber]['status'] = array_merge(
                $groupedWeapons[$rackNumber]['status'],
                explode(',', $weapon->status)
            );
            $groupedWeapons[$rackNumber]['weight'] = array_merge(
                $groupedWeapons[$rackNumber]['weight'],
                explode(',', $weapon->weight)
            );
        }

        // Kirim data yang sudah dikelompokkan ke view
        return view('weapons', ['weapons' => array_values($groupedWeapons)]);
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
    public function store(StoreweaponsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(weapons $weapons)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(weapons $weapons)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateweaponsRequest $request, weapons $weapons)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(weapons $weapons)
    {
        //
    }
}
