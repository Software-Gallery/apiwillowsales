<?php

namespace App\Http\Controllers;

use App\Models\mst_customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MstCustomerController extends Controller
{
    public function index(Request $request)
    {
        $customer = DB::table('mst_karyawan as k')
            ->join('mst_customer as c', 'k.id_departemen', '=', 'c.id_departemen')
            ->select(
                'c.id_customer',
                'c.nama',
                'c.alamat'
            )
            ->where('k.id_karyawan', $request->id);

        if ($request->filled('nama')) {
            $keyword = $request->nama;

            $customer->where('c.nama', 'like', "%{$keyword}%")
                ->orderByRaw(
                    "CASE 
                        WHEN c.nama LIKE ? THEN 0 
                        ELSE 1 
                    END, 
                    LOCATE(?, c.nama)",
                    ["{$keyword}%", $keyword]
                );
        } else {
            $customer->orderBy('c.nama', 'asc');
        }

        $data = $customer
            ->limit(10)
            ->get();

        return response()->json([
            'status' => 'Success',
            'message' => 'true',
            'statusCode' => 200,
            'data' => $data
        ]);
    }



    public function store(Request $request)
    {
        Log::info('customer store ' . $request->id_karyawan, $request->all());
        try {
            $validated = $request->validate([
                'id_customer' => 'required|integer|unique:mst_customer,id_customer',
                'kode_customer' => 'required|string|max:50',
                'nama' => 'nullable|string|max:100',
                'alamat' => 'nullable|string|max:200',
                'id_provinsi' => 'nullable|integer',
                'id_kota' => 'nullable|integer',
                'id_kecamatan' => 'nullable|integer',
                'id_kelurahan' => 'nullable|integer',
                'kode_pos' => 'nullable|string|max:5',
                'latitutde' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
            ]);

            $customer = mst_customer::create($validated);

            return response()->json($customer, 201);
        } catch (\Exception $e) {
            Log::error('customer store ' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $customer = mst_customer::findOrFail($id);
        return response()->json($customer);
    }

    public function update(Request $request, $id)
    {
        Log::info('customer update ' . $request->id_karyawan, $request->all());
        try {
            $customer = mst_customer::findOrFail($id);

            $validated = $request->validate([
                'kode_customer' => 'required|string|max:50',
                'nama' => 'nullable|string|max:100',
                'alamat' => 'nullable|string|max:200',
                'id_provinsi' => 'nullable|integer',
                'id_kota' => 'nullable|integer',
                'id_kecamatan' => 'nullable|integer',
                'id_kelurahan' => 'nullable|integer',
                'kode_pos' => 'nullable|string|max:5',
                'latitutde' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
            ]);

            $customer->update($validated);

            return response()->json($customer);
        } catch (\Exception $e) {
            Log::error('customer update ' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        Log::info('customer destroy ' . $id, ['id' => $id]);
        try {
            $customer = mst_customer::findOrFail($id);
            $customer->delete();

            return response()->json(['message' => 'Customer deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('customer destroy ' . $id . ' ERROR: ' . $e->getMessage(), ['id' => $id]);
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }
}
