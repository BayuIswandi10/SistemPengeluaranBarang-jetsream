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
        'penggunaan_kendaraan_dinas_detail_id',
        'nrp_karyawan',
        'updated_date',
    ];
    public function penggunaanDetail()
    {
        return $this->belongsTo(PenggunaanKendaraanDinasDetail::class, 'penggunaan_kendaraan_dinas_detail_id', 'penggunaan_kendaraan_dinas_detail_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'nrp_karyawan');
    }
}
