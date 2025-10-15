<?php

namespace App\Http\Controllers;

use App\Models\trn_sales_order_header;
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
        // $validated = $request->validate([
        //     'kode_sales_order' => 'required|string|max:30|unique:trn_sales_order_header,kode_sales_order',
        //     'tgl_sales_order' => 'nullable|date',
        //     'id_departemen' => 'nullable|integer',
        //     'id_customer' => 'nullable|integer',
        //     'id_karyawan' => 'nullable|integer',
        //     'no_ref' => 'nullable|string|max:500',
        //     'tgl_ref' => 'nullable|date',
        //     'keterangan' => 'nullable|string|max:200',
        //     'total' => 'nullable|numeric',
        // ]);        
        $validated = $request->validate([
            'id_departemen' => 'nullable|integer',
            'id_customer' => 'nullable|integer',
            'id_karyawan' => 'nullable|integer',
            'keterangan' => 'nullable|string|max:200',
        ]);   

        // Generate nextNomor
        $year = date('y'); 
        $month = date('m');
        $lastSalesHeader = trn_sales_order_header::whereYear('tgl_sales_order', now()->setTimezone('Asia/Jakarta')->format('Y'))
                                       ->whereMonth('tgl_sales_order', now()->setTimezone('Asia/Jakarta')->format('m'))
                                       ->orderByDesc('kode_sales_order')
                                       ->first();
        if ($lastSalesHeader) {
            $lastNumber = (int) substr($lastSalesHeader->sales_number, 4);
            $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '00001';
        }                

        $validated['kode_sales_order'] = $year . $month . $nextNumber;
        $validated['tgl_sales_order'] = now()->setTimezone('Asia/Jakarta')->format('Y-m-d');
        
        $order = trn_sales_order_header::create($validated);
        return response()->json([
            'status' => 'Success',
            'message' => 'Data successfully retrieved',
            'statusCode' => 200,
            'data' => $order
        ], 201);       
        // return response()->json($order, 201);
    }

    public function show($kode_sales_order)
    {
        $order = trn_sales_order_header::findOrFail($kode_sales_order);
        return response()->json($order);
    }

    public function update(Request $request, $kode_sales_order)
    {
        $order = trn_sales_order_header::findOrFail($kode_sales_order);

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
}
