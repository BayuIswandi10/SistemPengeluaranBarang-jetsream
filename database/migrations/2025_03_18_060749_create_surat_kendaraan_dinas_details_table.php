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
        Schema::create('tb_surat_kendaraan_dinas_detail', function (Blueprint $table) {
            $table->bigIncrements('surat_kendaraan_dinas_detail_id')->primary();
            $table->unsignedBigInteger('kendaraan_dinas_id');
            $table->string('surat_kendaraan_dinas_id', 35);

            $table->foreign('kendaraan_dinas_id')
                ->references('kendaraan_dinas_id')->on('tb_kendaraan_dinas')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('surat_kendaraan_dinas_id')
                ->references('surat_kendaraan_dinas_id')->on('tb_surat_kendaraan_dinas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_surat_kendaraan_dinas_details');
    }
};
