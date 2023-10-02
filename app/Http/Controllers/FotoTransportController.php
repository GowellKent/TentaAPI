<?php

namespace App\Http\Controllers;

use App\Models\tvl_foto_transport;
use App\Models\tvl_transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FotoTransportController extends Controller
{
    //

    public function fotoPage(Request $request){
        
        $validate = Validator::make($request->all(), [
            'tt_kode' => 'required'
        ]);
        
        //response error validation
        if ($validate->fails()) {
            return back();
        }

        $transport = $request->input('tt_kode');

        $path = DB::table('tvl_foto_transports')
        ->where('tft_tt_kode', $transport)
        ->get();

        $response = tvl_transport::find($transport);

        return view('transportasi.foto',['response'=>$response, 'title'=>'Foto Transportasi', 'path' => $path]);
    }

    public function fileUpload(Request $req){
        // $req->validate([
        // 'file' => 'required|mimes:csv|max:2048'
        // ]);

        $validate = Validator::make($req->all(), [
            'file' => 'required|mimes:png,jpg,jpeg,svg|max:2048',
            'tft_tt_kode' => 'required'
        ]);
        
        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $fileModel = new tvl_foto_transport();
        // if($req->file()) {
            $fileName = time().'_'.$req->file->getClientOriginalName();
            // $filePath = $req->file('file')->storeAs('fotoTransport', $fileName, 'public');
            $req->file('file')->move(public_path('fotoTransport'), $fileName);

            // $fileModel->tft_tt_kode = time().'_'.$req->file->getClientOriginalName();
            $fileModel->tft_tt_kode = $req->input('tft_tt_kode');
            $fileModel->tft_path = 'fotoTransport/' . $fileName;
            $fileModel->save();

            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        // }
    }

    public function delFoto(Request $request){

        $validate = Validator::make($request->all(), [
            'tft_kode' => 'required'
        ]);
        
        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        // $file = tvl_foto_transport::find($request->input('tft_kode'))->first();

        $file = DB::table('tvl_foto_transports')
        ->where('tft_kode', $request->input('tft_kode'))
        ->limit(1)
        ->get()->all();

        $fileName = $file[0]->tft_path;

        if(File::exists($fileName)){

            File::delete($fileName);

            // tvl_foto_transport::find($request->input('tft_kode'))->limit(1)->delete();

            $foto = DB::table('tvl_foto_transports')
            ->where('tft_kode', $request->input('tft_kode'))
            ->limit(1)
            ->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'File Deleted',

            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'File Failed  to Delete',
            'path' => $fileName

        ], 400);
    }

    public function findFoto(Request $request){
        $validate = Validator::make($request->all(), [
            'tft_tt_kode' => 'required'
        ]);
        
        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $transport = $request->input('tft_tt_kode');

        return tvl_transport::find($transport)->fotos;
    }

    public function listFotoPage(Request $request){
        
        $validate = Validator::make($request->all(), [
            'tt_kode' => 'required'
        ]);
        
        //response error validation
        if ($validate->fails()) {
            return back();
        }

        $transport = $request->input('tt_kode');

        $list = DB::table('tvl_foto_transports')
        ->join('tvl_transports', 'tft_tt_kode', '=', 'tt_kode')
        ->where('tft_tt_kode', $transport)
        ->get();

        $titleStr = 'List Foto ...';
        if(count($list->all()) > 0){
            $titleStr = 'List Foto '.$list[0]->tt_nama;
        }
        

        return view('transportasi.listfoto', ['title' => $titleStr, 'response' => $list, 'kode' => $transport]);
    }
}