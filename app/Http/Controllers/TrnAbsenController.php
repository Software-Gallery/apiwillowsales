<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\trn_absen;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TrnAbsenController extends Controller
{
    public function getByIdKaryawan(Request $request) {
        $data = DB::table('trn_absen')
                    ->where('id_karyawan', $request->id_absen)
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
            ->leftJoin('mst_customer', 'mst_customer.id_customer', '=', 'a.id_customer')
            ->leftJoin('mst_departemen', 'mst_departemen.id_departemen', '=', 'a.id_departemen')
            ->where('a.id_karyawan', '=', $request->id)
            ->orderBy('a.tgl', 'desc')
            ->orderBy('a.jam_masuk', 'desc')
            ->select('r.*', 'a.*', 'mst_customer.nama as nama_customer', 'mst_departemen.keterangan as nama_departemen')
            ->first();        
        $data = $data ?? [];
        if ($data !== []) {
            $isAbsen = $data->jam_keluar === null;            
        }   
        
        if (!$isAbsen) {
            $data = [];
        }    
        return response()->json([
            'status' => 'Success',
            'message' => $isAbsen,
            'statusCode' => 200,
            'data' => $data
        ]);     
    }

    public function histori(Request $request) {
        $data = DB::table('trn_absen as a')
            ->leftJoin('mst_customer_rute as r', function ($join) {
                $join->on('r.id_departemen', '=', 'a.id_departemen')
                     ->on('r.id_customer', '=', 'a.id_customer')
                     ->on('r.id_karyawan', '=', 'a.id_karyawan');
            })
            ->leftJoin('mst_customer', 'mst_customer.id_customer', '=', 'a.id_customer')
            ->leftJoin('mst_departemen', 'mst_departemen.id_departemen', '=', 'a.id_departemen')
            ->whereBetween('tgl', [$request->startDate, $request->endDate])
            ->orderBy('a.id_absen', 'desc')
            ->select('r.*', 'a.*', 'mst_customer.nama as nama_customer', 'mst_departemen.keterangan as nama_departemen')
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
            'statusCode' => 200,
            'message' => 'Absen berhasil disimpan!',
            'data' => $absen,
        ], 201);
    }

    public function selesai(Request $request) {
        $absen = trn_absen::find($request->id_absen);
        if ($absen) {
            $absen->jam_keluar = now()->setTimezone('Asia/Jakarta')->format('H:i:s');
            $absen->kode_sales_order = $request->kode_sales_order;
            $absen->save();
            return response()->json(['message' => 'Berhasil selesaikan absen'], 201);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }        
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $request->kode_sales_order . '.' . $image->getClientOriginalExtension(); // Menyertakan ekstensi file

            // Menyimpan gambar langsung di folder public/absen
            $destinationPath = public_path('absen');
            
            // Pastikan folder 'absen' ada atau buat jika belum ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Memindahkan file ke folder absen
            $image->move($destinationPath, $imageName);
            
            // URL untuk akses gambar
            $imageUrl = url('absen/' . $imageName);

            return response()->json([
                'message' => 'Image uploaded successfully!',
                'image_url' => $imageUrl, // URL yang langsung mengarah ke folder public/absen/
            ], 200);
        }

        return response()->json([
            'message' => 'No image file uploaded!',
        ], 400);
    }

    public function total(Request $request) {
        $periode = $request->periode;
        $total = 0;
        if ($periode == 'today') {
            $total = DB::table('trn_absen')
                       ->whereDate('tgl', Carbon::today())
                       ->where('id_karyawan', '=', $request->id)
                       ->count();
        } else if ($periode == 'weekly') {
            $total = DB::table('trn_absen')
                       ->whereBetween('tgl', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                       ->where('id_karyawan', '=', $request->id)
                       ->count();
        } else if ($periode == 'monthly') {
            $total = DB::table('trn_absen')
                       ->whereMonth('tgl', Carbon::now()->month)
                       ->whereYear('tgl', Carbon::now()->year)
                       ->where('id_karyawan', '=', $request->id)
                       ->count();
        }

        return response()->json([
            'status' => 'Success',
            'message' => 'true',
            'statusCode' => 200,
            'periode' => $request->periode,
            'data' => $total
        ]);     
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
