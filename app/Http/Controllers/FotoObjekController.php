<?php

namespace App\Http\Controllers;

use App\Models\tvl_foto_objek;
use App\Models\tvl_objek_tujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class FotoObjekController extends Controller
{
    //


    public function fotoPage(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'tot_kode' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return back();
        }

        $objek = $request->input('tot_kode');

        $path = DB::table('tvl_foto_objeks')
            ->where('tfo_tot_kode', $objek)
            ->get();

        $response = tvl_objek_tujuan::find($objek);

        return view('objek.foto', ['response' => $response, 'title' => 'Foto Objek Wisata', 'path' => $path]);
    }

    public function fileUpload(Request $req)
    {
        // $req->validate([
        // 'file' => 'required|mimes:csv|max:2048'
        // ]);

        $validate = Validator::make($req->all(), [
            'file' => 'required|mimes:png,jpg,jpeg,svg|max:2048',
            'tfo_tot_kode' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $fileModel = new tvl_foto_objek();
        // if($req->file()) {
        $fileName = time() . '_' . $req->file->getClientOriginalName();
        // $filePath = $req->file('file')->storeAs('fotoTransport', $fileName, 'public');
        $req->file('file')->move(public_path('fotoObjek'), $fileName);

        // $fileModel->tft_tt_kode = time().'_'.$req->file->getClientOriginalName();
        $fileModel->tfo_tot_kode = $req->input('tfo_tot_kode');
        $fileModel->tfo_path = 'fotoObjek/' . $fileName;
        $fileModel->save();

        return back()
            ->with('success', 'File has been uploaded.')
            ->with('file', $fileName);
        // }
    }

    public function delFoto(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'tfo_kode' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        // $file = tvl_foto_objek::find($request->input('tfo_kode'))->first();

        $file = DB::table('tvl_foto_objeks')
            ->where('tfo_kode', $request->input('tfo_kode'))
            ->limit(1)
            ->get()->all();


        $fileName = $file[0]->tfo_path;

        if (File::exists($fileName)) {

            File::delete($fileName);

            // tvl_foto_objek::find($request->input('tfo_kode'))->limit(1)->delete();
            $foto = DB::table('tvl_foto_objeks')
                ->where('tfo_kode', $request->input('tfo_kode'))
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

    public function findFoto(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'tfo_tot_kode' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $objek = $request->input('tfo_tot_kode');

        return tvl_objek_tujuan::find($objek)->fotos;
    }

    public function listFotoPage(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'tot_kode' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return back();
        }

        $objek = $request->input('tot_kode');

        $list = DB::table('tvl_foto_objeks')
            ->join('tvl_objek_tujuans', 'tfo_tot_kode', '=', 'tot_kode')
            ->where('tfo_tot_kode', $objek)
            ->get();

        $titleStr = 'List Foto ...';
        if (count($list->all()) > 0) {
            $titleStr = 'List Foto ' . $list[0]->tot_nama;
        }

        return view('objek.listfoto', ['title' => $titleStr, 'response' => $list, 'kode' => $objek]);
    }
}
