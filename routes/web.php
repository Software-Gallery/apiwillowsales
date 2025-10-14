<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeranjangController;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/api/insertAbsen', [TrnAbsenController::class, 'store']);
