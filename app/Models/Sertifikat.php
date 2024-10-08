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
        return $this->hasMany(SertifikatKondisiLingkungan::class, 'InstrumenId', 'id');
    }
    public function getTeganganUtama()
    {
        return $this->hasOne(SertifikatKondisiLingkungan::class, 'id', 'InstrumenId');
    }
    public function getPmeriksaanFisikFungsi()
    {
        return $this->hasOne(SertifikatFisikFungsi::class, 'id', 'InstrumenId');
    }
    public function getPengukuranListrik()
    {
        return $this->hasOne(PengukuranListrik::class, 'id', 'InstrumenId');
    }

    public function getPengujianKinerjaCentrifuge()
    {
        return $this->hasMany(SertifikatCentrifugePengujian::class, 'InstrumenId', 'id');
    }
    public function getTelaahTeknis()
    {
        return $this->hasOne(SertifikatTelaahTeknis::class, 'id', 'InstrumenId');
    }
}
