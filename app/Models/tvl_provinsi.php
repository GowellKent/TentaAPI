<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class tvl_provinsi extends Model
{
    use HasFactory;
    protected $primaryKey = 'tp_kode';
    protected $fillable = [
        'tp_kode', 'tp_nama'
    ];

    public function tvl_kota(): HasMany
    {
        return $this->hasMany(tvl_kota::class, 'tk_tp_kode', 'tp_kode');
    }
}
