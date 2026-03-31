<?php

namespace App\Http\Controllers;

use App\Models\trn_sales_order_header;
use App\Models\trn_sales_order_detail;
use App\Models\mst_barang;
use App\Models\keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TrnSalesOrderHeaderController extends Controller
{
    public function index()
    {
        // return response()->json(trn_sales_order_header::all());
        $salesOrders = trn_sales_order_header::with('customer')->get();
        return response()->json($salesOrders->map(
            function ($salesOrder) {
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
                    'nama_customer' => $salesOrder->customer ? $salesOrder->customer->nama : '', // Menambahkan nama_customer
                ];
            }
        ));
    }

    public function store(Request $request)
    {
        Log::info('sales-order-header store ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
            $validated = $request->validate([
                'id_departemen' => 'nullable|integer',
                'id_customer' => 'nullable|integer',
                'id_karyawan' => 'nullable|integer',
                'keterangan' => 'nullable|string|max:200',
                'tgl_sales_order' => 'nullable|date',
            ]);

            // ambil tanggal aktif
            $tglAktif = DB::table('mst_tgl_aktif')
                ->where('id_departemen', $request->id_departemen)
                ->value('tgl_aktif');   // hasilnya langsung tanggal

            $year = date('y', strtotime($tglAktif));
            $month = date('m', strtotime($tglAktif));

            $lastSalesHeader = DB::table('trn_sales_order_header')
                ->whereYear('tgl_sales_order', date('Y', strtotime($tglAktif)))
                ->whereMonth('tgl_sales_order', date('m', strtotime($tglAktif)))
                ->orderByDesc('kode_sales_order')
                ->select('kode_sales_order')
                ->first();

            if ($lastSalesHeader) {
                $lastNumber = (int) substr($lastSalesHeader->kode_sales_order, 4);
                $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $nextNumber = '00001';
            }
            $validated['kode_sales_order'] = $year . $month . $nextNumber;
            if (!($request->has('tgl_sales_order'))) {
                $validated['tgl_sales_order'] = $tglAktif;
            }
            $order = trn_sales_order_header::create($validated);
            $validated['kode_sales_order'] = (int) $validated['kode_sales_order'];
            return response()->json([
                'status' => 'Success',
                'message' => 'Data successfully retrieved',
                'statusCode' => 200,
                'data' => $validated
            ], 201);
        } catch (\Exception $e) {
            Log::error('sales-order-header store ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($kode_sales_order)
    {
        $order = trn_sales_order_header::findOrFail($kode_sales_order);
        return response()->json($order);
    }

    public function update(Request $request)
    {
        Log::info('sales-order-header update ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
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
        } catch (\Exception $e) {
            Log::error('sales-order-header update ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($kode_sales_order)
    {
        Log::info('sales-order-header destroy ' . $kode_sales_order, ['kode_sales_order' => $kode_sales_order]);
        try {
            $order = trn_sales_order_header::findOrFail($kode_sales_order);
            $order->delete();

            return response()->json(['message' => 'Sales order deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('sales-order-header destroy ' . $kode_sales_order . ' ERROR: ' . $e->getMessage(), ['kode_sales_order' => $kode_sales_order]);
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function HitungTotal(string $idKaryawan, string $idBarang)
    {
        $data = trn_sales_order_header::selectRaw('
            (
                (d.qty_besar * b.harga) + 
                (d.qty_tengah * b.harga / b.konversi_besar) + 
                (d.qty_kecil * b.harga / (b.konversi_besar * b.konversi_tengah))
            ) AS harga,
            (
                (
                    (d.qty_besar * (b.harga - d.disc_cash)) + 
                    (d.qty_tengah * (b.harga - d.disc_cash) / b.konversi_besar) + 
                    (d.qty_kecil * (b.harga - d.disc_cash) / (b.konversi_besar * b.konversi_tengah))
                ) * (1 - d.disc_perc / 100) 
            ) AS subtotal
        ')
            ->from('keranjangs as d')
            ->leftJoin('mst_barang as b', 'b.id_barang', '=', 'd.id_barang')
            ->where('d.id_karyawan', $idKaryawan)
            ->where('b.id_barang', $idBarang)
            ->first();

        return [
            'harga' => $data->harga,
            'subtotal' => $data->subtotal,
        ];
    }

    public function nextNomor(Request $request)
    {
        $tglAktif = DB::table('mst_tgl_aktif')
            ->where('id_departemen', $request->id_departemen)
            ->value('tgl_aktif');   // hasilnya langsung tanggal

        $year = date('y', strtotime($tglAktif));
        $month = date('m', strtotime($tglAktif));

        $lastSalesHeader = DB::table('trn_sales_order_header')
            ->whereYear('tgl_sales_order', date('Y', strtotime($tglAktif)))
            ->whereMonth('tgl_sales_order', date('m', strtotime($tglAktif)))
            ->orderByDesc('kode_sales_order')
            ->select('kode_sales_order')
            ->first();

        if ($lastSalesHeader) {
            $lastNumber = (int) substr($lastSalesHeader->kode_sales_order, 4);
            $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '00001';
        }
        $validated['kode_sales_order'] = $year . $month . $nextNumber;
        if (!($request->has('tgl_sales_order'))) {
            $validated['tgl_sales_order'] = $tglAktif;
        }

        return response()->json([
            'status' => 'Success',
            'message' => 'Data successfully retrieved',
            'statusCode' => 200,
            'tglAktif' => $tglAktif,
            'year' => $year,
            'month' => $month,
            'last' => $lastSalesHeader,
            'data' => $validated
        ], 200);
    }
}
