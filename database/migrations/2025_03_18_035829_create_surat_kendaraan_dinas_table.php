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
        Schema::create('tb_surat_kendaraan_dinas', function (Blueprint $table) {
            $table->string('surat_kendaraan_dinas_id', 35)->primary();
            $table->string('tujuan_penggunaan_1', 35);
            $table->string('tujuan_penggunaan_2', 35)->nullable();
            $table->string('tujuan_penggunaan_3', 35)->nullable();
            $table->date('tanggal_penggunaan');
            $table->integer('jenis_kendaraan');
            $table->string('status', 35);
            $table->string('created_by', 35);
            $table->timestamp('created_date')->useCurrent();
            $table->dateTime('expired_date')->useCurrent();
            $table->string('expired_status', 15);
            $table->string('kilometer_awal', 35)->nullable();
            $table->string('kilometer_akhir', 35)->nullable();

            $table->foreign('created_by')
                ->references('nrp_karyawan')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_surat_kendaraan_dinas');
    }
};
