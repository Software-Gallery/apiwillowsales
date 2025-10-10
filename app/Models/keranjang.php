<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class keranjang extends Model
{
    protected $table = 'keranjangs';
    protected $fillable = [
        'id_barang',
        'id_karyawan',
        'qty_besar',
        'qty_tengah',
        'qty_kecil',
        'created_at',
        'updated_at',
    ];    
}
