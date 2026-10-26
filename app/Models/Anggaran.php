<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    use HasFactory;

    protected $table = 'anggaran'; // Sesuai dengan nama tabel di migration
    protected $primaryKey = 'id_anggaran';

    protected $fillable = ['total_anggaran', 'sisa_dana'];

    // Hubungan ke rincian item: Satu data anggaran induk memiliki banyak item belanja (hasMany)
    public function detailBelanja()
    {
        return $this->hasMany(DetailBelanja::class, 'id_anggaran', 'id_anggaran');
    }
}