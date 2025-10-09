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
        Schema::create('mst_barang', function (Blueprint $table) {
            $table->increments('id_barang');
            $table->string('kode_barang', 50);
            $table->unsignedInteger('id_departemen');
            $table->string('nama_barang');
            $table->unsignedInteger('satuan_besar')->nullable();
            $table->unsignedInteger('satuan_tengah')->nullable();
            $table->unsignedInteger('satuan_kecil');
            $table->unsignedInteger('konversi_besar')->nullable();
            $table->unsignedInteger('konversi_tengah')->nullable();
            $table->text('gambar')->nullable();
            $table->boolean('is_aktif')->nullable()->default(true);
            $table->double('harga', 8, 2);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->unique(['kode_barang', 'id_departemen'], 'uk_barang_kode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_barang');
    }
};
