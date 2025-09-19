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
        Schema::create('mst_customer', function (Blueprint $table) {
            $table->increments('id_customer');
            $table->string('kode_customer', 50);
            $table->unsignedInteger('id_departemen');
            $table->string('nama', 100);
            $table->string('alamat', 200)->nullable();
            $table->unsignedInteger('id_provinsi')->nullable();
            $table->unsignedInteger('id_kota')->nullable();
            $table->unsignedInteger('id_kecamatan')->nullable();
            $table->unsignedInteger('id_kelurahan')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->decimal('latitude', 9, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->boolean('is_aktif')->nullable()->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();

            $table->unique(['kode_customer', 'id_departemen'], 'uk_customer_kode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_customer');
    }
};
