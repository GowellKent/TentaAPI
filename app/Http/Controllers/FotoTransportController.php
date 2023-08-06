<?php

namespace App\Http\Controllers;

use App\Models\tvl_foto_transport;
use App\Models\tvl_transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FotoTransportController extends Controller
{
    //

    public function createForm(){
        return view('test');
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

        $file = tvl_foto_transport::find($request->input('tft_kode'))->first();

        $fileName = $file->tft_path;

        if(File::exists($fileName)){

            File::delete($fileName);

            tvl_foto_transport::find($request->input('tft_kode'))->limit(1)->delete();
            
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
}