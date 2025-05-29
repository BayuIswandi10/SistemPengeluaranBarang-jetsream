<?php

namespace App\Exports;

use App\Models\SuratKendaraanDinas;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KendaraanDinasExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function array(): array
    {
        $query = SuratKendaraanDinas::with([
            'suratDetail.kendaraan',
            'pencatatanKendaraanDinas.user',
            'approval.user',
        ]);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_date', [$this->startDate, $this->endDate]);
        }

        $surats = $query->get();

        $data = [];
        $no = 1;

        foreach ($surats as $surat) {
            $noSurat = $surat->surat_kendaraan_dinas_id ?? '-';

            $tujuan = collect([
                $surat->tujuan_penggunaan_1,
                $surat->tujuan_penggunaan_2,
                $surat->tujuan_penggunaan_3
            ])->filter()->implode(', ') ?: '-';

            // Ambil kendaraan pertama yang tersedia (jika ada)
            $kendaraan = $surat->suratDetail->pluck('kendaraan')->filter()->first();
            $jenisKendaraan = $this->mapJenisKendaraan($kendaraan->jenis_kendaraan ?? null);
            $informasiKendaraan = $kendaraan
                ? ($kendaraan->merk_kendaraan ?? '-') . ' - ' . ($kendaraan->nomor_kendaraan ?? '-')
                : '-';
            $kapasitasKendaraan = $kendaraan->kapasitas_kendaraan ?? '-';

            $statusSurat = $this->translateStatus($surat->status ?? '-');

            // Loop untuk setiap peserta
            foreach ($surat->pencatatanKendaraanDinas as $peserta) {
                $user = $peserta->user;
                $nama = $user->name ?? $peserta->nrp_karyawan ?? '-';
                $departemen = $user->departemen ?? '-';
                $pesertaText = "$nama - $departemen";

                $data[] = [
                    $no++,
                    $noSurat,
                    $tujuan,
                    $jenisKendaraan,
                    $statusSurat,
                    $pesertaText,
                    $informasiKendaraan,
                    $kapasitasKendaraan,
                ];
            }
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'NO',
            'No Surat Pengajuan Kendaraan Dinas',
            'Tujuan Penggunaan',
            'Jenis Kendaraan',
            'Status Pengajuan',
            'Peserta (Nama - Departemen)',
            'Informasi Kendaraan',
            'Kapasitas Kendaraan',
        ];
    }

    private function translateStatus($status)
    {
        return match (strtoupper($status)) {
            'LEVEL 0' => 'Ditolak',
            'LEVEL 1' => 'Proses',
            'LEVEL 2' => 'Proses',
            'LEVEL 3' => 'Proses',
            'LEVEL 4' => 'Lengkap',
            default => ucfirst($status),
        };
    }

    private function mapJenisKendaraan($kode)
    {
        return match ((int) $kode) {
            1 => 'KANTOR',
            2 => 'PRIBADI',
            3 => 'TAXI',
            default => '-',
        };
    }
}
