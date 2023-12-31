<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\tvl_reservasi_head;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //
    //fungsi register akun
    public function register(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'whatsapp' => 'required'
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'whatsapp' => 'required'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['role'] = 0; //non-Admin role

        $result = User::create($validatedData);
        // $success['token'] = $result->createToken('TentaAPI')->plainTextToken;

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Account created',
                'data' => $result
            ], 201);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Failed to create account'
            ], 409);
        }
    }

    //fungsi login API
    public function authenticate(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //response error validation
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            // $request->session()->regenerate();

            // $user = DB::table("users")->select("id", "name", "email", "whatsapp")
            //     ->where("email", $credentials['email'])
            //     ->get();
            $user = Auth::user();
            $success = $user;
            $success['token'] = $request->user()->createToken('TentaAPI')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil',
                'data' => $user
            ], 201);
        }

        return response()->json([
            'success' => False,
            'message' => 'Login Gagal'
        ], 403);
    }

    public function index(){
        return view('login.index',[
            'title' => 'Login'
        ]);
    }

    public function authweb(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = User::select('name')->where('email', $credentials['email'])->get();

            return redirect()->intended('/admin/dashboard')->with('username', $user[0]->name);
        }

        return back()->withInput()->with('loginError', 'Login Failed!');
    }

    public function users(){
        $resp = DB::table("users")->where('role', '0')
        ->get();
        return view('users.index', ['response'=>$resp, 'title'=>'Customers']);
    }

    public function logout(Request $request){

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // $request->user()->tokens()->delete();

        return redirect('/');

    }

    public function dashboard(){
        $record = tvl_reservasi_head::select(DB::raw("SUM(trh_harga) as count"), DB::raw("MONTHNAME(trh_tgl_reservasi) as month_name"), DB::raw("MONTH(trh_tgl_reservasi) as day"))
    // ->where('created_at', '>', Carbon::today()->subDay(6))
    ->where('trh_tsr_kode', 4)
    ->where(DB::raw('YEAR(trh_tgl_reservasi)'), DB::raw('YEAR(CURRENT_DATE())'))
    ->groupBy('month_name','day')
    ->orderBy('day')
    ->get();

    $pending = tvl_reservasi_head::select(DB::raw("COUNT(*) as counted"))
    ->where('trh_tsr_kode', 2)
    ->get();

    $status = tvl_reservasi_head::select('trh_tsr_kode',DB::raw("COUNT(*) as total"))
    ->groupBy('trh_tsr_kode')
    ->get();

    $totalDone = 0;
    $totalPending = 0;
    $totalCheck = 0;
    $totalCancel = 0;
    $totalTask = 0;
    
    foreach($status as $key){
        switch($key['trh_tsr_kode']){
            case 1:
            $totalCheck = $key['total'];
            break;
            case 2:
            $totalPending = $key['total'];
            break;
            case 3:
            $totalCancel = $key['total'];
            break;
            case 4:
            $totalDone = $key['total'];
            break;
        }
        $totalTask += $key['total'];
    }

    
    $tasks['check'] =  $totalCheck / $totalTask * 100;
    $tasks['pending'] =  $totalPending / $totalTask * 100;
    $tasks['cancel'] =  $totalCancel / $totalTask * 100;
    $tasks['done'] =  $totalDone / $totalTask * 100;

    $earnMonth = tvl_reservasi_head::select(DB::raw("SUM(trh_harga) as total"))
    ->where('trh_tsr_kode', '4')
    ->where(DB::raw('MONTH(trh_tgl_reservasi)'), DB::raw('MONTH(CURRENT_DATE())'))
    ->get();
   
    $earnYear = tvl_reservasi_head::select(DB::raw("SUM(trh_harga) as total"))
    ->where('trh_tsr_kode', '4')
    ->where(DB::raw('YEAR(trh_tgl_reservasi)'), DB::raw('YEAR(CURRENT_DATE())'))
    ->get();

    $earning = [];
    $earning['monthly'] = $earnMonth[0]->total;
    $earning['yearly'] = $earnYear[0]->total;

     $data = [];
 
     foreach($record as $row) {
        $data['label'][] = $row->month_name;
        $data['data'][] = (int) $row->count;
      }
 
    $data['chart_data'] = json_encode($data);
    return view('dashboard', $data)->with(['title' => 'Dashboard', 'pending' => $totalPending, 'earning' => $earning, 'tasks' => $tasks]);
    }

    public function customer(){
        $resp = DB::table("users")
        ->where('role', '0')
        ->get();
        return view('customer.index', ['response'=>$resp, 'title'=>'Customers']);
    }

}
