<?php

namespace App\Http\Controllers;

use App\Models\trn_sales_order_header;
use Illuminate\Http\Request;

class TrnSalesOrderHeaderController extends Controller
{
    public function index()
    {
        return response()->json(trn_sales_order_header::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_sales_order' => 'required|string|max:30|unique:trn_sales_order_header,kode_sales_order',
            'tgl_sales_order' => 'nullable|date',
            'id_departemen' => 'nullable|integer',
            'id_customer' => 'nullable|integer',
            'id_karyawan' => 'nullable|integer',
            'no_ref' => 'nullable|string|max:500',
            'tgl_ref' => 'nullable|date',
            'keterangan' => 'nullable|string|max:200',
            'total' => 'nullable|numeric',
        ]);

        $order = trn_sales_order_header::create($validated);

        return response()->json($order, 201);
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
