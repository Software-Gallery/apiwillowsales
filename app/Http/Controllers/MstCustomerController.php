<?php

namespace App\Http\Controllers;

use App\Models\mst_customer;
use Illuminate\Http\Request;

class MstCustomerController extends Controller
{
    public function index()
    {
        return response()->json(mst_customer::all());
    }

    public function store(Request $request)
    {
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
    }

    public function show($id)
    {
        $customer = mst_customer::findOrFail($id);
        return response()->json($customer);
    }

    public function update(Request $request, $id)
    {
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
    }

    public function destroy($id)
    {
        $customer = mst_customer::findOrFail($id);
        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully.']);
    }
}
