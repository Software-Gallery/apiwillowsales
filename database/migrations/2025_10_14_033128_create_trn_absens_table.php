<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trn_absen', function (Blueprint $table) {
            $table->id('id_absen'); 
            $table->unsignedInteger('id_karyawan');
            $table->unsignedInteger('id_customer');
            $table->unsignedInteger('id_departemen');
            $table->string('kode_sales_order')->nullable(); 
            $table->date('tgl'); 
            $table->time('jam_masuk'); 
            $table->time('jam_keluar')->nullable(); 
            $table->double('latitude'); 
            $table->double('longitude'); 
            $table->string('keterangan')->nullable(); 
            $table->string('alamat')->nullable(); 
            $table->string('tipe');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_absens');
    }
};
