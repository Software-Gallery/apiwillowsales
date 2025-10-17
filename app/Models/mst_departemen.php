<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mst_departemen extends Model
{
    protected $table = 'mst_departemen';
    protected $primaryKey = 'id_departemen';    
    protected $fillable = [
        'id_departemen',
        'kode_departemen',
        'keterangan',
        'created_at',
        'updated_at',
    ];
}
