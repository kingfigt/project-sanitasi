<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // =======================================================================
    // 1. HALAMAN UTAMA DASHBOARD (Menampilkan Metrik Indikator, Kelayakan & Anggaran)
    // =======================================================================
    public function index()
    {
        $jumlahRt = DB::table('rumah_tangga')->count();
        $jumlahKomunal = DB::table('komunal')->count();
        $jumlahSpal = DB::table('spal')->count();

        $totalLayak = DB::table('rumah_tangga')
                        ->where('status_kelayakan', 'Layak')
                        ->count();

        $totalTidakLayak = DB::table('rumah_tangga')
                            ->where('status_kelayakan', 'Tidak Layak')
                            ->count();

        $totalSemuaData = $jumlahRt + $jumlahKomunal + $jumlahSpal;

        return view('dashboard', compact(
            'jumlahRt',
            'jumlahKomunal',
            'jumlahSpal',
            'totalLayak',        
            'totalTidakLayak',   
            'totalSemuaData'
        ));
    }

    // =======================================================================
    // 2. HALAMAN FORM TAMBAH USER (Membuka File Full Page tambah_user.blade)
    // =======================================================================
    public function tambahUser()
    {
        $users = DB::table('user')->get();
        return view('tambah_user', compact('users'));
    }

    // =======================================================================
    // 3. PROSES SIMPAN USER PETUGAS BARU LANGSUNG KE DATABASE MYSQL
    // =======================================================================
    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:user,username',
            'password' => 'required|string|min:6',
            'role'     => 'required',
        ]);

        // Insert data ke tabel user di database Laragon kamu
        DB::table('user')->insert([
            'username'   => $request->username,
            'password'   => bcrypt($request->password), // Di-hash aman dengan bcrypt Laravel
            'role'       => $request->role,
        ]);

        // Mengembalikan ke halaman form dengan membawa session flash message sukses
        return redirect()->route('users.create')->with('success', 'User petugas baru berhasil disimpan ke database!');
    }

    // =======================================================================
    // 4. PROSES UPDATE USER PETUGAS
    // =======================================================================
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:user,username,'.$id.',id_user',
            'role'     => 'required',
        ]);

        $updateData = [
            'username'   => $request->username,
            'role'       => $request->role,
        ];

        // Jika password diisi, maka update password
        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        DB::table('user')->where('id_user', $id)->update($updateData);

        return redirect()->route('users.create')->with('success', 'Data user berhasil diperbarui!');
    }

    // =======================================================================
    // 5. PROSES HAPUS USER PETUGAS
    // =======================================================================
    public function deleteUser($id)
    {
        DB::table('user')->where('id_user', $id)->delete();
        return redirect()->route('users.create')->with('success', 'User berhasil dihapus dari database!');
    }
}