<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class inventori extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inventoris';
    protected $guarded =['id'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->kode = self::generateKode();
        });
    }

    public static function generateKode()
    {
        $latest = self::latest('id')->first();
        $nextNumber = $latest ? $latest->id + 1 : 1;
        $number = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        $bulan = date('n');
        $tahun = date('Y');

        return "{$number}/AS-DKH/{$bulan}/{$tahun}";
    }

}
