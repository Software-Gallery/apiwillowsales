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
        Schema::create('list_piutang', function (Blueprint $table) {
            $table->string('no_nota', 30)->primary();
            $table->date('tgl_nota');
            $table->unsignedInteger('id_departemen')->nullable();
            $table->unsignedInteger('id_customer');
            $table->unsignedInteger('id_karyawan')->nullable();
            $table->date('tgl_jtempo');
            $table->date('tgl_kirim');
            $table->decimal('total_nota', 18, 4)->nullable();
            $table->decimal('total_pay', 18, 4)->nullable();
            $table->decimal('total_piutang', 18, 4)->nullable();
            $table->string('keterangan', 200)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_piutang');
    }
};
