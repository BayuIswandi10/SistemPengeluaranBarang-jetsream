<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $primaryKey = 'approval_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'tb_approval';
    public $timestamps = false;

    protected $fillable = [
        'approval_id',
        'pengeluaran_barang_id',
        'created_by',
        'created_date',
        'status_approval',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'nrp_karyawan');
    }

    public function pengeluaranBarang()
    {
        return $this->belongsTo(PengeluaranBarang::class, 'pengeluaran_barang_id', 'pengeluaran_barang_id');
    }

    public function updateApprovalStatus()
    {
        // Define the levels
        $levels = [
            'Level 1',
            'Level 2',
            'Level 3',
            'Level 4',
            'Level 5',
        ];

        // Get the current level
        $currentLevelIndex = array_search($this->status_approval, $levels);

        // Check if the current status is not at the maximum level (Level 5)
        if ($currentLevelIndex !== false && $currentLevelIndex < 4) {
            // Set the next level status
            $this->status_approval = $levels[$currentLevelIndex + 1];
            $this->save();
        }
    }

}