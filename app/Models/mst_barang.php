<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mst_barang extends Model
{
    protected $table = 'mst_barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = [
        'id_barang',
        'kode_barang',
        'id_departemen',
        'nama_barang',
        'satuan_besar',
        'satuan_tengah',
        'satuan_kecil',
        'konversi_besar',
        'konversi_tengah',
        'gambar',
        'is_aktif',
        'created_at',
        'updated_at',
        'harga'
    ];
}
