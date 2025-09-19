<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mst_satuan extends Model
{
    protected $table = 'mst_satuan';
    protected $fillable = [
        'id_satuan',
        'kode_satuan',
    ];
}
