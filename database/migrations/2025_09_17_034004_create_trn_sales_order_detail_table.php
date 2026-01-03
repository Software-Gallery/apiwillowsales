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
        Schema::create('trn_sales_order_detail', function (Blueprint $table) {
            $table->string('kode_sales_order', 30);
            $table->unsignedInteger('id_barang');
            $table->decimal('qty_besar', 18, 4)->default(0);
            $table->decimal('qty_tengah', 18, 4)->default(0);
            $table->decimal('qty_kecil', 18, 4)->default(0);
            $table->decimal('harga', 18, 4)->nullable();
            $table->decimal('disc_cash', 18, 4)->default(0);
            $table->decimal('disc_perc', 9, 4)->default(0);
            $table->decimal('subtotal', 18, 4)->default(0);
            $table->string('ket_detail', 200)->nullable();
            $table->string('status', 10)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();

            $table->primary(['kode_sales_order', 'id_barang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_sales_order_detail');
    }
};
