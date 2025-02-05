<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_barang_keluar', function (Blueprint $table) {
            $table->bigIncrements('barang_keluar_id');
            $table->string('nama_barang', 50);
            $table->bigInteger('jumlah_barang');
            $table->string('satuan_barang', 35);
            $table->string('keterangan_barang', 500);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_barang_keluar');
        
    }
};