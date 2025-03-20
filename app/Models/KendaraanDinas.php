<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KendaraanDinas extends Model
{
    protected $primaryKey = 'kendaraan_dinas_id';
    protected $table = 'tb_kendaraan_dinas';
    public $incrementing = true;
    protected $keyType = 'int'; 
    public $timestamps = false;

    protected $fillable = [
        'kendaraan_dinas_id',
        'merk_kendaraan',
        'jenis_kendaraan',
        'nomor_kendaraan',
        'kapasitas_kendaraan',
        'status_kendaraan',
        'created_by',
        'created_date',
        'updated_by',
        'updated_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'nrp_karyawan');
    }

}
