<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class trn_sales_order_header extends Model
{
    protected $table = 'trn_sales_order_header';
    protected $primaryKey = 'kode_sales_order';
    public $incrementing = true; 
    protected $keyType = 'int';  
    protected $fillable = [
        'kode_sales_order',
        'tgl_sales_order',
        'id_departemen',
        'id_customer',
        'id_karyawan',
        'no_ref',
        'tgl_ref',
        'keterangan',
        'status',
        'total',
        'created_at',
        'updated_at',
        'source',
    ];
}
