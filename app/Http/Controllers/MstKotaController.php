<?php

namespace App\Http\Controllers;

use App\Models\mst_kota;
use Illuminate\Http\Request;

class MstKotaController extends Controller
{
    public function index()
    {
        return response()->json(mst_kota::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kota' => 'required|integer|unique:mst_kota,id_kota',
            'kode_kota' => 'required|string|max:50',
        ]);

        $kota = mst_kota::create($validated);

        return response()->json($kota, 201);
    }

    public function show($id)
    {
        $kota = mst_kota::findOrFail($id);
        return response()->json($kota);
    }

    public function update(Request $request, $id)
    {
        $kota = mst_kota::findOrFail($id);

        $validated = $request->validate([
            'kode_kota' => 'required|string|max:50',
        ]);

        $kota->update($validated);

        return response()->json($kota);
    }

    public function destroy($id)
    {
        $kota = mst_kota::findOrFail($id);
        $kota->delete();

        return response()->json(['message' => 'Kota deleted successfully.']);
    }
}
