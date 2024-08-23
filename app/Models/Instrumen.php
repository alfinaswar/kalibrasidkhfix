<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Expr\Cast;

class Instrumen extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'instrumens';
    protected $guarded = ['id'];
    protected $casts = [
        'AlatUkur' => 'json'
    ];

    public function getAlatUkur()
    {
        return $this->whereJsonContains(MasterAlat::class, 'id', 'AlatUkur');
    }

}
