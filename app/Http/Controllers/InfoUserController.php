<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Ramsey\Uuid\Type\Integer;

function getTanggal() {
    // $tgl = date('d').'-';
    // $tanggal = ( (int) date('d') );
    // $jam = ( (int) date('H') )+7;
    // if($jam >= 24) {$tanggal += 1; $jam = "0".($jam - 24);}
    // elseif($jam < 10) {$jam = "0".$jam;}
    // if($tanggal < 10) $tgl = date("Y-m")."-0".$tanggal.' '.$jam.date(':i:s');
    // else if ($tanggal < 32) $tgl = date("Y-m-").$tanggal.' '.$jam.date(':i:s');
    date_default_timezone_set('Asia/Jakarta');
    return date("Y-m-d H:i:s");
}

function updateDeposito($tgl){
    $jumlahkoin = DB::table('transaksi_koin')
        ->select(DB::raw('SUM(koin * jumlah) as total_koin'))
        ->where('user_id','=',auth()->user()->id)
        ->where('status', 'Berhasil')
        ->first();
    $total = 0;
    if($jumlahkoin->total_koin != null) $total = $jumlahkoin->total_koin;
    $deposito = DB::table('deposito_koin')
        ->where('user_id','=',auth()->user()->id)
        ->update([
            'koin' => $total,
            'tanggal_update' => $tgl
        ]);
    if($deposito == 1) return $total;
}

class InfoUserController extends Controller
{
    /*
    //dari sessioncontroller u/ login
    public function store()
    {
        $attributes = request()->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        if(Auth::attempt($attributes))
        {
            session()->regenerate();
            $dbase = DB::table('users')
                ->where("username","=",$attributes['username'])
                ->get(['role','status']);

            if($dbase[0]->role == 1) return redirect('berita'); //admin, dashboard->with(['success'=>'You are logged in.'])
            else return redirect('lihat-berita/semua'); //penggemar//penjual
        }
        else return redirect()->back()->withErrors(['username'=>'Username or password invalid.']);
    }
    */

    //done
    //buka profile penggemar
    public function create()
    {
        //jumlah koin user cek di dbase
        $pesan = 'penggemar';

        if(auth()->user()->role >= 2 || auth()->user()->status == 0) {
            if(auth()->user()->role == 3) $pesan = 'penjual';
            return view('user-fans/user-profile',[
                'mode' => 'penggemar',
                'pesan' => $pesan,
                // 'pengikut' => $pengikut."-".$pesan,
                'koin' => updateDeposito(getTanggal())
            ]);
        }//bisa juga masuk penjual tapi sebagai penggemar
        else {Auth::logout(); return redirect('/login');}
    }

