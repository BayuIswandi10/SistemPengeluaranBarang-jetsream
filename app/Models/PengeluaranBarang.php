<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranBarang extends Model
{
    use HasFactory;

    protected $primaryKey = 'pengeluaran_barang_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'tb_pengeluaran_barang';
    public $timestamps = false;

    protected $fillable = [
        'pengeluaran_barang_id', 
        'kategori_pengeluaran',
        'pembawa_scrap',
        'created_by',
        'created_date',
        'lokasi_barang_keluar',
        'tujuan_pengeluaran_barang',
        'jenis_kendaraan',
        'no_polisi',
        'status',
        'updated_by',
        'updated_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'nrp_karyawan');
    }

    public function approval()
    {
        return $this->hasMany(Approval::class, 'pengeluaran_barang_id', 'pengeluaran_barang_id');
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'pengeluaran_barang_id', 'pengeluaran_barang_id');
    }
}