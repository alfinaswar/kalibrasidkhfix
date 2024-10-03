<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class poDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'po_details';
    protected $guarded = ['id'];

    public function getNamaAlat()
    {
        return $this->hasOne(Instrumen::class, 'id', 'InstrumenId');
    }
    public function getSertifikat()
    {
        return $this->hasOne(Sertifikat::class, 'InstrumenId', 'InstrumenId');
    }
}
