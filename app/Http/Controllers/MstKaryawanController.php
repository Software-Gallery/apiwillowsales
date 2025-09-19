<?php

namespace App\Http\Controllers;

use App\Models\mst_karyawan;
use Illuminate\Http\Request;

class MstKaryawanController extends Controller
{
    public function index()
    {
        return response()->json(mst_karyawan::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_karyawan' => 'required|integer|unique:mst_karyawan,id_karyawan',
            'kode_karyawan' => 'required|string|max:50',
            'nama' => 'nullable|string|max:100',
        ]);

        $karyawan = mst_karyawan::create($validated);

        return response()->json($karyawan, 201);
    }

    public function show($id)
    {
        $karyawan = mst_karyawan::findOrFail($id);
        return response()->json($karyawan);
    }

    public function update(Request $request, $id)
    {
        $karyawan = mst_karyawan::findOrFail($id);

        $validated = $request->validate([
            'kode_karyawan' => 'required|string|max:50',
            'nama' => 'nullable|string|max:100',
        ]);

        $karyawan->update($validated);

        return response()->json($karyawan);
    }

    public function destroy($id)
    {
        $karyawan = mst_karyawan::findOrFail($id);
        $karyawan->delete();

        return response()->json(['message' => 'Karyawan deleted successfully.']);
    }
}
