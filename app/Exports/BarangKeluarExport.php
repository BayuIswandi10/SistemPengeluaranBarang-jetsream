<?php

namespace App\Exports;

use App\Models\PengeluaranBarang;
use App\Models\ApprovalBarangKeluar;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BarangKeluarExport implements FromArray, WithHeadings, ShouldAutoSize
{
    private $totalCount = 0;

    public function array(): array
    {
        $result = [];
        $user = Auth::user();
        $query = PengeluaranBarang::query();

        if ($user->level === 'Staff' && $user->departemen === 'FIN') {
            $pengeluaranBarangs = $query->get();
        } elseif ($user->level === 'Ka.Sie') {
            $pengeluaranBarangs = $query->whereHas('user', function ($query) use ($user) {
                $query->where('departemen', $user->departemen);
            })->get();
        } elseif (in_array($user->level, ['Ka.Dept', 'Security', 'Super Admin'])) {
            $pengeluaranBarangs = $query->get();
        } else {
            $pengeluaranBarangs = collect();
        }

        $this->totalCount = $pengeluaranBarangs->count();

        foreach ($pengeluaranBarangs as $pengeluaran) {
            $baseRow = [
                $pengeluaran->pengeluaran_barang_id,
                '', // Barang
                '', // Approval
                $pengeluaran->kategori_pengeluaran == 1 ? 'Scrap' : 'Non Scrap',
                $pengeluaran->pembawa_scrap ?? '-',
                $pengeluaran->created_by ?? '-',
                Carbon::parse($pengeluaran->created_date)->format('d-m-Y H:i'),
                $pengeluaran->lokasi_barang_keluar ?? '-',
                $pengeluaran->tujuan_pengeluaran_barang ?? '-',
                $pengeluaran->jenis_kendaraan ?? '-',
                $pengeluaran->no_polisi ?? '-',
                $pengeluaran->status ?? '-',
                $pengeluaran->updated_by ?? '-',
                Carbon::parse($pengeluaran->updated_date)->format('d-m-Y H:i'),
            ];

            $barangs = $pengeluaran->barangKeluar;
            $approvals = ApprovalBarangKeluar::with('user')
                ->where('pengeluaran_barang_id', $pengeluaran->pengeluaran_barang_id)
                ->get()
                ->map(function ($approval) use ($pengeluaran) {
                    return ($approval->user->name ?? 'Tidak Diketahui') . ' (' .
                        $this->translateApprovalStatus($approval->status_approval ?? '-', $pengeluaran->kategori_pengeluaran) . ')';
                });

            $max = max($barangs->count(), $approvals->count());

            for ($i = 0; $i < $max; $i++) {
                $row = $baseRow;
                $row[1] = $barangs[$i]->nama_barang ?? '';
                $row[2] = $approvals[$i] ?? '';
                $result[] = $row;
            }
        }

        return $result;
    }

    private function translateApprovalStatus($status, $kategori)
    {
        return match ($status) {
            'Level 1' => 'Mengajukan',
            'Level 2' => 'PIC/Ka.Sie Sudah Menyetujui',
            'Level 3' => 'Ka.Dept Ybs Sudah Menyetujui',
            'Level 4' => 'Ka Dept GA Sudah Menyetujui',
            'Level 5' => 'Finance Sudah Menyetujui',
            'Level 6' => 'Security Sudah Menyetujui',
            'Level 0' => 'Ditolak',
            default => '-',
        };
    }

    public function headings(): array
    {
        return [
            'No Surat Pengeluaran Barang',
            'Barang Keluar',
            'Approval',
            'Kategori Pengeluaran',
            'Pembawa Scrap',
            'Dibuat Oleh',
            'Tanggal Dibuat',
            'Lokasi Barang Keluar',
            'Tujuan Pengeluaran',
            'Jenis Kendaraan',
            'Nomor Polisi',
            'Status',
            'Diperbarui Oleh',
            'Tanggal Diperbarui',
        ];
    }
}
