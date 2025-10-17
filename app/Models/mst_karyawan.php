<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mst_karyawan extends Model
{
    protected $table = 'mst_karyawan';
    protected $primaryKey = 'id_karyawan';    
    protected $fillable = [
        'id_karyawan',
        'kode_karyawan',
        'id_departemen',
        'nama',
        'created_at',
        'updated_at',
    ];
}
