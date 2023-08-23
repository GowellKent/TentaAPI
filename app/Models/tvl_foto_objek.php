<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class tvl_foto_objek extends Model
{
    use HasFactory;
    protected $primaryKey = 'tfo_kode';
    protected $fillable = [
        'tfo_kode', 'tfo_tot_kode', 'tfo_path'
    ];

    public function transport(): BelongsTo
    {
        return $this->belongsTo(tvl_objek_tujuan::class, 'tot_kode', 'tfo_tt_kode');
    }
}
