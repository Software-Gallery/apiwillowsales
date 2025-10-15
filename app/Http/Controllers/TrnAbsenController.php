<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\trn_absen;

class TrnAbsenController extends Controller
{
    public function getByIdKaryawan(Request $request) {
        $data = DB::table('trn_absen')
                    ->where('id_karyawan', $request->id)
                    ->orderBy('tgl', 'desc')
                    ->orderBy('jam_masuk', 'desc')
                    ->get();
    
        return response()->json([
            'status' => 'Success',
            'message' => 'true',
            'statusCode' => 200,
            'data' => $data
        ]);            
    }

    public function checkAbsen(Request $request) {
        // $data = DB::table('trn_absen')
        //             ->where('id_karyawan', $request->id)
        //             ->orderBy('tgl', 'desc')
        //             ->orderBy('jam_masuk', 'desc')
        //             ->first();

        $data = DB::table('mst_customer_rute as r')
            ->leftJoin('trn_absen as a', function ($join) {
                $join->on('r.id_departemen', '=', 'a.id_departemen')
                     ->on('r.id_customer', '=', 'a.id_customer')
                     ->on('r.id_karyawan', '=', 'a.id_karyawan');
            })
            ->leftJoin('mst_customer', 'm_customer.id_customer', '=', 'a.id_customer')
            ->leftJoin('mst_departemen', 'm_departemen.id_departemen', '=', 'a.id_departemen')
            ->whereDate('a.tgl', '=', now()->format('Y-m-d'))
            ->select('r.*', 'a.*')
            ->get();        
        $isAbsen = true;
        // $isAbsen = $data->jam_keluar == null;
        // if (!($isAbsen)) {
        //     $data = [];
        // }
    
        return response()->json([
            'status' => 'Success',
            'message' => $isAbsen,
            'statusCode' => 200,
            'data' => $data
        ]);     
    }
    
    public function index()
    {
        return response()->json(trn_absen::all());
    }

    public function create()
    {
        //
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'id_karyawan' => 'required|integer',
        'id_customer' => 'required|integer',
        'id_departemen' => 'required|integer',
        'tgl' => 'required|date',
        'jam_masuk' => 'required|date_format:H:i:s',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'keterangan' => 'nullable|string|max:255',
        'alamat' => 'nullable|string|max:255',
    ]);
    $absen = trn_absen::create($validated);
    return response()->json([
        'message' => 'Absen berhasil disimpan!',
        'data' => $absen,
    ], 201);
    // return response()->json([
    //     'message' => 'Coba test pesan',
    //     'data' => $request->all(),
    // ], 200);    
}


    public function show(trn_absen $trnAbsen)
    {
        //
    }

    public function edit(trn_absen $trnAbsen)
    {
        //
    }

    public function update(Request $request, TrnAbsen $trnAbsen)
    {
        //
    }

    public function destroy(trn_absen $trnAbsen)
    {
        //
    }
}
