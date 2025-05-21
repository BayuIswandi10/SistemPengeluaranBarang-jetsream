<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengeluaranBarang;
use App\Models\BarangKeluar;
use App\Models\ApprovalBarangKeluar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalNotification;
use App\Exports\BarangKeluarExport;
use Maatwebsite\Excel\Facades\Excel;
use Endroid\QrCode\QrCode as QrCodeQrCode;

class PengeluaranBarangController extends Controller
{
    public function index()
    {
        $pengeluaranBarangs = PengeluaranBarang::with('approval')->get(); 
        return view('livewire.form-pengeluaran', compact('pengeluaranBarangs'));
    }

    public function export(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        return Excel::download(new BarangKeluarExport($start, $end), 'data_barang_keluar.xlsx');
    }

    public function getDataRange(Request $request){
        $start = $request->query('start');
        $end = $request->query('end');
    
        $pengeluaranBarangs = PengeluaranBarang::when($start && $end, function($query) use ($start, $end) {
            return $query->whereBetween('created_date', [$start, $end]);
        })
        ->get();
    
        return response()->json(['barang_keluar' => $pengeluaranBarangs]);
    }
    

    public function getDataLevel4()
    {
        $pengeluaranBarangs = PengeluaranBarang::where(function ($query) {
            $query->where('kategori_pengeluaran', 1)->where('status', 'Level 5') // Jika kategori 1, harus Level 5
                  ->orWhere('kategori_pengeluaran', 0)->where('status', 'Level 4'); // Jika kategori 0, cukup Level 4
        })->get();
    
        return response()->json(['barang_keluar' => $pengeluaranBarangs]);
    }
    

    public function getDetail(Request $request)
    {
        $pengeluaranId = $request->pengeluaran_barang_id;

        // Mengambil data pengeluaran barang beserta barang keluar
        $pengeluaranBarang = PengeluaranBarang::with('barangKeluar')->findOrFail($pengeluaranId);

        // Mengambil informasi tambahan terkait pengeluaran barang (misal: User yang mengeluarkan barang)
        $approvalData = ApprovalBarangKeluar::with('user')
            ->where('pengeluaran_barang_id', $pengeluaranId)
            ->get()
            ->map(function ($approval, $index) {
                return [
                    'no' => $index + 1,
                    'nama' => $approval->user->name ?? 'Tidak Diketahui',
                    'tingkatan' => $approval->user->level ?? 'Tidak Diketahui',
                    'departemen' => $approval->user->departemen ?? 'Tidak Diketahui',
                    'status' => $approval->status_approval,
                ];
            });

        return response()->json([
            'barang_keluar' => $pengeluaranBarang->barangKeluar,
            'informasi_tambahan' => $approvalData,
            'status' => $pengeluaranBarang->status ?? 'Tidak Diketahui',
            'kategori_pengeluaran' => isset($pengeluaranBarang->kategori_pengeluaran) 
                ? (int) $pengeluaranBarang->kategori_pengeluaran 
                : 0, // Default ke Non Scrap
            'no_polisi' => $pengeluaranBarang->no_polisi ?? 'Tidak Ada',
        ], 200);
    }

    public function getDetailNonAuth(Request $request)
    {
        $pengeluaranId = $request->pengeluaran_barang_id;

        // Mengambil data pengeluaran barang beserta barang keluar
        $pengeluaranBarang = PengeluaranBarang::with('barangKeluar')->findOrFail($pengeluaranId);

        // Mengambil informasi tambahan terkait pengeluaran barang (misal: User yang mengeluarkan barang)
        $approvalData = ApprovalBarangKeluar::with('user')
            ->where('pengeluaran_barang_id', $pengeluaranId)
            ->get()
            ->map(function ($approval, $index) {
                return [
                    'no' => $index + 1,
                    'nama' => $approval->user->name ?? 'Tidak Diketahui',
                    'tingkatan' => $approval->user->level ?? 'Tidak Diketahui',
                    'departemen' => $approval->user->departemen ?? 'Tidak Diketahui',
                    'status' => $approval->status_approval,
                ];
            });

        return response()->json([
            'barang_keluar' => $pengeluaranBarang->barangKeluar,
            'informasi_tambahan' => $approvalData,
            'status' => $pengeluaranBarang->status ?? 'Tidak Diketahui',
            'kategori_pengeluaran' => isset($pengeluaranBarang->kategori_pengeluaran) 
                ? (int) $pengeluaranBarang->kategori_pengeluaran 
                : 0, // Default ke Non Scrap
            'no_polisi' => $pengeluaranBarang->no_polisi ?? 'Tidak Ada',
        ], 200);
    }


