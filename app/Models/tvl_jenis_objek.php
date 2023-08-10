<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class tvl_jenis_objek extends Model
{
    use HasFactory;

    protected $primaryKey = 'tjo_kode';
    protected $fillable = [
        'tjo_kode', 'tjo_desc'
    ];

    public function objeks(): HasMany
    {
        return $this->hasMany(tvl_objek_tujuan::class, 'tot_tjo_kode', 'tjo_kode');
    }
}
