<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Facades\DB;

class DataSanitasiExport implements FromView, WithDrawings, ShouldAutoSize, WithEvents
{
    protected $type;
    protected $data;
    
    public function __construct($type)
    {
        $this->type = $type;
        $this->fetchData();
    }

    protected function fetchData()
    {
        if ($this->type == 'rt') {
            $this->data = DB::table('rumah_tangga')->get();
        } else if ($this->type == 'komunal') {
            $this->data = DB::table('komunal')->get();
        } else if ($this->type == 'spal') {
            $this->data = DB::table('spal')->select(
                'id_babs', 'nama_kepala as kepala_keluarga', 'kelurahan', 'id_user as id_rt',
                'status_spal as pembuangan', 'kondisi_bak as simpan_keterangan', 'latitude', 'longitude', 'foto_dokumen'
            )->get();
        } else if ($this->type == 'laporan') {
            $this->data = DB::table('laporan')
                ->leftJoin('komunal', 'laporan.id_komunal', '=', 'komunal.id_komunal')
                ->select('laporan.*', 'komunal.latitude', 'komunal.longitude', 'komunal.kelurahan', 'komunal.rw')
                ->get();
        }
    }

    public function view(): View
    {
        return view('exports.sanitasi', [
            'type' => $this->type,
            'data' => $this->data
        ]);
    }

    public function drawings()
    {
        $drawings = [];
        $row = 2; // Data row starts at 2

        foreach ($this->data as $item) {
            $drawing = new Drawing();
            $drawing->setName('Foto');
            $drawing->setDescription('Foto Bukti');
            
            $path = '';
            // G is the 7th column for RT, F is the 6th column for SPAL and Laporan
            if ($this->type == 'rt' && !empty($item->foto_dokumen)) {
                $path = storage_path('app/public/dokumen/' . $item->foto_dokumen);
                $drawing->setCoordinates('G' . $row); 
            } else if ($this->type == 'spal' && !empty($item->foto_dokumen)) {
                $path = storage_path('app/public/dokumen/' . $item->foto_dokumen);
                $drawing->setCoordinates('F' . $row); 
            } else if ($this->type == 'laporan' && !empty($item->foto_bukti)) {
                $path = storage_path('app/public/laporan/' . $item->foto_bukti);
                $drawing->setCoordinates('F' . $row); 
            }

            if (!empty($path) && file_exists($path)) {
                $drawing->setPath($path);
                $drawing->setHeight(80);
                $drawing->setOffsetY(5);
                $drawing->setOffsetX(5);
                $drawings[] = $drawing;
            }
            $row++;
        }

        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Set default row height so images fit nicely
                foreach (range(2, count($this->data) + 1) as $row) {
                    $event->sheet->getDelegate()->getRowDimension($row)->setRowHeight(70);
                }
            },
        ];
    }
}
