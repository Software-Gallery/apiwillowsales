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
        Schema::create('trn_sales_order_header', function (Blueprint $table) {
            $table->string('kode_sales_order', 30)->primary();
            $table->date('tgl_sales_order');
            $table->unsignedInteger('id_departemen')->nullable();
            $table->unsignedInteger('id_customer');
            $table->unsignedInteger('id_karyawan')->nullable();
            $table->string('no_ref', 200)->nullable();
            $table->date('tgl_ref')->nullable();
            $table->string('keterangan', 200)->nullable();
            $table->string('status', 20)->default('DRAFT');
            $table->decimal('total', 18, 4)->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->string('source', 20)->default('SFA');

            // $table->unique(['kode_sales_order'], 'uk_so_kode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_sales_order_header');
    }
};
