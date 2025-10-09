<?php

namespace App\Http\Controllers;

use App\Models\mst_departemen;
use Illuminate\Http\Request;

class MstDepartemenController extends Controller
{
    public function index()
    {
        return response()->json(mst_departemen::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_departemen' => 'required|integer|unique:mst_departemen,id_departemen',
            'kode_departemen' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:100',
        ]);

        $departemen = mst_departemen::create($validated);

        return response()->json($departemen, 201);
    }

    public function show($id)
    {
        $departemen = mst_departemen::findOrFail($id);
        return response()->json($departemen);
    }

    public function update(Request $request, $id)
    {
        $departemen = mst_departemen::findOrFail($id);

        $validated = $request->validate([
            'kode_departemen' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:100',
        ]);

        $departemen->update($validated);

        return response()->json($departemen);
    }

    public function destroy($id)
    {
        $departemen = mst_departemen::findOrFail($id);
        $departemen->delete();

        return response()->json(['message' => 'Departemen deleted successfully.']);
    }
}
