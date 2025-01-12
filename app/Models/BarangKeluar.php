<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $primaryKey = 'barang_keluar_id';
    protected $table = 'tb_barang_keluar';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'barang_keluar_id',
        'nama_barang',
        'jumlah_barang',
        'satuan_barang',
        'keterangan_barang',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate UUID for barang_keluar_id automatically
        static::creating(function ($model) {
            if (empty($model->barang_keluar_id)) {
                $model->barang_keluar_id = (string) Str::uuid();
            }
        });
    }

    public function pengeluaranBarang()
    {
        return $this->belongsToMany(PengeluaranBarang::class, 'tb_detail_pengeluaran', 'barang_keluar_id', 'pengeluaran_barang_id');
    }
}