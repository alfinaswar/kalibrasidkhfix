<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KajiUlang extends Model
{
    use HasFactory;
    protected $table = 'kaji_ulangs';
    protected $guarded = ['id'];

    public function getInstrumen()
    {
        return $this->hasOne(Instrumen::class, 'id', 'InstrumenId');
    }
    public function getCustomer()
    {
        return $this->hasOne(MasterCustomer::class, 'id', 'CustomerId');
    }
    public function getMetode1()
    {
        return $this->hasOne(MasterMetode::class, 'id', 'Metode1');
    }
    public function getMetode2()
    {
        return $this->hasOne(MasterMetode::class, 'id', 'Metode2');
    }
}
