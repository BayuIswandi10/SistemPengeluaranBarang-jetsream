<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $primaryKey = 'barang_keluar_id';
    protected $table = 'tb_barang_keluar';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nama_barang',
        'jumlah_barang',
        'satuan_barang',
        'keterangan_barang',
    ];

    public function pengeluaranBarang()
    {
        return $this->belongsToMany(PengeluaranBarang::class, 'tb_detail_pengeluaran', 'barang_keluar_id', 'pengeluaran_barang_id');
    }
}