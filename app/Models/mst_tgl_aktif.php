<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mst_tgl_aktif extends Model
{
    protected $table = 'mst_tgl_aktif';
    protected $fillable = [
        'id_departemen',
        'tgl_aktif',
    ];
}
