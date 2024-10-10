<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertifikatPatientMonitorPengujuan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sertifikat_patient_monitor_pengujuans';
    protected $guarded = ['id'];
}
