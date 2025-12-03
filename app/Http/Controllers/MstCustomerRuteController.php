<?php

namespace App\Http\Controllers;

use App\Models\mst_customer_rute;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MstCustomerRuteController extends Controller
{
    public function index()
    {
        return response()->json(MstCustomerRute::all());
    }

    public function getById(Request $request)
    {
        // Mendapatkan hari saat ini
        $dayOfWeek = Carbon::now()->dayOfWeek; // Angka 0 (Minggu) sampai 6 (Sabtu)
        
        // Mendapatkan minggu ke berapa dalam bulan ini
        $currentDate = Carbon::now();
        $startOfMonth = $currentDate->copy()->startOfMonth(); // Mulai bulan ini
        $weekOfMonth = ceil(($currentDate->day + $startOfMonth->dayOfWeek) / 7); // Menghitung minggu dalam bulan

        // Tentukan apakah minggu ini ganjil atau genap
        $isEvenWeek = $weekOfMonth % 2 == 0;
            
        // $rute = DB::table('mst_karyawan as k')
        //     ->leftJoin('mst_tgl_aktif as ta', 'k.id_departemen', '=', 'ta.id_departemen')
        //     ->leftJoin('mst_customer_rute as cr', function($join) {
        //         $join->on('k.id_karyawan', '=', 'cr.id_karyawan')
        //             ->where('ta.id_departemen', '=', DB::raw('cr.id_departemen'));
        //     })
        //     ->leftJoin('mst_customer as c', 'cr.id_customer', '=', 'c.id_customer')
        //     ->leftJoin('mst_departemen as d', 'ta.id_departemen', '=', 'd.id_departemen')
        //     ->where('k.id_karyawan', $request->id)
        //     ->where(function ($query) {
        //         $query->where(DB::raw('MOD(WEEK(ta.tgl_aktif), 2)'), '=', 1)
        //             ->where('cr.week_ganjil', 1)
        //             ->orWhere(function ($query) {
        //                 $query->where(DB::raw('MOD(WEEK(ta.tgl_aktif), 2)'), '=', 0)
        //                     ->where('cr.week_genap', 1);
        //             });
        //     })
        //     ->where(function ($query) {
        //         $query->where(function ($query) {
        //             $query->where(DB::raw('DAYOFWEEK(ta.tgl_aktif)'), '=', 1)
        //                 ->where('cr.day7', 1);
        //         })
        //         ->orWhere(function ($query) {
        //             $query->where(DB::raw('DAYOFWEEK(ta.tgl_aktif)'), '=', 2)
        //                 ->where('cr.day1', 1);
        //         })
        //         ->orWhere(function ($query) {
        //             $query->where(DB::raw('DAYOFWEEK(ta.tgl_aktif)'), '=', 3)
        //                 ->where('cr.day2', 1);
        //         })
        //         ->orWhere(function ($query) {
        //             $query->where(DB::raw('DAYOFWEEK(ta.tgl_aktif)'), '=', 4)
        //                 ->where('cr.day3', 1);
        //         })
        //         ->orWhere(function ($query) {
        //             $query->where(DB::raw('DAYOFWEEK(ta.tgl_aktif)'), '=', 5)
        //                 ->where('cr.day4', 1);
        //         })
        //         ->orWhere(function ($query) {
        //             $query->where(DB::raw('DAYOFWEEK(ta.tgl_aktif)'), '=', 6)
        //                 ->where('cr.day5', 1);
        //         })
        //         ->orWhere(function ($query) {
        //             $query->where(DB::raw('DAYOFWEEK(ta.tgl_aktif)'), '=', 7)
        //                 ->where('cr.day6', 1);
        //         });
        //     })
        //     ->select('cr.*', 'd.keterangan as nama_departemen', 'c.nama as nama_customer', DB::raw('WEEK(CURDATE()) as week'), 'ta.tgl_aktif');

        $rute = DB::table('mst_karyawan AS k')
        ->select(
            'cr.*',
            'd.keterangan AS nama_departemen',
            'c.nama AS nama_customer',
            DB::raw('WEEK(ta.tgl_aktif, 3) AS WEEK'),
            'ta.tgl_aktif'
        )
        ->leftJoin('mst_tgl_aktif AS ta', 'k.id_departemen', '=', 'ta.id_departemen')
        ->leftJoin('mst_customer_rute AS cr', function($join) {
            $join->on('k.id_karyawan', '=', 'cr.id_karyawan')
                ->on('ta.id_departemen', '=', 'cr.id_departemen');
        })
        ->leftJoin('mst_customer AS c', 'cr.id_customer', '=', 'c.id_customer')
        ->leftJoin('mst_departemen AS d', 'ta.id_departemen', '=', 'd.id_departemen')
        ->where('k.id_karyawan', $request->id)
        ->where(function($query) {
            $query->whereRaw("CASE DAYOFWEEK(ta.tgl_aktif)
                                WHEN 2 THEN day1  -- Monday
                                WHEN 3 THEN day2  -- Tuesday
                                WHEN 4 THEN day3  -- Wednesday
                                WHEN 5 THEN day4  -- Thursday
                                WHEN 6 THEN day5  -- Friday
                                WHEN 7 THEN day6  -- Saturday
                                WHEN 1 THEN day7  -- Sunday
                            END = 1");
        })
        ->where(function($query) {
            $query->whereRaw("(MOD(WEEK(ta.tgl_aktif, 3), 2) = 1 AND week_ganjil = 1)")
                ->orWhereRaw("(MOD(WEEK(ta.tgl_aktif, 3), 2) = 0 AND week_genap = 1)");
        });
        $rute = $rute->get();
    
        return response()->json([
            'status' => 'Success',
            'message' => 'Data successfully retrieved',
            'statusCode' => 200,
            'data' => $rute
        ]);
    }

    public function getByIdAll(Request $request)
    {
        // $perPage = $request->per_page ?? 20;
        $perPage = 20;
        $rute = DB::table('mst_karyawan as k')
            ->join('mst_customer as c', 'k.id_departemen', '=', 'c.id_departemen')
            ->leftJoin('mst_departemen as d', 'c.id_departemen', '=', 'd.id_departemen')
            ->select(
                'c.id_departemen',
                'c.id_customer',
                DB::raw('0 as id_karyawan'),
                DB::raw('1 as day1'),
                DB::raw('1 as day2'),
                DB::raw('1 as day3'),
                DB::raw('1 as day4'),
                DB::raw('1 as day5'),
                DB::raw('1 as day6'),
                DB::raw('1 as day7'),
                DB::raw('1 as week_ganjil'),
                DB::raw('1 as week_genap'),
                'd.keterangan as nama_departemen',
                'c.nama as nama_customer',
                DB::raw('WEEK(CURDATE(),3) as week'),
                DB::raw('NOW() as tgl_aktif')
            )
            ->where('k.id_karyawan', $request->id);

        if ($request->filled('nama')) {
            $rute->where('c.nama', 'like', "%{$request->nama}%");
        }
        $rute = $rute->paginate($perPage);
    
        return response()->json([
            'status' => 'Success',
            'message' => 'Data successfully retrieved',
            'statusCode' => 200,
            'data' => $rute
        ]);
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

    public function tglAktif(Request $request) {
        $rute = DB::table('mst_karyawan as k')
            ->leftJoin('mst_tgl_aktif as ta', 'k.id_departemen', '=', 'ta.id_departemen')
            ->where('k.id_karyawan', $request->id)
            ->select('ta.tgl_aktif')
            ->first();
        return response()->json($rute, 200);
    }
}
