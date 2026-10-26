<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komunal extends Model
{
    use HasFactory;
    protected $table = 'komunal';
    protected $primaryKey = 'id_komunal';
    protected $fillable = ['id', 'kelurahan', 'rw', 'jml_wc', 'jarak_air', 'status_kelayakan'];
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_komunal', 'id_komunal');
    }
}