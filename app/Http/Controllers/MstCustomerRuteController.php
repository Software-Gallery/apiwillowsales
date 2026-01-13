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
        $dayOfWeek = Carbon::now()->dayOfWeek;
        $currentDate = Carbon::now();
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $weekOfMonth = ceil(($currentDate->day + $startOfMonth->dayOfWeek) / 7);
        $isEvenWeek = $weekOfMonth % 2 == 0;
        $subSalesOrder = DB::table('trn_sales_order_header')
            ->select(
                'id_customer',
                'tgl_sales_order',
                'id_karyawan',
                DB::raw('COUNT(*) AS jml_absen'),
                DB::raw('SUM(Total) AS sisa_piutang'),
            )
            ->groupBy('id_customer', 'tgl_sales_order', 'id_karyawan');

        $rute = DB::table('mst_karyawan AS k')
            ->select(
                'cr.*',
                'd.keterangan AS nama_departemen',
                'c.nama AS nama_customer',
                DB::raw('WEEK(ta.tgl_aktif, 3) AS WEEK'),
                'ta.tgl_aktif',
                DB::raw('c.alamat AS alamat_customer'),
                DB::raw("CONCAT(c.latitude, ', ', c.longitude) AS latlong_customer"),
                DB::raw('IFNULL(h.jml_absen, 0) AS jml_nota'),
                'lp.value_nota',
                'h.sisa_piutang',
                DB::raw('IFNULL(h.jml_absen, 0) AS jml_absen')
            )
            ->leftJoin('mst_tgl_aktif AS ta', 'k.id_departemen', '=', 'ta.id_departemen')
            ->leftJoin('mst_customer_rute AS cr', function ($join) {
                $join->on('k.id_karyawan', '=', 'cr.id_karyawan')
                    ->on('ta.id_departemen', '=', 'cr.id_departemen');
            })
            ->leftJoin('mst_customer AS c', 'cr.id_customer', '=', 'c.id_customer')
            ->leftJoin('mst_departemen AS d', 'ta.id_departemen', '=', 'd.id_departemen')
            ->leftJoin('list_piutang AS lp', 'c.id_customer', '=', 'lp.id_customer')
            ->leftJoinSub($subSalesOrder, 'h', function ($join) {
                $join->on('h.id_customer', '=', 'c.id_customer')
                ->on('h.id_karyawan', '=', 'k.id_karyawan')
                ->on('h.tgl_sales_order', '=', 'ta.tgl_aktif');
            })
            ->where('k.id_karyawan', $request->id)
            ->whereRaw("
                CASE DAYOFWEEK(ta.tgl_aktif)
                    WHEN 2 THEN cr.day1
                    WHEN 3 THEN cr.day2
                    WHEN 4 THEN cr.day3
                    WHEN 5 THEN cr.day4
                    WHEN 6 THEN cr.day5
                    WHEN 7 THEN cr.day6
                    WHEN 1 THEN cr.day7
                END = 1
            ")
            ->where(function ($query) {
                $query->whereRaw("MOD(WEEK(ta.tgl_aktif, 3), 2) = 1 AND cr.week_ganjil = 1")
                    ->orWhereRaw("MOD(WEEK(ta.tgl_aktif, 3), 2) = 0 AND cr.week_genap = 1");
            })
            ->orderBy('c.nama', 'asc');
            // ->orderBy('jml_absen', 'asc');

        $rute = $rute->get();

        $rute->transform(function ($item) {
            $item->value_nota = (float) $item->value_nota;
            $item->sisa_piutang = (float) $item->sisa_piutang;
            return $item;
        });        
    
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
            ->leftJoin('list_piutang AS lp', 'c.id_customer', '=', 'lp.id_customer')
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
                DB::raw('NOW() as tgl_aktif'),
                DB::raw('c.alamat alamat_customer'),
                DB::raw("CONCAT(latitude, ', ', longitude) as latlong_customer"),
                'lp.jml_nota', 'lp.value_nota', 'lp.sisa_piutang',
            )
            ->where('k.id_karyawan', $request->id)->orderBy('c.nama', 'asc');

        if ($request->filled('nama')) {
            $rute->where('c.nama', 'like', "%{$request->nama}%");
        }
        $rute = $rute->paginate($perPage);
        $rute->transform(function ($item) {
            $item->value_nota = (float) $item->value_nota;
            $item->sisa_piutang = (float) $item->sisa_piutang;
            return $item;
        });        
    
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
        $currentDate = Carbon::now()->format('Y-m-d');
        if ($rute->tgl_aktif == null) {
            return response()->json([
                'tgl_aktif' => $currentDate
            ], 200);
        } else {
            return response()->json($rute, 200);
        }    
    }
}
