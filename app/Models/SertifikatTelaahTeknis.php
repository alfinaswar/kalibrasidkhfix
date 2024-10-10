<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertifikatTelaahTeknis extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sertifikat_telaah_teknis';
    protected $guarded = ['id'];
}
