<?php

namespace App\Http\Controllers;

use App\Models\mst_karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MstKaryawanController extends Controller
{
    public function index()
    {
        return response()->json(mst_karyawan::all());
    }

    public function store(Request $request)
    {
        Log::info('karyawan store ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
            $validated = $request->validate([
                'id_karyawan' => 'required|integer|unique:mst_karyawan,id_karyawan',
                'kode_karyawan' => 'required|string|max:50',
                'nama' => 'nullable|string|max:100',
            ]);

            $karyawan = mst_karyawan::create($validated);

            return response()->json($karyawan, 201);
        } catch (\Exception $e) {
            Log::error('karyawan store ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $karyawan = mst_karyawan::findOrFail($id);
        return response()->json($karyawan);
    }

    public function update(Request $request, $id)
    {
        Log::info('karyawan update ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
            $karyawan = mst_karyawan::findOrFail($id);

            $validated = $request->validate([
                'kode_karyawan' => 'required|string|max:50',
                'nama' => 'nullable|string|max:100',
            ]);

            $karyawan->update($validated);

            return response()->json($karyawan);
        } catch (\Exception $e) {
            Log::error('karyawan update ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        Log::info('karyawan destroy ' . $id, ['id' => $id]);
        try {
            $karyawan = mst_karyawan::findOrFail($id);
            $karyawan->delete();

            return response()->json(['message' => 'Karyawan deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('karyawan destroy ' . $id . ' ERROR: ' . $e->getMessage(), ['id' => $id]);
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }
}
