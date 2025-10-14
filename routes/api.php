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

// Resource routes
Route::apiResource('barang', MstBarangController::class);
Route::apiResource('departemen', MstDepartemenController::class);
Route::apiResource('kota', MstKotaController::class);
Route::apiResource('provinsi', MstProvinsiController::class);
Route::apiResource('customer', MstCustomerController::class);
Route::apiResource('kecamatan', MstKecamatanController::class);
Route::apiResource('kelurahan', MstKelurahanController::class);
Route::apiResource('karyawan', MstKaryawanController::class);
Route::apiResource('satuan', MstSatuanController::class);
//Route::apiResource('absen', TrnAbsenController::class);

Route::get('searchBarang', [MstBarangController::class, 'searchBarang']);
Route::get('absengetkaryawan', [TrnAbsenController::class, 'getByIdKaryawan']);
Route::get('checkAbsen', [TrnAbsenController::class, 'checkAbsen']);

Route::get('getKeranjang', [KeranjangController::class, 'get']);
Route::post('addKeranjang', [KeranjangController::class, 'add']);
Route::delete('removeKeranjang', [KeranjangController::class, 'remove']);

Route::get('sales-order-header', [TrnSalesOrderHeaderController::class, 'index']);
Route::post('sales-order-header', [TrnSalesOrderHeaderController::class, 'store']);

Route::get('sales-order-header/show', [TrnSalesOrderHeaderController::class, 'show']);
Route::put('sales-order-header/update', [TrnSalesOrderHeaderController::class, 'update']);
Route::delete('sales-order-header/delete', [TrnSalesOrderHeaderController::class, 'destroy']);

Route::get('sales-order-detail', [TrnSalesOrderDetailController::class, 'index']);
Route::post('sales-order-detail', [TrnSalesOrderDetailController::class, 'store']);

Route::get('sales-order-detail/show', [TrnSalesOrderDetailController::class, 'show']);
Route::put('sales-order-detail/update', [TrnSalesOrderDetailController::class, 'update']);
Route::delete('sales-order-detail/delete', [TrnSalesOrderDetailController::class, 'destroy']);

Route::get('customer-rute', [MstCustomerRuteController::class, 'index']);
Route::get('customer-rute-by-id', [MstCustomerRuteController::class, 'getById']);
Route::post('customer-rute', [MstCustomerRuteController::class, 'store']);
Route::get('customer-rute/show', [MstCustomerRuteController::class, 'show']);
Route::put('customer-rute/update', [MstCustomerRuteController::class, 'update']);
Route::delete('customer-rute/delete', [MstCustomerRuteController::class, 'destroy']);


Route::get('absen', [TrnAbsenController::class, 'index']);
Route::post('absen', [TrnAbsenController::class, 'store']);
Route::get('absen/show', [TrnAbsenController::class, 'show']);
Route::put('absen/update', [TrnAbsenController::class, 'update']);
Route::delete('absen/delete', [TrnAbsenController::class, 'destroy']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('isValidLogin', [LoginController::class, 'isValidLogin']);
Route::post('/register', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Route::middleware('auth:api')->group(function () {
Route::get('/profile', [LoginController::class, 'profile']);
Route::post('/logout', [LoginController::class, 'logout']);
// });
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
