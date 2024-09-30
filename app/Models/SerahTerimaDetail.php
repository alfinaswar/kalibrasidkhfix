<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerahTerimaDetail extends Model
{
    use HasFactory;

    protected $table = 'serah_terima_details';
    protected $guarded = ['id'];
    public function getNamaAlat()
    {
        return $this->hasOne(Instrumen::class, 'id', 'InstrumenId');
    }
}
