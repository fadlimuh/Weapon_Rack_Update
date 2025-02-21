<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.admin', compact('users'));
    }
    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8'

        ]);

        try {
            $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['success' => true, 'message' => 'Admin berhasil ditambahkan.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Gagal menambahkan admin.']);
    }
}




    public function edit(User $user)
    {
        return view('admin.edit-admin', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required|confirmed|min:8'

        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.index')->with('success', 'Berhasil di update');
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('error', 'Gagal menghapus admin.');
        }
    }

}

