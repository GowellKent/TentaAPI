<?php

namespace App\Http\Controllers;

use App\Models\tvl_kota;
use App\Models\tvl_provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvKotaController extends Controller
{
    //
    public function allProv(){
        return tvl_provinsi::all();
    }

    public function kotaByProv(Request $request){
        $provinsi = $request->input('tk_tp_kode');
        
        $kota = tvl_provinsi::find($provinsi)->tvl_kota;

        return $kota;
    }
}
