<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        $record = User::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("MONTH(created_at) as day"))
    // ->where('created_at', '>', Carbon::today()->subDay(6))
    ->groupBy('month_name','day')
    ->orderBy('day')
    ->get();
  
     $data = [];
 
     foreach($record as $row) {
        $data['label'][] = $row->month_name;
        $data['data'][] = (int) $row->count;
      }
 
    $data['chart_data'] = json_encode($data);
    return view('dashboard', $data)->with('title', 'Dashboard');
    }

    public function customer(){
        $resp = DB::table("users")
        ->where('role', '0')
        ->get();
        return view('customer.index', ['response'=>$resp, 'title'=>'Customers']);
    }

}
