<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\tmprfid;
use App\Models\personnels;
use App\Models\weapons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PersonnelsController extends Controller
{
    public function index()
    {
        $personnel = Personnels::with('weapon')->get();
        $weapons = weapons::select('loadCellID')->get();
        return view('personnels', compact('personnel', 'weapons'));
    }

    public function fetchPersonnel()
    {
        try {
            $response = Http::get('http://192.168.1.10:8000/api/personnel-data');
            $data = $response->json()['data'] ?? [];

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error fetching personnel data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch personnel data'], 500);
        }
    }

    public function create()
    {
        return view('personnels.create-personnels');
    }

    public function store(Request $request)
    {
            // Validasi data
            $request->validate([
                'personnel_id' => 'required|numeric|unique:personnels,personnel_id',
                'loadCellID' => 'required|string|exists:weapons,loadCellID', // Pastikan weapons memiliki kolom loadCellID
                'nokartu' => 'required|numeric|exists:tmprfids,nokartu', // Pastikan tmprfids memiliki kolom nokartu
                'nama' => 'required|string',
                'pangkat' => 'required|string',
                'nrp' => 'required|string|unique:personnels,nrp',
                'jabatan' => 'required|string',
                'kesatuan' => 'required|string',
            ]);

            try {
                // Simpan data ke database
                personnels::create([
                    'personnel_id' => $request->personnel_id,
                    'loadCellID' => $request->loadCellID,
                    'nokartu' => $request->nokartu,
                    'nama' => $request->nama,
                    'pangkat' => $request->pangkat,
                    'nrp' => $request->nrp,
                    'jabatan' => $request->jabatan,
                    'kesatuan' => $request->kesatuan,
                ]);

                // Redirect ke halaman index dengan pesan sukses
                return redirect()->route('personnels.index')->with('success', 'Data personnel berhasil ditambahkan!');
            } catch (\Exception $e) {
                // Redirect kembali dengan pesan error jika terjadi kesalahan
                return redirect()->back()->withErrors('Terjadi kesalahan: ' . $e->getMessage())->withInput();
            }
    }

    public function show($id)
    {
        $personnel = personnels::with('weapon')->findOrFail($id);
        $weapons = weapons::select('loadCellID')->get();
        return view('webpage.personnel', compact('personnel', 'weapons'));
    }

    public function edit($id)
    {
        $personnel = personnels::findOrFail($id);
        $weapons = weapons::select('loadCellID')->distinct()->get();
        return view('personnels.edit-personnels', compact('personnel', 'weapons'));
    }

    public function update(Request $request, $id)
    {
        $personnel = personnels::findOrFail($id);

        $request->validate([
            'loadCellID' => 'required|exists:weapons,loadCellID',
            'nama' => 'required',
            'pangkat' => 'required',
            'nrp' => 'required|unique:personnels,nrp,' . $id . ',personnel_id',
            'jabatan' => 'required',
            'kesatuan' => 'required',
        ]);

        $personnel->update($request->all());
        return redirect()->route('personnels.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $personnel = personnels::findOrFail($id);
        $personnel->delete();
        return redirect()->route('personnel.index')->with('success', 'Data berhasil dihapus');
    }
}
