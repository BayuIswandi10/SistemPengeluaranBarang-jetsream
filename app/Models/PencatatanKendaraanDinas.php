<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PencatatanKendaraanDinas extends Model
{
    protected $table = 'tb_pencatatan_kendaraan_dinas';
    protected $primaryKey = 'pencatatan_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'pencatatan_id',
        'surat_kendaraan_dinas_id',
        'nrp_karyawan',
        'update_date',
    ];
    public function suratDinas()
    {
        return $this->belongsTo(SuratKendaraanDinas::class, 'surat_kendaraan_dinas_id', 'surat_kendaraan_dinas_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'nrp_karyawan', 'nrp_karyawan');
    }
}
