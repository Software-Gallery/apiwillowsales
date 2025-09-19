<?php

namespace App\Http\Controllers;

use App\Models\mst_customer_rute;
use Illuminate\Http\Request;

class MstCustomerRuteController extends Controller
{
    public function index()
    {
        return response()->json(MstCustomerRute::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_departemen' => 'required|integer',
            'id_customer' => 'required|integer',
            'id_karyawan' => 'required|integer',

            'day1' => 'boolean',
            'day2' => 'boolean',
            'day3' => 'boolean',
            'day4' => 'boolean',
            'day5' => 'boolean',
            'day6' => 'boolean',
            'day7' => 'boolean',

            'week1' => 'boolean',
            'week2' => 'boolean',
            'week3' => 'boolean',
            'week4' => 'boolean',
        ]);

        $rute = MstCustomerRute::create($validated);

        return response()->json($rute, 201);
    }

    public function show(Request $request)
    {
        // Karena tidak ada primary key tunggal,
        // kita ambil dengan kombinasi 3 id:
        $rute = MstCustomerRute::where('id_departemen', $request->id_departemen)
            ->where('id_customer', $request->id_customer)
            ->where('id_karyawan', $request->id_karyawan)
            ->firstOrFail();

        return response()->json($rute);
    }

    public function update(Request $request)
    {
        $rute = MstCustomerRute::where('id_departemen', $request->id_departemen)
            ->where('id_customer', $request->id_customer)
            ->where('id_karyawan', $request->id_karyawan)
            ->firstOrFail();

        $validated = $request->validate([
            'day1' => 'boolean',
            'day2' => 'boolean',
            'day3' => 'boolean',
            'day4' => 'boolean',
            'day5' => 'boolean',
            'day6' => 'boolean',
            'day7' => 'boolean',

            'week1' => 'boolean',
            'week2' => 'boolean',
            'week3' => 'boolean',
            'week4' => 'boolean',
        ]);

        $rute->update($validated);

        return response()->json($rute);
    }

    public function destroy(Request $request)
    {
        $rute = MstCustomerRute::where('id_departemen', $request->id_departemen)
            ->where('id_customer', $request->id_customer)
            ->where('id_karyawan', $request->id_karyawan)
            ->firstOrFail();

        $rute->delete();

        return response()->json(['message' => 'Customer rute deleted successfully.']);
    }
}
