<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertifikatTensimeterDigitalPengujian extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sertifikat_tensimeter_digital_pengujians';
    protected $guarded = ['id'];
}
