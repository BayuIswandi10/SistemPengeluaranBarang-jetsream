<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\PengeluaranBarang;
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

    public function approveSecurity(Request $request, Approval $approval)
    {
        // Validasi data yang masuk
        $request->validate([
            'no_polisi' => 'required|string|max:20',
        ]);

        // Update no_polisi pada pengeluaran_barang terkait
        $pengeluaranBarang = PengeluaranBarang::where('pengeluaran_barang_id', $approval->pengeluaran_barang_id)->first();
        if ($pengeluaranBarang) {
            $pengeluaranBarang->no_polisi = $request->no_polisi;
            $pengeluaranBarang->save();
        }

        // Update status_approval menjadi Level 5
        $approval->status_approval = 'Level 5';
        $approval->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Approval updated successfully!');
    }
}
