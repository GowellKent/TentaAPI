<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvl_jenis_trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'tjt_kode', 'tjt_desc'
    ];
}