    private function generateSuratJalan($lokasi, $departemen)
    {
        // Ambil tahun dan bulan saat ini
        $tahun = now()->format('Y');
        $bulanAngka = now()->format('m');
        $bulanRomawi = $this->convertToRoman($bulanAngka);

        // Hitung nomor urut surat jalan untuk bulan dan tahun yang sama
        $lastNumber = DB::table('tb_pencatatan_pengeluaran_barang')
            ->whereYear('created_date', $tahun)
            ->whereMonth('created_date', $bulanAngka)
            ->count();

        $noSurat = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        // Gabungkan menjadi format surat jalan
        return "{$noSurat}/{$departemen}/{$lokasi}/{$bulanRomawi}/{$tahun}";
    }

    private function convertToRoman($month)
    {
        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        return $romans[intval($month)];
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'created_by' => 'required',
            'kategori_pengeluaran' => 'required|in:0,1',
            'pembawa_scrap' => 'nullable|string',
            'tujuan_pengeluaran_barang' => 'required',
            'jenis_kendaraan' => 'required',
            'no_polisi' => [
                'required',
                'regex:/^[A-Z]{1,2} \d{1,4} [A-Z]{1,3}$/'
            ],
            'lokasi_barang_keluar' => 'required',
            'barang_ids' => 'required|array',
            'barang_ids.*' => 'required',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|numeric|min:1',
            'satuan' => 'required|array',
            'satuan.*' => 'required',
            'keterangan' => 'nullable|array',
        ], [
            'created_by.required' => 'NRP wajib diisi.',
            'kategori_pengeluaran.required' => 'Kategori pengeluaran wajib dipilih.',
            'kategori_pengeluaran.in' => 'Kategori pengeluaran tidak valid.',
            'pembawa_scrap.string' => 'Pembawa scrap harus berupa teks.',
            'tujuan_pengeluaran_barang.required' => 'Tujuan pengeluaran barang wajib diisi.',
            'jenis_kendaraan.required' => 'Jenis kendaraan wajib dipilih.',
            'no_polisi.required' => 'No polisi wajib diisi.',
            'no_polisi.regex' => 'Format no polisi tidak valid. Contoh: B 1234 ABC',
            'lokasi_barang_keluar.required' => 'Lokasi barang keluar wajib diisi.',
            'barang_ids.required' => 'Minimal satu barang harus ditambahkan.',
            'barang_ids.*.required' => 'Nama barang tidak boleh kosong.',
            'jumlah.required' => 'Jumlah barang wajib diisi.',
            'jumlah.*.required' => 'Jumlah barang tidak boleh kosong.',
            'jumlah.*.numeric' => 'Jumlah harus berupa angka.',
            'jumlah.*.min' => 'Jumlah minimal 1.',
            'satuan.required' => 'Satuan barang wajib diisi.',
            'satuan.*.required' => 'Satuan tidak boleh kosong.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }

        $lokasiBarangKeluar = strtoupper($request->input('lokasi_barang_keluar'));
        $tujuanPengeluaran = strtoupper($request->input('tujuan_pengeluaran_barang'));
    
        if ($lokasiBarangKeluar === $tujuanPengeluaran) {
            return redirect()->back()->with('error', 'Lokasi barang keluar dan tujuan pengeluaran barang tidak boleh sama!')->withInput();
        }

        $nrpKaryawan = $request->input('created_by');
        $user = User::where('nrp_karyawan', $nrpKaryawan)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'NRP tidak ditemukan!')->withInput();
        }
    
        DB::beginTransaction();
    
        try {

    
            $departemen = $user->singkatan;
            $pengeluaranBarangId = $this->generateSuratJalan($request->input('lokasi_barang_keluar'), $departemen);
    
            // Insert ke tabel pengeluaran_barang
            $pengeluaranBarang = PengeluaranBarang::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'kategori_pengeluaran' => $request->kategori_pengeluaran,
                'pembawa_scrap' => $request->input('pembawa_scrap'),
                'tujuan_pengeluaran_barang' => $request->input('tujuan_pengeluaran_barang'),
                'jenis_kendaraan' => $request->input('jenis_kendaraan'),
                'no_polisi' => $request->input('no_polisi'),
                'lokasi_barang_keluar' => $request->input('lokasi_barang_keluar'),
                'status' => 'Level 1',
            ]);
    
            foreach ($request->input('barang_ids') as $index => $barangId) {
                $barangKeluar = BarangKeluar::create([
                    'nama_barang' => $barangId,
                    'jumlah_barang' => $request->input('jumlah')[$index],
                    'satuan_barang' => $request->input('satuan')[$index],
                    'keterangan_barang' => $request->input('keterangan')[$index],
                    'pengeluaran_barang_id' => $pengeluaranBarang->pengeluaran_barang_id, // Fix error
                ]);
            }
    
            // Insert ke tabel tb_approval_barang_keluar
            ApprovalBarangKeluar::create([
                'pengeluaran_barang_id' => $pengeluaranBarangId,
                'created_by' => $nrpKaryawan,
                'created_date' => now(),
                'status_approval' => 'Level 1',
            ]);

            // Kirim email ke pengaju
            $statusText = $this->getStatusText('Level 1');
            $userDepartment = $this->getDepartmentName($user->level);
            $this->sendApprovalEmail($user->email, $pengeluaranBarangId, $user->name, $statusText, $userDepartment);

            // Cari kepala seksi dari departemen pengaju
            $kepalaSeksi = User::where('departemen', $user->departemen) // pastikan ini kolom yang sesuai
                ->where('level', 'Ka.Sie')
                ->first();

            if ($kepalaSeksi) {
                $this->sendApprovalEmail($kepalaSeksi->email, $pengeluaranBarangId, $user->name, $statusText, $userDepartment);
            }
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Pengajuan Pengeluaran Barang berhasil disimpan dengan Nomor: ' . $pengeluaranBarangId)
            ->with('clear_local_storage', true);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal Menyimpan Pengajuan Pengeluaran Barang! ' . $e->getMessage());
        }
    }
    
    public function generateQrCodeBarang(Request $request)
    {
        $pengeluaranId = $request->pengeluaran_barang_id;
        $pengeluaranBarang = PengeluaranBarang::with('barangKeluar')->findOrFail($pengeluaranId);

        // Generate QR Code menggunakan BaconQrCode
        $renderer = new ImageRenderer(
            new RendererStyle(140), // Ukuran QR Code
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($pengeluaranBarang->pengeluaran_barang_id);

        return response()->json([
            'pengeluaran_barang_id'      => $pengeluaranBarang->pengeluaran_barang_id,
            'jenis_kendaraan'            => $pengeluaranBarang->jenis_kendaraan,
            'no_polisi'                  => $pengeluaranBarang->no_polisi,
            'status'                  => $pengeluaranBarang->status,
            'lokasi_barang_keluar'       => $pengeluaranBarang->lokasi_barang_keluar,
            'tujuan_pengeluaran_barang'  => $pengeluaranBarang->tujuan_pengeluaran_barang,
            'barangKeluar'               => $pengeluaranBarang->barangKeluar,
            'qr_code_barang'                    => $qrCode
        ]);
    }

    public function edit(Request $request)
    {
        $pengeluaranId = $request->pengeluaran_barang_id;
        $pengeluaranBarang = PengeluaranBarang::with('barangKeluar')->findOrFail($pengeluaranId);

        return response()->json([
            'pengeluaran_barang_id'      => $pengeluaranBarang->pengeluaran_barang_id,
            'jenis_kendaraan'            => $pengeluaranBarang->jenis_kendaraan,
            'no_polisi'                  => $pengeluaranBarang->no_polisi,
            'status'                  => $pengeluaranBarang->status,
            'lokasi_barang_keluar'       => $pengeluaranBarang->lokasi_barang_keluar,
            'tujuan_pengeluaran_barang'  => $pengeluaranBarang->tujuan_pengeluaran_barang,
            'barangKeluar'               => $pengeluaranBarang->barangKeluar,
        ]);
    }

    public function update(Request $request) 
    {
        $data = $request->validate([
            'pengeluaran_barang_id'    => 'required',
            'jenis_kendaraan'          => 'required',
            'lokasi_barang_keluar'     => 'required',
            'tujuan_pengeluaran_barang'=> 'required',
            'barang_ids'               => 'required|array',
            'barang_ids.*'             => 'nullable|string',
            'nama_barang'              => 'required|array',
            'jumlah'                   => 'required|array',
            'satuan'                   => 'required|array',
            'keterangan'               => 'required|array',
        ]);
    
        DB::beginTransaction();
    
        $user = Auth::user();
        $nrpKaryawan = $user->nrp_karyawan;

        try {
            // Cari data pengeluaran barang berdasarkan ID
            $pengeluaranBarang = PengeluaranBarang::findOrFail($data['pengeluaran_barang_id']);
    
            // Update data utama di tabel tb_pencatatan_pengeluaran_barang
            $pengeluaranBarang->update([
                'jenis_kendaraan'       => $data['jenis_kendaraan'],
                'lokasi_barang_keluar'  => $data['lokasi_barang_keluar'],
                'tujuan_pengeluaran_barang' => $data['tujuan_pengeluaran_barang'],
                'updated_by'            => $nrpKaryawan, 
                'updated_date'          => now(),
            ]);
    
            // Ambil semua barang_keluar_id yang terkait dengan pengeluaran_barang_id ini dari tabel tb_detail_barang_keluar
            $existingBarangIds = DB::table('tb_detail_barang_keluar')
                ->where('pengeluaran_barang_id', $pengeluaranBarang->pengeluaran_barang_id)
                ->pluck('barang_keluar_id')
                ->toArray();
    
            // Barang yang tetap ada (dari form)
            $barangIdsFromForm = array_filter($data['barang_ids']);
    
            // Barang yang perlu dihapus
            $barangIdsToDelete = array_diff($existingBarangIds, $barangIdsFromForm);
    
            // Hapus barang dari database jika ada id yang tidak dipertahankan
            if (!empty($barangIdsToDelete)) {
                BarangKeluar::whereIn('barang_keluar_id', $barangIdsToDelete)->delete();
            }
    
            // Sinkronisasi dan proses insert/update barang
            foreach ($data['barang_ids'] as $index => $barangId) {
                // Jika barang ID kosong, buat record baru
                if (empty($barangId)) {
                    BarangKeluar::create([
                        // Jangan memasukkan 'barang_keluar_id' karena auto-increment
                        'pengeluaran_barang_id' => $pengeluaranBarang->pengeluaran_barang_id,
                        'nama_barang'           => $data['nama_barang'][$index],
                        'jumlah_barang'         => $data['jumlah'][$index],
                        'satuan_barang'         => $data['satuan'][$index],
                        'keterangan_barang'     => $data['keterangan'][$index],
                    ]);
                } else {
                    // Update barang yang sudah ada
                    $barang = BarangKeluar::findOrFail($barangId);
                    $barang->update([
                        'nama_barang'       => $data['nama_barang'][$index],
                        'jumlah_barang'     => $data['jumlah'][$index],
                        'satuan_barang'     => $data['satuan'][$index],
                        'keterangan_barang' => $data['keterangan'][$index],
                    ]);
                }
            }
    
            DB::commit();
    
            return redirect()->route('form')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function sendApprovalEmail($userEmail, $pengeluaranBarangId, $approvedBy, $status, $fromDepartment)
    {
        Mail::to($userEmail)->send(new ApprovalNotification($pengeluaranBarangId, $approvedBy, $status, $fromDepartment));
    }

    private function getStatusText($level)
    {
        $statusMap = [
            'Level 1' => 'Telah Mengajukan Sebagai Yang Membawa',
            'Level 2' => 'Telah Disetujui Sebagai Yang Mengeluarkan',
            'Level 3' => 'Telah Menyetujui dari Ka.Dept Ybs',
            'Level 4' => 'Telah Mengetahui dari Ka.Dept GA',
            'Level 5' => 'Telah Menerima dari Finance',
            'Level 6' => 'Telah Memeriksa oleh Security',
        ];

        return $statusMap[$level] ?? 'Ditolak';
    }

    private function getDepartmentName($departmentId)
    {
        $statusDepartmentMap = [
            'Staff' => 'Staff',
            'Ka.Sie' => 'PIC/Ka.Sie',
            'Ka.Dept' => 'Ka.Dept',
            'Security' => 'Security',
        ];

        return $statusDepartmentMap[$departmentId] ?? 'Tidak Diketahui';
    }
}
