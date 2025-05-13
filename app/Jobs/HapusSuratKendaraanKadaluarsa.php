<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\SuratKendaraanDinas;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule; // tambahkan import ini di atas

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

    // public function handle(): void
    // {
    //     $threshold = now()->subHours(2);

    //     $updated = SuratKendaraanDinas::where('status', 'Level 1') // hanya status awal
    //         ->where('created_date', '<=', $threshold) // lebih dari 2 jam
    //         ->update(['status' => 'Expired']);

    //     logger("Auto update: {$updated} surat kendaraan dinas menjadi expired.");
    // }
    public function handle(): void
    {
        $updated = SuratKendaraanDinas::where('status', 'Level 1') // hanya status awal
            ->where('expired_date', '<=', now()) // jika sudah melewati expired_date
            ->update([
                'status' => 'Expired',
                'expired_status' => 'Expired',
            ]);

        logger("Auto update: {$updated} surat kendaraan dinas menjadi expired.");
    }

    public function schedule(Schedule $schedule): void
    {
        $schedule->everyTenMinutes(); // atau everyHour(), daily(), dll
    }

}
