<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertifikatKondisiLingkungan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sertifikat_kondisi_lingkungans';
    protected $guarded = ['id'];
}
