<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\mst_customer;

class trn_sales_order_header extends Model
{
    protected $table = 'trn_sales_order_header';
    protected $primaryKey = 'kode_sales_order';
    protected $casts = [
       // 'kode_sales_order' => 'string',
        'total' => 'double',
    ];

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
    
    public function getTotalAttribute($value)
    {
        return number_format((float) $value, 1, '.', '');
    }

    public function customer()
    {
        return $this->belongsTo(mst_customer::class, 'id_customer'); // 'id_customer' adalah foreign key
    }    

}
