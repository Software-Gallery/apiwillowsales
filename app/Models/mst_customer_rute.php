<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mst_customer_rute extends Model
{
    protected $table = 'mst_customer_rute';
    protected $primaryKey = 'id_departemen';
    protected $fillable = [
        'id_departemen',
        'id_customer',
        'id_karyawan',
        'day1',
        'day2',
        'day3',
        'day4',
        'day5',
        'day6',
        'day7',
        'week_ganjil',
        'week_genap',
    ];

    public function departemen()
    {
        return $this->belongsTo(mst_departemen::class, 'id_departemen');
    }
    
    public function customer()
    {
        return $this->belongsTo(mst_customer::class, 'id_customer');
    }
    
    public function karyawan()
    {
        return $this->belongsTo(mst_karyawan::class, 'id_karyawan');
    }
    
}
