<?php

namespace App\Http\Controllers;

use App\Models\tvl_transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransportController extends Controller
{
    //
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

        //find objek tujuan by tb_kode
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
            'tt_kota_asal' => 'required',
            'tt_kota_tujuan' => 'required',
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

            $resp = DB::table("tvl_transports")
                ->where("tt_kota_asal", $request->input("tt_kota_asal"))
                ->where("tt_kota_tujuan", $request->input("tt_kota_tujuan"))
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
