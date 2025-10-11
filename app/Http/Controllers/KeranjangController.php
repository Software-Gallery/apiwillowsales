<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    public function get(Request $request) {
        // $barangs_id = DB::table('keranjangs')
        //     ->where('id_karyawan', $request->id)
        //     ->pluck('id_barang');

        // $barangs = DB::table('mst_barang')
        //     ->whereIn('id_barang', $barangs_id)
        //     ->get();

        $barangs = DB::table('keranjangs')
            ->join('mst_barang', 'keranjangs.id_barang', '=', 'mst_barang.id_barang')
            ->where('keranjangs.id_karyawan', $request->id)
            ->select('mst_barang.*', 'keranjangs.qty')
            ->get();

        $barangs->transform(function ($item) {
            $item->qty = (float) $item->qty;
            return $item;
        });        
        
        return response()->json([
            'status' => 'Success',
            'message' => 'true',
            'statusCode' => 200,
            'data' => $barangs
        ]);
    }

    public function add(Request $request) {
        // Validasi request
        $request->validate([
            'id_karyawan' => 'required|integer', 
            'id_barang' => 'required|integer',
            'qty' => 'required'
        ]);
    
        // Cek apakah barang sudah ada di favorit member tersebut
        $existingFavorite = DB::table('keranjangs')
            ->where('id_karyawan', $request->id_karyawan)
            ->where('id_barang', $request->id_barang)
            ->first();
        if ($existingFavorite) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Item is already in cart',
                'statusCode' => 400
            ]);
        }
    
        // Simpan data ke tabel favorites
        DB::table('keranjangs')->insert([
            'id_karyawan' => $request->id_karyawan,
            'id_barang' => $request->id_barang,
            'qty' => $request->qty,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return response()->json([
            'status' => 'Success',
            'message' => 'Item added to carts',
            'statusCode' => 200
        ]);
    }

    public function remove(Request $request) {
        // Validasi request
        $request->validate([
            'id_karyawan' => 'required|integer', 
            'id_barang' => 'required|integer',
            'qty' => 'required'
        ]);
    
        // Cek apakah barang ada di favorit member tersebut
        $existingFavorite = DB::table('keranjangs')
            ->where('id_karyawan', $request->id_karyawan)
            ->where('id_barang', $request->id_barang)
            ->first();
    
        if (!$existingFavorite) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Item is not in cart',
                'statusCode' => 400
            ]);
        }
    
        // Hapus data dari tabel favorites
        DB::table('keranjangs')
            ->where('id_karyawan', $request->id_karyawan)
            ->where('id_barang', $request->id_barang)
            ->delete();
    
        return response()->json([
            'status' => 'Success',
            'message' => 'Item removed from cart',
            'statusCode' => 200
        ]);
    }
}
