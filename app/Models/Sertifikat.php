<?php

namespace App\Models;

use App\Models\Instrumen;
use App\Models\MasterCustomer;
use App\Models\PengukuranListrik;
use App\Models\SertifikatFisikFungsi;
use App\Models\SertifikatTelaahTeknis;
use Illuminate\Database\Eloquent\Model;
use App\Models\SertifikatKondisiLingkungan;
use App\Models\SertifikatKondisiKelistrikan;
use App\Models\SertifikatNebulizerPengujian;
use App\Models\SertifikatCentrifugePengujian;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SertifikatPatientMonitorPengujuan;
use App\Models\SertifikatSpyghmomanometerakurasi;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\SertifikatSpyghmomanometerPengujian;
use App\Models\SertifikatTensimeterDigitalPengujian;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function getSpyghmomanometerakurasi()
    {
        return $this->hasOne(SertifikatSpyghmomanometerakurasi::class, 'SertifikatId', 'id');
    }

    public function getSpyghmomanometerPengujian()
    {
        return $this->hasMany(SertifikatSpyghmomanometerPengujian::class, 'SertifikatId', 'id');
    }

    public function getNebulizerPengujian()
    {
        return $this->hasOne(SertifikatNebulizerPengujian::class, 'SertifikatId', 'id');
    }
}
