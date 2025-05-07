<?php

namespace App\Exports;

use App\Models\PengeluaranBarang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BarangKeluarExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    public function collection()
    {
        return PengeluaranBarang::all();
    }

    public function map($row): array
    {
        return [
            $row->pengeluaran_barang_id,
            $row->kategori_pengeluaran == 1 ? 'Scrap' : 'Non Scrap',
            $row->pembawa_scrap,
            $row->created_by,
            $row->created_date,
            $row->lokasi_barang_keluar,
            $row->tujuan_pengeluaran_barang,
            $row->jenis_kendaraan,
            $row->no_polisi,
            $row->status,
            $row->updated_by,
            $row->updated_date,
        ];
    }

    public function headings(): array
    {
        return [
            'No Surat Pengeluaran Barang',
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

                // Hitung kolom terakhir (L = 12 kolom)
                $lastColumn = 'L';
                $lastRow = $sheet->getHighestRow();

                // Apply autofilter
                $sheet->setAutoFilter("A1:{$lastColumn}1");

                // Apply table style (dengan border dan fill di header)
                $headerStyle = [
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFEEEEEE']
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ];

                $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray($headerStyle);
                $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            }
        ];
    }
}
