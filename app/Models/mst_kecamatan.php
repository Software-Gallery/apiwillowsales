<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mst_kecamatan extends Model
{
    protected $table = 'mst_kecamatan';
    protected $primaryKey = 'id_kecamatan';
    public $incrementing = true; 
    protected $keyType = 'int';  
    protected $fillable = [
        'id_kecamatan',
        'kode_kecamatan',
        'created_at',
        'updated_at',
    ];
}
