<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MstBarangController;
use App\Http\Controllers\MstDepartemenController;
use App\Http\Controllers\MstKotaController;
use App\Http\Controllers\MstProvinsiController;
use App\Http\Controllers\MstCustomerController;
use App\Http\Controllers\MstKecamatanController;
use App\Http\Controllers\MstKelurahanController;
use App\Http\Controllers\MstCustomerRuteController;
use App\Http\Controllers\MstKaryawanController;
use App\Http\Controllers\MstSatuanController;
use App\Http\Controllers\TrnSalesOrderHeaderController;
use App\Http\Controllers\TrnSalesOrderDetailController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TrnAbsenController;
use App\Http\Controllers\AppSettingController;

// Rute untuk login dan register (tanpa autentikasi)
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);
Route::post('isValidLogin', [LoginController::class, 'isValidLogin']);

// Rute untuk semua resource yang tidak memerlukan autentikasi
Route::apiResource('barang', MstBarangController::class);
Route::apiResource('departemen', MstDepartemenController::class);
Route::apiResource('kota', MstKotaController::class);
Route::apiResource('provinsi', MstProvinsiController::class);
Route::apiResource('customer', MstCustomerController::class);
Route::apiResource('kecamatan', MstKecamatanController::class);
Route::apiResource('kelurahan', MstKelurahanController::class);
Route::apiResource('karyawan', MstKaryawanController::class);
Route::apiResource('satuan', MstSatuanController::class);

// Rute absensi tanpa autentikasi
Route::get('absen', [TrnAbsenController::class, 'index']);
Route::post('absen', [TrnAbsenController::class, 'store'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::get('absen/show', [TrnAbsenController::class, 'show']);
Route::put('absen/update', [TrnAbsenController::class, 'update']);
Route::delete('absen/delete', [TrnAbsenController::class, 'destroy']);
Route::get('absengetkaryawan', [TrnAbsenController::class, 'getByIdKaryawan']);
Route::get('checkAbsen', [TrnAbsenController::class, 'checkAbsen']);
Route::post('selesaiabsen', [TrnAbsenController::class, 'selesai']);
Route::post('upload-image', [TrnAbsenController::class, 'uploadImage']);
Route::get('absen-total', [TrnAbsenController::class, 'total']);
Route::get('absen-histori', [TrnAbsenController::class, 'histori']);

// Rute keranjang tanpa autentikasi
Route::get('getKeranjang', [KeranjangController::class, 'get']);
Route::get('getTrnDetail', [KeranjangController::class, 'getTrnDetail']);
Route::post('addKeranjang', [KeranjangController::class, 'add']);
Route::delete('removeKeranjang', [KeranjangController::class, 'remove']);

// Rute sales order tanpa autentikasi
Route::get('sales-order-header', [TrnSalesOrderHeaderController::class, 'index']);
Route::post('sales-order-header', [TrnSalesOrderHeaderController::class, 'store']);
Route::get('sales-order-header/show', [TrnSalesOrderHeaderController::class, 'show']);
Route::post('sales-order-header/update', [TrnSalesOrderHeaderController::class, 'update']);
Route::delete('sales-order-header/delete', [TrnSalesOrderHeaderController::class, 'destroy']);

Route::get('sales-order-detail', [TrnSalesOrderDetailController::class, 'index']);
Route::post('sales-order-detail', [TrnSalesOrderDetailController::class, 'store']);
Route::get('sales-order-detail/show', [TrnSalesOrderDetailController::class, 'show']);
Route::post('sales-order-detail/update', [TrnSalesOrderDetailController::class, 'update']);
Route::delete('sales-order-detail/delete', [TrnSalesOrderDetailController::class, 'destroy']);

// Rute customer rute tanpa autentikasi
Route::get('customer-rute', [MstCustomerRuteController::class, 'index']);
Route::get('customer-rute-all', [MstCustomerRuteController::class, 'getByIdAll']);
Route::get('customer-rute-by-id', [MstCustomerRuteController::class, 'getById']);
Route::post('customer-rute', [MstCustomerRuteController::class, 'store']);
Route::get('customer-rute/show', [MstCustomerRuteController::class, 'show']);
Route::put('customer-rute/update', [MstCustomerRuteController::class, 'update']);
Route::delete('customer-rute/delete', [MstCustomerRuteController::class, 'destroy']);

Route::get('profile', [LoginController::class, 'profile']);

// Rute searchBarang tanpa autentikasi
Route::get('searchBarang', [MstBarangController::class, 'searchBarang']);

Route::get('setting-info', [AppSettingController::class, 'index']);
