<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SanitasiController extends Controller
{
    // =======================================================================
    // 1. SECURITY LOGINS (Disesuaikan dengan LoginResponse di Android)
    // =======================================================================
    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username atau password salah!',
                'user' => null
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil!',
            'user' => [
                'id' => (int)$user->id_user, 
                'name' => (string)$user->username, // Menghindari field name null jika kosong
                'username' => (string)$user->username,
                'role' => (string)$user->role,
                'kelurahan' => (string)$user->kelurahan
            ]
        ], 200);
    }

    public function logout(Request $request) {
        return response()->json(['status' => 'success', 'message' => 'Logout berhasil.'], 200);
    }

    // =======================================================================
    // 1.5. GET LIST JALAN DINAMIS
    // =======================================================================
    public function getListJalan(Request $request)
    {
        $kelurahan = $request->kelurahan;

        $rt = DB::table('rumah_tangga')->select('alamat as nama_jalan', 'kelurahan')->where('alamat', 'NOT LIKE', '%Pilih Jalan%');
        $kom = DB::table('komunal')->select('alamat as nama_jalan', 'kelurahan')->where('alamat', 'NOT LIKE', '%Pilih Jalan%');
        $spal = DB::table('spal')->select('alamat as nama_jalan', 'kelurahan')->where('alamat', 'NOT LIKE', '%Pilih Jalan%');

        if (!empty($kelurahan)) {
            $rt->where('kelurahan', $kelurahan);
            $kom->where('kelurahan', $kelurahan);
            $spal->where('kelurahan', $kelurahan);
        }

        // Union and get distinct
        $jalans = $rt->union($kom)->union($spal)->distinct()->get();
        
        $formatted = $jalans->map(function($item) {
            $nama_jalan = $item->nama_jalan ?? '';
            $namaJalanBersih = explode(',', $nama_jalan)[0];
            return [
                'kelurahan' => $item->kelurahan,
                'nama_jalan' => trim($namaJalanBersih)
            ];
        })->unique(function ($item) {
            return $item['kelurahan'] . '-' . strtolower($item['nama_jalan']);
        })->values()->map(function($item, $index) {
            return [
                'id' => $index + 1,
                'kelurahan' => $item['kelurahan'],
                'nama_jalan' => $item['nama_jalan']
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $formatted
        ], 200);
    }

    // =======================================================================
    // 2. STORE DATA RUMAH TANGGA
    // =======================================================================
    public function storeRumahTangga(Request $request)
    {
        try {
            $idUserRaw = $request->input('id_user') ?? 1;

            $namaDokumen = null;
            if ($request->hasFile('foto_dokumen')) {
                $files = $request->file('foto_dokumen');
                if (!is_array($files)) {
                    $files = [$files];
                }
                $namaDokumenArr = [];
                foreach ($files as $file) {
                    $namaFile = time() . '_' . uniqid() . '_dokumen_' . $file->getClientOriginalName();
                    $file->storeAs('public/dokumen', $namaFile);
                    $namaDokumenArr[] = $namaFile;
                }
                $namaDokumen = implode(',', $namaDokumenArr);
            }

            $idRt = DB::table('rumah_tangga')->insertGetId([
                'id_user'            => $idUserRaw,
                'kelurahan'          => $request->input('kelurahan') ?? 'Mojoroto',
                'alamat'             => $request->input('alamat') ?? 'Kediri',
                'no_kk'              => $request->input('no_kk') ?? '352900000000',
                'kepala_keluarga'    => $request->input('kepala_keluarga') ?? 'Warga Baru',
                'jml_penghuni'       => (int)($request->input('jml_penghuni') ?? 1),
                'kepemilikan_jamban' => (string) strtolower($request->input('kepemilikan_jamban') ?? 'sendiri'),
                'jenis_jamban'       => (string) strtolower($request->input('jenis_jamban') ?? 'leher angsa'),
                'pembuangan'         => (string) strtolower($request->input('pembuangan') ?? 'tangki septic'),
                'riwayat_sedot'      => (string) ($request->input('riwayat_sedot') ?? 'Belum Pernah Disedot'),
                'greywater'          => (string) ($request->input('greywater') ?? 'Saluran Tertutup'),
                'jarak_air'          => (string) ($request->input('jarak_air') ?? '≥ 10 Meter (Aman)'),
                'status_kelayakan'   => (string) ($request->input('status_kelayakan') ?? 'Layak'),
                'latitude'           => round((float)($request->input('latitude') ?? -7.816), 8),
                'longitude'          => round((float)($request->input('longitude') ?? 112.010), 8),
                'foto_dokumen'       => $namaDokumen,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Data Rumah Tangga Baru Berhasil Masuk Database!'
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error storeRumahTangga: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Server Laravel Menolak: ' . $e->getMessage()
            ], 400);
        }
    }

    // =======================================================================
    // 3. STORE DATA SANITASI KOMUNAL
    // =======================================================================
    public function storeKomunal(Request $request)
    {
        try {
            DB::table('komunal')->insert([
                'id_user'          => (int)($request->input('id_user') ?? 1),
                'kelurahan'        => (string)($request->input('kelurahan') ?? 'Mojoroto'),
                'alamat'           => (string)($request->input('alamat') ?? 'Kediri'),
                'rw'               => (string)($request->input('rw') ?? '1'),
                'rt'               => (string)($request->input('rt') ?? '1'),
                'kode_pos'         => (string)($request->input('kode_pos') ?? ''),        
                'nama_fasilitas'   => (string)($request->input('nama_fasilitas') ?? 'MCK Komunal Baru'),  
                'nama_sistem'      => (string)($request->input('nama_sistem') ?? 'MCK Umum Bersama'),   
                'bilik_mandi'      => (int)($request->input('bilik_mandi') ?? 1), 
                'jml_wc'           => (int)($request->input('jml_wc') ?? 1),        
                'jarak_air'        => (string)($request->input('jarak_air') ?? '10 Meter'),     
                'kondisi_fisik'    => (string)($request->input('kondisi_fisik') ?? 'Aman'),  
                'kondisi_air'      => (string)($request->input('kondisi_air') ?? 'Lancar'),    
                'status_kelayakan' => (string)($request->input('status_kelayakan') ?? 'Layak'),
                'latitude'         => (double)($request->input('latitude') ?? -7.816),
                'longitude'        => (double)($request->input('longitude') ?? 112.010),
                'created_at'       => now(),
                'updated_at'       => now()
            ]);

            return response()->json(['status' => 'success', 'message' => 'Data Komunal Berhasil Disimpan!'], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal: ' . $e->getMessage()], 400);
        }
    }

    // =======================================================================
    // 4. STORE DATA MONITORING JARINGAN SPAL
    // =======================================================================
    public function storeSpal(Request $request)
    {
        try {
            $namaDokumen = null;
            if ($request->hasFile('foto_dokumen')) {
                $files = $request->file('foto_dokumen');
                if (!is_array($files)) {
                    $files = [$files];
                }
                $namaDokumenArr = [];
                foreach ($files as $file) {
                    $namaFile = time() . '_' . uniqid() . '_spal_' . $file->getClientOriginalName();
                    $file->storeAs('public/dokumen', $namaFile);
                    $namaDokumenArr[] = $namaFile;
                }
                $namaDokumen = implode(',', $namaDokumenArr);
            }

            DB::table('spal')->insert([
                'id_user'      => (int)($request->input('id_user') ?? 1),
                'no_kk'        => (string)($request->input('no_kk') ?? '-'),
                'nama_kepala'  => (string)($request->input('nama_kepala') ?? 'Warga'),
                'kelurahan'    => (string)($request->input('kelurahan') ?? 'Mojoroto'),
                'alamat'       => (string)($request->input('alamat') ?? 'Kediri'),
                'status_spal'  => (string)($request->input('status_spal') ?? 'Belum Tersambung'),
                'kondisi_bak'  => (string)($request->input('kondisi_bak') ?? 'Berfungsi Baik'),
                'latitude'     => (double)($request->input('latitude') ?? -7.816),
                'longitude'    => (double)($request->input('longitude') ?? 112.010),
                'foto_dokumen' => $namaDokumen ?? '', 
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Data Pipa SPAL Berhasil Disimpan!'], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal: ' . $e->getMessage()], 400);
        }
    }

    // =======================================================================
    // 5. STORE PELAPORAN MASALAH SANITASI
    // =======================================================================
    public function storeLaporan(Request $request)
    {
        try {
            $namaFoto = null;
            if ($request->hasFile('foto_bukti')) {
                $files = $request->file('foto_bukti');
                if (!is_array($files)) {
                    $files = [$files];
                }
                $namaFotoArr = [];
                foreach ($files as $file) {
                    $namaFile = time() . '_' . uniqid() . '_laporan_' . $file->getClientOriginalName();
                    $file->storeAs('public/laporan', $namaFile);
                    $namaFotoArr[] = $namaFile;
                }
                $namaFoto = implode(',', $namaFotoArr);
            }

            DB::table('laporan')->insert([
                'id_user'          => (int)($request->input('id_user') ?? 1), 
                'id_komunal'       => (int)($request->input('id_komunal') ?? 1),
                'alamat_mck'       => (string)($request->input('alamat_mck') ?? 'Kediri'),
                'deskrip_masalah'  => (string)($request->input('deskrip_masalah') ?? 'Kerusakan sarana mck'),
                'status_kelayakan' => (string)($request->input('status_kelayakan') ?? 'Layak'),
                'kondisi_buangan'  => (string)($request->input('kondisi_buangan') ?? 'Baik / Tertutup'),
                'kebersihan'       => (string)($request->input('kebersihan') ?? 'Bersih Terawat'),       
                'status_perbaikan' => (string)($request->input('status_perbaikan') ?? 'Tidak / Ringan'),
                'foto_bukti'       => $namaFoto ?? '', 
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Laporan aduan berhasil disimpan!'], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal: ' . $e->getMessage()], 400);
        }
    }

    // =======================================================================
    // 6. LIST DATA FASILITAS UNTUK SPINNER DI ANDROID (`KomunalListResponse`)
    // =======================================================================
    public function getListKomunal()
    {
        try {
            $data = DB::table('komunal')->get()->map(function ($item) {
                return [
                    'id' => (int)$item->id_komunal,
                    'nama_fasilitas' => (string)$item->nama_fasilitas,
                    'nama_sistem' => (string)$item->nama_sistem,
                    'alamat' => (string)$item->alamat,
                    'kelurahan' => (string)$item->kelurahan
                ];
            });
            return response()->json(['status' => 'success', 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'data' => []], 500);
        }
    }

    // =======================================================================
    // 7. GABUNGAN RIWAYAT GLOBAL (`ResponseRiwayat`)
    // =======================================================================
    public function getRiwayatPelaporan(Request $request)
    {
        try {
            $idUser = $request->query('id_user');
            $gabunganData = [];

            // 1. Modul Laporan
            try {
                $laporan = DB::table('laporan')
                    ->leftJoin('komunal', 'laporan.id_komunal', '=', 'komunal.id_komunal')
                    ->select(
                        'laporan.id_laporan as id', 'laporan.id_user', 'laporan.id_komunal',
                        'komunal.nama_fasilitas', DB::raw('NULL as kepala_keluarga'),
                        'komunal.alamat', 'laporan.alamat_mck', 'laporan.deskrip_masalah', 'laporan.created_at',
                        DB::raw('"laporan" as type')
                    );
                if ($idUser) { $laporan = $laporan->where('laporan.id_user', $idUser); }
                $gabunganData = array_merge($gabunganData, $laporan->get()->toArray());
            } catch (\Exception $e) {}

            // 2. Modul Rumah Tangga
            try {
                $rtQuery = DB::table('rumah_tangga')
                    ->select(
                        'id_rt as id', 'id_user', DB::raw('NULL as id_komunal'), DB::raw('NULL as nama_fasilitas'),
                        'kepala_keluarga', 'alamat', DB::raw('NULL as alamat_mck'),
                        DB::raw('"Pendataan Rumah Tangga" as deskrip_masalah'), 'created_at',
                        DB::raw('"rumah_tangga" as type')
                    );
                if ($idUser) { $rtQuery = $rtQuery->where('id_user', $idUser); }
                $gabunganData = array_merge($gabunganData, $rtQuery->get()->toArray());
            } catch (\Exception $e) {}

            // 3. Modul Komunal
            try {
                $komunalQuery = DB::table('komunal')
                    ->select(
                        'id_komunal as id', 'id_user', 'id_komunal', 'nama_fasilitas', DB::raw('NULL as kepala_keluarga'),
                        'alamat', DB::raw('NULL as alamat_mck'), DB::raw('"Pendataan Fasilitas Komunal" as deskrip_masalah'), 'created_at',
                        DB::raw('"komunal" as type')
                    );
                if ($idUser) { $komunalQuery = $komunalQuery->where('id_user', $idUser); }
                $gabunganData = array_merge($gabunganData, $komunalQuery->get()->toArray());
            } catch (\Exception $e) {}

            // 4. Modul SPAL
            try {
                $spalQuery = DB::table('spal')
                    ->select(
                        'id_babs as id', 'id_user', DB::raw('NULL as id_komunal'), DB::raw('NULL as nama_fasilitas'),
                        'nama_kepala as kepala_keluarga', 'alamat', DB::raw('NULL as alamat_mck'),
                        DB::raw('"Monitoring Jaringan SPAL" as deskrip_masalah'), 'created_at',
                        DB::raw('"spal" as type')
                    );
                if ($idUser) { $spalQuery = $spalQuery->where('id_user', $idUser); }
                $gabunganData = array_merge($gabunganData, $spalQuery->get()->toArray());
            } catch (\Exception $e) {}

            usort($gabunganData, function ($a, $b) { return strtotime($b->created_at) - strtotime($a->created_at); });

            $finalData = array_map(function($item) {
                return [
                    'id' => (int)$item->id,
                    'id_user' => (int)$item->id_user,
                    'id_komunal' => isset($item->id_komunal) ? (int)$item->id_komunal : null,
                    'nama_fasilitas' => $item->nama_fasilitas,
                    'kepala_keluarga' => $item->kepala_keluarga,
                    'alamat' => $item->alamat,
                    'alamat_mck' => $item->alamat_mck,
                    'deskrip_masalah' => $item->deskrip_masalah,
                    'type' => $item->type,
                    'created_at' => date('Y-m-d H:i:s', strtotime($item->created_at))
                ];
            }, $gabunganData);

            return response()->json(['status' => 'success', 'data' => $finalData], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'data' => []], 500);
        }
    }

    // Riwayat Cadangan Jalur Spesifik Tunggal
    public function getRiwayatRT(Request $request) {
        $data = DB::table('rumah_tangga')->where('id_user', $request->query('id_user'))->orderBy('id_rt', 'desc')->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
    public function getRiwayatKomunal(Request $request) {
        $data = DB::table('komunal')->where('id_user', $request->query('id_user'))->orderBy('id_komunal', 'desc')->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
    public function getRiwayatSpal(Request $request) {
        $data = DB::table('spal')->where('id_user', $request->query('id_user'))->orderBy('id_babs', 'desc')->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
    
    // =======================================================================
    // 8. HAPUS DATA GLOBAL
    // =======================================================================
    public function deleteData(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');

        try {
            if ($type == 'rumah_tangga') {
                DB::table('rumah_tangga')->where('id_rt', $id)->delete();
            } else if ($type == 'komunal') {
                DB::table('komunal')->where('id_komunal', $id)->delete();
            } else if ($type == 'spal') {
                DB::table('spal')->where('id_babs', $id)->delete();
            } else if ($type == 'laporan') {
                DB::table('laporan')->where('id_laporan', $id)->delete();
            } else {
                return response()->json(['status' => 'error', 'message' => 'Tipe data tidak dikenali'], 400);
            }
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus dari database'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus data: ' . $e->getMessage()], 400);
        }
    }
}