<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    public function get(Request $request) {
        // $barangs = DB::table('keranjangs')
        //     ->join('mst_barang', 'keranjangs.id_barang', '=', 'mst_barang.id_barang')
        //     ->where('keranjangs.id_karyawan', $request->id)
        //     ->select('mst_barang.*', 'keranjangs.qty', 'keranjangs.qty_besar', 'keranjangs.qty_tengah', 'keranjangs.qty_kecil', 'keranjangs.disc_cash', 'keranjangs.disc_perc', 'keranjangs.ket_detail', )
        //     ->get();

        $barangs = DB::table('keranjangs as d')
            ->join('mst_barang as b', 'd.id_barang', '=', 'b.id_barang')
            ->where('d.id_karyawan', $request->id)
            ->select(
                'b.*',
                'd.qty',
                'd.qty_besar',
                'd.qty_tengah',
                'd.qty_kecil',
                'd.disc_cash',
                'd.disc_perc',
                'd.ket_detail'
            )
            ->selectRaw('
                (
                    (d.qty_besar * b.harga) +
                    (d.qty_tengah * b.harga / b.konversi_besar) +
                    (d.qty_kecil * b.harga / (b.konversi_besar * b.konversi_tengah))
                ) AS subtotal
            ')
            ->selectRaw('
                (
                    (
                        (d.qty_besar * (b.harga - d.disc_cash)) +
                        (d.qty_tengah * (b.harga - d.disc_cash) / b.konversi_besar) +
                        (d.qty_kecil * (b.harga - d.disc_cash) / (b.konversi_besar * b.konversi_tengah))
                    ) * (1 - d.disc_perc / 100)
                ) AS total
            ')
            ->get();

        $barangs->transform(function ($item) {
            $item->qty = (float) $item->qty;
            $item->qty_besar = (float) $item->qty_besar;
            $item->qty_tengah = (float) $item->qty_tengah;
            $item->qty_kecil = (float) $item->qty_kecil;
            $item->disc_cash = (float) $item->disc_cash;
            $item->disc_perc = (float) $item->disc_perc;
            $item->subtotal = (float) $item->subtotal;
            $item->total = (float) $item->total;
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
            'disc_cash' => 'required|integer',
            'disc_perc' => 'required|integer',
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
                    'disc_cash' => $request->disc_cash,
                    'disc_perc' => $request->disc_perc,
                    'ket_detail' => $request->ket,
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
                'disc_cash' => $request->disc_cash,
                'disc_perc' => $request->disc_perc,
                'ket_detail' => $request->ket,                
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
            ->select('mst_barang.*', 'trn_sales_order_detail.qty_besar', 'trn_sales_order_detail.qty_tengah', 'trn_sales_order_detail.qty_kecil', 'trn_sales_order_detail.disc_cash', 'trn_sales_order_detail.disc_perc', 'trn_sales_order_detail.ket_detail')
            ->get();

        $barangs->transform(function ($item) {
            $item->qty_besar = (float) $item->qty_besar;
            $item->qty_tengah = (float) $item->qty_tengah;
            $item->qty_kecil = (float) $item->qty_kecil;
            $item->disc_cash = (float) $item->disc_cash;
            $item->disc_perc = (float) $item->disc_perc;
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
