<?php

namespace App\Http\Controllers;

use App\Models\tvl_reservasi_det;
use App\Models\tvl_reservasi_head;
use App\Models\tvl_status_reservasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReservasiController extends Controller
{
    //
    // ==================================================================================================================================================
    // RESERVASI HEAD CONTROLER
    // ==================================================================================================================================================

    public function getAllHead(){
        return tvl_reservasi_head::all();
    }
    
    public function status(){
        return tvl_status_reservasi::all();
    }

    public function findHead(Request $request){
        $validate = Validator::make($request->all(), [
            'trh_kode' => 'required'
        ]);
        
        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        
        $trh_kode = $request->input('trh_kode');

        // $resp = tvl_reservasi_head::find($trh_kode);
        $resp =DB::table("tvl_reservasi_heads")
        ->select(
            "trh_kode", "trh_provinsi_asal", "trh_kota_asal", "trh_provinsi_tujuan", "trh_kota_tujuan", "trh_pax", "trh_durasi", "trh_harga", "trh_tgl_reservasi","trh_tgl_jalan",
            "name", "email", "whatsapp", "tph_nama", "tsr_desc","tt_nama")
        ->join("tvl_paket_heads", "trh_tph_kode", "=", "tph_kode")
        ->join("users", "trh_tu_kode", "=", "id")
        ->join("tvl_status_reservasis", "trh_tsr_kode", "=", "tsr_kode")
        ->join("tvl_transportasis", "trh_tt_kode", "=", "tt_kode")
        ->where("trh_kode", $request->input('trh_kode'))
        ->get();
        
        $resp['det'] = DB::table('tvl_reservasi_dets')
            ->select("trd_kode", "tot_kode", "tot_nama", "tot_alamat", "tot_kota", "tot_provinsi", "tot_tjo_kode", "tjo_desc", "tot_harga", "tot_foto", "trd_hari", "trd_jam")
            ->join('tvl_objek_tujuans', 'trd_tot_kode', '=', 'tot_kode')
            ->join('tvl_jenis_objeks', 'tot_tjo_kode', '=', 'tjo_kode')
            ->where('trd_trh_kode',  $trh_kode)
            ->orderBy('trd_hari', 'asc')
            ->orderBy('trd_jam', 'asc')
            ->get();

        if(count($resp->all()) > 0){
            return $resp;
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Reservasi Data Not Found',
            ], 404);
        }
    
    }

    public function storeHead(Request $request){
        $validate = Validator::make($request->all(), [
            'trh_tph_kode' => 'required',
            'trh_tu_kode' => 'required',
            'trh_tgl_jalan' => 'required',
            'trh_pax' => 'required',
            'trh_tt_kode' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        // $data = array_keys((array)$request->input());
        $trh_kode = DB::table("tvl_reservasi_heads")->max('trh_kode') + 1;
        $trh_tph_kode = $request->input('trh_tph_kode');
        $trh_tt_kode = $request->input('trh_tt_kode');

        $paket = DB::table('tvl_paket_heads')
            ->select(
                "tph_harga as trh_harga",
                "tph_durasi as trh_durasi",
                "tph_provinsi_asal as trh_provinsi_asal",
                "tph_kota_asal as trh_kota_asal",
                "tph_provinsi_tujuan as trh_provinsi_tujuan",
                "tph_kota_tujuan as trh_kota_tujuan"
            )
            ->where("tph_kode", $trh_tph_kode)
            ->get();

        $hargaTp = DB::table('tvl_transports')
            ->select("tt_harga")->where("tt_kode", $trh_tt_kode)->get();

        $hargaTotal = (int)($paket[0]->trh_harga + $hargaTp[0]->tt_harga);
        
        if($paket){
            $data = array();
            foreach (array_keys((array)$request->input()) as $value) {
                $data[$value] = $request->input($value);
                $data['trh_kode'] = $trh_kode;
                $data['trh_harga'] = $hargaTotal;
                $data['trh_durasi'] = $paket[0]->trh_durasi;
                $data['trh_provinsi_asal'] = $paket[0]->trh_provinsi_asal;
                $data['trh_kota_asal'] = $paket[0]->trh_kota_asal;
                $data['trh_provinsi_tujuan'] = $paket[0]->trh_provinsi_tujuan;
                $data['trh_kota_tujuan'] = $paket[0]->trh_kota_tujuan;
                $data['trh_tt_kode'] = $trh_tt_kode;
                $data['trh_tgl_reservasi'] = Carbon::now()->format('Y-m-d');
                $data['trh_tsr_kode'] = 2;
            }    
            //save to DB
            $resHead = tvl_reservasi_head::create($data);

            if($resHead){
                $det = DB::table("tvl_paket_dets")
                    ->select("tpd_kode as trd_tpd_kode", "tpd_tot_kode as trd_tot_kode", "tpd_hari as trd_hari", "tpd_jam as trd_jam")
                    ->where("tpd_tph_kode", $trh_tph_kode)
                    ->get()
                    ->all();

                $trd_kode = DB::table("tvl_reservasi_dets")->max('trd_kode') + 1;
                $i = 0;
                $dataDetail = array();
                foreach ($det as $dets) {
                    $dataDetail['trd_kode'] = $trd_kode + $i;
                    $dataDetail['trd_tot_kode'] = $det[$i]->trd_tot_kode;
                    $dataDetail['trd_hari'] = $det[$i]->trd_hari;
                    $dataDetail['trd_jam'] = $det[$i]->trd_jam;
                    $dataDetail['trd_trh_kode'] = $trh_kode;

                    $reservasiDet = tvl_reservasi_det::create($dataDetail);

                    $i++;
                }
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Paket Not Found',
            ], 404);
        }


        if ($resHead && $reservasiDet) {

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

    public function updateHead(Request $request, tvl_reservasi_head $head){
        $trh_kode = $request->input('trh_kode');

        $validate = Validator::make($request->all(), [
            'trh_kode' => 'required'
        ]);

        // response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        //find paket tujuan by tph_kode
        $head = tvl_reservasi_head::where('trh_kode', $trh_kode)->firstOrFail();

        //save to DB

        if ($head) {

            $data = array();
            foreach (array_keys((array)$request->input()) as $value) {
                $data[$value] = $request->input($value);
            }

            $head =    DB::table("tvl_reservasi_heads")
                ->where('trh_kode', $trh_kode)
                ->limit(1)
                ->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Reservasi Updated',
                'data'    => $request->input()
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'paket Tujuan Failed to Update',
            'data' => $request->input()
        ], 409);
    }

    public function deleteHead(Request $request, tvl_reservasi_head $head){
        $trh_kode = $request->input('trh_kode');

        $validate = Validator::make($request->all(), [
            'trh_kode' => 'required'
        ]);

        // response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        //find paket tujuan by tph_kode
        $head = tvl_reservasi_head::where('trh_kode', $trh_kode)->firstOrFail();

        //save to DB

        if ($head) {

            $head =    DB::table("tvl_reservasi_heads")
                ->where('trh_kode', $trh_kode)
                ->limit(1)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Reservasi Deleted',
                'data'    => $head
            ], 201);
        } else {
            //failed save to database
            return response()->json([
                'success' => false,
                'message' => 'Reservasi Failed to delete',
            ], 409);
        }
    }
}
