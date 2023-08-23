<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvl_paket_head extends Model
{
    use HasFactory;
    protected $primaryKey = 'tph_kode';
    protected $fillable = ['tph_kode', 'tph_nama', 'tph_tjt_kode', 'tph_durasi', 'tph_provinsi_asal', 'tph_kota_asal', 'tph_provinsi_tujuan','tph_kota_tujuan',
                            'tph_harga'];
}
