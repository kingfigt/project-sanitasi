<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jalan extends Model
{
    use HasFactory;
    
    protected $table = 'jalans';
    protected $fillable = ['kelurahan', 'nama_jalan'];
}
