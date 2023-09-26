<?php

namespace App\Http\Controllers;

use App\Models\tvl_reservasi_det;
use App\Models\tvl_reservasi_head;
use App\Models\tvl_status_reservasi;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
    
    public function searchByUser(Request $request){
        $validate = Validator::make($request->all(), [
            'trh_tu_kode' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $dataHead = DB::table("tvl_reservasi_heads")
            ->select(
                "trh_kode",
                "trh_tgl_reservasi",
                "trh_tgl_jalan",
                "trh_harga",
                "trh_pax",
                "trh_durasi",
                "name",
                "whatsapp",
                "tph_nama",
                "tsr_desc",
                "tt_nama"
            )
            ->join("tvl_paket_heads", "trh_tph_kode", "=", "tph_kode")
            ->join("users", "trh_tu_kode", "=", "id")
            ->join("tvl_status_reservasis", "trh_tsr_kode", "=", "tsr_kode")
            ->join("tvl_transportasis", "trh_tt_kode", "=", "tt_kode")
            ->where("trh_tu_kode", $request->input('trh_tu_kode'))
            ->get();

        if (count($dataHead->all()) > 0) {
            if (count($dataHead->all()) == 1) {

                $dataDetail = DB::table("tvl_reservasi_dets")
                    ->select("trd_kode", "tot_kode", "tot_nama as nama", "tot_alamat as alamat", "tot_kota as kota", "tot_provinsi as provinsi")
                    ->join("tvl_objek_tujuans", "trd_tot_kode", "=", "tot_kode")
                    ->where("trd_trh_kode", $dataHead[0]->trh_kode)
                    ->get();

                return response()->json([$dataHead, $dataDetail], 200);
            }

            // $responseData = array();
            foreach ($dataHead->all() as $idx) {

                $dataDetail = DB::table("tvl_reservasi_dets")
                    ->select("trd_kode", "tot_kode", "tot_nama as nama", "tot_alamat as alamat", "tot_kota as kota", "tot_provinsi as provinsi")
                    ->join("tvl_objek_tujuans", "trd_tot_kode", "=", "tot_kode")
                    ->where("trd_trh_kode", $idx->trh_kode)
                    ->get();

                // $detailResp = array();
                // foreach($dataDetail->all() as $idz){
                //     $detailResp[] = $idz;
                // }

                $idx->detail = $dataDetail;

                $responseData[] = $idx;
            }
            return  $responseData;
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi Not Found',
            ], 404);
        }
    }

    function customRes(Request $request)
    {

        //get max value of primary key for sequencing
        $trh_kode = DB::table("tvl_reservasi_heads")->max('trh_kode') + 1;

        $insertHead = array();

        foreach (array_keys((array)$request->input()) as $value) {

            $insertHead['trh_kode'] = $trh_kode;
            $insertHead['trh_durasi'] = $request->input('trh_durasi');
            $insertHead['trh_provinsi_asal'] = $request->input('trh_provinsi_asal');
            $insertHead['trh_kota_asal'] = $request->input('trh_kota_asal');
            $insertHead['trh_provinsi_tujuan'] = $request->input('trh_provinsi_tujuan');
            $insertHead['trh_kota_tujuan'] = $request->input('trh_kota_tujuan');
            $insertHead['trh_tb_kode_brk'] = $request->input('trh_tb_kode_brk');
            $insertHead['trh_tb_kode_pul'] = $request->input('trh_tb_kode_pul');
            $insertHead['trh_tu_kode'] = $request->input('trh_tu_kode');
            $insertHead['trh_tph_kode'] = 17;
            $insertHead['trh_pax'] = $request->input('trh_pax');
            $insertHead['trh_tgl_jalan'] = DateTime::createFromFormat('Y-m-d', $request->input('trh_tgl_jalan'));
            $insertHead['trh_tgl_reservasi'] = Carbon::now()->format('Y-m-d');
            $insertHead['trh_tsr_kode'] = 2;
        }

        foreach (array_keys((array)$request->input('trd_tot_kode')) as $kode) {
            // var_dump($request->input('trd_tot_kode')[$kode][1]);
        }
        //     // var_dump($kode);

        //     $objek = tvl_objek_tujuan::where('tot_kode', $kode)->first();
        // }
        // if ($objek) {

        $hargaBusBrk = DB::table("tvl_buses")->select("tb_harga")->where("tb_kode", $request->input('trh_tb_kode_brk'))->get();
        $hargaBusPul = DB::table("tvl_buses")->select("tb_harga")->where("tb_kode", $request->input('trh_tb_kode_pul'))->get();
        if ($hargaBusBrk && $hargaBusPul) {
            $insertHead["trh_harga"] = (int)($hargaBusBrk[0]->tb_harga + $hargaBusPul[0]->tb_harga);
        }

        $reservasi = tvl_reservasi_head::create($insertHead);

        if ($reservasi) {

            $trd_kode = DB::table("tvl_reservasi_dets")->max('trd_kode') + 1;
            $dataDetail = array();
            $i = 0;
            var_dump($request->input('trd_tot_kode'));
            foreach (array_keys($request->input('trd_tot_kode')) as $kode) {

                var_dump($kode);
                $dataDetail['trd_tot_kode'] = $kode;
                $dataDetail['trd_hari'] = $request->input('trd_tot_kode')[$kode][0];
                $dataDetail['trd_jam'] = $request->input('trd_tot_kode')[$kode][1];
                $dataDetail['trd_kode'] = $trd_kode + $i;
                $dataDetail['trd_trh_kode'] = $trh_kode;

                $resDet = tvl_reservasi_det::create($dataDetail);
                var_dump($resDet);
                if ($resDet) {
                    $hargaAwal = DB::table("tvl_reservasi_heads")->select("trh_harga")->where("trh_kode", $trh_kode)->get();
                    $hargaObjek = DB::table("tvl_objek_tujuans")->select("tot_harga")->where("tot_kode", $kode)->get();

                    $hargaUpdate = (int)$hargaAwal[0]->trh_harga + $hargaObjek[0]->tot_harga;

                    $hargaBaru =    DB::table("tvl_reservasi_heads")
                        ->where('trh_kode', $trh_kode)
                        ->limit(1)
                        ->update(array("trh_harga" => $hargaUpdate));
                }

                $i++;
            }
            $newDataRes = DB::table("tvl_reservasi_heads")->where("trh_kode", $trh_kode)->get();
    
            return response()->json([
                'success' => true,
                'message' => 'Reservasi Created',
                'data' => $newDataRes
            ], 201);
        }
        // if ($reservasi && $resDet) {

        // }
        // }


        return response()->json([
            'success' => false,
            'message' => 'Reservasi Gagal'
        ], 409);
    }

    function addDataDet(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'trd_trh_kode' => 'required',
            'trd_tot_kode' => 'required',
            'trd_hari' => 'required',
            'trd_jam' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        // $data = array_keys((array)$request->input());
        $resp = DB::table("tvl_reservasi_dets")->max('trd_kode') + 1;

        $data = array();
        foreach (array_keys((array)$request->input()) as $value) {
            $data[$value] = $request->input($value);
            // $data['trd_kode'] = 0;   
        }

        //save to DB
        $paketDet = tvl_reservasi_det::create($data);

        if ($paketDet) {
            $trh_kode = $request->input('trd_trh_kode');
            $hargaAwal = DB::table("tvl_reservasi_heads")->select("trh_harga")->where("trh_kode", $trh_kode)->get();
            $hargaObjek = DB::table("tvl_objek_tujuans")->select("tot_harga")->where("tot_kode",  $request->input("trd_tot_kode"))->get();

            $hargaUpd = (int)$hargaAwal[0]->trh_harga + $hargaObjek[0]->tot_harga;

            $paket =    DB::table("tvl_reservasi_heads")
                ->where('trh_kode', $trh_kode)
                ->limit(1)
                ->update(array("trh_harga" => $hargaUpd));

            return response()->json([
                'success' => true,
                'message' => 'Reservasi Created',
                'data'    => $request->input()
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Reservasi Failed to Save',
        ], 409);
    }

    function addMultiDataDet(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'trd_trh_kode' => 'required',
            'trd_tot_kode' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        // $data = array_keys((array)$request->input());
        $resp = DB::table("tvl_reservasi_dets")->max('trd_kode') + 1;

        $data = array();
        $tot_kode = explode(';', $request->input("trd_tot_kode"));
        // var_dump($tot_kode);
        foreach ($tot_kode as $value) {
            $record = Str::remove(['[', ']'], $value);
            $items = explode(',', $record);
            
            var_dump($items);

            $temp = Str::swap(["\""=>""], $items[2]);
            $dateStr = (string)'01/01/1999 '.$temp;

            $timeString = Carbon::createFromFormat('d/m/Y H:i:s', $dateStr)->format('H:i:s');

            var_dump($timeString);
            
            $data['trd_trh_kode'] = $request->input('trd_trh_kode');
            $data['trd_kode'] = $resp;
            $data['trd_tot_kode'] = $items[0];
            $data['trd_hari'] = $items[1];
            $data['trd_jam'] = (int)$timeString;

            $paketDet = tvl_reservasi_det::create($data);
            $resp += 1;

            if ($paketDet) {
                $trh_kode = $request->input('trd_trh_kode');
                $hargaAwal = DB::table("tvl_reservasi_heads")->select("trh_harga")->where("trh_kode", $trh_kode)->get();
                $hargaObjek = DB::table("tvl_objek_tujuans")->select("tot_harga")->where("tot_kode",  $value)->get();

                $hargaUpd = (int)$hargaAwal[0]->trh_harga + $hargaObjek[0]->tot_harga;

                $paket =    DB::table("tvl_reservasi_heads")
                    ->where('trh_kode', $trh_kode)
                    ->limit(1)
                    ->update(array("trh_harga" => $hargaUpd));
            }
        }


        //save to DB

        if ($paketDet) {


            return response()->json([
                'success' => true,
                'message' => 'Detail Reservasi Added',
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Reservasi Failed to Save',
        ], 409);
    }


    //===================================================================================================================================
    // VIEW FUNCTIONS
    //===================================================================================================================================

    function index(){
        $response = DB::table("tvl_reservasi_heads")
        ->select("trh_kode", "tph_nama",  "name", "trh_tgl_reservasi", "trh_tgl_jalan", "trh_pax", "tsr_desc")
        ->join("tvl_paket_heads", "trh_tph_kode", "=", "tph_kode")
        ->join("users", "trh_tu_kode", "=", "id")
        ->join("tvl_status_reservasis", "trh_tsr_kode", "=", "tsr_kode")
        ->get();

    return view('reservasi.index', ['response' => $response, 'title' => 'Reservasi']);

    }

    function resCreate(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'trh_tph_kode' => 'required',
            'trh_tu_kode' => 'required',
            'trh_tgl_jalan' => 'required',
            'trh_pax' => 'required',
            'trh_tt_kode' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return back()->withInput()->with("CRUDError", "Create Reservasi Validate Failed!");
        }

        //get max value of primary key for sequencing
        $trh_kode = DB::table("tvl_reservasi_heads")->max('trh_kode') + 1;

        $trh_tph_kode = $request->input("trh_tph_kode");
        $trh_tt_kode = $request->input('trh_tt_kode');

        $head = DB::table('tvl_paket_heads')
            ->where("tph_kode", $trh_tph_kode)
            ->get();

        $hargaTp = DB::table('tvl_transports')
            ->select("tt_harga")->where("tt_kode", $trh_tt_kode)->get();

        $hargaTotal = (int)($head[0]->tph_harga + $hargaTp[0]->tt_harga) * (int)$request->input('trh_pax');

        //get all params to data Array
        if ($head) {
            $data = array();
            foreach (array_keys((array)$request->input()) as $value) {
                $data[$value] = $request->input($value);
                $data['trh_kode'] = $trh_kode;
                $data['trh_harga'] = $hargaTotal;
                $data['trh_durasi'] = $head[0]->tph_durasi;
                $data['trh_tp_kode_asal'] = $head[0]->tph_tp_kode_asal;
                $data['trh_tk_kode_asal'] = $head[0]->tph_tk_kode_asal;
                $data['trh_tp_kode_tujuan'] = $head[0]->tph_tp_kode_tujuan;
                $data['trh_tk_kode_tujuan'] = $head[0]->tph_tk_kode_tujuan;
                $data['trh_tt_kode'] = $trh_tt_kode;
                $data['trh_tgl_reservasi'] = Carbon::now()->format('Y-m-d');
                $data['trh_tsr_kode'] = 2;
            }

            $reservasi = tvl_reservasi_head::create($data);

            if ($reservasi) {
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

                return redirect('/admin/reservasi/index');
            }
        } else {
            return back()->withInput()->with("CRUDError", "Create Reservasi Failed!");
        }



        // if ($reservasi && $reservasiDet) {

        //     // $redirectURL = (string)'/resDetail?trh_kode=' . $trh_kode;
        //     // return redirect($redirectURL);
        //     return redirect('/admin/reservasi/index');
        // }

        // //failed save to database
        // return back()->withInput()->with("CRUDError", "Create Reservasi Failed!");
    }
}
