<?php

namespace App\Mail;
use Illuminate\Mail\Mailable;

class ApprovalDinasNotification extends Mailable
{
    public $suratDinasId;
    public $approvedBy;
    public $status;
    public $fromDepartment;

    public function __construct($suratDinasId, $approvedBy, $status, $fromDepartment)
    {
        $this->suratDinasId = $suratDinasId;
        $this->approvedBy = $approvedBy;
        $this->status = $status;
        $this->fromDepartment = $fromDepartment;
    }

    public function build()
    {
        return $this->subject('Approval Notification')
            ->view('emails.approvalDinasNotification')
            ->with([
                'suratDinasId' => $this->suratDinasId,
                'approvedBy' => $this->approvedBy,
                'status' => $this->status,
                'fromDepartment'=> $this->fromDepartment
            ]);
    }
}
