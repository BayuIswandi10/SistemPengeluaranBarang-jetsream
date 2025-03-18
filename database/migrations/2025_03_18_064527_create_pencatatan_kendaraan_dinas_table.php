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
        Schema::create('tb_pencatatan_kendaraan_dinas', function (Blueprint $table) {
            $table->bigIncrements('pencatatan_id');
            $table->unsignedBigInteger('penggunaan_kendaraan_dinas_detail_id');
            $table->string('nrp_karyawan', 35);
            $table->timestamp('update_date')->useCurrent();

            $table->foreign('penggunaan_kendaraan_dinas_detail_id', 'fk_pencatatan_penggunaan_id')
                ->references('penggunaan_kendaraan_dinas_detail_id')->on('tb_penggunaan_kendaraan_dinas_detail')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('nrp_karyawan')
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
        Schema::dropIfExists('tb_pencatatan_kendaraan_dinas');
    }
};
