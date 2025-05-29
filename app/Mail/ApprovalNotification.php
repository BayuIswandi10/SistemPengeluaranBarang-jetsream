<?php

namespace App\Mail;
use Illuminate\Mail\Mailable;

class ApprovalNotification extends Mailable
{
    public $pengeluaranBarangId;
    public $approvedBy;
    public $status;
    public $fromDepartment;
    public $reason;

    public function __construct($pengeluaranBarangId, $approvedBy, $status, $fromDepartment, $reason = null)
    {
        $this->pengeluaranBarangId = $pengeluaranBarangId;
        $this->approvedBy = $approvedBy;
        $this->status = $status;
        $this->fromDepartment = $fromDepartment;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('Approval Notification')
            ->view('emails.approvalNotification')
            ->with([
                'pengeluaranBarangId' => $this->pengeluaranBarangId,
                'approvedBy' => $this->approvedBy,
                'status' => $this->status,
                'fromDepartment'=> $this->fromDepartment,
                'reason' => $this->reason
            ]);
    }
}
