<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mst_customer extends Model
{
    protected $table = 'mst_customer';
    protected $primaryKey = 'id_customer';    
    protected $fillable = [
        'id_customer',
        'kode_customer',
        'id_departemen',
        'nama',
        'alamat',
        'id_provinsi',
        'id_kota',
        'id_kecamatan',
        'id_kelurahan',
        'kode_pos',
        'latitude',
        'longitude',
        'is_aktif',
        'created_at',
        'updated_at',
    ];
}
