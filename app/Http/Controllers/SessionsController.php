<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use mysqli;
use PDO;

class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    public function store()
    {
        // $pdo = (new PDO("mysql:host=127.0.0.1;dbname=tugas_akhir_6684", "root", ""))->setAttribute(PDO::ATTR_TIMEOUT, 30);
        // $mysqli = (new mysqli("127.0.0.1", "root", "", "tugas_akhir_6684"))->options(MYSQLI_OPT_CONNECT_TIMEOUT, 60);

        $attributes = request()->validate([
            'username'=>'required',
            'password'=>'required'
        ],[
            'username.required'=> 'Wajib mengisi username Anda.',
            'password.required'=> 'Wajib mengisi password Anda.',
        ]);

        $dbase = DB::table('users')
            ->whereRaw("username = '".$attributes['username']."'")
            ->get(['password','role','status']);
        if(count($dbase) == 0) return back()->withInput(['username' => $attributes['username']])
            ->withErrors(['password'=>'Akun Anda Tidak Terdaftar.']);
        else{
            if($dbase[0]->status == 0) return back()->withErrors(['password' => 'Akun Anda dinon-aktifkan.']);
            else if(Auth::attempt($attributes)){//$dbase[0]->password ==  Hash::make($attributes['password'])
                session()->regenerate();// &&

                $updated = DB::table('users')
                    ->where('username','=',$attributes['username'])
                    ->update(['updated_at' => date('Y-m-d')]);
                if($dbase[0]->status == 1){
                    if($dbase[0]->role == 1) return redirect('berita-aggregator/grafik'); //admin, dashboard->with(['success'=>'You are logged in.'])
                    else return redirect('berita/semua'); //penggemar//penjual
                }
            }
            // dd(Hash::check($attributes['password'],$dbase[0]->password));
            else return back()->withInput(['username' => $attributes['username']
                ])->withErrors(['password'=>'Username atau password tidak benar.']);
        }
        // print($dbase[0]->role."---".$dbase[0]->status);
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/login');//->with(['success'=>'You\'ve been logged out.']);
    }
}
