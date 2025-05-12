<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\SuratKendaraanDinas;
use Carbon\Carbon;

class HapusSuratKendaraanKadaluarsa implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
   public function handle(): void
    {
        $threshold = now()->subHours(2);

        $deleted = SuratKendaraanDinas::where('status', 'Level 1') // hanya status awal
            ->where('created_date', '<=', $threshold) // lebih dari 2 jam
            ->delete();

        logger("Auto delete: {$deleted} surat kendaraan dinas kadaluarsa.");
    }

}
