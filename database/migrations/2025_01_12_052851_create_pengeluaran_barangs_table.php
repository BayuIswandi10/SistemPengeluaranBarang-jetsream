<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_pengeluaran_barang', function (Blueprint $table) {
            $table->string('pengeluaran_barang_id', 35)->primary();
            $table->integer('kategori_pengeluaran')->nullable();
            $table->string('pembawa_scrap', 35)->nullable();
            $table->string('created_by', 35);
            $table->timestamp('created_date')->useCurrent();
            $table->string('lokasi_barang_keluar', 35);
            $table->string('tujuan_pengeluaran_barang', 35);
            $table->string('jenis_kendaraan', 35);
            $table->string('no_polisi', 35)->nullable();
            $table->string('status', 35);

            $table->foreign('created_by')
                ->references('nrp_karyawan')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_pengeluaran_barang');
    }
};