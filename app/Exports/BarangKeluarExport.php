<?php

namespace App\Exports;

use App\Models\PengeluaranBarang;
use App\Models\ApprovalBarangKeluar;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BarangKeluarExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
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

        foreach ($pengeluaranBarangs as $pengeluaran) {
            $result[] = [
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

            foreach ($pengeluaran->barangKeluar as $barang) {
                $result[] = [
                    '',
                    $barang->nama_barang ?? '-',
                    '',
                    '', '', '', '', '', '', '', '', '', '', ''
                ];
            }

            $approvals = ApprovalBarangKeluar::with('user')
                ->where('pengeluaran_barang_id', $pengeluaran->pengeluaran_barang_id)
                ->get();

            foreach ($approvals as $approval) {
                $translatedStatus = $this->translateApprovalStatus($approval->status_approval ?? '-', $pengeluaran->kategori_pengeluaran);
                $result[] = [
                    '',
                    '',
                    ($approval->user->name ?? 'Tidak Diketahui') . ' (' . $translatedStatus . ')',
                    '', '', '', '', '', '', '', '', '', '', ''
                ];
            }                
        }

        return $result;
    }

    private function translateApprovalStatus($status, $kategori)
    {
        switch ($status) {
            case 'Level 1':
                return 'Mengajukan';
            case 'Level 2':
                return 'PIC/Ka.Sie Sudah Menyetujui';
            case 'Level 3':
                return 'Ka.Dept Ybs Sudah Menyutujui';
            case 'Level 4':
                return 'Ka Dept GA Sudah Menyetujui';
            case 'Level 5':
                return 'Finance Sudah Menyetujui';
            case 'Level 6':
                return 'Security Sudah Menyetujui';
            case 'Level 0':
                return 'Ditolak';
            default:
                return '-';
        }
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastColumn = 'N';
                $lastRow = $sheet->getHighestRow();

                // Style untuk header
                $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4F81BD'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Style seluruh tabel
                $sheet->getStyle("A2:{$lastColumn}{$lastRow}")->applyFromArray([
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_TOP,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Atur tinggi baris otomatis
                for ($i = 1; $i <= $lastRow; $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(-1);
                }
            }
        ];
    }
}
