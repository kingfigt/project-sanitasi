<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spal extends Model
{
    use HasFactory;

    protected $table = 'spal';

    protected $primaryKey = 'id_babs';

    protected $fillable = [
        'id_user',
        'no_kk',
        'nama_kepala',
        'kelurahan',
        'alamat',
        'status_spal',
        'kondisi_bak',
        'latitude',
        'longitude',
        'foto_dokumen'
    ];
}
