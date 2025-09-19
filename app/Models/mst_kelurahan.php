<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mst_kelurahan extends Model
{
    protected $table = 'mst_kelurahan';
    protected $primaryKey = 'id_kelurahan';
    public $incrementing = true; 
    protected $keyType = 'int';  
    protected $fillable = [
        'id_kelurahan',
        'kode_kelurahan',
        'created_at',
        'updated_at',
    ];
}
