<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class app_setting extends Model
{
    protected $table = 'app_settings';
    protected $fillable = [
        'min_version',
    ];
}