    //done (ubah yg validate, contoh dari ubahPenjual)
    //edit profile penggemar
    public function store(Request $request)
    {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $attributes = request()->validate([
            'email' => ['email', 'max:50', Rule::unique('users')->ignore(Auth::user()->id)],
            'nama' => ['max:50'],
            'nomor' => ['numeric'],
            'ttg' => ['max:1000'],
            'kota' => ['max:50'],
            'artis' => ['max:50'],
            'gambar' => ['image','between:1,10240', Rule::dimensions()->maxWidth(10000)->maxHeight(10000)]//5120*2 itu 10 MB
        ],[
            // 'required' => 'Harap Mengisi Email Anda',
            'email.email' => 'Wajib mengisi dalam bentuk email.',
            'email.max'=> 'Panjang email lebih dari 50 karakter.',
            'nama.max'=> 'Panjang nama lebih dari 50 karakter.',
            'nomor.numeric' => 'Nomor telepon harus berupa angka.',
            'ttg.max' => 'Panjang tentang user lebih dari 1000 karakter.',
            'kota.max' => 'Panjang kota lebih dari 50 karakter.',
            'artis.max'=> 'Panjang nama artis lebih dari 50 karakter.',
            'gambar.image' => 'Gambar profile harus dalam file [.jpg / .jpeg / .png / .gif].',
            'gambar.between' => 'Ukuran gambar profile harus antara 1 KB dan 10 MB.',
            'gambar.dimensions' => 'Dimensi gambar profile melebihi batas maksimum.'
        ]);

        $gmb = auth()->user()->gambar_profile;
        if($request->hasFile('gambar')){
            $profile = 'profile';//C:\xampp\htdocs\projectTA\public
            $file = $request->gambar;
            $ext = $file->getClientOriginalExtension();
            $filename = "user-".auth()->user()->role."-".auth()->user()->id.".".$ext;
            $file->move("C:\\xampp\htdocs\projectTA\public\\".$profile,$filename);
            $gmb = "../".$profile."/".$filename;
            // $resize = Image::make(public_path($profile.$filename))->fit(70,70)->save();
            // move_uploaded_file($request->file('gambar')->path(),$profile."/".$filename);

            // print("gambar-pathbaru) ".$profile."\\".$filename."<hr>");
            // print("gmb) ".$gmb."<hr>");
            // print("gambar-path) ".$request->file('gambar')->path()."<hr>");
            // print("gambar-ext) ".$request->file('gambar')->extension()."<hr>");
        }
        $kotanya = auth()->user()->kota;
        // dd($request);
        // if(!isset($attributes['kota']) && ) {$attributes['kota'] = $kotanya; }
        // dd('luar',$attributes);

        //nama artis
        $artis = DB::table('artis')->where(strtolower('nama'),'like','%'.strtolower($attributes['artis']).'%')->count(['id']);
        if($artis == 0) $artis = DB::table('artis')->insert(['nama' => $attributes['artis'],'status' => 1]);

        User::where('id',Auth::user()->id)
            ->update([
                'email' => $attributes['email'],
                'nama' => $attributes['nama'],
                'nomor_telepon' => $attributes['nomor'],
                'kota' => $attributes['kota'],
                'gambar_profile' => $gmb,
                'artis' => $attributes['artis'],
                'tentang_user' => $attributes["ttg"],
            ]);
        return redirect('/user-profile')->with('success','Profile Anda Berhasil Diubah.');

        // if($request->get('email') != Auth::user()->email)
        // {
        //     if(env('IS_DEMO') && Auth::user()->id == 1)
        //     {
        //         return redirect()->back()->withErrors(['msg2' => 'You are in a demo version, you can\'t change the email address.']);
        //     }
        // }
        // else{
        //     $attribute = request()->validate([
        //         'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore(Auth::user()->id)],
        //     ]);
        // }
    }

    //done
    public function getPenjual($mode){
        $konfirmasi = [];
        if ((auth()->user()->role == 2 && $mode == 'registrasi') || (auth()->user()->role == 3 && $mode == 'profile') && auth()->user()->status == 1) {
            $dbase = DB::table('konfirmasi_penjual')
                ->join('transaksi_koin','konfirmasi_penjual.transaksi_id','=','transaksi_koin.id')
                ->where("konfirmasi_penjual.penggemar_id","=",auth()->user()->id)
                ->select('konfirmasi_penjual.ktp_nomor as ktp','konfirmasi_penjual.ktp_foto as foto',
                'konfirmasi_penjual.status_konfirmasi as konfirmasi','konfirmasi_penjual.catatan as catatan',
                'konfirmasi_penjual.transaksi_id as trans','transaksi_koin.status as status')
                ->get();

            //jumlah koin user cek di dbase
            $koin = updateDeposito(getTanggal());
            $pesan = 'belum';//belum bayar
            if($koin < 20) $pesan = 'tidak cukup';//belum daftar

            if(count($dbase) > 0){
                $konfirmasi[] = [
                    'ktp' => $dbase[0]->ktp,
                    'foto' => $dbase[0]->foto,
                    'konfirmasi' => $dbase[0]->konfirmasi,
                    'status' => $dbase[0]->status,
                    'trans' => $dbase[0]->trans,
                    'catatan' => $dbase[0]->catatan,
                ];
                // if($koin < 20) $pesan = 'tidak cukup';//sudah daftar tapi belum lunas
                if($dbase[0]->konfirmasi == 1) $pesan = 'sudah';//sdh konfirmasi dan sdh jd penjual
                else if($dbase[0]->status == 'Admin'){
                    if($dbase[0]->konfirmasi == 0) $pesan = strtolower($dbase[0]->status);//sdh konfirmasi dan sdh jd penjual
                    else if($dbase[0]->konfirmasi == 2) $pesan = 'ulang';//sdh konfirmasi dan sdh jd penjual
                }
            }
            $pengikut = DB::table('pengikut')->whereRaw("penjual_id = ".auth()->user()->id." and status=1")->count();

            return view('user-fans/user-profile',[
                'mode' => $mode,
                'penjual' => $konfirmasi,
                'pengikut' => $pengikut,
                'pesan' => $pesan,
                'koin' => $koin
            ]);
        }
        else {Auth::logout(); return redirect('/login');}
    }

