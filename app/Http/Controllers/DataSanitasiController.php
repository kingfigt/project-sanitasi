<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataSanitasiController extends Controller
{
    public function index()
    {
        $dataRt = DB::table('rumah_tangga')->orderBy('created_at', 'desc')->get();
        $dataKomunal = DB::table('komunal')->orderBy('created_at', 'desc')->get();
        $dataBabs = DB::table('spal')
            ->select(
                'id_babs',
                'nama_kepala as kepala_keluarga',
                'kelurahan',
                'id_user as id_rt',
                'status_spal as pembuangan',
                'kondisi_bak as simpan_keterangan',
                'latitude',
                'longitude',
                'foto_dokumen',
                'created_at'
            )
            ->orderBy('created_at', 'desc')
            ->get();

        // 4. PERBAIKAN PELAPORAN: Join dengan komunal saja
        $dataPelaporan = DB::table('laporan')
            ->leftJoin('komunal', 'laporan.id_komunal', '=', 'komunal.id_komunal')
            ->select(
                'laporan.*',
                'komunal.latitude', 
                'komunal.longitude', 
                'komunal.kelurahan', 
                'komunal.rw'
            )
            ->orderBy('laporan.created_at', 'desc')
            ->get();

        return view('data_sanitasi', compact('dataRt', 'dataKomunal', 'dataBabs', 'dataPelaporan'));
    }

    // =======================================================================
    // FUNGSI MENAMPUNG AKSI UPDATE STATUS PERBAIKAN DARI WEB ADMIN
    // =======================================================================
    public function updateStatusPerbaikan(Request $request)
    {
        $request->validate([
            'id_laporan' => 'required|integer',
            'status_perbaikan' => 'required|in:belum,proses,selesai',
        ]);

        DB::table('laporan')
            ->where('id_laporan', $request->id_laporan)
            ->update([
                'status_perbaikan' => $request->status_perbaikan,
                'updated_at' => now()
            ]);

        return redirect()->back()->with('success', 'Status perbaikan laporan berhasil diperbarui!');
    }

    // =======================================================================
    // FUNGSI UNTUK EKSPOR DATA KE PDF ATAU EXCEL
    // =======================================================================
    public function exportData($type, $format)
    {
        if ($format == 'excel') {
            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\DataSanitasiExport($type), 'Data_Sanitasi_' . strtoupper($type) . '.xlsx');
        } else if ($format == 'pdf') {
            $export = new \App\Exports\DataSanitasiExport($type);
            $data = $export->view()->getData();
            $data['is_pdf'] = true;
            
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.sanitasi', $data)->setPaper('a4', 'landscape');
            return $pdf->download('Data_Sanitasi_' . strtoupper($type) . '.pdf');
        }
        
        return redirect()->back();
    }
}