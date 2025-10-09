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
        Schema::create('mst_karyawan', function (Blueprint $table) {
            $table->increments('id_karyawan');
            $table->string('kode_karyawan', 50);
            $table->unsignedInteger('id_departemen');
            $table->string('nama', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();

            $table->unique(['kode_karyawan', 'id_departemen'], 'uk_karyawan_kode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_karyawan');
    }
};
