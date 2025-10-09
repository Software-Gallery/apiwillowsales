<?php

namespace App\Http\Controllers;

use App\Models\mst_kecamatan;
use Illuminate\Http\Request;

class MstKecamatanController extends Controller
{
    public function index()
    {
        return response()->json(mst_kecamatan::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kecamatan' => 'required|integer|unique:mst_kecamatan,id_kecamatan',
            'kode_kecamatan' => 'required|string|max:50',
        ]);

        $kecamatan = mst_kecamatan::create($validated);

        return response()->json($kecamatan, 201);
    }

    public function show($id)
    {
        $kecamatan = mst_kecamatan::findOrFail($id);
        return response()->json($kecamatan);
    }

    public function update(Request $request, $id)
    {
        $kecamatan = mst_kecamatan::findOrFail($id);

        $validated = $request->validate([
            'kode_kecamatan' => 'required|string|max:50',
        ]);

        $kecamatan->update($validated);

        return response()->json($kecamatan);
    }

    public function destroy($id)
    {
        $kecamatan = mst_kecamatan::findOrFail($id);
        $kecamatan->delete();

        return response()->json(['message' => 'Kecamatan deleted successfully.']);
    }
}
