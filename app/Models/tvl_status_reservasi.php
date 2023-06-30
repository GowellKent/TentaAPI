<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvl_status_reservasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'tsr_kode', 'tsr_desc'
    ];
}
