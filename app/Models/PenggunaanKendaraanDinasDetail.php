<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenggunaanKendaraanDinasDetail extends Model
{
    protected $primaryKey = 'penggunaan_kendaraan_dinas_detail_id';
    protected $table = 'tb_penggunaan_kendaraan_dinas_detail';
    public $incrementing = true;
    protected $keyType = 'int'; 
    public $timestamps = false;

    protected $fillable = [
        'penggunaan_kendaraan_dinas_detail_id',
        'surat_kendaraan_dinas_id',
        'created_date',
    ];
    public function suratKendaraanDinas()
    {
        return $this->belongsTo(SuratKendaraanDinas::class, 'surat_kendaraan_dinas_id', 'surat_kendaraan_dinas_id');
    }
}
