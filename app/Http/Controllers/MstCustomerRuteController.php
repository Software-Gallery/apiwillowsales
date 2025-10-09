<?php

namespace App\Http\Controllers;

use App\Models\mst_customer_rute;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
    
        // Ambil data berdasarkan id_karyawan
        $rute = mst_customer_rute::leftJoin('mst_departemen', 'mst_customer_rute.id_departemen', '=', 'mst_departemen.id_departemen')
                              ->leftJoin('mst_customer', 'mst_customer_rute.id_customer', '=', 'mst_customer.id_customer')
                              ->select('mst_customer_rute.*', 'mst_departemen.keterangan as nama_departemen', 'mst_customer.nama as nama_customer')
                              ->where('id_karyawan', $request->id);
    
        // Filter berdasarkan hari (misal, Day1 untuk Senin, Day2 untuk Selasa, dst.)
        if ($dayOfWeek == 1) {
            // Hari Senin
            $rute = $rute->where('day1', 1);
        } elseif ($dayOfWeek == 2) {
            // Hari Selasa
            $rute = $rute->where('day2', 1);
        } elseif ($dayOfWeek == 3) {
            // Hari Rabu
            $rute = $rute->where('day3', 1);
        } elseif ($dayOfWeek == 4) {
            // Hari Kamis
            $rute = $rute->where('day4', 1);
        } elseif ($dayOfWeek == 5) {
            // Hari Jumat
            $rute = $rute->where('day5', 1);
        } elseif ($dayOfWeek == 6) {
            // Hari Sabtu
            $rute = $rute->where('day6', 1);
        } elseif ($dayOfWeek == 7) {
            // Hari Minggu
            $rute = $rute->where('day7', 1);
        }
    
        // Filter berdasarkan minggu genap atau ganjil
        if ($isEvenWeek) {
            // Minggu Genap
            $rute = $rute->where('week_genap', 1);
        } else {
            // Minggu Ganjil
            $rute = $rute->where('week_ganjil', 1);
        }
    
        // Ambil data yang sesuai dengan kondisi
        $rute = $rute->get();
    
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
}