    //registrasi done
    public function ubahPenjual(Request $request){
        if(auth()->user()->role != 2 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $ubahDepo = updateDeposito(getTanggal());
        $db = DB::table('konfirmasi_penjual')
            ->join('transaksi_koin','konfirmasi_penjual.transaksi_id','=','transaksi_koin.id')
            ->where('konfirmasi_penjual.penggemar_id','=',auth()->user()->id)
            ->where('transaksi_koin.jenis','=','registrasi')
            ->select('konfirmasi_penjual.ktp_nomor as ktp','konfirmasi_penjual.ktp_foto as foto')
            ->get();

        // dd(count($db));

        $gmb = '';
        if(count($db) == 0) {
            if ($request->foto == null || $request->ktp == null) return redirect()->back()->with(['koin',$ubahDepo])->withErrors(['ktp' => 'Wajib Mengisi Seluruh Data yang Tersedia.']);
            // && $request->trans == 'none' && auth()->user()->role == 2 && $request->mode == 'registrasi'
            $attributes = request()->validate([
                'ktp' => ['required','numeric'],
                'foto' => ['required','image','between:1,10240', Rule::dimensions()->maxWidth(10000)->maxHeight(10000)]//5120*2 itu 10 MB
            ],[
                // 'required'=> 'Wajib mengisi ',
                'ktp.numeric'=> 'Nomor KTP harus berupa nomor / angka.',
                // 'foto.required'=> 'Wajib mengisi foto KTP.',
                'foto.image' => 'Foto KTP harus berupa gambar.',
                'foto.between' => 'Ukuran gambar harus antara 1 KB dan 10 MB.',
                'foto.dimensions' => 'Dimensi gambar melebihi batas maksimum.'
            ]);

            if($request->hasFile('foto')){
                $ktp = 'penjual-ktp';//C:\xampp\htdocs\projectTA\public
                $file = $request->foto;
                $ext = $file->getClientOriginalExtension();
                $filename = "user-".auth()->user()->role."-".auth()->user()->id.".".$ext;
                $file->move("C:\\xampp\htdocs\projectTA\public\\".$ktp,$filename);
                $gmb = "../".$ktp."/".$filename;
            }
            else return redirect()->back()->with(['koin',$ubahDepo])->withErrors(['foto' => 'Wajib mengisi Foto KTP.']);
            if(strlen($attributes['ktp']) != strlen("36XXX1001223XXXX") ) return redirect()->back()->with(['koin',$ubahDepo])->withErrors(['ktp' => 'Panjang nomor KTP kurang atau lebih dari 16 nomor.']);

            $transkoin = 0;
            $db = DB::table('transaksi_koin')->where('user_id','=',auth()->user()->id)->where('jenis','=','registrasi')->get('id');
            if(count($db) == 1) $transkoin = $db[0]->id;
            else{
                $idkode = 'ID';
                $idtrans = '00000';//dari dbase nanti
                $counting = DB::table('transaksi_koin')->count();
                if(((int) $counting+1) < 10) $idtrans = '0000'.((int) $counting+1);
                else if(((int) $counting+1) < 100) $idtrans = '000'.((int) $counting+1);
                else if(((int) $counting+1) < 1000) $idtrans = '00'.((int) $counting+1);
                else if(((int) $counting+1) < 10000) $idtrans = '0'.((int) $counting+1);
                date_default_timezone_set('Asia/Jakarta');
                $idkode = 'ID'.date('Ymd').$idtrans;

                $tgl = getTanggal();
                // $count = DB::table('transaksi_koin')->count()+1;
                $trans = DB::table('transaksi_koin')
                    ->insert([
                        // 'id' => $count,
                        'jenis' => 'registrasi',
                        'koin' => -20,
                        'jumlah' => 1,
                        'total_bayar' => 0,
                        'user_id' => auth()->user()->id,
                        'tanggal' => getTanggal(),
                        'status' => 'Admin',
                        'transaksi_kode' => $idkode,
                ]);
                if($trans == 1){
                    $db = DB::table('transaksi_koin')->where('user_id','=',auth()->user()->id)->where('jenis','=','registrasi')->get('id');
                    $transkoin = $db[0]->id;
                }
            }
            // dd([$request->foto,$request->ktp,$trans]);

            if($transkoin > 0 && $ubahDepo > 0){
                $konfirmasi = DB::table('konfirmasi_penjual')
                ->insert( array(
                    "penggemar_id" => auth()->user()->id,
                    "ktp_nomor" => $attributes['ktp'],
                    "ktp_foto" => $gmb,
                    "status_konfirmasi" => 0,
                    "transaksi_id" => $transkoin
                ) );
                if($konfirmasi == 1) return redirect('/penjual/registrasi')->with('success','Registrasi menjadi Penjual Berhasil. Harap Menunggu Konfirmasi Terlebih Dahulu.');
            }
            else if($ubahDepo-20 < 0) return redirect()->back()->with(['koin',$ubahDepo])->withErrors(['biaya' => 'Koin Anda Tidak Mencukupi.']);
        } else if (count($db) == 1){//edit perbaikan registrasi
            // dd($gmb == null, $request->ktp, '36XXX1001223XXXX', strlen($request->ktp) != strlen("36XXX1001223XXXX") , $request->all());
            $attributes = request()->validate([
                'ktp' => ['numeric'],
                'foto' => ['image','between:1,10240', Rule::dimensions()->maxWidth(10000)->maxHeight(10000)]//5120*2 itu 10 MB
            ],[
                'ktp.numeric'=> 'Nomor KTP harus berupa nomor / angka.',
                'foto.image' => 'Foto KTP harus berupa gambar.',
                'foto.between' => 'Ukuran gambar harus antara 1 KB dan 10 MB.',
                'foto.dimensions' => 'Dimensi gambar melebihi batas maksimum.',
            ]);
            if($request->hasFile('foto')){
                $ktp = 'penjual-ktp';//C:\xampp\htdocs\projectTA\public
                $file = $request->foto;
                $ext = $file->getClientOriginalExtension();
                $filename = "user-".auth()->user()->role."-".auth()->user()->id.".".$ext;
                $file->move("C:\\xampp\htdocs\projectTA\public\\".$ktp,$filename);
                $gmb = "../".$ktp."/".$filename;
            }
            if(strlen($attributes['ktp']) != strlen("36XXX1001223XXXX") ) return redirect()->back()->with(['koin',$ubahDepo])->withErrors(['ktp' => 'Panjang nomor KTP kurang atau lebih dari 16 nomor.']);

            // print('berubah<hr>');
            // print("<br>".$attributes['ktp'].'<hr>');
            // print($db[0]->foto."<br>".$db[0]->ktp.'<hr>');
            if($gmb == null) $gmb = $db[0]->foto;
            // if($attributes['ktp'] == $db[0]->ktp) $gmb = $db[0]->foto;
            $trans = DB::table('users')
                ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
                ->join('transaksi_koin','konfirmasi_penjual.transaksi_id','=','transaksi_koin.id')
                ->where("users.role","=",2)
                // ->where('users.id','=',auth()->user()->id)
                ->where('konfirmasi_penjual.penggemar_id','=',auth()->user()->id)
                ->where('transaksi_koin.id','=',$request->transaksi)
                ->update([
                    // "users.role" => 3,
                    'konfirmasi_penjual.status_konfirmasi' => -2,
                    "konfirmasi_penjual.ktp_nomor" => $attributes['ktp'],
                    "konfirmasi_penjual.ktp_foto" => $gmb,
                    'transaksi_koin.status' => 'Admin',
            ]);
            if($trans == 1) return redirect('/penjual/registrasi')->with('success','Anda telah Menyelesaikan Registrasi Ulang. Harap Menunggu Konfirmasi Ulang.');
        }
    }
}
