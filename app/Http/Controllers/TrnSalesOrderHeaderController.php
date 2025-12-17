<?php

namespace App\Http\Controllers;

use App\Models\trn_sales_order_header;
use App\Models\trn_sales_order_detail;
use App\Models\mst_barang;
use App\Models\keranjang;
use Illuminate\Http\Request;

class TrnSalesOrderHeaderController extends Controller
{
    public function index()
    {
        // return response()->json(trn_sales_order_header::all());
        $salesOrders =trn_sales_order_header::with('customer')->get();
        return response()->json($salesOrders->map(function($salesOrder) {
                return [
                    'kode_sales_order' => $salesOrder->kode_sales_order,
                    'tgl_sales_order' => $salesOrder->tgl_sales_order,
                    'id_departemen' => $salesOrder->id_departemen,
                    'id_customer' => $salesOrder->id_customer,
                    'id_karyawan' => $salesOrder->id_karyawan,
                    'no_ref' => $salesOrder->no_ref,
                    'tgl_ref' => $salesOrder->tgl_ref,
                    'keterangan' => $salesOrder->keterangan,
                    'status' => $salesOrder->status,
                    'total' => $salesOrder->total,
                    'created_at' => $salesOrder->created_at,
                    'updated_at' => $salesOrder->updated_at,
                    'source' => $salesOrder->source,
                    'nama_customer' =>  $salesOrder->customer ? $salesOrder->customer->nama : '', // Menambahkan nama_customer
                ];
            }
         ));        
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_departemen' => 'nullable|integer',
            'id_customer' => 'nullable|integer',
            'id_karyawan' => 'nullable|integer',
            'keterangan' => 'nullable|string|max:200',
            'tgl_sales_order' => 'nullable|date',
        ]);   

        // Generate nextNomor
        $year = date('y'); 
        $month = date('m');
        $lastSalesHeader = trn_sales_order_header::whereYear('tgl_sales_order', now()->setTimezone('Asia/Jakarta')->format('Y'))
                                       ->whereMonth('tgl_sales_order', now()->setTimezone('Asia/Jakarta')->format('m'))
                                       ->orderByDesc('kode_sales_order')
                                       ->first();
        if ($lastSalesHeader) {
            $lastNumber = (int) substr($lastSalesHeader->kode_sales_order, 4);
            $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '00001';
        }                
        $validated['kode_sales_order'] = $year . $month . $nextNumber;
        //$validated['tgl_sales_order'] = now()->setTimezone('Asia/Jakarta')->format('Y-m-d');
        $order = trn_sales_order_header::create($validated);
        // Create Detail
        // $keranjangs = keranjang::where('id_karyawan', $request->id_karyawan)
        //                        ->leftJoin('mst_barang', 'keranjangs.id_barang', '=', 'mst_barang.id_barang')
        //                        ->get();
        // $total = 0;
        // foreach ($keranjangs as $keranjang) {
        //     $harga = $this->HitungTotal($request->id_karyawan, $keranjang->id_barang);
        //     trn_sales_order_detail::create([
        //         'kode_sales_order' => $validated['kode_sales_order'],
        //         'id_barang' => $keranjang->id_barang,
        //         'qty_besar' => $keranjang->qty_besar,
        //         'qty_tengah' => $keranjang->qty_tengah,
        //         'qty_kecil' => $keranjang->qty_kecil,
        //         'harga' => $harga['total'],
        //         'disc_cash' => $keranjang->disc_cash,
        //         'disc_perc' => $keranjang->disc_perc,
        //         'ket_detail' => $keranjang->ket_detail,
        //         'subtotal' => $harga['totalDisc'],
        //         'ket_detail' => $request->keterangan,
        //     ]);
        //     $keranjang->delete();
        // }        
        // $neworder = trn_sales_order_header::where('kode_sales_order', $validated['kode_sales_order'])
        //                                     ->first();        

        // $neworder->total = $total;
        // $neworder->save();
        $validated['kode_sales_order'] = (int)$validated['kode_sales_order'];
        return response()->json([
            'status' => 'Success',
            'message' => 'Data successfully retrieved',
            'statusCode' => 200,
            'data' => $validated
        ], 201);       
    }

    public function show($kode_sales_order)
    {
        $order = trn_sales_order_header::findOrFail($kode_sales_order);
        return response()->json($order);
    }

    public function update(Request $request)
    {
        $order = trn_sales_order_header::findOrFail($request->kode_sales_order);

        $validated = $request->validate([
            'tgl_sales_order' => 'nullable|date',
            'id_departemen' => 'nullable|integer',
            'id_customer' => 'nullable|integer',
            'id_karyawan' => 'nullable|integer',
            'no_ref' => 'nullable|string|max:500',
            'tgl_ref' => 'nullable|date',
            'keterangan' => 'nullable|string|max:200',
            'total' => 'nullable|numeric',
        ]);

        $order->update($validated);

        return response()->json($order);
    }

    public function destroy($kode_sales_order)
    {
        $order = trn_sales_order_header::findOrFail($kode_sales_order);
        $order->delete();

        return response()->json(['message' => 'Sales order deleted successfully.']);
    }

    public function HitungTotal(String $idKaryawan, String $idBarang) {
        $data = trn_sales_order_header::selectRaw('
            qty_besar*harga+qty_tengah*harga/konversi_besar+qty_kecil*harga/konversi_besar/konversi_tengah total, d.disc_cash, d.disc_perc
        ')
        ->from('keranjangs as d')
        ->leftJoin('mst_barang as b', 'b.id_barang', '=', 'd.id_barang')
        ->where('d.id_karyawan', $idKaryawan)
        ->where('b.id_barang', $idBarang)
        ->first();
        return [
            'total' => $data->total,
            'totalDisc' => $data->total-($data->total*$data->disc_perc/100)-$data->disc_cash,
        ];
    }
    // public function HitungTotal(String $idKaryawan, String $idBarang) {
    //     $data = trn_sales_order_header::selectRaw('
    //         (qty_besar * konversi_besar * konversi_tengah) AS besar,
    //         (qty_tengah * konversi_tengah) AS tengah,
    //         (qty_kecil) AS kecil,
    //         b.harga, d.disc_cash, d.disc_perc
    //     ')
    //     ->from('keranjangs as d')
    //     ->leftJoin('mst_barang as b', 'b.id_barang', '=', 'd.id_barang')
    //     ->where('d.id_karyawan', $idKaryawan)
    //     ->where('b.id_barang', $idBarang)
    //     ->first();

    //     $totalQty = ($data->besar+$data->tengah+$data->kecil)*$data->harga;

    //     return [
    //         'total' => $totalQty,
    //         'totalDisc' => $totalQty-($totalQty*$data->disc_perc/100)-$data->disc_cash,
    //     ];
    // }
}
