<?php

namespace App\Http\Controllers;

use App\Models\mst_kelurahan;
use Illuminate\Http\Request;

class MstKelurahanController extends Controller
{
    public function index()
    {
        return response()->json(mst_kelurahan::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kelurahan' => 'required|integer|unique:mst_kelurahan,id_kelurahan',
            'kode_kelurahan' => 'required|string|max:50',
        ]);

        $kelurahan = mst_kelurahan::create($validated);

        return response()->json($kelurahan, 201);
    }

    public function show($id)
    {
        $kelurahan = mst_kelurahan::findOrFail($id);
        return response()->json($kelurahan);
    }

    public function update(Request $request, $id)
    {
        $kelurahan = mst_kelurahan::findOrFail($id);

        $validated = $request->validate([
            'kode_kelurahan' => 'required|string|max:50',
        ]);

        $kelurahan->update($validated);

        return response()->json($kelurahan);
    }

    public function destroy($id)
    {
        $kelurahan = mst_kelurahan::findOrFail($id);
        $kelurahan->delete();

        return response()->json(['message' => 'Kelurahan deleted successfully.']);
    }
}
