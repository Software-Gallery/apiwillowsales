<?php

namespace App\Http\Controllers;

use App\Models\trn_sales_order_detail;
use App\Models\trn_sales_order_header;
use App\Models\mst_barang;
use App\Models\keranjang;
use App\Http\Controllers\MstBarangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TrnSalesOrderDetailController extends Controller
{
    public function index()
    {
        return response()->json(trn_sales_order_detail::all());
    }

    public function add(Request $request)
    {
        Log::info('sales-order-detail add ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
            $request->validate([
                'kode_sales_order' => 'required',
                'id_barang' => 'required|integer',
                'qty' => 'required|string',
                'disc_cash' => 'required',
                'disc_perc' => 'required',
                'status' => 'required|string',
            ]);

            $qtyParts = array_pad(explode('.', $request->qty), 3, 0);
            $qty_besar = (int) $qtyParts[0];
            $qty_tengah = (int) $qtyParts[1];
            $qty_kecil = (int) $qtyParts[2];

            $existingFavorite = DB::table('trn_sales_order_detail')
                ->where('kode_sales_order', $request->kode_sales_order)
                ->where('id_barang', $request->id_barang)
                ->where('status', $request->status)
                ->first();

            $barang = DB::table('mst_barang')
                ->where('id_barang', $request->id_barang)
                ->first();

            $subtotal = (
                ($qty_besar * ($barang->harga - $request->disc_cash)) +
                ($qty_tengah * ($barang->harga - $request->disc_cash) / $barang->konversi_besar) +
                ($qty_kecil * ($barang->harga - $request->disc_cash) / ($barang->konversi_besar * $barang->konversi_tengah))
            ) * (1 - $request->disc_perc / 100);
            if ($request->status == 'BONUS') {
                $subtotal = 0;
            }
            if ($existingFavorite) {
                DB::table('trn_sales_order_detail')
                    ->where('kode_sales_order', $request->kode_sales_order)
                    ->where('id_barang', $request->id_barang)
                    ->where('status', $request->status)
                    ->update([
                        'qty_besar' => $qty_besar,
                        'qty_tengah' => $qty_tengah,
                        'qty_kecil' => $qty_kecil,
                        'disc_cash' => $request->disc_cash,
                        'disc_perc' => $request->disc_perc,
                        'ket_detail' => $request->ket,
                        'harga' => $barang->harga,
                        'subtotal' => $subtotal,
                        'status' => $request->status,
                        'updated_at' => now()
                    ]);
            } else {
                DB::table('trn_sales_order_detail')->insert([
                    'kode_sales_order' => $request->kode_sales_order,
                    'id_barang' => $request->id_barang,
                    'qty_besar' => $qty_besar,
                    'qty_tengah' => $qty_tengah,
                    'qty_kecil' => $qty_kecil,
                    'disc_cash' => $request->disc_cash,
                    'disc_perc' => $request->disc_perc,
                    'ket_detail' => $request->ket,
                    'status' => $request->status,
                    'harga' => $barang->harga,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $trnsales = trn_sales_order_header::where('kode_sales_order', $request->kode_sales_order)->first();
            $total = DB::selectOne(
                'SELECT get_total_value(?) AS total',
                [$request->kode_sales_order]
            )->total;
            $trnsales->total = $total;
            $trnsales->save();
            return response()->json([
                'status' => 'Success',
                'message' => 'Item added to cart',
                'statusCode' => 200
            ]);
        } catch (\Exception $e) {
            Log::error('sales-order-detail add ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        Log::info('sales-order-detail store ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
            $validated = $request->validate([
                'kode_sales_order' => 'required|string|max:30',
            ]);
            $keranjangs = keranjang::where('id_karyawan', 'kodekaryawan=' . $request->id_karyawan)
                ->leftJoin('mst_barang', 'keranjangs.id_barang', '=', 'mst_barang.id_barang')
                ->get();
            $total = 0;
            $trnSalesController = new TrnSalesOrderHeaderController();
            foreach ($keranjangs as $keranjang) {
                $harga = $trnSalesController->HitungTotal('kodekaryawan=' . $request->id_karyawan, $keranjang->id_barang);
                $total += $harga['subtotal'];
                trn_sales_order_detail::create([
                    'kode_sales_order' => $validated['kode_sales_order'],
                    'id_barang' => $keranjang->id_barang,
                    'qty_besar' => $keranjang->qty_besar,
                    'qty_tengah' => $keranjang->qty_tengah,
                    'qty_kecil' => $keranjang->qty_kecil,
                    'harga' => $harga['harga'],
                    'disc_cash' => $keranjang->disc_cash,
                    'disc_perc' => $keranjang->disc_perc,
                    'ket_detail' => $keranjang->ket_detail,
                    'subtotal' => $harga['subtotal'],
                ]);
            }

            $neworder = trn_sales_order_header::where('kode_sales_order', $validated['kode_sales_order'])
                ->first();
            $neworder->status = 'POSTED';
            $neworder->total = $total;
            $neworder->save();

            $keranjangs->delete();
            return response()->json([
                'status' => 'Success',
                'message' => 'Data successfully retrieved',
                'statusCode' => 200,
                'data' => $neworder
            ], 201);
        } catch (\Exception $e) {
            Log::error('sales-order-detail store ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
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
        Log::info('sales-order-detail update ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
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
        } catch (\Exception $e) {
            Log::error('sales-order-detail update ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        Log::info('sales-order-detail delete ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
            $request->validate([
                'kode_sales_order' => 'required',
                'id_barang' => 'required|integer',
            ]);

            trn_sales_order_detail::where('kode_sales_order', $request->kode_sales_order)
                ->where('id_barang', $request->id_barang)
                ->where('status', $request->status)
                ->delete();

            $trnsales = trn_sales_order_header::where('kode_sales_order', $request->kode_sales_order)->first();
            $total = DB::selectOne(
                'SELECT get_total_value(?) AS total',
                [$request->kode_sales_order]
            )->total;
            $trnsales->total = $total;
            $trnsales->save();

            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('sales-order-detail delete ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }


    public function HitungTotal(string $nomor)
    {
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
            $totalOrder += $detail->total - ($detail->total * $detail->disc_perc / 100);
        }
        return $totalOrder;
    }
}
