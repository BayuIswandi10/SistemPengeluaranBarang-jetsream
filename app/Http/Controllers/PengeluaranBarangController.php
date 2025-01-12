<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengeluaranBarang;
use Illuminate\Support\Str;
use App\Models\BarangKeluar;

use Illuminate\Support\Facades\DB;

class PengeluaranBarangController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('livewire.form-pengeluaran');
    }



    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Insert ke tabel pengeluaran_barang
            $pengeluaranBarang = PengeluaranBarang::create([
                'pengeluaran_barang_id' => Str::uuid()->toString(),
                'created_by' => $request->input('created_by'),
                'tujuan_pengeluaran_barang' => $request->input('tujuan_pengeluaran_barang'),
                'jenis_kendaraan' => $request->input('jenis_kendaraan'),
            ]);

            // Iterasi barang dan buat entry pada barang_keluar
            foreach ($request->input('barang_ids') as $index => $barangId) {
                // Insert ke tabel barang_keluar
                $barangKeluar = BarangKeluar::create([
                    'nama_barang' => $barangId,
                    'jumlah_barang' => $request->input('jumlah')[$index],
                    'satuan_barang' => $request->input('satuan')[$index],
                    'keterangan_barang' => $request->input('keterangan')[$index],
                ]);

                // Hubungkan dengan tabel pivot
                $pengeluaranBarang->barangKeluar()->attach($barangKeluar->barang_keluar_id, [
                    'detail_pengeluaran_id' => Str::uuid()->toString(),
                ]);
            }

            DB::commit();

            return redirect()->route('pengeluaran_barang.index')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
