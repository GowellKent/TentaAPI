<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class tvl_objek_tujuan extends Model
{
    use HasFactory;

    protected $primaryKey = 'tot_kode';
    protected $fillable = ['tot_kode', 'tot_nama', 'tot_telp', 'tot_alamat', 'tot_harga', 'tot_tjo_kode', 'tot_tp_kode', 'tot_tk_kode'];

    public function jenisObjek(): BelongsTo
    {
        return $this->belongsTo(tvl_jenis_objek::class, 'tjo_kode', 'tot_tjo_kode');
    }
}
