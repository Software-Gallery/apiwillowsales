<?php

namespace App\Http\Controllers;

use App\Models\trn_sales_order_header;
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

        $data = DB::table('trn_absen as a')
            ->leftJoin('mst_customer as c', 'c.id_customer', '=', 'a.id_customer')
            ->leftJoin('mst_departemen as d', 'd.id_departemen', '=', 'a.id_departemen')
            ->select(
                DB::raw('c.id_departemen, c.id_customer, 0 as id_karyawan, 1 as day1, 1 as day2, 1 as day3, 1 as day4, 1 as day5, 1 as day6, 1 as day7, 1 as week_ganjil, 1 as week_genap'),
                'a.*',
                'c.nama as nama_customer',
                'd.keterangan as nama_departemen'
            )
            ->where('a.id_karyawan', '=', $request->id)
            ->orderBy('a.tgl', 'desc')
            ->orderBy('a.jam_masuk', 'desc')
            ->first();


        $isAbsen = false;
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
            ->leftJoin('trn_sales_order_header as h', 'a.kode_sales_order', '=', 'h.kode_sales_order')
            ->leftJoin('mst_customer as c', 'c.id_customer', '=', 'a.id_customer')
            ->leftJoin('mst_departemen as d', 'd.id_departemen', '=', 'a.id_departemen')
            ->select('a.id_absen','a.id_karyawan','a.id_customer','a.id_departemen','a.kode_sales_order','a.jam_masuk','a.jam_keluar','a.latitude','a.longitude','h.keterangan','a.alamat','a.tipe',
                DB::raw("c.id_departemen, c.id_customer, 0 as id_karyawan, 1 as day1, 1 as day2, 1 as day3, 1 as day4, 1 as day5, 1 as day6, 1 as day7, 1 as week_ganjil, 1 as week_genap"),
                'h.tgl_sales_order as tgl',
                'c.nama as nama_customer', 
                'd.keterangan as nama_departemen',
                'h.status',
                'a.tgl as tgl_absen',
                DB::raw('get_total_sku(a.kode_sales_order) as totalSKU'),
                DB::raw('get_total_value(a.kode_sales_order) as totalValue'))
            ->whereBetween('h.tgl_sales_order', [$request->startDate, $request->endDate])
            ->where('a.id_karyawan', '=', $request->id)
            ->where('c.id_customer', 'like', '%' . $request->id_customer . '%')
            ->orderBy('a.tgl', 'desc')
            ->orderBy('a.jam_masuk', 'desc')
            ->get();

        $data->transform(function ($item) {
            $item->totalSKU   = (float) number_format($item->totalSKU, 2, '.', '');
            $item->totalValue = (float) number_format($item->totalValue, 2, '.', '');
            return $item;
        });
        

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
        // dd($request->all());
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
            'tipe' => 'nullable|string',
            // 'kode_sales_order' => 'nullable'
        ]);

        if (is_null($request->kode_sales_order) || (string)$request->kode_sales_order == '0') {
            $tglAktif = $validated['tgl'];

            $year  = date('y', strtotime($tglAktif));
            $month = date('m', strtotime($tglAktif));

            $lastSalesHeader = DB::table('trn_sales_order_header')
                // ->where('id_departemen', $request->id_departemen)
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
        }
        // if ($request->has('keterangan')) {
        //     $validated['kode_sales_order'] = $request->kode_sales_order;
        // }
        $absen = trn_absen::create(attributes: $validated);
        return response()->json([
            'statusCode' => 200,
            'message' => 'Absen berhasil disimpan!',
            'data' => $absen,
        ], 201);
    }

    public function selesai(Request $request) {
        $absen = trn_absen::find($request->id_absen);
        
            // $trnsales = trn_absen::find($absen->kode_sales_order);
            $trnsales = trn_sales_order_header::where('kode_sales_order', $absen->kode_sales_order)->first();   
            
            
            if ($trnsales) {
                $total = DB::selectOne(
                    'SELECT get_total_value(?) AS total',
                    [$absen->kode_sales_order]
                )->total;
                if ($request->has('keterangan')) {
                    $trnsales->keterangan = $request->keterangan;
                }
                $trnsales->total = $total;
                $trnsales->status = 'POSTED';
                $trnsales->save();
            }
            // dd($trnsales);
        
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
        $karyawan = DB::table('mst_karyawan')
                    ->where('id_karyawan', '=', $request->id)
                    ->first();        

                    
        $tgl_aktif = DB::table('mst_tgl_aktif')
            ->where('id_departemen', '=', $karyawan->id_departemen)
            ->select(
                'tgl_aktif',
                 DB::raw('DATE_SUB(tgl_aktif, INTERVAL 7 DAY) as tgl_aktif7')
            )
            ->first();
        if ($periode == 'today') {
            $total = DB::table('trn_sales_order_header')
                    ->whereDate('tgl_sales_order', Carbon::parse($tgl_aktif->tgl_aktif)) // Use $tgl_aktif here
                    ->where('id_karyawan', '=', $request->id)
                    ->distinct('id_customer')
                    ->count();
        } else if ($periode == 'weekly') {  
            $total = DB::table('trn_sales_order_header')
                    ->whereBetween('tgl_sales_order', [$tgl_aktif->tgl_aktif7,Carbon::parse($tgl_aktif->tgl_aktif)])
                    ->where('id_karyawan', '=', $request->id)
                    ->distinct('id_customer')
                    ->count();
        } else if ($periode == 'monthly') {
            $total = DB::table('trn_sales_order_header')
                    ->whereMonth('tgl_sales_order', Carbon::parse($tgl_aktif->tgl_aktif)->month) 
                    ->whereYear('tgl_sales_order', Carbon::parse($tgl_aktif->tgl_aktif)->year) 
                    ->where('id_karyawan', '=', $request->id)
                    ->distinct('id_customer')
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
