<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvl_jenis_objek extends Model
{
    use HasFactory;

    protected $fillable = [
        'tjo_kode', 'tjo_desc'
    ];
}
