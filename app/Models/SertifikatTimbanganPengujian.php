<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertifikatTimbanganPengujian extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sertifikat_timbangan_pengujians';
    protected $guarded = ['id'];

    protected $casts = [
        'MassaHalf' => 'json',
        'MassaMax' => 'json',
        'PengujianZ' => 'json',
        'PengujianM' => 'json'
    ];

}
