<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use HasFactory,SoftDeletes;

    protected $table ='quotations';
    protected $guarded = ['id'];

    public function DetailQuotation()
    {
        return $this->hasMany(QuotationDetail::class, 'idQuotation', 'id');
    }
    public function getCustomer()
    {
        return $this->hasOne(MasterCustomer::class, 'id', 'CustomerId');
    }
}
