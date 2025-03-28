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
        Schema::create('tb_approval_penggunaan_kendaraan_dinas', function (Blueprint $table) {
            $table->bigIncrements('approval_penggunaan_kendaraan_dinas_id');
            $table->string('surat_kendaraan_dinas_id', 35);
            $table->string('created_by', 35);
            $table->timestamp('created_date')->useCurrent();
            $table->string('status_approval', 20);

            $table->foreign('surat_kendaraan_dinas_id',  'fk_appr_surat_id')
                ->references('surat_kendaraan_dinas_id')->on('tb_surat_kendaraan_dinas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->foreign('create_by')
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
        Schema::dropIfExists('tb_approval_penggunaan_kendaraan_dinas');
    }
};
