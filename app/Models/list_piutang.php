<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class list_piutang extends Model
{
    protected $table = 'list_piutang';
    protected $fillable = [
        'no_nota',
        'tgl_nota',
        'id_departemen',
        'id_customer',
        'id_karyawan',
        'tgl_jtempo',
        'tgl_kirim',
        'total_nota',
        'total_pay',
        'total_piutang',
        'keterangan',
        'created_at',
        'updated_at',
    ];
}
