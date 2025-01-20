<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengeluaran extends Model
{
    use HasFactory;

    protected $primaryKey = 'detail_pengeluaran_id';
    protected $table = 'tb_detail_pengeluaran';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'detail_pengeluaran_id',
        'barang_keluar_id',
        'pengeluaran_barang_id',
    ];

    public function barangKeluar()
    {
        return $this->belongsTo(BarangKeluar::class, 'barang_keluar_id');
    }

    public function pengeluaranBarang()
    {
        return $this->belongsTo(PengeluaranBarang::class, 'pengeluaran_barang_id');
    }
}
