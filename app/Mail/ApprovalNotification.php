<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalNotification extends Mailable
{
    public $pengeluaranBarangId;
    public $approvedBy;
    public $status;
    public $qrCodeBase64;

    public function __construct($pengeluaranBarangId, $approvedBy, $status)
    {
        $this->pengeluaranBarangId = $pengeluaranBarangId;
        $this->approvedBy = $approvedBy;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject('Approval Notification')
            ->view('emails.approvalNotification')
            ->with([
                'pengeluaranBarangId' => $this->pengeluaranBarangId,
                'approvedBy' => $this->approvedBy,
                'status' => $this->status,
            ]);
    }
}
