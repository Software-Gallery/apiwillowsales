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
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_barang');
            $table->unsignedInteger('id_karyawan');
            $table->decimal('qty_besar', 18, 4)->default(0);
            $table->decimal('qty_tengah', 18, 4)->default(0);
            $table->decimal('qty_kecil', 18, 4)->default(0);            
            $table->decimal('qty', 10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjangs');
    }
};
