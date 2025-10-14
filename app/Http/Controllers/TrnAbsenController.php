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
        //
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
