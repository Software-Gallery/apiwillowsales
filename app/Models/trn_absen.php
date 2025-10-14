<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class trn_absen extends Model
{
    protected $table = 'trn_absen';
    protected $primaryKey = 'id_absen';
    protected $fillable = [
        "id_karyawan",
        "id_customer",
        "kode_sales_order",
        "tgl",
        "jam_masuk",
        "jam_keluar",
        "latitude",
        "longitude",
        "keterangan",
        "alamat"
    ];
}
