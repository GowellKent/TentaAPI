<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvl_transport extends Model
{
    use HasFactory;
    protected $fillable = [
        "tt_kode", "tt_nama", "tt_kota_asal", "tt_kota_tujuan","tt_provinsi_asal", "tt_provinsi_tujuan", "tt_pax", "tt_harga"
    ];
}
