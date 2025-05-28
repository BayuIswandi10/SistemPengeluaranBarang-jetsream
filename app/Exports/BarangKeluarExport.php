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
    private $start;
    private $end;

    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function array(): array
    {
        $result = [];
        $user = Auth::user();
        $query = PengeluaranBarang::query();

        // Filter tanggal jika tersedia
        if ($this->start && $this->end) {
            $query->whereBetween('created_date', [$this->start . ' 00:00:00', $this->end . ' 23:59:59']);
        }

        $pengeluaranBarangs = $query->get();

        $this->totalCount = $pengeluaranBarangs->count();

       foreach ($pengeluaranBarangs as $pengeluaran) {
            $barangs = $pengeluaran->barangKeluar;

            $approvals = ApprovalBarangKeluar::where('pengeluaran_barang_id', $pengeluaran->pengeluaran_barang_id)->get();

            $approvalStatus = '-';
            $kategori = $pengeluaran->kategori_pengeluaran;

            $hasRejected = $approvals->contains(function ($a) {
                return $a->status_approval === 'Level 0';
            });

            if ($hasRejected) {
                $approvalStatus = 'Ditolak';
            } else {
                // Hitung jumlah approval valid (tidak termasuk null, '-' atau 'Level 0')
                $validCount = $approvals->whereNotIn('status_approval', [null, '-', 'Level 0'])->count();

                if ($kategori == 1) { // Scrap
                    $approvalStatus = $validCount >= 5 ? 'Lengkap' : 'Proses';
                } else { // Non Scrap
                    $approvalStatus = $validCount >= 4 ? 'Lengkap' : 'Proses';
                }
            }

            $baseRow = [
                $pengeluaran->pengeluaran_barang_id,
                '', // Barang
                $approvalStatus, // Ganti kolom approval jadi ringkasan saja
                $kategori == 1 ? 'Scrap' : 'Non Scrap',
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

            if ($barangs->isEmpty()) {
                $result[] = $baseRow;
            } else {
                foreach ($barangs as $barang) {
                    $row = $baseRow;
                    $row[1] = $barang->nama_barang ?? '';
                    $result[] = $row;
                }
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
