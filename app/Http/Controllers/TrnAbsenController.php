<?php

namespace App\Http\Controllers;

use App\Models\TrnAbsen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $data = DB::table('trn_absen')
                    ->where('id_karyawan', $request->id)
                    ->orderBy('tgl', 'desc')
                    ->orderBy('jam_masuk', 'desc')
                    ->first();
        
        $isAbsen = $data->jam_keluar == null;
        if (!($isAbsen)) {
            $data = [];
        }
    
        return response()->json([
            'status' => 'Success',
            'message' => $isAbsen,
            'statusCode' => 200,
            'data' => $data
        ]);     
    }
    
    public function index()
    {
        return response()->json(TrnAbsen::all());
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
            'jam_masuk' => 'required|date_format:H:i',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'keterangan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
        ]);

        $absen = TrnAbsen::create($validated);

        return response()->json([
            'message' => 'Absen berhasil disimpan!',
            'data' => 'Test'
        ], 201);
    }

    public function show(TrnAbsen $trnAbsen)
    {
        //
    }

    public function edit(TrnAbsen $trnAbsen)
    {
        //
    }

    public function update(Request $request, TrnAbsen $trnAbsen)
    {
        //
    }

    public function destroy(TrnAbsen $trnAbsen)
    {
        //
    }
}
