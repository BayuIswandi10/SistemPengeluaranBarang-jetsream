<?php

namespace App\Mail;
use Illuminate\Mail\Mailable;

class ApprovalNotification extends Mailable
{
    public $pengeluaranBarangId;
    public $approvedBy;
    public $status;
    public $fromDepartment;

    public function __construct($pengeluaranBarangId, $approvedBy, $status, $fromDepartment)
    {
        $this->pengeluaranBarangId = $pengeluaranBarangId;
        $this->approvedBy = $approvedBy;
        $this->status = $status;
        $this->fromDepartment = $fromDepartment;
    }

    public function build()
    {
        return $this->subject('Approval Notification')
            ->view('emails.approvalNotification')
            ->with([
                'pengeluaranBarangId' => $this->pengeluaranBarangId,
                'approvedBy' => $this->approvedBy,
                'status' => $this->status,
                'fromDepartment'=> $this->fromDepartment
            ]);
    }
}
