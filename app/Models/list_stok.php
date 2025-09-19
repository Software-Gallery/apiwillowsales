<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class list_stok extends Model
{
    protected $fillable = [
        'id_barang',
        'tgl_stok',
        'id_departemen',
        'qty_besar',
        'qty_tengah',
        'qty_kecil',
        'created_at',
        'updated_at',
    ];
}
