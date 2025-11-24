<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Login;

class Login extends Model
{
    protected $table = 'login';

    protected $fillable = [
        'name', 'email', 'password', 'api_token',
    ];

    protected $hidden = [
        'password', 'api_token',
    ];

    // Mutator untuk password, otomatis hash saat menyimpan
    public function setPasswordAttribute($value)
    {
        // Jika ada nilai password yang dimasukkan, hash dan simpan
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    // Boot method untuk men-generate api_token secara otomatis
    protected static function booted()
    {
        static::creating(function ($login) {
            // Generate api_token jika belum ada token yang diisi
            if (empty($login->api_token)) {
                $login->api_token = Str::random(60);
            }
        });
    }

    public function karyawan()
    {
        return $this->belongsTo(mst_karyawan::class, 'id_karyawan');
    }

}
