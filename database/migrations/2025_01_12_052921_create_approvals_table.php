<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_approval', function (Blueprint $table) {
            $table->bigIncrements('approval_id');
            $table->string('pengeluaran_barang_id', 35);
            $table->string('created_by', 35);
            $table->timestamp('created_date')->useCurrent();
            $table->string('status_approval', 20);

            $table->foreign('pengeluaran_barang_id')->references('pengeluaran_barang_id')->on('tb_pengeluaran_barang')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('nrp_karyawan')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_approval');
    }
};