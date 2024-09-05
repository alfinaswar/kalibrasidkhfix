<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class po extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pos';
    protected $guarded = ['id'];

    public function getCustomer()
    {
        return $this->hasOne(MasterCustomer::class, 'id', 'CustomerId');
    }

    public function DetailPo()
    {
        return $this->hasMany(poDetail::class, 'id', 'PoId');
    }
}
