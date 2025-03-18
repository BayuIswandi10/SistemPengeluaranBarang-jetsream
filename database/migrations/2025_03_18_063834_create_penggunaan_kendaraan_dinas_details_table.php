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
        Schema::create('tb_penggunaan_kendaraan_dinas_detail', function (Blueprint $table) {
            $table->bigIncrements('penggunaan_kendaraan_dinas_detail_id');
            $table->string('surat_kendaraan_dinas_id', 35);
            $table->timestamp('created_date')->useCurrent();

            $table->foreign('surat_kendaraan_dinas_id', 'fk_penggunaan_surat_id')
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
        Schema::dropIfExists('tb_penggunaan_kendaraan_dinas_detail');
    }
};
