<?php

namespace App\Http\Controllers;

use App\Models\tvl_jenis_trip;
use App\Models\tvl_paket_det;
use App\Models\tvl_paket_head;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class PaketController extends Controller
{
    // ==================================================================================================================================
    //paket head functions
    // ==================================================================================================================================
    public function getAllHead(){
        return tvl_paket_head::all();
    }

    public function jenis(){
        return tvl_jenis_trip::all();
    }

    public function findHead(Request $request){
        $validate = Validator::make($request->all(), [
            'tph_kode' => 'required'
        ]);
        
        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        
        $tph_kode = $request->input('tph_kode');

        $resp = tvl_paket_head::find($tph_kode);
        
        $resp['det'] = DB::table('tvl_paket_dets')
            ->select("tpd_kode", "tot_kode", "tot_nama", "tot_alamat", "tot_kota", "tot_provinsi", "tot_tjo_kode", "tjo_desc", "tot_harga", "tot_foto", "tpd_hari", "tpd_jam")
            ->join('tvl_objek_tujuans', 'tpd_tot_kode', '=', 'tot_kode')
            ->join('tvl_jenis_objeks', 'tot_tjo_kode', '=', 'tjo_kode')
            ->where('tpd_tph_kode',  $tph_kode)
            ->orderBy('tpd_hari', 'asc')
            ->orderBy('tpd_jam', 'asc')
            ->get();

        if(count($resp->all()) > 0){
            return $resp;
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Paket Data Not Found',
            ], 404);
        }
    }

    public function searchHead(Request $request){
        $validate = Validator::make($request->all(), [
            'tph_kota_asal' => 'required',
            'tph_kota_tujuan' => 'required',
            'tph_tjt_kode' => 'required'
        ]);
        
        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        
        $kota_asal = $request->input("tph_kota_asal");
        $kota_tujuan = $request->input("tph_kota_tujuan");
        $tjt_kode = $request->input("tph_tjt_kode");

        $resp = DB::table("tvl_paket_heads")
        ->select("tph_kode", "tph_nama", "tph_harga", "tph_durasi", "tph_min_pax", "tph_max_pax")
        ->where("tph_kota_asal", $kota_asal)
        ->where("tph_kota_tujuan", $kota_tujuan)
        ->where("tph_tjt_kode", $tjt_kode)
        ->get();
   
        if(count($resp->all()) > 0){
            return $resp;
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Paket Data Not Found',
            ], 404);
        }
    }

    public function storeHead(Request $request){
        $validate = Validator::make($request->all(), [
            'tph_tjt_kode' => 'required',
            'tph_nama' => 'required',
            'tph_durasi' => 'required',
            'tph_provinsi_asal' => 'required',
            'tph_kota_asal' => 'required',
            'tph_provinsi_tujuan' => 'required',
            'tph_kota_tujuan' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        // $data = array_keys((array)$request->input());
        $tph_kode = DB::table("tvl_paket_heads")->max('tph_kode') + 1;

        $data = array();
        foreach (array_keys((array)$request->input()) as $value) {
            $data[$value] = $request->input($value);
            $data['tph_kode'] = $tph_kode;
            $data['tph_harga'] = 0;
        }


        //save to DB
        $paketHead = tvl_paket_head::create($data);

        if ($paketHead) {

            return response()->json([
                'success' => true,
                'message' => 'Paket Created',
                'data'    => $data
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Paket Failed to Save',
        ], 409);
    }

    public function deleteHead(Request $request, tvl_paket_head $head){
        
        $tph_kode = $request->input('tph_kode');

        $validate = Validator::make($request->all(), [
            'tph_kode' => 'required'
        ]);

        // response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        //find paket tujuan by tph_kode
        $head = tvl_paket_head::where('tph_kode', $tph_kode)->firstOrFail();
        // $det = tvl_paket_det::where("tpd_tph_kode", $tph_kode);

        //save to DB

        if ($head) {

            $head =    DB::table("tvl_paket_heads")
                ->where('tph_kode', $tph_kode)
                ->limit(1)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'paket tujuan Deleted',
                'data'    => $head
            ], 201);
        } else {
            //failed save to database
            return response()->json([
                'success' => false,
                'message' => 'paket Tujuan Failed to delete',
            ], 409);
        }
    }

    public function updateHead(Request $request, tvl_paket_head $head){
        $tph_kode = $request->input('tph_kode');

        $validate = Validator::make($request->all(), [
            'tph_kode' => 'required'
        ]);

        // response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        //find paket tujuan by tph_kode
        $head = tvl_paket_head::where('tph_kode', $tph_kode)->firstOrFail();

        //save to DB

        if ($head) {

            $data = array();
            foreach (array_keys((array)$request->input()) as $value) {
                $data[$value] = $request->input($value);
            }

            $head =    DB::table("tvl_paket_heads")
                ->where('tph_kode', $tph_kode)
                ->limit(1)
                ->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Paket Updated',
                'data'    => $request->input()
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Paket Failed to Update',
            'data' => $request->input()
        ], 409);

    }

    // ===================================================================================================================================
    // Detail Controller functions
    // ===================================================================================================================================

    public function getAllDet(){
        return tvl_paket_det::all();
    }

    public function findDet(Request $request){
        $validate = Validator::make($request->all(), [
            'tpd_tph_kode' => 'required',
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        
        $resp = DB::table('tvl_paket_dets')
            ->select("tpd_kode", "tot_kode", "tot_nama", "tot_alamat", "tk_nama", "tp_nama", "tot_tjo_kode", "tjo_desc", "tot_harga", "tot_foto", "tpd_hari", "tpd_jam")
            ->join('tvl_objek_tujuans','tpd_tot_kode', '=', 'tot_kode')
            ->join('tvl_jenis_objeks', 'tot_tjo_kode', '=', 'tjo_kode')
            ->join('tvl_kotas', 'tot_tk_kode', '=', 'tk_kode')
            ->join('tvl_provinsis', 'tot_tp_kode', '=', 'tp_kode')
            ->where('tpd_tph_kode', $request->input("tpd_tph_kode"))
            ->get();

            if(count($resp->all()) > 0){
                return $resp;
            }
            else{
                return response()->json([
                  ], 200);
            }
    }
    
    public function storeDet(Request $request){
        $validate = Validator::make($request->all(), [
            'tpd_tph_kode' => 'required',
            'tpd_tot_kode' => 'required',
            'tpd_hari' => 'required',
            'tpd_jam' => 'required',
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        // $data = array_keys((array)$request->input());
        $resp = DB::table("tvl_paket_dets")->max('tpd_kode') + 1 ;

        $data = array();
        foreach (array_keys((array)$request->input()) as $value) {
            $data[$value] = $request->input($value);
            $data['tpd_kode'] = $resp;
        }
        

        //save to DB
        $paketDet = tvl_paket_det::create($data);

        if ($paketDet) {
            $tph_kode = $request->input('tpd_tph_kode');
            $hargaAwal = DB::table("tvl_paket_heads")->select("tph_harga")->where("tph_kode", $tph_kode)->get();
            $hargaObjek= DB::table("tvl_objek_tujuans")->select("tot_harga")->where("tot_kode",  $request->input("tpd_tot_kode"))->get();

            $hargaUpd = (int)$hargaAwal[0]->tph_harga + $hargaObjek[0]->tot_harga;

            $paket =    DB::table("tvl_paket_heads")
                ->where('tph_kode', $tph_kode)
                ->limit(1)
                ->update(array("tph_harga" => $hargaUpd));

            if($paket){
                return response()->json([
                    'success' => true,
                    'message' => 'Detail Paket Created',
                    'data'    => $data
                ], 201);
            }
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Detail Paket Failed to Save',
        ], 409);
    }

    public function updateDet(Request $request, tvl_paket_det $det){
        
        $tpd_kode = $request->input('tpd_kode');

        $validate = Validator::make($request->all(), [
            'tpd_kode' => 'required'
        ]);

        // response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        //find Detail Paket by tpd_kode
        $det = tvl_paket_det::where('tpd_kode', $tpd_kode)->firstOrFail();

        //save to DB

        if ($det) {

            $data = array();
            foreach (array_keys((array)$request->input()) as $value) {
                $data[$value] = $request->input($value);
            }

            $det = DB::table("tvl_paket_dets")
                ->where('tpd_kode', $tpd_kode)
                ->limit(1)
                ->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Detail Paket Updated',
                'data'    => $request->input()
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Detail Paket Failed to Update',
            'data' => $request->input()
        ], 409);
    }

    public function deleteDet(Request $request, tvl_paket_det $det){
        $tpd_kode = $request->input('tpd_kode');

        $validate = Validator::make($request->all(), [
            'tpd_kode' => 'required'
        ]);

        // response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        //find Detail Paket by tpd_kode
        $det = tvl_paket_det::where('tpd_kode', $tpd_kode)->firstOrFail();
        $detail = DB::table("tvl_paket_dets")->select("tpd_tph_kode", "tpd_tot_kode")->where("tpd_kode", $tpd_kode)->get();
        //save to DB

        if ($det) {

            // $tph_kode = $request->input('tpd_tph_kode');
            $hargaAwal = DB::table("tvl_paket_heads")->select("tph_harga")->where("tph_kode", $detail[0]->tpd_tph_kode)->get();
            $hargaObjek= DB::table("tvl_objek_tujuans")->select("tot_harga")->where("tot_kode",  $detail[0]->tpd_tot_kode)->get();

            $hargaUpd = (int)$hargaAwal[0]->tph_harga - $hargaObjek[0]->tot_harga;

            $det =    DB::table("tvl_paket_heads")
                ->where('tph_kode', $detail[0]->tpd_tph_kode)
                ->limit(1)
                ->update(array("tph_harga" => $hargaUpd));

            $det =    DB::table("tvl_paket_dets")
                ->where('tpd_kode', $tpd_kode)
                ->limit(1)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Detail Paket Deleted',
                'data'    => $det
            ], 201);
        } else {
            //failed save to database
            return response()->json([
                'success' => false,
                'message' => 'Detail Paket Failed to delete',
            ], 409);
        }
    }
}
