<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jalan;

class JalanController extends Controller
{
    // List jalan untuk Admin
    public function index()
    {
        // Ambil semua data jalan, diurutkan berdasarkan kelurahan
        $jalans = Jalan::orderBy('kelurahan')->orderBy('nama_jalan')->get();
        return view('jalan.index', compact('jalans'));
    }

    // Simpan jalan baru
    public function store(Request $request)
    {
        $request->validate([
            'kelurahan' => 'required|string|max:255',
            'nama_jalan' => 'required|string|max:255',
        ]);

        Jalan::create([
            'kelurahan' => $request->kelurahan,
            'nama_jalan' => $request->nama_jalan,
        ]);

        return redirect()->route('jalan.index')->with('success', 'Jalan berhasil ditambahkan!');
    }

    // Hapus jalan
    public function destroy($id)
    {
        $jalan = Jalan::findOrFail($id);
        $jalan->delete();

        return redirect()->route('jalan.index')->with('success', 'Jalan berhasil dihapus!');
    }
}
