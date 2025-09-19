<?php

namespace App\Http\Controllers;

use App\Models\mst_provinsi;
use Illuminate\Http\Request;

class MstProvinsiController extends Controller
{
    public function index()
    {
        return response()->json(mst_provinsi::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_provinsi' => 'required|integer|unique:mst_provinsi,id_provinsi',
            'kode_provinsi' => 'required|string|max:50',
        ]);

        $provinsi = mst_provinsi::create($validated);

        return response()->json($provinsi, 201);
    }

    public function show($id)
    {
        $provinsi = mst_provinsi::findOrFail($id);
        return response()->json($provinsi);
    }

    public function update(Request $request, $id)
    {
        $provinsi = mst_provinsi::findOrFail($id);

        $validated = $request->validate([
            'kode_provinsi' => 'required|string|max:50',
        ]);

        $provinsi->update($validated);

        return response()->json($provinsi);
    }

    public function destroy($id)
    {
        $provinsi = mst_provinsi::findOrFail($id);
        $provinsi->delete();

        return response()->json(['message' => 'Provinsi deleted successfully.']);
    }
}
