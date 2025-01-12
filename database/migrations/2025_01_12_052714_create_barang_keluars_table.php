<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_barang_keluar', function (Blueprint $table) {
            $table->string('barang_keluar_id')->primary();
            $table->string('nama_barang');
            $table->bigInteger('jumlah_barang');
            $table->string('satuan_barang');
            $table->string('keterangan_barang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_barang_keluar');
        
    }
};