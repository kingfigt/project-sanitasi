<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahTangga extends Model
{
    use HasFactory;

    protected $table = 'rumah_tanggas';
    protected $primaryKey = 'id_rt';
    
    protected $fillable = [
        'id', 'kelurahan', 'alamat', 'no_kk', 'kepala_keluarga', 
        'jml_penghuni', 'kepemilikan_jamban', 'jenis_jamban', 
        'status_kelayakan', 'pembuangan', 'jarak_air', 'longitude', 'latitude'
    ];

    // Hubungan balik ke tabel users (Mengetahui siapa petugasnya)
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    // Hubungan ke tabel Babs (Satu rumah tangga bisa punya riwayat BABS)
    public function babs()
    {
        return $this->hasMany(Babs::class, 'id_rt', 'id_rt');
    }
}
