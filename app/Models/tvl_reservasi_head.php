<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvl_reservasi_head extends Model
{
    use HasFactory;
    protected $pirmaryKey = 'trh_kode';
    protected $fillable = ['trh_kode', 'trh_tph_kode', 'trh_tsr_kode', 'trh_tu_kode','trh_tgl_reservasi', 'trh_tgl_jalan', 'trh_durasi', 'trh_pax','trh_harga',
                            'trh_provinsi_asal', 'trh_kota_asal', 'trh_provinsi_tujuan', 'trh_kota_tujuan', 'trh_tt_kode'];
}
