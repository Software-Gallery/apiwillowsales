<?php

namespace App\Http\Controllers;

use App\Models\mst_satuan;
use Illuminate\Http\Request;

class MstSatuanController extends Controller
{
    public function index()
    {
        return response()->json(mst_satuan::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_satuan' => 'required|integer|unique:mst_satuan,id_satuan',
            'kode_satuan' => 'required|string|max:5',
        ]);

        $satuan = mst_satuan::create($validated);

        return response()->json($satuan, 201);
    }

    public function show($id)
    {
        $satuan = mst_satuan::findOrFail($id);
        return response()->json($satuan);
    }

    public function update(Request $request, $id)
    {
        $satuan = mst_satuan::findOrFail($id);

        $validated = $request->validate([
            'kode_satuan' => 'required|string|max:5',
        ]);

        $satuan->update($validated);

        return response()->json($satuan);
    }

    public function destroy($id)
    {
        $satuan = mst_satuan::findOrFail($id);
        $satuan->delete();

        return response()->json(['message' => 'Satuan deleted successfully.']);
    }
}
