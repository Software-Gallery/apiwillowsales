<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/api/getKeranjang', [KeranjangController::class, 'get']);
Route::get('/api/addKeranjang', [KeranjangController::class, 'add']);
Route::get('/api/removeKeranjang', [KeranjangController::class, 'remove']);
