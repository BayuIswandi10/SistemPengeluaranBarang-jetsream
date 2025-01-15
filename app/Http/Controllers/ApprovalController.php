<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function approve(Approval $approval)
    {
        // Update status approval level by level
        $approval->updateApprovalStatus();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Status approval updated!');
    }
}
