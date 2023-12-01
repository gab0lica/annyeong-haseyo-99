<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        $attributes = request()->validate([
            // 'username' => ['required', 'min:10', 'max:20'],
            // 'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            // 'token' => 'required',
            'username' => 'required',
            'password' => 'required|min:5|max:25',
            'cpassword' => 'required'//confirmed
        ],[
            'username.required'=> 'Wajib mengisi username Anda.',
            'password.required'=> 'Wajib mengisi password baru.',
            'password.min' => 'Panjang password kurang dari 5 karakter.',
            'password.max' => 'Panjang password lebih dari 25 karakter.',
            'cpassword.required'=> 'Wajib mengisi konfirmasi password baru.',
        ]);
        $role = DB::table('users')
            ->where("username","=",$attributes['username'])
            ->get();
        if(count($role) == 0) return redirect()->back()->withInput(['username' => $attributes['username']])->withErrors(['username' => 'Username Anda tidak valid atau tidak terdaftar. Silakan Registrasi terlebih dahulu.']);
        else if(count($role) == 1){
            if($role[0]->role == 1) return redirect()->back()->withInput(['username' => $attributes['username']])->withErrors(['username' => 'Anda tidak bisa mengganti password.']);
            else if($attributes['password'] != $attributes['cpassword']) return redirect()->back()->withErrors(['cpassword'=>'Pastikan kembali password baru dan konfirmasi password baru.']);
            $attributes['password'] = bcrypt($attributes['password']);

            $status = User::where('username',$attributes['username'])->update(['password' => Hash::make($attributes["password"])]);
            if($status == 1) return redirect('/reset-password')->with('success','Ganti Password Berhasil');
            else return redirect()->back()->withInput(['username' => $attributes['username']])->withErrors(['username' => 'Gagal mengubah password.']);
        }

        // $status = Password::reset(
        //     $request->only('email', 'password', 'password_confirmation', 'token'),
        //     function ($user, $password) {
        //         $user->forceFill([
        //             'password' => Hash::make($password)
        //         ])->setRememberToken(Str::random(60));
        //         $user->save();
        //         event(new PasswordReset($user));
        //     }
        // );
        // return $status === Password::PASSWORD_RESET
        //             ? redirect('/login')->with('success', __($status))
        //             : back()->withErrors(['email' => [__($status)]]);
    }
}
