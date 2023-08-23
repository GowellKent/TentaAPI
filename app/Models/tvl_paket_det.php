<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvl_paket_det extends Model
{
    use HasFactory;
    protected $primaryKey = 'tpd_kode';
    protected $fillable = ['tpd_kode', 'tpd_tph_kode', 'tpd_tot_kode', 'tpd_hari', 'tpd_jam'];

}
