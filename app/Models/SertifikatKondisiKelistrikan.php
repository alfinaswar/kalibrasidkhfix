<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertifikatKondisiKelistrikan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sertifikat_kondisi_kelistrikans';
    protected $guarded = ['id'];
}
