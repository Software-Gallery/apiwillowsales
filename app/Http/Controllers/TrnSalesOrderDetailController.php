<?php

namespace App\Http\Controllers;

use App\Models\trn_sales_order_detail;
use App\Models\trn_sales_order_header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrnSalesOrderDetailController extends Controller
{
    public function index()
    {
        return response()->json(trn_sales_order_detail::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_sales_order' => 'required|string|max:30',
            'id_barang' => 'required|integer',
            'qty_besar' => 'nullable|numeric',
            'qty_tengah' => 'nullable|numeric',
            'qty_kecil' => 'nullable|numeric',
            'harga' => 'nullable|numeric',
            'disc_cash' => 'nullable|numeric',
            'disc_perc' => 'nullable|numeric',
            'subtotal' => 'nullable|numeric',
            'ket_detail' => 'nullable|string|max:200',
        ]);

        $detail = trn_sales_order_detail::create($validated);

        return response()->json($detail, 201);
    }

    public function show(Request $request)
    {
        $detail = trn_sales_order_detail::where('kode_sales_order', $request->kode_sales_order)
            ->where('id_barang', $request->id_barang)
            ->firstOrFail();

        return response()->json($detail);
    }

    public function update(Request $request)
    {
        // Validasi request
        $request->validate([ 
            'kode_sales_order' => 'required|integer',
            'id_barang' => 'required|integer',
            'qty' => 'required|string',
            'disc_cash' => 'nullable|numeric',
            'disc_perc' => 'nullable|numeric',       
        ]);

        $qtyParts = array_pad(explode('.', $request->qty), 3, 0);
        $qty_besar = (int) $qtyParts[0];   
        $qty_tengah = (int) $qtyParts[1];
        $qty_kecil = (int) $qtyParts[2]; 

        $existingFavorite = DB::table('trn_sales_order_detail')
            ->where('kode_sales_order', $request->kode_sales_order)
            ->where('id_barang', $request->id_barang)
            ->first();

        if ($existingFavorite) {
            DB::table('trn_sales_order_detail')
                ->where('kode_sales_order', $request->kode_sales_order)
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
                
            $totalOrder = $this->HitungTotal($request->kode_sales_order);
            DB::table('trn_sales_order_header')
                ->where('kode_sales_order', $request->kode_sales_order)
                ->update([
                    'total' => $totalOrder
                ]);  

            return response()->json([
                'status' => 'Success',
                'message' => 'Item quantity updated in cart',
                'statusCode' => 200
            ]);
        } 
    }

    public function destroy(Request $request)
    {
        $detail = trn_sales_order_detail::where('kode_sales_order', $request->kode_sales_order)
            ->where('id_barang', $request->id_barang)
            ->firstOrFail();

        $detail->delete();

        return response()->json(['message' => 'Sales order detail deleted successfully.']);
    }

    public function HitungTotal(String $nomor) {
        $data = trn_sales_order_header::selectRaw('
            (qty_besar * konversi_besar * konversi_tengah) AS besar,
            (qty_tengah * konversi_tengah) AS tengah,
            (qty_kecil) AS kecil,
            d.harga, d.disc_cash, d.disc_perc
        ')
        ->from('trn_sales_order_detail as d')
        ->leftJoin('mst_barang as b', 'b.id_barang', '=', 'd.id_barang')
        ->where('d.kode_sales_order', $nomor)
        ->get();

        // dd($data);
        $totalOrder = 0;
        foreach ($data as $detail) {
            $totalQty = ($detail->besar+$detail->tengah+$detail->kecil)*$detail->harga;
            $totalOrder += $totalQty-($totalQty*$detail->disc_perc/100)-$detail->disc_cash;
        }
        return $totalOrder;
    }    
}
