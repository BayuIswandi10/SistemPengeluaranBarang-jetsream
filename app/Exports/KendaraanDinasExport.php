<?php

namespace App\Exports;

use App\Models\SuratKendaraanDinas;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KendaraanDinasExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        $data = [];
        $no = 1;

        $surats = SuratKendaraanDinas::with([
            'suratDetail.kendaraan',
            'pencatatanKendaraanDinas.user',
            'approval.user',
        ])->get();

        foreach ($surats as $surat) {
            $noSurat = $surat->surat_kendaraan_dinas_id ?? '-';

            $tujuan = collect([
                $surat->tujuan_penggunaan_1,
                $surat->tujuan_penggunaan_2,
                $surat->tujuan_penggunaan_3
            ])->filter()->implode(', ') ?: '-';

            // Riwayat persetujuan digabung menjadi satu kolom
            $historisPersetujuan = $surat->approval->map(function ($item) {
                $nama = $item->user->name ?? 'Tidak Diketahui';
                $status = $this->translateStatus($item->status_approval);
                return "$nama ($status)";
            })->implode(', ') ?: '-';

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
                    $historisPersetujuan,
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
            'Riwayat Persetujuan',
        ];
    }

    private function translateStatus($status)
    {
        return match (strtoupper($status)) {
            'LEVEL 0' => 'Ditolak',
            'LEVEL 1' => 'Mengajukan',
            'LEVEL 2' => 'Ka.Dept Ybs Menyetujui',
            'LEVEL 3' => 'PIC/Ka.Sie General Service Menyetujui',
            'LEVEL 4' => 'Security Menyetujui',
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
