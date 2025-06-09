<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKendaraanDinas extends Model
{
    protected $primaryKey = 'surat_kendaraan_dinas_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'tb_surat_kendaraan_dinas';
    public $timestamps = false;

    protected $fillable = [
        'surat_kendaraan_dinas_id',
        'tujuan_penggunaan_1',
        'tujuan_penggunaan_2',
        'tujuan_penggunaan_3',
        'tanggal_penggunaan',
        'waktu_pergi',
        'waktu_pulang',
        'jenis_kendaraan',
        'created_by',
        'created_date',
        'expired_date',
        'expired_status',
        'status',
        'kilometer_awal',
        'alasan_penolakan',
        'alasan_penggunaan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'nrp_karyawan');
    }

    public function pencatatanKendaraanDinas()
    {
        return $this->hasMany(PencatatanKendaraanDinas::class, 'surat_kendaraan_dinas_id', 'surat_kendaraan_dinas_id');
    }

    public function suratDetail()
    {
        return $this->hasMany(SuratKendaraanDinasDetail::class, 'surat_kendaraan_dinas_id', 'surat_kendaraan_dinas_id');
    }

    public function approval()
    {
        return $this->hasMany(ApprovalKendaraanDinas::class, 'surat_kendaraan_dinas_id', 'surat_kendaraan_dinas_id');
    }
}
