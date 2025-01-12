<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_pengeluaran_barang', function (Blueprint $table) {
            $table->string('pengeluaran_barang_id')->primary();
            $table->string('created_by');
            $table->timestamp('created_date')->useCurrent();
            $table->string('tujuan_pengeluaran_barang');
            $table->string('jenis_kendaraan');

            $table->foreign('created_by')
                ->references('nrp_karyawan')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('tb_detail_pengeluaran', function (Blueprint $table) {
            $table->string('detail_pengeluaran_id')->primary();
            $table->string('barang_keluar_id');
            $table->string('pengeluaran_barang_id');
            $table->integer('jumlah');

            $table->foreign('barang_keluar_id')
                ->references('barang_keluar_id')->on('tb_barang_keluar')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('pengeluaran_barang_id')
                ->references('pengeluaran_barang_id')->on('tb_pengeluaran_barang')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_pengeluaran_barang');
        Schema::dropIfExists('tb_detail_pengeluaran');
    }
};