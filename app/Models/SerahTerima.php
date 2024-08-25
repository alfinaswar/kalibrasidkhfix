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
}
