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
        'tujuan_penggunaan',
        'tanggal_penggunaan',
        'created_by',
        'created_date',
        'status',
        'waktu keluar',
        'waktu kembali',
        'kilometer_awal',
        'kilometer_akhir',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'nrp_karyawan');
    }
}
