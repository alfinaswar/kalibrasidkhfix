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
}
