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
        Schema::create('tb_kendaraan_dinas', function (Blueprint $table) {
            $table->bigIncrements('kendaraan_dinas_id');
            $table->string('merk_kendaraan', 50);
            $table->integer('jenis_kendaraan');
            $table->string('nomor_kendaraan', 15);
            $table->integer('kapasitas_kendaraan');
            $table->integer('status_kendaraan');
            $table->string('created_by', 35);
            $table->timestamp('created_date')->useCurrent();
            $table->string('updated_by', 35)->nullable();
            $table->timestamp('updated_date')->useCurrent()->nullable();

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
        Schema::dropIfExists('tb_kendaraan_dinas');
    }
};
