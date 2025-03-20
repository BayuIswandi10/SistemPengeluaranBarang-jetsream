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
        'jenis_kendaraan',
        'created_by',
        'created_date',
        'status',
        'waktu_keluar',
        'waktu_kembali',
        'kilometer_awal',
        'kilometer_akhir',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'nrp_karyawan');
    }

    public function pencatatanDinas()
    {
        return $this->hasMany(PencatatanKendaraanDinas::class, 'surat_kendaraan_dinas_id', 'surat_kendaraan_dinas_id');
    }
}
