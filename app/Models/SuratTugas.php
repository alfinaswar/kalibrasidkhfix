<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratTugas extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ='surat_tugas';
    protected $guarded =['id'];
    protected $casts = [
        'karywanId' => 'json'
    ];
    public function getCustomer()
    {
        return $this->hasOne(MasterCustomer::class, 'id', 'CustomerId');
    }
    public function DetailPo()
    {
        return $this->hasMany(poDetail::class, 'PoId', 'PoId');
    }
    public function getNomorPO()
    {
        return $this->hasOne(po::class, 'id', 'PoId');
    }
}
