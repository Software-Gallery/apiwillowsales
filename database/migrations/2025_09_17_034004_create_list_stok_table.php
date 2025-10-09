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
        Schema::create('list_stok', function (Blueprint $table) {
            $table->increments('id_barang');
            $table->date('tgl_stok');
            $table->unsignedInteger('id_departemen')->nullable();
            $table->decimal('qty_besar', 18, 4)->default(0);
            $table->decimal('qty_tengah', 18, 4)->default(0);
            $table->decimal('qty_kecil', 18, 4)->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_stok');
    }
};
