<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Approval extends Model
{
    use HasFactory;

    protected $primaryKey = 'approval_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
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

    public function addNextApprovalLevel()
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
            // Get the next level status
            $nextLevel = $levels[$currentLevelIndex + 1];

            // Generate the next approval_id based on the last entry in the database
            $lastApproval = Approval::orderBy('approval_id', 'desc')->first();
            if ($lastApproval) {
                $lastNumber = (int) substr($lastApproval->approval_id, 3); // Extract numeric part
                $nextNumber = $lastNumber + 1; // Increment the number
            } else {
                $nextNumber = 1; // Start from 1 if no record exists
            }

            $newApprovalId = 'APR' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT); // Format as APR0001

            // Create a new Approval entry with next level
            $newApproval = new Approval();
            $newApproval->approval_id = $newApprovalId;
            $newApproval->pengeluaran_barang_id = $this->pengeluaran_barang_id;
            $newApproval->status_approval = $nextLevel;
            $newApproval->created_by = $this->created_by; // Assuming this comes from the user
            $newApproval->created_date = Carbon::now(); // Set the current timestamp
            $newApproval->save();

            return $newApproval;
        }
        return null;
    }

}