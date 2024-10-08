<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sertifikat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sertifikats';

    protected $guarded = ['id'];

    public function getCustomer()
    {
        return $this->hasOne(MasterCustomer::class, 'id', 'CustomerId');
    }

    public function getNamaAlat()
    {
        return $this->hasOne(Instrumen::class, 'id', 'InstrumenId');
    }

    public function getPengukuranKondisiLingkungan()
    {
        return $this->hasOne(SertifikatKondisiLingkungan::class, 'SertifikatId', 'id');
    }

    public function getTeganganUtama()
    {
        return $this->hasOne(SertifikatKondisiKelistrikan::class, 'SertifikatId', 'id');
    }

    public function getPmeriksaanFisikFungsi()
    {
        return $this->hasOne(SertifikatFisikFungsi::class, 'SertifikatId', 'id');
    }

    public function getPengukuranListrik()
    {
        return $this->hasOne(PengukuranListrik::class, 'SertifikatId', 'id');
    }

    public function getPengujianKinerjaCentrifuge()
    {
        return $this->hasMany(SertifikatCentrifugePengujian::class, 'SertifikatId', 'id');
    }

    public function getTelaahTeknis()
    {
        return $this->hasOne(SertifikatTelaahTeknis::class, 'SertifikatId', 'id');
    }

    public function getPengujianPatientMonitor()
    {
        return $this->hasMany(SertifikatPatientMonitorPengujuan::class, 'SertifikatId', 'id');
    }
    public function getPengujianTensimeterDigital()
    {
        return $this->hasMany(SertifikatTensimeterDigitalPengujian::class, 'SertifikatId', 'id');
    }
}
