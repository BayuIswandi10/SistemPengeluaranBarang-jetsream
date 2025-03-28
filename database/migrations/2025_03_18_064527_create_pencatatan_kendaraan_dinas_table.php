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
            $table->string('surat_kendaraan_dinas_id', 35);
            $table->string('nrp_karyawan', 35);
            $table->timestamp('update_date')->useCurrent();
            $table->string('status', 35)->nullable();

            $table->foreign('surat_kendaraan_dinas_id', 'fk_pencatatan_dinas_id')
                ->references('surat_kendaraan_dinas_id')->on('tb_surat_kendaraan_dinas')
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
