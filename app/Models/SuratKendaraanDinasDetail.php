<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKendaraanDinasDetail extends Model
{
    protected $primaryKey = 'surat_kendaraan_dinas_detail_id';
    protected $table = 'tb_surat_kendaraan_dinas_detail';
    public $incrementing = true;
    protected $keyType = 'int'; 
    public $timestamps = false;

    protected $fillable = [
        'surat_kendaraan_dinas_detail_id',
        'kendaraan_dinas_id',
        'surat_kendaraan_dinas_id',
    ];

    public function surat() {
        return $this->belongsTo(SuratKendaraanDinas::class, 'surat_kendaraan_dinas_id', 'surat_kendaraan_dinas_id');
    }
    public function kendaraan() {
        return $this->belongsTo(KendaraanDinas::class, 'kendaraan_dinas_id', 'kendaraan_dinas_id');
    }
}
