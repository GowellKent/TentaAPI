<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvl_reservasi_det extends Model
{
    use HasFactory;

    protected $fillable = [
        'trd_kode', 'trd_trh_kode','trd_tot_kode', 'trd_jam', 'trd_hari'
    ];
}
