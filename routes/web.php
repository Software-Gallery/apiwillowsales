<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TrnAbsenController;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/api/insertAbsen', [TrnAbsenController::class, 'store']);
