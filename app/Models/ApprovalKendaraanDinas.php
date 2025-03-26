<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalKendaraanDinas extends Model
{
    protected $table = 'tb_approval_penggunaan_kendaraan_dinas';
    protected $primaryKey = 'approval_penggunaan_kendaraan_dinas_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'approval_penggunaan_kendaraan_dinas_id',
        'surat_kendaraan_dinas_id',
        'created_by',
        'created_date',
        'status_approval',
    ];

    public function suratKendaraanDinas()
    {
        return $this->belongsTo(SuratKendaraanDinas::class, 'surat_kendaraan_dinas_id', 'surat_kendaraan_dinas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'nrp_karyawan');
    }

}
