<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class tvl_foto_transport extends Model
{
    use HasFactory;
    protected $primaryKey = 'tft_kode';
    protected $fillable = [
        'tft_kode', 'tft_tt_kode', 'tft_path'
    ];

    public function transport(): BelongsTo
    {
        return $this->belongsTo(tvl_transport::class, 'tt_kode', 'tft_tt_kode');
    }
}
