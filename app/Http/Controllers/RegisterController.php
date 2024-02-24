<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create()
    {
        return view('session.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'username' => ['required', 'min:10', 'max:20'],
            'email' => ['required', 'email', 'max:50'], //Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:25'],
            'nama' => ['required','max:50'],
            'nomor_telepon' => ['required', 'min:10','numeric'],
            'role' => ['numeric'],
            // 'status' => ['required','numeric']
        ],[
            // 'status.required' => 'Wajib Menyetujui Syarat dan Ketentuan',
            'required' => 'Wajib mengisi seluruh data Anda untuk registrasi sebagai penggemar.',
            'username.min' => 'Panjang username kurang dari 10 karakter.',
            'username.max' => 'Panjang username lebih dari 20 karakter.',
            'email.max' => 'Panjang email lebih dari 50 karakter.',
            'email.email' => 'Wajib mengisi dalam bentuk email.',
            // 'email.rule' => 'Email Anda telah terdaftar.',
            'password.min' => 'Panjang password kurang dari 5 karakter.',
            'password.max' => 'Panjang password lebih dari 25 karakter.',
            'nama.max' => 'Panjang nama lebih dari 50 karakter.',
            'nomor_telepon.min' => 'Panjang nomor telepon kurang dari 10 karakter.',
            'nomor_telepon.numeric' => 'Nomor telepon harus berupa angka.',
        ]);
        $attributes['password'] = bcrypt($attributes['password'] );

        $search = DB::table('users')
            ->where('username','=',$attributes['username'])
            ->where('email','=',$attributes['email'])
            ->count();
        if($search == 1) return back()
            ->withInput([
                'username' => $attributes['username'],
                'email' => $attributes['email'],
                'nama' => $attributes['nama'],
                'nomor_telepon' => $attributes['nomor_telepon'],
                ])
            ->withErrors(['errornya'=> 'Username / Email Anda telah terdaftar.']);

        $user = User::create($attributes);

        // $tgl = date('d').'-';
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date("Y-m-d H:i:s");
        // $tanggal = ( (int) date('d') );
        // $jam = ( (int) date('H') )+7;
        // if($jam >= 24) {$tanggal += 1; $jam = "0".($jam - 24);}
        // elseif($jam < 10) {$jam = "0".$jam;}
        // if($tanggal < 10) $tgl = date("Y-m")."-0".$tanggal.' '.$jam.date(':i:s');
        // else if ($tanggal < 32) $tgl = date("Y-m-").$tanggal.' '.$jam.date(':i:s');

        $akunBaru = DB::table('users')->where('username','=',$attributes['username'])->get('id');
        $koin = DB::table('deposito_koin')
            ->join('users', 'users.id', '=', 'deposito_koin.user_id')
            ->whereRaw("users.id = $akunBaru[0]->id")
            ->get();
        if(count($akunBaru) == 1 && count($koin) == 0){
            $koin = DB::table('deposito_koin')
            ->insert([
                'koin' => 0,
                'user_id' => $akunBaru[0]->id,
                'tanggal_update' => $tgl,//getTanggal(),
                'status' => 1
            ]);
        }// session()->flash('success', 'Akun Anda Berhasil Terdaftar.');//keluar di halaman login
        return redirect('/register')->with('success', 'Akun Anda Berhasil Terdaftar.');

        // Auth::login($user);
        // return redirect('login');

        // if(Auth::attempt($attributes))
        // {
        //     session()->regenerate();
        // }
        // else return back()->withErrors(['password'=> 'Error']);
    }
}
