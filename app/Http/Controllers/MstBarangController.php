<?php

namespace App\Http\Controllers;

use App\Models\mst_barang;
use Illuminate\Http\Request;

class MstBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function searchBarang()
    {
        $keyword = $request->input('keyword'); // Get the keyword from the request
        $barang = DB::table('mst_barang')
                    ->where('nama', 'like', '%' . $keyword . '%') // Search by name
                    ->get();
    
        return response()->json([
            'status' => 'Success',
            'message' => 'true',
            'statusCode' => 200,
            'data' => $barang
        ]);    
    }
    
    public function index()
    {
        $data = mst_barang::all();
        return response()->json([
            'status' => 'Success',
            'message' => 'Data successfully retrieved',
            'statusCode' => 200,
            'data' => $data
        ]);        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Jika menggunakan API, biasanya ini tidak diperlukan.
        // Bisa dikosongkan atau dihapus jika tidak pakai view.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_barang' => 'required|integer|unique:mst_barang,id_barang',
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'nullable|string|max:255',
            'satuan_besar' => 'nullable|integer',
            'satuan_tengah' => 'nullable|integer',
            'satuan_kecil' => 'nullable|integer',
            'konversi_besar' => 'nullable|numeric',
            'konversi_tengah' => 'nullable|numeric',
            'gambar' => 'nullable|string',
        ]);

        $barang = mst_barang::create($validated);

        return response()->json($barang, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $barang = mst_barang::findOrFail($id);
        return response()->json($barang);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Biasanya tidak digunakan dalam API. Hapus jika tidak perlu.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $barang = mst_barang::findOrFail($id);

        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'nullable|string|max:255',
            'satuan_besar' => 'nullable|integer',
            'satuan_tengah' => 'nullable|integer',
            'satuan_kecil' => 'nullable|integer',
            'konversi_besar' => 'nullable|numeric',
            'konversi_tengah' => 'nullable|numeric',
            'gambar' => 'nullable|string',
        ]);

        $barang->update($validated);

        return response()->json($barang);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = mst_barang::findOrFail($id);
        $barang->delete();

        return response()->json(['message' => 'Barang deleted successfully.']);
    }
}
