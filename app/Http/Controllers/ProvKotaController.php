<?php

namespace App\Http\Controllers;

use App\Models\tvl_kota;
use App\Models\tvl_provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProvKotaController extends Controller
{
    //
    public function allProv(){
        return tvl_provinsi::all();
    }

    public function kotaByProv(Request $request){

        $validate = Validator::make($request->all(), [
            'id_provinsi' => 'required'
        ]);
        
        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        
        $provinsi = $request->input('id_provinsi');
        
        return tvl_provinsi::find($provinsi)->tvl_kota;

    }
}
