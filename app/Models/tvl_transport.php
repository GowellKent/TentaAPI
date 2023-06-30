<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class tvl_transport extends Model
{
    use HasFactory;
    protected $primaryKey = 'tt_kode';
    protected $fillable = [
        "tt_kode", "tt_nama", "tt_kota_asal", "tt_kota_tujuan","tt_provinsi_asal", "tt_provinsi_tujuan", "tt_pax", "tt_harga"
    ];

    public function fotos(): HasMany
    {
        return $this->hasMany(tvl_foto_transport::class, 'tft_tt_kode', 'tt_kode');
    }
}
