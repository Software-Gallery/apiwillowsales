<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mst_kota extends Model
{
    protected $table = 'mst_kota';
    protected $primaryKey = 'id_kota';
    public $incrementing = true; 
    protected $keyType = 'int';      
    protected $fillable = [
        'id_kota',
        'kode_kota',
        'created_at',
        'updated_at',
    ];
}
