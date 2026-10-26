<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBelanja extends Model
{
    use HasFactory;

    protected $table = 'detail_belanja';
    protected $primaryKey = 'id_detail';

    protected $fillable = ['id_anggaran', 'nama_item', 'volume_item', 'harga_satuan', 'total_harga'];

    // Hubungan balik: Setiap baris item belanja mutlak merujuk ke satu anggaran induk (belongsTo)
    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class, 'id_anggaran', 'id_anggaran');
    }
}