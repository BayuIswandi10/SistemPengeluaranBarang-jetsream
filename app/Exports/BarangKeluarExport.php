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

        // Tambahkan baris kosong dan jumlah total
        $result[] = array_fill(0, 14, ''); // baris kosong
        $result[] = [
            'TOTAL DATA', '', '', '', '', '', '', '', '', '', '', '', '', $this->totalCount
        ];

        return $result;
    }

    private function translateApprovalStatus($status, $kategori)
    {
        return match ($status) {
            'Level 1' => 'Mengajukan',
            'Level 2' => 'PIC/Ka.Sie Sudah Menyetujui',
            'Level 3' => 'Ka.Dept Ybs Sudah Menyutujui',
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastColumn = 'N';
                $lastRow = $sheet->getHighestRow();

                // Header styling
                $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F81BD']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']]],
                ]);

                // Table styling
                $sheet->getStyle("A2:{$lastColumn}{$lastRow}")->applyFromArray([
                    'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']]],
                ]);

                // Total row styling
                $sheet->getStyle("A{$lastRow}:{$lastColumn}{$lastRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9D9D9']],
                ]);

                // Data Rekap
                $pengeluaran = PengeluaranBarang::all();
                $scrap7Hari = $pengeluaran->where('kategori_pengeluaran', 1)->where('created_date', '>=', now()->subDays(7))->count();
                $scrap1Bulan = $pengeluaran->where('kategori_pengeluaran', 1)->where('created_date', '>=', now()->subMonth())->count();
                $scrap1Tahun = $pengeluaran->where('kategori_pengeluaran', 1)->where('created_date', '>=', now()->subYear())->count();

                $nonScrap7Hari = $pengeluaran->where('kategori_pengeluaran', 0)->where('created_date', '>=', now()->subDays(7))->count();
                $nonScrap1Bulan = $pengeluaran->where('kategori_pengeluaran', 0)->where('created_date', '>=', now()->subMonth())->count();
                $nonScrap1Tahun = $pengeluaran->where('kategori_pengeluaran', 0)->where('created_date', '>=', now()->subYear())->count();

                $startColumn = 'P'; // kolom tambahan di kanan
                $sheet->setCellValue("{$startColumn}1", 'Kategori');
                $sheet->setCellValue("Q1", '7 Hari Terakhir');
                $sheet->setCellValue("R1", '1 Bulan Terakhir');
                $sheet->setCellValue("S1", '1 Tahun Terakhir');

                // Scrap Row
                $sheet->setCellValue("{$startColumn}2", 'Scrap');
                $sheet->setCellValue("Q2", $scrap7Hari);
                $sheet->setCellValue("R2", $scrap1Bulan);
                $sheet->setCellValue("S2", $scrap1Tahun);

                // Non Scrap Row
                $sheet->setCellValue("{$startColumn}4", 'Non Scrap');
                $sheet->setCellValue("Q4", $nonScrap7Hari);
                $sheet->setCellValue("R4", $nonScrap1Bulan);
                $sheet->setCellValue("S4", $nonScrap1Tahun);

                // Styling
                $rekapRange = ["{$startColumn}1:S2", "{$startColumn}4:S4"];
                foreach ($rekapRange as $range) {
                    $sheet->getStyle($range)->applyFromArray([
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
                    $sheet->getStyle(explode(':', $range)[0])->applyFromArray([
                        'font' => ['bold' => true],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'BDD7EE'],
                        ],
                    ]);
                }
            }];
        }
    }


