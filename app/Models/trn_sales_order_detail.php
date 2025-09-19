<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class trn_sales_order_detail extends Model
{
    protected $table = 'trn_sales_order_detail';
    protected $fillable = [
        'kode_sales_order',
        'id_barang',
        'qty_besar',
        'qty_tengah',
        'qty_kecil',
        'harga',
        'disc_cash',
        'disc_perc',
        'subtotal',
        'ket_detail',
        'created_at',
        'updated_at',
    ];
}
