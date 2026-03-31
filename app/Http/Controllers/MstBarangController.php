<?php

namespace App\Http\Controllers;

use App\Models\mst_barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MstBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function searchBarang(Request $request)
    {
        $keyword = $request->input('keyword');
        $data = DB::table('mst_karyawan')
            ->join('mst_barang', 'mst_barang.id_departemen', '=', 'mst_karyawan.id_departemen')
            ->leftjoin('list_stok', 'mst_barang.id_barang', '=', 'list_stok.id_barang')
            ->where('mst_karyawan.id_karyawan', $request->id)
            ->where('nama_barang', 'like', '%' . $keyword . '%')
            ->orWhere('kode_barang', 'like', '%' . $keyword . '%')
            ->select('mst_barang.*', 'list_stok.qty_besar', 'list_stok.qty_tengah', 'list_stok.qty_kecil')
            ->get();

        $data->transform(function ($item) {
            $item->qty_besar = (float) $item->qty_besar;
            $item->qty_tengah = (float) $item->qty_tengah;
            $item->qty_kecil = (float) $item->qty_kecil;
            return $item;
        });

        return response()->json([
            'status' => 'Success',
            'message' => 'true',
            'statusCode' => 200,
            'data' => $data
        ]);
    }

    public function index(Request $request)
    {
        $data = DB::table('mst_karyawan')
            ->join('mst_barang', 'mst_barang.id_departemen', '=', 'mst_karyawan.id_departemen')
            ->leftjoin('list_stok', 'mst_barang.id_barang', '=', 'list_stok.id_barang')
            ->where('mst_karyawan.id_karyawan', $request->id)
            ->select('mst_barang.*', 'list_stok.qty_besar', 'list_stok.qty_tengah', 'list_stok.qty_kecil')
            ->get();

        // $data = mst_barang::all();
        $data->transform(function ($item) {
            $item->qty_besar = (float) $item->qty_besar;
            $item->qty_tengah = (float) $item->qty_tengah;
            $item->qty_kecil = (float) $item->qty_kecil;
            return $item;
        });
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
        Log::info('barang store ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
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
        } catch (\Exception $e) {
            Log::error('barang store ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
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
        Log::info('barang update ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
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
        } catch (\Exception $e) {
            Log::error('barang update ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Log::info('barang destroy ' . $id, ['id' => $id]);
        try {
            $barang = mst_barang::findOrFail($id);
            $barang->delete();

            return response()->json(['message' => 'Barang deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('barang destroy ' . $id . ' ERROR: ' . $e->getMessage(), ['id' => $id]);
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }
}
