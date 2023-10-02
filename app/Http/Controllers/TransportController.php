<?php

namespace App\Http\Controllers;

use App\Models\tvl_transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransportController extends Controller
{
    //api controllers
    function getAll(){
        return tvl_transport::all();
    }

    function find(Request $request){
        
        $validate = Validator::make($request->all(), [
            'tt_kode' => 'required'
        ]);
        
        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        
        $tt_kode = $request->input('tt_kode');

        $resp = tvl_transport::find($tt_kode);
        $resp['foto'] = tvl_transport::find($tt_kode)->fotos;

        if(count($resp->all()) > 0){
            return $resp;
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Transport Data Not Found',
            ], 404);
        }
    }

    function store(Request $request){
        $validate = Validator::make($request->all(), [
            'tt_nama' => 'required',
            'tt_provinsi_asal' => 'required',
            'tt_kota_asal' => 'required',
            'tt_provinsi_tujuan' => 'required',
            'tt_kota_tujuan' => 'required',
            'tt_pax' => 'required',
            'tt_harga' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        // $data = array_keys((array)$request->input());
        $resp = DB::table("tvl_transports")->max('tt_kode') + 1 ;

        $data = array();
        foreach (array_keys((array)$request->input()) as $value) {
            $data[$value] = $request->input($value);
            $data['tt_kode'] = $resp;
        }


        //save to DB
        $bus = tvl_transport::create($data);

        if ($bus) {

            return response()->json([
                'success' => true,
                'message' => 'Data Bus Created',
                'data'    => $data
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Data Bus Failed to Save',
        ], 409);
    }

    public function update(Request $request, tvl_transport $transport){
        $tt_kode = $request->input('tt_kode');

        $validate = Validator::make($request->all(), [
            'tt_kode' => 'required'
        ]);

        // response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        //find objek tujuan by tt_kode
        $transport = tvl_transport::where('tt_kode', $tt_kode)->firstOrFail();

        //save to DB

        if ($transport) {

            $data = array();
            foreach (array_keys((array)$request->input()) as $value) {
                $data[$value] = $request->input($value);
            }

            $transport = DB::table("tvl_transports")
                ->where('tt_kode', $tt_kode)
                ->limit(1)
                ->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Transport Data Updated',
                'data'    => $request->input()
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Transport Data Failed to Update',
            'data' => $request->input()
        ], 409);
    }

    public function delete(Request $request, tvl_transport $transport){
        $tt_kode = $request->input('tt_kode');

        $validate = Validator::make($request->all(), [
            'tt_kode' => 'required'
        ]);

        // response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        //find objek tujuan by tt_kode
        $transport = tvl_transport::where('tt_kode', $tt_kode)->firstOrFail();

        //save to DB

        if ($transport) {

            $transport =    DB::table("tvl_transports")
                ->where('tt_kode', $tt_kode)
                ->limit(1)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Transport Data Deleted',
                'data'    => $transport
            ], 201);
        } else {
            //failed save to database
            return response()->json([
                'success' => false,
                'message' => 'Transport Data Failed to delete',
            ], 409);
        }
    }

    public function searchByRoute(Request $request){
        $validate = Validator::make($request->all(), [
            'tt_tk_kode_asal' => 'required',
            'tt_tk_kode_tujuan' => 'required',
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

            $resp = DB::table("tvl_transports")
                ->where("tt_tk_kode_asal", $request->input("tt_tk_kode_asal"))
                ->where("tt_tk_kode_tujuan", $request->input("tt_tk_kode_tujuan"))
                ->get();
            if (count($resp->all()) > 0) {
                return  $resp;
            } else {
            return response()->json([
                'success' => false,
                'message' => 'Transport Not Found',

            ], 404);
        }
    }


    // web controllers

    public function index(){
        $resp = DB::table("tvl_transports")
        ->select('tt_kode', 'tt_nama', 'c.tk_nama as tt_kota_asal', 'd.tk_nama as  tt_kota_tujuan', 'tt_pax', 'tt_harga')
        ->join("tvl_provinsis as a", "tt_tp_kode_asal", "=", "a.tp_kode")
        ->join("tvl_provinsis as b", "tt_tp_kode_tujuan", "=", "b.tp_kode")
        ->join("tvl_kotas as c", "tt_tk_kode_asal", "=", "c.tk_kode")
        ->join("tvl_kotas as d", "tt_tk_kode_tujuan", "=", "d.tk_kode")
        ->get();
        return view('transportasi.index',['response' => $resp, 'title'=>'Daftar Transportasi']);
    }

    public function create(Request $request){
        $validate = Validator::make($request->all(), [
            'tt_nama' => 'required',
            'tt_tp_kode_asal' => 'required',
            'tt_tk_kode_asal' => 'required',
            'tt_tp_kode_tujuan' => 'required',
            'tt_tk_kode_tujuan' => 'required',
            'tt_pax' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return back()->withInput()->with('CRUDError', 'Create Data Failed!');
        }

        // $data = array_keys((array)$request->input());
        $resp = DB::table("tvl_transports")->max('tt_kode') + 1 ;

        $data = array();
        foreach (array_keys((array)$request->input()) as $value) {
            $data[$value] = $request->input($value);
            $data['tt_kode'] = $resp;
        }


        //save to DB
        $bus = tvl_transport::create($data);

        if ($bus) {
            return redirect()->intended('/admin/transportasi/index');
        }

        //failed save to database
        return back()->withInput()->with('CRUDError', 'Create Data Failed!');
    }

    public function detail(Request $request){
        
        $validate = Validator::make($request->all(), [
            'tt_kode' => 'required'
        ]);
        
        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        
        $id = $request->input('tt_kode');

        $resp = DB::table('tvl_transports')
        ->select('tt_kode', 'tt_nama','tt_tp_kode_asal', 'tt_tp_kode_tujuan', 'tt_tk_kode_asal', 'tt_tk_kode_tujuan','a.tp_nama as tt_provinsi_asal', 'b.tp_nama as tt_provinsi_tujuan', 'c.tk_nama as tt_kota_asal', 'd.tk_nama as  tt_kota_tujuan', 'tt_pax', 'tt_harga')
        ->join("tvl_provinsis as a", "tt_tp_kode_asal", "=", "a.tp_kode")
        ->join("tvl_provinsis as b", "tt_tp_kode_tujuan", "=", "b.tp_kode")
        ->join("tvl_kotas as c", "tt_tk_kode_asal", "=", "c.tk_kode")
        ->join("tvl_kotas as d", "tt_tk_kode_tujuan", "=", "d.tk_kode")
        ->where('tt_kode', $id)
        ->get();

        $path = DB::table('tvl_foto_transports')
        ->where('tft_tt_kode', $id)
        ->get();

        if(count($resp->all()) > 0){
            return view('transportasi.detail', ['response'=>$resp, 'title'=>'Detail Transportasi', 'path' => $path]);
        }
    }

    public function updateWeb(Request $request, tvl_transport $bus){

        $tt_kode = $request->input('tt_kode');

        $validate = Validator::make($request->all(), [
            'tt_kode' => 'required'
        ]);

        // response error validation
        if ($validate->fails()) {
            return back()->withInput()->with('CRUDError', 'Update Failed!');
        }

        //find objek tujuan by tt_kode
        $bus = tvl_transport::where('tt_kode', $tt_kode)->firstOrFail();

        //save to DB

        if ($bus) {

            $data = array();
            foreach (array_keys((array)$request->except(['_token'])) as $value) {
                $data[$value] = $request->input($value);
            }

            $bus = DB::table("tvl_transports")
                ->where('tt_kode', $tt_kode)
                ->limit(1)
                ->update($data);

            // $request->session()->regenerate();
            return redirect()->intended('admin/transportasi/index');

            // return view('bus.index');
        }

        //failed save to database
        return back()->withInput()->with('CRUDError', 'Update Failed!');
    }

    public function deleteWeb(Request $request, tvl_transport $bus){
        $tt_kode = $request->input('tt_kode');

        $validate = Validator::make($request->all(), [
            'tt_kode' => 'required'
        ]);

        // response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        //find objek tujuan by tt_kode
        $bus = tvl_transport::where('tt_kode', $tt_kode)->firstOrFail();

        //save to DB

        if ($bus) {

            $bus =    DB::table("tvl_transports")
                ->where('tt_kode', $tt_kode)
                ->limit(1)
                ->delete();

                return back();
        } 

        return back();

    }

    public function searchTransport(Request $request){
        $validate = Validator::make($request->all(), [
            'tt_tk_kode_asal' => 'required',
            'tt_tk_kode_tujuan' => 'required',
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

            $resp = DB::table("tvl_transports")
                ->where("tt_tk_kode_asal", $request->input("tt_tk_kode_asal"))
                ->where("tt_tk_kode_tujuan", $request->input("tt_tk_kode_tujuan"))
                ->get();
            if (count($resp->all()) > 0) {
                return  $resp;
            } else {
            return response()->json([
                'success' => false,
                'message' => 'Transport Not Found',

            ], 404);
        }
    }
}
