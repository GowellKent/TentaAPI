<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class tvl_kota extends Model
{
    use HasFactory;
    protected $fillable = [
        'tk_kode', 'tk_tp_kode', 'tk_nama'
    ];

    public function tvl_provinsi(): BelongsTo
    {
        return $this->belongsTo(tvl_provinsi::class, 'tk_tp_kode', 'tp_kode');
    }
}
