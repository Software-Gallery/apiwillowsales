<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mst_provinsi extends Model
{
    protected $table = 'mst_provinsi';
    protected $primaryKey = 'id_provinsi';
    public $incrementing = true; 
    protected $keyType = 'int';  
    protected $fillable = [
        'id_provinsi',
        'kode_provinsi',
        'created_at',
        'updated_at',
    ];
}
