<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnggaranController extends Controller
{
    public function index()
    {
        $totalPagu = DB::table('anggaran')->sum('total_anggaran');
        $dataAnggaran = DB::table('detail_belanja')->orderBy('id_detail', 'desc')->get();
        $totalTerpakai = DB::table('detail_belanja')->sum('total_harga');
        $sisaAnggaran = $totalPagu - $totalTerpakai;

        $chartData = DB::table('detail_belanja')
            ->select('nama_item', DB::raw('SUM(total_harga) as total_nominal'))
            ->groupBy('nama_item')
            ->get();

        return view('data_anggaran', compact('dataAnggaran', 'totalPagu', 'totalTerpakai', 'sisaAnggaran', 'chartData'));
    }
}