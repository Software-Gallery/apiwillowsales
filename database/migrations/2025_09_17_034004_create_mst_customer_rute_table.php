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
        Schema::create('mst_customer_rute', function (Blueprint $table) {
            $table->unsignedInteger('id_departemen');
            $table->unsignedInteger('id_customer');
            $table->unsignedInteger('id_karyawan');
            $table->boolean('day1')->nullable()->default(false);
            $table->boolean('day2')->nullable()->default(false);
            $table->boolean('day3')->nullable()->default(false);
            $table->boolean('day4')->nullable()->default(false);
            $table->boolean('day5')->nullable()->default(false);
            $table->boolean('day6')->nullable()->default(false);
            $table->boolean('day7')->nullable()->default(false);
            $table->boolean('week_ganjil')->nullable()->default(false);
            $table->boolean('week_genap')->nullable()->default(false);
            $table->timestamps();
            $table->primary(['id_departemen', 'id_customer', 'id_karyawan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_customer_rute');
    }
};
