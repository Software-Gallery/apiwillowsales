<?php

namespace App\Http\Controllers;

use App\Models\trn_sales_order_detail;
use Illuminate\Http\Request;

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
        $detail = trn_sales_order_detail::where('kode_sales_order', $request->kode_sales_order)
            ->where('id_barang', $request->id_barang)
            ->firstOrFail();

        $validated = $request->validate([
            'qty_besar' => 'nullable|numeric',
            'qty_tengah' => 'nullable|numeric',
            'qty_kecil' => 'nullable|numeric',
            'harga' => 'nullable|numeric',
            'disc_cash' => 'nullable|numeric',
            'disc_perc' => 'nullable|numeric',
            'subtotal' => 'nullable|numeric',
            'ket_detail' => 'nullable|string|max:200',
        ]);

        $detail->update($validated);

        return response()->json($detail);
    }

    public function destroy(Request $request)
    {
        $detail = trn_sales_order_detail::where('kode_sales_order', $request->kode_sales_order)
            ->where('id_barang', $request->id_barang)
            ->firstOrFail();

        $detail->delete();

        return response()->json(['message' => 'Sales order detail deleted successfully.']);
    }
}
