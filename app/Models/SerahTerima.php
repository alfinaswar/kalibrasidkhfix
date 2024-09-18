<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SerahTerima extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'serah_terimas';
    protected $guarded = ['id'];

    public function Stdetail()
    {
        return $this->hasMany(SerahTerimaDetail::class, 'SerahTerimaId', 'id');
    }

    public function getNamaAlat()
    {
        return $this->hasOne(Instrumen::class, 'id', 'InstrumanId');
    }

    public function dataKaji()
    {
        return $this->hasMany(KajiUlang::class, 'SerahTerimaId', 'id');
    }

    public function getCustomer()
    {
        return $this->hasOne(MasterCustomer::class, 'id', 'CustomerId');
    }
}
