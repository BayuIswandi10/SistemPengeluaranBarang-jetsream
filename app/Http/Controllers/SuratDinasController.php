<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratKendaraanDinas;
use App\Models\User;
use App\Models\PencatatanKendaraanDinas;
use Illuminate\Support\Facades\DB;
use App\Models\ApprovalKendaraanDinas;
use Illuminate\Support\Facades\Validator;
use App\Models\KendaraanDinas;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratKendaraanDinasDetail;
use App\Mail\ApprovalDinasNotification;
use App\Mail\ApprovalNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SuratDinasController extends Controller
{
    /**
     * Generate Surat Dinas ID
     */

    public function getUserDetails(Request $request)
    {
        $user = User::where('nrp_karyawan', $request->nrp_karyawan)->first();
    
        if ($user) {
            return response()->json([
                'success' => true,
                'data' => [
                    'name' => $user->name,
                    'departemen' => $user->departemen
                ]
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    private function generateSuratDinasID($jenisKendaraan, $tanggalPenggunaan)
    {
        // Mapping jenis kendaraan
        $jenisKendaraanMap = [
            '1' => 'KN', // KANTOR
            '2' => 'PR', // PRIBADI
            '3' => 'TX', // TAXI
        ];

        // Ambil kode kendaraan
        $jenisKendaraanCode = $jenisKendaraanMap[$jenisKendaraan] ?? 'UK';

        // Format tanggal
        $tanggalFormat = date('dmY', strtotime($tanggalPenggunaan));

        // Ambil nomor urut terakhir untuk tanggal tersebut
        $lastSurat = SuratKendaraanDinas::where('surat_kendaraan_dinas_id', 'LIKE', "{$jenisKendaraanCode}/{$tanggalFormat}/%")
                        ->orderBy('surat_kendaraan_dinas_id', 'desc')
                        ->first();

        // Tentukan nomor urut selanjutnya
        $nextNumber = 1;
        if ($lastSurat) {
            $lastNumber = (int) substr($lastSurat->surat_kendaraan_dinas_id, -4);
            $nextNumber = $lastNumber + 1;
        }

        // Format ID
        return sprintf("%s/%s/%04d", $jenisKendaraanCode, $tanggalFormat, $nextNumber);
    }

    public function getDataLevel3()
    {
        $suratKendaraan = SuratKendaraanDinas::where('status', 'Level 3')->get();

        return response()->json([
            'surat_kendaraan_dinas' => $suratKendaraan
        ]);
    }


    /**
     * Store Surat Dinas
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'tujuan_penggunaan_1' => 'required|string|max:35',
            'tujuan_penggunaan_2' => 'nullable|string|max:35',
            'tujuan_penggunaan_3' => 'nullable|string|max:35',
            'tanggal_penggunaan' => 'required|date|after_or_equal:today',
            'jenis_kendaraan' => 'required|in:1,2,3',
            'created_by' => 'required|string',
            'waktu_keluar' => 'required|date_format:H:i',
            'waktu_kembali' => 'required|date_format:H:i|after:waktu_keluar',
            'peserta' => 'nullable|array', // Memastikan peserta dikirim dalam bentuk array
            'peserta.*.nrp_karyawan' => 'required|string', // Validasi setiap peserta harus memiliki nrp_karyawan
        ], [
            'tujuan_penggunaan_1.required' => 'Tujuan penggunaan utama wajib diisi.',
            'tujuan_penggunaan_1.string' => 'Tujuan penggunaan harus berupa teks.',
            'tujuan_penggunaan_1.max' => 'Tujuan penggunaan maksimal 35 karakter.',
            
            'tujuan_penggunaan_2.string' => 'Tujuan penggunaan harus berupa teks.',
            'tujuan_penggunaan_2.max' => 'Tujuan penggunaan maksimal 35 karakter.',
            
            'tujuan_penggunaan_3.string' => 'Tujuan penggunaan harus berupa teks.',
            'tujuan_penggunaan_3.max' => 'Tujuan penggunaan maksimal 35 karakter.',
        
            'tanggal_penggunaan.required' => 'Tanggal penggunaan wajib diisi.',
            'tanggal_penggunaan.date' => 'Format tanggal tidak valid.',
            'tanggal_penggunaan.after_or_equal' => 'Tanggal penggunaan minimal harus hari ini.',
        
            'jenis_kendaraan.required' => 'Jenis kendaraan wajib dipilih.',
            'jenis_kendaraan.in' => 'Jenis kendaraan tidak valid.',
        
            'created_by.required' => 'NRP pembuat wajib diisi.',
            'created_by.string' => 'NRP pembuat harus berupa teks.',
        
            'waktu_keluar.required' => 'Waktu keluar wajib diisi.',
            'waktu_keluar.date_format' => 'Format waktu keluar harus HH:MM (jam:menit).',
        
            'waktu_kembali.required' => 'Waktu kembali wajib diisi.',
            'waktu_kembali.date_format' => 'Format waktu kembali harus HH:MM (jam:menit).',
            'waktu_kembali.after' => 'Waktu kembali harus setelah waktu keluar.',
        
            'peserta.array' => 'Data peserta harus dalam format array.',
            'peserta.*.nrp_karyawan.required' => 'NRP peserta wajib diisi.',
            'peserta.*.nrp_karyawan.string' => 'NRP peserta harus berupa teks.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', implode('<br>', $validator->errors()->all()))
                ->withInput();
        }
        
        $nrpKaryawan = $request->input('created_by');
        $tanggalPenggunaan = $request->input('tanggal_penggunaan');

        $user = User::where('nrp_karyawan', $nrpKaryawan)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'NRP tidak terdaftar!')->withInput();
        }

        // Cek apakah user sudah mengajukan atau sudah diajukan pada tanggal yang sama
        $existingRequest = SuratKendaraanDinas::where('created_by', $nrpKaryawan)
        ->whereDate('tanggal_penggunaan', $tanggalPenggunaan)
        ->exists();

        if ($existingRequest) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan kendaraan dinas pada tanggal ini.')->withInput();
        }

        // Cek apakah peserta yang diajukan sudah memiliki pengajuan di tanggal yang sama
        if ($request->has('peserta') && is_array($request->peserta)) {
            foreach ($request->peserta as $peserta) {
                $existsAsParticipant = PencatatanKendaraanDinas::where('nrp_karyawan', $peserta['nrp_karyawan'])
                    ->whereHas('suratKendaraanDinas', function ($query) use ($tanggalPenggunaan) {
                        $query->whereDate('tanggal_penggunaan', $tanggalPenggunaan);
                    })
                    ->exists();

                if ($existsAsParticipant) {
                    return redirect()->back()->with('error', 'Peserta dengan NRP ' . $peserta['nrp_karyawan'] . ' sudah diajukan di tanggal yang sama.')->withInput();
                }
            }
        }

        DB::beginTransaction();
        try {
    
            // Generate surat_dinas_id
            $suratDinasID = $this->generateSuratDinasID($request->jenis_kendaraan, $request->tanggal_penggunaan);
    
            // Simpan ke database tb_surat_kendaraan_dinas
            $suratDinas = SuratKendaraanDinas::create([
                'surat_kendaraan_dinas_id' => $suratDinasID,
                'tujuan_penggunaan_1' => $request->tujuan_penggunaan_1,
                'tujuan_penggunaan_2' => $request->tujuan_penggunaan_2,
                'tujuan_penggunaan_3' => $request->tujuan_penggunaan_3,
                'tanggal_penggunaan' => $request->tanggal_penggunaan,
                'jenis_kendaraan' => $request->jenis_kendaraan,
                'created_by' => $nrpKaryawan,
                'created_date' => \Carbon\Carbon::now('Asia/Jakarta'),
                'expired_date' => \Carbon\Carbon::now('Asia/Jakarta')->addHours(2),
                'expired_status' => 'Aktif',
                'status' => 'Level 1',
                'waktu_keluar' => $request->waktu_keluar,
                'waktu_kembali' => $request->waktu_kembali,
                'kilometer_awal' => $request->kilometer_awal,
            ]);
    
            // Cek apakah ada peserta yang dikirim
            if ($request->has('peserta') && is_array($request->peserta)) {
                foreach ($request->peserta as $peserta) {
                    $nrp = $peserta['nrp_karyawan'];

                    //Cek NRP peserta di tabel users
                    $userExists = User::where('nrp_karyawan', $nrp)->exists();
        
                    if (!$userExists) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'NRP peserta ' . $nrp . ' tidak terdaftar!')->withInput();
                    }
                    // Pastikan NRP peserta tidak kosong
                    if (!empty($peserta['nrp_karyawan'])) {
                        PencatatanKendaraanDinas::create([
                            'nrp_karyawan' => $peserta['nrp_karyawan'],
                            'surat_kendaraan_dinas_id' => $suratDinas->surat_kendaraan_dinas_id,
                            'update_date' => now(),
                        ]);
                    }
                }
            }

            // Jika jenis kendaraan adalah KANTOR (jenis_kendaraan = 1), hanya simpan ke tb_surat_kendaraan_dinas_detail
            if ($request->jenis_kendaraan == 1 && $request->has('kendaraan_dinas_id')) {
                $kendaraanDinasID = $request->kendaraan_dinas_id;

                // Pastikan kendaraan_dinas_id valid
                $kendaraanDinas = KendaraanDinas::find($kendaraanDinasID);
                if (!$kendaraanDinas) {
                    return redirect()->back()->with('error', 'Kendaraan tidak ditemukan!')->withInput();
                }

                // Simpan ke tabel tb_surat_kendaraan_dinas_detail tanpa perlu menyimpan kendaraan baru
                SuratKendaraanDinasDetail::create([
                    'kendaraan_dinas_id' => $kendaraanDinasID,
                    'surat_kendaraan_dinas_id' => $suratDinas->surat_kendaraan_dinas_id,
                ]);
            } 

            // Jika jenis kendaraan adalah PRIBADI atau TAXI (jenis_kendaraan = 2 atau 3), simpan ke tb_kendaraan_dinas dan tb_surat_kendaraan_dinas_detail
            elseif (in_array($request->jenis_kendaraan, [2, 3]) && $request->has('kendaraan')) {
                foreach ($request->kendaraan as $kendaraan) {
                    // Simpan kendaraan ke tb_kendaraan_dinas
                    $kendaraanBaru = KendaraanDinas::create([
                        'jenis_kendaraan' => $request->jenis_kendaraan,
                        'nomor_kendaraan' => $kendaraan['nomor_kendaraan'],
                        'merk_kendaraan' => $kendaraan['merk_kendaraan'],
                        'kapasitas_kendaraan' => $kendaraan['kapasitas_kendaraan'],
                        'status_kendaraan' => 1,
                        'created_by' => $nrpKaryawan,
                        'created_date' => \Carbon\Carbon::now('Asia/Jakarta'),
                    ]);

                    // Simpan kendaraan yang baru dibuat ke tb_surat_kendaraan_dinas_detail
                    SuratKendaraanDinasDetail::create([
                        'kendaraan_dinas_id' => $kendaraanBaru->kendaraan_dinas_id,
                        'surat_kendaraan_dinas_id' => $suratDinas->surat_kendaraan_dinas_id,
                    ]);
                }
            }


            // Insert ke tabel tb_approval_barang_keluar
            ApprovalKendaraanDinas::create([
                'surat_kendaraan_dinas_id' => $suratDinasID,
                'created_by' => $nrpKaryawan,
                'created_date' => \Carbon\Carbon::now('Asia/Jakarta'),
                'status_approval' => 'Level 1',
            ]);

            // Kirim email ke pengaju
            $statusText = $this->getStatusText('Level 1');
            $userDepartment = $this->getDepartmentName($user->level);
            $this->sendApprovalEmail($user->email, $suratDinasID, $user->name, $statusText, $userDepartment);

            // Cari kepala seksi dari departemen pengaju
            $kepalaDept = User::where('departemen', $user->departemen) // pastikan ini kolom yang sesuai
                ->where('level', 'Ka.Dept')
                ->first();

            if ($kepalaDept) {
                $this->sendApprovalEmail($kepalaDept->email, $suratDinasID, $user->name, $statusText, $userDepartment);
            }
            
    
            DB::commit();
            return redirect()->back()->with('success', 'Surat Dinas berhasil disimpan dengan ID: ' . $suratDinasID)
            ->with('clear_local_storage', true);
    
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menyimpan surat dinas: ' . $e->getMessage());
        }
    }

    public function getDetailSurat(Request $request)
    {
        $suratDinasId = $request->surat_kendaraan_dinas_id;
    
        // Mengambil data surat dinas beserta pencatatan kendaraan dinas
        $suratDinas = SuratKendaraanDinas::with([
            'pencatatanKendaraanDinas.user',
            'suratDetail.kendaraan'
        ])->findOrFail($suratDinasId);

        // Mengambil informasi tambahan terkait persetujuan
        $approvalData = ApprovalKendaraanDinas::with('user')
            ->where('surat_kendaraan_dinas_id', $suratDinasId)
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
    
        // Mapping data user dinas dengan nama & departemen
        $userDinasData = $suratDinas->pencatatanKendaraanDinas->map(function ($user) {
            return [
                'nrp_karyawan' => $user->nrp_karyawan,
                'name' => $user->user->name ?? 'Tidak Diketahui',
                'departemen' => $user->user->departemen ?? 'Tidak Diketahui',
            ];
        });

        // Ambil data kendaraan dinas
        $kendaraanData = $suratDinas->suratDetail->map(function ($detail) {
            return [
                'id_kendaraan' => $detail->kendaraan->kendaraan_dinas_id ?? 'N/A',
                'nomor_kendaraan' => $detail->kendaraan->nomor_kendaraan ?? 'Tidak Diketahui',
                'keterangan' => $detail->kendaraan->merk_kendaraan . ' - ' . $detail->kendaraan->jenis_kendaraan ?? 'Tidak Diketahui',
            ];
        });
    
        return response()->json([
            'userDinas' => $userDinasData,
            'informasi_tambahan' => $approvalData,
            'data_kendaraan' => $kendaraanData,
            'status' => $suratDinas->status ?? 'Tidak Diketahui',
        ], 200);
    }

    public function getDetailSuratNonAuth(Request $request)
    {
        $suratDinasId = $request->surat_kendaraan_dinas_id;
    
        // Mengambil data surat dinas beserta pencatatan kendaraan dinas
        $suratDinas = SuratKendaraanDinas::with([
            'pencatatanKendaraanDinas.user',
            'suratDetail.kendaraan'
        ])->findOrFail($suratDinasId);

        // Mengambil informasi tambahan terkait persetujuan
        $approvalData = ApprovalKendaraanDinas::with('user')
            ->where('surat_kendaraan_dinas_id', $suratDinasId)
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
    
        // Mapping data user dinas dengan nama & departemen
        $userDinasData = $suratDinas->pencatatanKendaraanDinas->map(function ($user) {
            return [
                'nrp_karyawan' => $user->nrp_karyawan,
                'name' => $user->user->name ?? 'Tidak Diketahui',
                'departemen' => $user->user->departemen ?? 'Tidak Diketahui',
            ];
        });

        // Ambil data kendaraan dinas
        $kendaraanData = $suratDinas->suratDetail->map(function ($detail) {
            return [
                'id_kendaraan' => $detail->kendaraan->kendaraan_dinas_id ?? 'N/A',
                'nomor_kendaraan' => $detail->kendaraan->nomor_kendaraan ?? 'Tidak Diketahui',
                'keterangan' => $detail->kendaraan->merk_kendaraan . ' - ' . $detail->kendaraan->jenis_kendaraan ?? 'Tidak Diketahui',
            ];
        });
    
        return response()->json([
            'userDinas' => $userDinasData,
            'informasi_tambahan' => $approvalData,
            'data_kendaraan' => $kendaraanData,
            'status' => $suratDinas->status ?? 'Tidak Diketahui',
        ], 200);
    }
    
    
    public function edit(Request $request)
    {
        try {
            $suratDinasId = $request->surat_kendaraan_dinas_id;
    
            // Ambil data surat dinas dan relasinya
            $suratDinas = SuratKendaraanDinas::with([
                'pencatatanKendaraanDinas.user',
                'suratDetail.kendaraan'
            ])->findOrFail($suratDinasId);
    
            // Mapping data user dinas
            $userDinasData = $suratDinas->pencatatanKendaraanDinas->map(function ($user) {
                return [
                    'nrp_karyawan' => $user->nrp_karyawan,
                    'name' => $user->user->name ?? 'Tidak Diketahui',
                    'departemen' => $user->user->departemen ?? 'Tidak Diketahui',
                ];
            });
    
            // Data kendaraan yang sudah dipilih di surat
            $kendaraanData = $suratDinas->suratDetail->map(function ($detail) {
                $kendaraan = $detail->kendaraan;
                return [
                    'id_kendaraan' => $kendaraan->kendaraan_dinas_id ?? null,
                    'nomor_kendaraan' => $kendaraan->nomor_kendaraan ?? 'Tidak Diketahui',
                    'keterangan' => ($kendaraan->merk_kendaraan ?? '') . ' - ' . ($kendaraan->jenis_kendaraan ?? ''),
                    'merk_kendaraan' => $kendaraan->merk_kendaraan ?? '',
                    'jenis_kendaraan' => $kendaraan->jenis_kendaraan ?? '',
                ];
            });
    
            // Waktu dan tanggal dari surat
            $tanggalPenggunaan = $suratDinas->tanggal_penggunaan;
            $waktuKeluar = $suratDinas->waktu_keluar;
            $waktuKembali = $suratDinas->waktu_kembali;
    
            // Kendaraan yang tidak digunakan oleh surat lain pada waktu yang sama
            $kendaraanTersedia = KendaraanDinas::whereNotExists(function ($query) use ($tanggalPenggunaan, $waktuKeluar, $waktuKembali, $suratDinasId) {
                $query->select(DB::raw(1))
                    ->from('tb_surat_kendaraan_dinas_detail as dskd')
                    ->join('tb_surat_kendaraan_dinas as skd', 'dskd.surat_kendaraan_dinas_id', '=', 'skd.surat_kendaraan_dinas_id')
                    ->whereRaw('dskd.kendaraan_dinas_id = tb_kendaraan_dinas.kendaraan_dinas_id')
                    ->where('skd.tanggal_penggunaan', $tanggalPenggunaan)
                    ->where('skd.surat_kendaraan_dinas_id', '!=', $suratDinasId)
                    ->where(function ($q) use ($waktuKeluar, $waktuKembali) {
                        $q->whereBetween(DB::raw("'$waktuKeluar'"), ['skd.waktu_keluar', 'skd.waktu_kembali'])
                            ->orWhereBetween(DB::raw("'$waktuKembali'"), ['skd.waktu_keluar', 'skd.waktu_kembali'])
                            ->orWhereBetween('skd.waktu_keluar', [$waktuKeluar, $waktuKembali])
                            ->orWhereBetween('skd.waktu_kembali', [$waktuKeluar, $waktuKembali]);
                    });
            })->get();
    
            // Ubah kendaraan tersedia ke format array
            $kendaraanTersediaData = $kendaraanTersedia->map(function ($kendaraan) {
                return [
                    'id_kendaraan' => $kendaraan->kendaraan_dinas_id,
                    'nomor_kendaraan' => $kendaraan->nomor_kendaraan,
                    'keterangan' => $kendaraan->merk_kendaraan . ' - ' . $kendaraan->jenis_kendaraan,
                    'merk_kendaraan' => $kendaraan->merk_kendaraan,
                    'jenis_kendaraan' => $kendaraan->jenis_kendaraan,
                ];
            });
    
            // Gabungkan kendaraan yang tersedia dan yang sudah dipilih, lalu hilangkan duplikat
            $daftarKendaraan = $kendaraanTersediaData->merge($kendaraanData)->unique('id_kendaraan')->values();
    
            return response()->json([
                'surat_kendaraan_dinas_id' => $suratDinas->surat_kendaraan_dinas_id,
                'tujuan_penggunaan_1' => $suratDinas->tujuan_penggunaan_1,
                'tujuan_penggunaan_2' => $suratDinas->tujuan_penggunaan_2,
                'tujuan_penggunaan_3' => $suratDinas->tujuan_penggunaan_3,
                'tanggal_penggunaan' => $suratDinas->tanggal_penggunaan,
                'jenis_kendaraan' => $suratDinas->jenis_kendaraan,
                'waktu_keluar' => $suratDinas->waktu_keluar,
                'waktu_kembali' => $suratDinas->waktu_kembali,
                'userDinas' => $userDinasData,
                'data_kendaraan' => $kendaraanData,
                'daftar_kendaraan' => $daftarKendaraan,
                'status' => $suratDinas->status ?? 'Tidak Diketahui',
            ], 200);
    
        } catch (\Throwable $e) {
            // \Log::error('Edit Surat Kendaraan Dinas Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat memuat data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function editNonAuth(Request $request)
    {
        try {
            $suratDinasId = $request->surat_kendaraan_dinas_id;

            // Ambil data surat dinas dan relasinya
            $suratDinas = SuratKendaraanDinas::with([
                'pencatatanKendaraanDinas.user'
            ])->findOrFail($suratDinasId);

            // Mapping data user dinas (peserta)
            $userDinasData = $suratDinas->pencatatanKendaraanDinas->map(function ($user) {
                return [
                    'nrp_karyawan' => $user->nrp_karyawan,
                    'name' => $user->user->name ?? 'Tidak Diketahui',
                    'departemen' => $user->user->departemen ?? 'Tidak Diketahui',
                ];
            });

            // Return hanya data yang diminta
            return response()->json([
                'tujuan_penggunaan_1' => $suratDinas->tujuan_penggunaan_1,
                'tujuan_penggunaan_2' => $suratDinas->tujuan_penggunaan_2,
                'tujuan_penggunaan_3' => $suratDinas->tujuan_penggunaan_3,
                'jenis_kendaraan' => $suratDinas->jenis_kendaraan,
                'tanggal_penggunaan' => $suratDinas->tanggal_penggunaan,
                'userDinas' => $userDinasData,
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memuat data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    

    public function update(Request $request)
    {
        DB::beginTransaction();
    
        try {
            // 1. Update data utama surat kendaraan dinas
            $surat = SuratKendaraanDinas::findOrFail($request->surat_kendaraan_dinas_id);
            $surat->update([
                'tujuan_penggunaan_1' => $request->tujuan_penggunaan_1,
                'tujuan_penggunaan_2' => $request->tujuan_penggunaan_2,
                'tujuan_penggunaan_3' => $request->tujuan_penggunaan_3,
                'tanggal_penggunaan'  => $request->tanggal_penggunaan,
                'jenis_kendaraan'     => $request->jenis_kendaraan,
                'waktu_keluar'        => $request->waktu_keluar,
                'waktu_kembali'       => $request->waktu_kembali,
            ]);
    
            // 2. Sinkronisasi kendaraan dinas
            //$kendaraanBaru = $request->nomor_kendaraan; // Array of kendaraan_dinas_id
            $kendaraanBaru = $request->nomor_kendaraan ?? []; // <- aman dari null
            $suratId = $request->surat_kendaraan_dinas_id;
    
            // Ambil ID kendaraan lama yang terhubung ke surat ini
            $kendaraanLama = SuratKendaraanDinasDetail::where('surat_kendaraan_dinas_id', $suratId)->pluck('kendaraan_dinas_id')->toArray();
    

            $hapus = array_diff($kendaraanLama, $kendaraanBaru);
            $tambah = array_diff($kendaraanBaru, $kendaraanLama);
    
            // Hapus yang tidak dipilih lagi
            // SuratKendaraanDinasDetail::where('surat_kendaraan_dinas_id', $suratId)
            //     ->whereIn('kendaraan_dinas_id', $hapus)
            //     ->delete();

            // Hapus kendaraan yang tidak dipilih lagi
            if (!empty($hapus)) {
                SuratKendaraanDinasDetail::where('surat_kendaraan_dinas_id', $suratId)
                    ->whereIn('kendaraan_dinas_id', $hapus)
                    ->delete();
            }
    
            // Tambah kendaraan baru
            foreach ($tambah as $kendaraanId) {
                SuratKendaraanDinasDetail::create([
                    'kendaraan_dinas_id' => $kendaraanId,
                    'surat_kendaraan_dinas_id' => $suratId,
                ]);
            }
    
            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
    

    public function getSuratTujuan()
    {
        $list = SuratKendaraanDinas::where('status', '!=', 'Sudah Dibatalkan')->get();

        return response()->json($list);
    }

    public function pindahkanPeserta(Request $request)
    {
        $peserta = $request->peserta; // array of NRP
        $suratBaru = $request->surat_tujuan;

        foreach ($peserta as $nrp) {
            // Ubah surat pada pencatatan kendaraan dinas
            PencatatanKendaraanDinas::where('nrp_karyawan', $nrp)
                ->update([
                    'surat_kendaraan_dinas_id' => $suratBaru,
                    'status' => 'Dipindahkan'
                ]);
        }

        return response()->json(['status' => 'success']);
    }

    private function sendApprovalEmail($userEmail, $suratDinasId, $approvedBy, $status, $fromDepartment)
    {
        Mail::to($userEmail)->send(new ApprovalDinasNotification($suratDinasId, $approvedBy, $status, $fromDepartment));
    }

    private function getStatusText($level)
    {
        $statusMap = [
            'Level 1' => 'Telah Mengajukan Sebagai Yang Membawa',
            'Level 2' => 'Telah Menyetujui dari Ka.Dept Ybs',
            'Level 3' => 'Telah Menyetujui dari Ka.Sie Transport GA',
            'Level 4' => 'Telah Memeriksa oleh Security',
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
