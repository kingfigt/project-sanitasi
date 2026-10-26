<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Babs extends Model
{
    use HasFactory;

    protected $table = 'babs';
    protected $primaryKey = 'id_babs';

    protected $fillable = ['id_rt', 'pembuangan', 'simpan_keterangan'];

    // Jembatan emas untuk menarik seluruh data Rumah Tangga lewat id_rt
    public function rumahTangga()
    {
        return $this->belongsTo(RumahTangga::class, 'id_rt', 'id_rt');
    }
}