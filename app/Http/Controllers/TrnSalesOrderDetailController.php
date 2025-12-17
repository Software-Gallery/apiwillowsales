<?php

namespace App\Http\Controllers;

use App\Models\trn_sales_order_detail;
use App\Models\trn_sales_order_header;
use App\Models\mst_barang;
use App\Models\keranjang;
use App\Http\Controllers\MstBarangController;
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
        // $validated = $request->validate([
        //     'kode_sales_order' => 'required|string|max:30',
        //     'id_barang' => 'required|integer',
        //     'qty_besar' => 'nullable|numeric',
        //     'qty_tengah' => 'nullable|numeric',
        //     'qty_kecil' => 'nullable|numeric',
        //     'harga' => 'nullable|numeric',
        //     'disc_cash' => 'nullable|numeric',
        //     'disc_perc' => 'nullable|numeric',
        //     'subtotal' => 'nullable|numeric',
        //     'ket_detail' => 'nullable|string|max:200',
        // ]);
        // $detail = trn_sales_order_detail::create($validated);
        $validated = $request->validate([
            'kode_sales_order' => 'required|string|max:30',
        ]);
        $keranjangs = keranjang::where('id_karyawan', $request->id_karyawan)
                               ->leftJoin('mst_barang', 'keranjangs.id_barang', '=', 'mst_barang.id_barang')
                               ->get();
        $total = 0;
        $trnSalesController = new TrnSalesOrderHeaderController();
        foreach ($keranjangs as $keranjang) {
            $harga = $trnSalesController->HitungTotal($request->id_karyawan, $keranjang->id_barang);
            $total+=$harga['total'];
            trn_sales_order_detail::create([
                'kode_sales_order' => $validated['kode_sales_order'],
                'id_barang' => $keranjang->id_barang,
                'qty_besar' => $keranjang->qty_besar,
                'qty_tengah' => $keranjang->qty_tengah,
                'qty_kecil' => $keranjang->qty_kecil,
                'harga' => $harga['total'],
                'disc_cash' => $keranjang->disc_cash,
                'disc_perc' => $keranjang->disc_perc,
                'ket_detail' => $keranjang->ket_detail,
                'subtotal' => $harga['totalDisc'],
                'ket_detail' => $request->keterangan,
            ]);
            $keranjang->delete();
        }        
        $neworder = trn_sales_order_header::where('kode_sales_order', $validated['kode_sales_order'])
                                            ->first();        
        $neworder->status = 'POSTED';
        $neworder->total = $total;
        $neworder->save();


        return response()->json([
            'status' => 'Success',
            'message' => 'Data successfully retrieved',
            'statusCode' => 200,
            'data' => $neworder
        ], 201);       
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
            (d.qty_besar * (b.harga-d.disc_cash)) + 
            (d.qty_tengah * (b.harga-d.disc_cash) / b.konversi_besar) + 
            (d.qty_kecil * (b.harga-d.disc_cash) / (b.konversi_besar * b.konversi_tengah))
             AS total,
            d.disc_perc
        ')
        ->from('trn_sales_order_detail as d')
        ->leftJoin('mst_barang as b', 'b.id_barang', '=', 'd.id_barang')
        ->where('d.kode_sales_order', $nomor)
        ->get();

        // dd($data);
        $totalOrder = 0;
        foreach ($data as $detail) {
            $totalQty = $detail->total;
            $totalOrder += $total-($total*$detail->disc_perc/100);
        }
        return $totalOrder;
    }    
}
