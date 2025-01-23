<?php

namespace App\Livewire;

use App\Models\PengeluaranBarang;
use Livewire\Component;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class FormSecutity extends Component
{
    // Livewire Component
    // public function render()
    // {
    //     // Ambil data pengeluaran barang beserta approval dan barang terkait
    //     $pengeluaranBarangs = PengeluaranBarang::with(['approval', 'barangKeluar'])->get();
        
    //     // Mengumpulkan semua barang yang ada dalam pengeluaranBarang
    //     $barangDetails = [];
    //     foreach ($pengeluaranBarangs as $pengeluaranBarang) {
    //         foreach ($pengeluaranBarang->barangKeluar as $barang) {
    //             $barangDetails[] = (object) [
    //                 'pengeluaran_barang_id' => $pengeluaranBarang->pengeluaran_barang_id,
    //                 'nama_barang' => $barang->nama_barang,
    //                 'jumlah_barang' => $barang->jumlah_barang,
    //                 'satuan_barang' => $barang->satuan_barang,
    //                 'keterangan_barang' => $barang->keterangan_barang,
    //             ];
    //         }
    //     }

    //     // Kirim data ke view
    //     return view('livewire.form-secutity', compact('pengeluaranBarangs', 'barangDetails'));
    // }


    public function render()
    {
        $pengeluaranBarangs = PengeluaranBarang::with(['approval', 'barangKeluar'])->get();
        $barangDetails = [];
        
        foreach ($pengeluaranBarangs as $pengeluaranBarang) {
            foreach ($pengeluaranBarang->barangKeluar as $barang) {
                $barangDetails[] = (object) [
                    'pengeluaran_barang_id' => $pengeluaranBarang->pengeluaran_barang_id,
                    'nama_barang' => $barang->nama_barang,
                    'jumlah_barang' => $barang->jumlah_barang,
                    'satuan_barang' => $barang->satuan_barang,
                    'keterangan_barang' => $barang->keterangan_barang,
                ];
            }
        }

        // Generate QR Code untuk setiap pengeluaran_barang_id
        $qrCodes = [];
        foreach ($pengeluaranBarangs as $pengeluaranBarang) {
            $renderer = new ImageRenderer(
                new RendererStyle(140), // Ukuran QR Code
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $qrCodes[$pengeluaranBarang->pengeluaran_barang_id] = $writer->writeString($pengeluaranBarang->pengeluaran_barang_id);
        }

        return view('livewire.form-secutity', compact('pengeluaranBarangs', 'barangDetails', 'qrCodes'));
    }
}
