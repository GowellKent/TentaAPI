<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class tvl_paket_head extends Model
{
    use HasFactory;
    protected $primaryKey = 'tph_kode';
    protected $fillable = ['tph_kode', 'tph_nama', 'tph_tjt_kode', 'tph_durasi', 'tph_tp_kode_asal', 'tph_tk_kode_asal', 'tph_tp_kode_tujuan','tph_tk_kode_tujuan',
                            'tph_harga'];

    public function details(): HasMany
    {
        return $this->hasMany(tvl_paket_det::class, 'tpd_tph_kode', 'tph_kode');
    }
}
