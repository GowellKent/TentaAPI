<?php

namespace App\Http\Controllers;

use App\Models\tvl_jenis_objek;
use App\Models\tvl_objek_tujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ObjekController extends Controller
{
    //
    function getAll(){
        return tvl_objek_tujuan::all(); 
    }

    function jenis(){
        return tvl_jenis_objek::all();
    }

    function find(Request $request){
        $validate = Validator::make($request->all(), [
            'tot_kode' => 'required'
        ]);
        
        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        
        $tot_kode = $request->input('tot_kode');

        $resp = tvl_objek_tujuan::find($tot_kode);
        $resp['foto'] = tvl_objek_tujuan::find($tot_kode)->fotos;

        if(count($resp->all()) > 0){
            return $resp;
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Objek Tujuan Data Not Found',
            ], 404);
        }
    }

    function findByLoc(Request $request){
        $validate = Validator::make($request->all(), [
            'tot_tp_kode' => 'required',
            'tot_tk_kode' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $kota = $request->input('tot_tk_kode');
        $provinsi = $request->input('tot_tp_kode');

        $resp = DB::table('tvl_objek_tujuans')
            ->join("tvl_provinsis", "tot_tp_kode", "=", "tp_kode")
            ->join("tvl_kotas", "tot_tk_kode", "=", "tk_kode")
            ->where('tot_tk_kode', $kota)
            ->orWhere('tot_tp_kode', $provinsi)
            ->get();

        if(count($resp->all()) > 0){
            return $resp;
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Objek Tujuan Not Found',
            ], 404);
        }

    }

    function store(Request $request){
        $validate = Validator::make($request->all(), [
            'tot_nama' => 'required',
            'tot_telp' => 'required',
            'tot_alamat' => 'required',
            'tot_tjo_kode' => 'required',
            'tot_tp_kode' => 'required',
            'tot_tk_kode' => 'required',
            'tot_harga' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        // $data = array_keys((array)$request->input());
        $resp = DB::table("tvl_objek_tujuans")->max('tot_kode') + 1 ;

        $data = array();
        foreach (array_keys((array)$request->input()) as $value) {
            $data[$value] = $request->input($value);
            $data['tot_kode'] = $resp;
        }


        //save to DB
        $Objek = tvl_objek_tujuan::create($data);

        if ($Objek) {

            return response()->json([
                'success' => true,
                'message' => 'Data Objek Created',
                'data'    => $data
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Objek Tujuan Failed to Save',
        ], 409);
    }

    function update(Request $request, tvl_objek_tujuan $objek){
        $tot_kode = $request->input('tot_kode');

        $validate = Validator::make($request->all(), [
            'tot_kode' => 'required'
        ]);

        // response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        //find objek tujuan by tb_kode
        $objek = tvl_objek_tujuan::where('tot_kode', $tot_kode)->firstOrFail();

        //save to DB

        if ($objek) {

            $data = array();
            foreach (array_keys((array)$request->input()) as $value) {
                $data[$value] = $request->input($value);
            }

            $objek = DB::table("tvl_objek_tujuans")
                ->where('tot_kode', $tot_kode)
                ->limit(1)
                ->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Objek Tujuan Data Updated',
                'data'    => $request->input()
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Objek Tujuan Data Failed to Update',
            'data' => $request->input()
        ], 409);
    }

    function delete(Request $request, tvl_jenis_objek $objek){
        $tot_kode = $request->input('tot_kode');

        $validate = Validator::make($request->all(), [
            'tot_kode' => 'required'
        ]);

        // response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        //find objek tujuan by tot_kode
        $objek = tvl_objek_tujuan::where('tot_kode', $tot_kode)->firstOrFail();

        //save to DB

        if ($objek) {

            $objek =    DB::table("tvl_objek_tujuans")
                ->where('tot_kode', $tot_kode)
                ->limit(1)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Objek Tujuan Data Deleted',
                'data'    => $objek
            ], 201);
        } else {
            //failed save to database
            return response()->json([
                'success' => false,
                'message' => 'Objek Tujuan Data Failed to delete',
            ], 409);
        }
    }
}
