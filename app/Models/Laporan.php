<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id', 'id_komunal', 'alamat_mck', 'deskrip_masalah', 
        'status_kelayakan', 'kondisi_buangan', 'status_perbaikan', 'foto_bukti'
    ];

    public function komunal()
    {
        return $this->belongsTo(Komunal::class, 'id_komunal', 'id_komunal');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}