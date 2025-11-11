<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    public function get(Request $request) {
        $barangs = DB::table('keranjangs')
            ->join('mst_barang', 'keranjangs.id_barang', '=', 'mst_barang.id_barang')
            ->where('keranjangs.id_karyawan', $request->id)
            ->select('mst_barang.*', 'keranjangs.qty', 'keranjangs.qty_besar', 'keranjangs.qty_tengah', 'keranjangs.qty_kecil')
            ->get();

        $barangs->transform(function ($item) {
            $item->qty = (float) $item->qty;
            $item->qty_besar = (float) $item->qty_besar;
            $item->qty_tengah = (float) $item->qty_tengah;
            $item->qty_kecil = (float) $item->qty_kecil;
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
            'qty' => 'required|string',
        ]);

        $qtyParts = array_pad(explode('.', $request->qty), 3, 0);
        $qty_besar = (int) $qtyParts[0];   
        $qty_tengah = (int) $qtyParts[1];
        $qty_kecil = (int) $qtyParts[2]; 

        $existingFavorite = DB::table('keranjangs')
            ->where('id_karyawan', $request->id_karyawan)
            ->where('id_barang', $request->id_barang)
            ->first();

        if ($existingFavorite) {
            DB::table('keranjangs')
                ->where('id_karyawan', $request->id_karyawan)
                ->where('id_barang', $request->id_barang)
                ->update([
                    'qty_besar' => $qty_besar,
                    'qty_tengah' => $qty_tengah,
                    'qty_kecil' => $qty_kecil,
                    'updated_at' => now()
                ]);

            return response()->json([
                'status' => 'Success',
                'message' => 'Item quantity updated in cart',
                'statusCode' => 200
            ]);
        } else {
            DB::table('keranjangs')->insert([
                'id_karyawan' => $request->id_karyawan,
                'id_barang' => $request->id_barang,
                'qty_besar' => $qty_besar,
                'qty_tengah' => $qty_tengah,
                'qty_kecil' => $qty_kecil,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'Success',
                'message' => 'Item added to cart',
                'statusCode' => 200
            ]);
        }
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

    public function getTrnDetail(Request $request) {
        $barangs = DB::table('trn_sales_order_detail')
            ->join('mst_barang', 'trn_sales_order_detail.id_barang', '=', 'mst_barang.id_barang')
            ->where('trn_sales_order_detail.kode_sales_order', $request->kode)
            ->select('mst_barang.*', 'trn_sales_order_detail.qty', 'trn_sales_order_detail.qty_besar', 'trn_sales_order_detail.qty_tengah', 'trn_sales_order_detail.qty_kecil')
            ->get();

        $barangs->transform(function ($item) {
            $item->qty = (float) $item->qty;
            $item->qty_besar = (float) $item->qty_besar;
            $item->qty_tengah = (float) $item->qty_tengah;
            $item->qty_kecil = (float) $item->qty_kecil;
            return $item;
        });        
        
        return response()->json([
            'status' => 'Success',
            'message' => 'true',
            'statusCode' => 200,
            'data' => $barangs
        ]);
    }    
}
