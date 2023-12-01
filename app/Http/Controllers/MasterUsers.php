<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

function getTanggal() {
    date_default_timezone_set('Asia/Jakarta');
    return date("Y-m-d H:i:s");
}

// function updateDeposito($tgl){
//     $jumlahkoin = DB::table('transaksi_koin')
//         ->select(DB::raw('SUM(koin * jumlah) as total_koin'))
//         ->where('user_id','=',auth()->user()->id)
//         ->where('status', 'Berhasil')
//         ->first();
//     $total = -1;
//     if($jumlahkoin == null) $total = 0;
//     $deposito = DB::table('deposito_koin')
//         ->where('user_id','=',auth()->user()->id)
//         ->update([
//             'koin' => $total,
//             'tanggal_update' => $tgl
//         ]);
//     if($deposito == 1) return $jumlahkoin->total_koin;
// }

class MasterUsers extends Controller
{
    //not yet
    //done
    public function create() {
        if(auth()->user()->role == 1 && auth()->user()->status == 1) {return view('user-admin/user-profile');}
        else {Auth::logout(); return redirect('/login');}
    }

    //dari infousercontroller u/ ubah profile, done
    public function store(Request $request){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {Auth::logout(); return redirect('/login');}
        $attributes = request()->validate([
            'nama' => ['max:50'],
            'nomor' => ['max:12'],
        ]);

        User::where('id',Auth::user()->id)
        ->update([
            // 'username'    => $attributes['username'],
            // 'email' => $attribute['email'],
            'nama' => $attributes['nama'],
            'nomor_telepon' => $attributes['nomor'],
            // 'lokasi' => $attributes['lokasi'],
            // 'tentang_user' => $attributes["tentang_user"],
        ]);
        return redirect('/profile/admin')->with('success','Profile Anda Berhasil Diubah.');

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

    //user: penggemar/penjual done
    public function getDaftarUser($user) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $duser = [];
        $error = false;
        $tidak = 0;
        $role = 1;//admin
        if($user == 'penggemar') {
            $role = 2;
            $dbase = DB::table('users')
                ->where("role","=",$role)
                ->orderBy('updated_at','desc')->get();
        }
        else if($user == 'penjual') {
            $role = 3;
            $dbase = DB::table('users')
                ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
                ->where("users.role","=",3)
                ->select('users.id as id','users.username as username','users.nama as nama','users.email as email','users.nomor_telepon as nomor_telepon',
                    'users.tentang_user as tentang_user','users.gambar_profile as gambar_profile','users.kota as kota',
                    'users.created_at as created_at','users.updated_at as updated_at','users.status as status','users.artis as artis',
                    'konfirmasi_penjual.ktp_nomor as ktp','konfirmasi_penjual.ktp_foto as foto','konfirmasi_penjual.status_konfirmasi as konfirmasi')
                ->orderBy('users.updated_at','desc')->get();
        }

        foreach ($dbase as $value) {
            $ktp = '';
            $foto_ktp = '';
            $konfirmasi = '';

            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $tanggal_format = strtotime($value->updated_at);
            $updated = str_replace($bulanInggris, $bulanIndonesia, date("d F Y", $tanggal_format));
            $tanggal_format = strtotime($value->created_at);
            $created = str_replace($bulanInggris, $bulanIndonesia, date("d F Y", $tanggal_format));

            $jumlahikut = -1;
            if($role == 2){
                $ktp = 'tidak';
                $foto_ktp = 'tidak';
                $konfirmasi = 'tidak';
            }
            else{
                $jumlahikut = DB::table('pengikut')->whereRaw('penjual_id = '.$value->id.' and status=1')->count('pengikut_id');
                $ktp = $value->ktp;
                $foto_ktp = $value->foto;
                $konfirmasi = $value->konfirmasi;
            }
            if($value->status == 0) $tidak += 1;
            $duser[] = [
                'id' => $value->id,
                'username' => $value->username,
                'email' => $value->email,
                'nama' => $value->nama,
                'nomor_telepon' => $value->nomor_telepon,
                'tentang_user' => $value->tentang_user,
                'gambar_profile' => $value->gambar_profile,
                'kota' => $value->kota,
                'artis' => $value->artis,
                'created_at' => $created,
                'updated_at' => $updated,
                'ktp' => $ktp,
                'foto_ktp' => $foto_ktp,
                'konfirmasi' => $konfirmasi,
                'status' => $value->status,
                'pengikut' => $jumlahikut
            ];
        }

        return view('user-admin/user/data-user',
            ['user' => $user,
            'error' => $error,'pesan' => 'belum',
            'tidak' => $tidak,'datauser' => $duser]);
    }

    //user: penggemar/penjual done
    public function ubahStatus($user,$id) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $role = 1;//admin
        if($user == 'penggemar') $role = 2;
        else if($user == 'penjual') $role = 3;

        $dbase = DB::table('users')
            ->where("id","=",$id)
            ->where("role","=",$role)
            ->get('status');

        $status = -1;
        if(count($dbase) == 1){
            $status = $dbase[0]->status;
            if($status == 0) $status = 1;
            else $status = 0;
            $dbase = DB::table('users')
                ->where("id","=",$id)
                ->where("role","=",$role)
                ->update(['status' => $status]);
        }
        return redirect()->route('daftarUser',['user' => $user]);
    }

    //lihat laporan konfirmasi
    public function konfirmasiPenjual (){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $duser = [];
        $error = false;
        $tidak = 0;
        $revisi = 0;
        $dbase = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->join('transaksi_koin','users.id','=','transaksi_koin.user_id')
            ->where('transaksi_koin.jenis','=','registrasi')
            ->where("users.role","=",2)
            ->orWhere('users.id','=','transaksi_koin.admin_id')
            ->select('users.*',
                'konfirmasi_penjual.id as kon_id','konfirmasi_penjual.ktp_nomor as ktp',
                'konfirmasi_penjual.ktp_foto as foto','konfirmasi_penjual.status_konfirmasi as konfirmasi',
                'konfirmasi_penjual.transaksi_id as transaksi','konfirmasi_penjual.catatan as catatan',
                "transaksi_koin.admin_id as adminid",
                'transaksi_koin.id as deposito', 'transaksi_koin.transaksi_kode as kodedepo', 'transaksi_koin.transaksi_tipe as tipedepo',
                'transaksi_koin.jenis as jenisdepo', 'transaksi_koin.admin_id as admindepo',
                'transaksi_koin.koin as koindepo', 'transaksi_koin.jumlah as jumlahdepo', 'transaksi_koin.total_bayar as totaldepo',
                'transaksi_koin.tanggal as tanggaldepo', 'transaksi_koin.status as statusdepo'
                )
            ->orderBy('users.updated_at','asc')->get();

        foreach ($dbase as $value) {
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $tanggal_format = strtotime($value->updated_at);
            $updated = str_replace($bulanInggris, $bulanIndonesia, date("d F Y", $tanggal_format));
            $tanggal_format = strtotime($value->created_at);
            $created = str_replace($bulanInggris, $bulanIndonesia, date("d F Y", $tanggal_format));
            $tanggal_format = strtotime($value->tanggaldepo);
            $tanggaldepo = str_replace($bulanInggris, $bulanIndonesia, date("d F Y", $tanggal_format));

            $catatan = $value->catatan;
            // if($catatan == null) $catatan = 'none';
            if($value->konfirmasi == 0) $tidak += 1;
            if($value->konfirmasi == 2 || $value->konfirmasi == -2) $revisi += 1;
            $duser[] = [
                'id' => $value->id,
                'username' => $value->username,
                'email' => $value->email,
                'nama' => $value->nama,
                'nomor_telepon' => $value->nomor_telepon,
                'tentang_user' => $value->tentang_user,
                'gambar_profile' => $value->gambar_profile,
                'kota' => $value->kota,
                'artis' => $value->artis,
                'created_at' => $created,
                'updated_at' => $updated,
                'status' => $value->status,
                'idkon' => $value->kon_id,
                'ktp' => $value->ktp,
                'foto' => $value->foto,
                'konfirmasi' => $value->konfirmasi,
                'transaksi' => $value->transaksi,
                'catatan' => $catatan,
                'adminid' => $value->adminid,
                // 'admin' => $value->admin,
                'deposito' => $value->deposito,
                'kodedepo' => $value->kodedepo,
                'tipedepo' => $value->tipedepo,
                'jenisdepo' => $value->jenisdepo,
                'admindepo' => $value->admindepo,
                'koindepo' => $value->koindepo,
                'jumlahdepo' => $value->jumlahdepo,
                'totaldepo' => $value->totaldepo,
                'tanggaldepo' => $tanggaldepo,
                'statusdepo'=> $value->statusdepo,
            ];
        }

        return view('user-admin/user/konfirmasi',
            ['tidak' => $tidak,'revisi' => $revisi,
            'error' => $error,'pesan' => 'belum',
            'datauser' => $duser]);
    }

    //konfirmasi penjual (haruse ada opsi langsung terima ato ga)
    public function ubahKonfirmasi(Request $request) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        // dd($request);

        $attributes = request()->validate([
            'catatan' => ['required'],
            'pilihan' => ['required']
        ],[
            'required'=> 'Wajib mengisi yang telah ditandai.'
        ]);

        //alur:
        // langsung diterima : 0 user --> 1 Admin v
        // revisi baru diterima : 0 u --> 2 A --> -2 u --> 1 A v
        $status = 0; $role = 2; $pesan = 'Admin';
        if($request->pilihan == 'terima') {$status = 1; $role = 3; $pesan = 'Berhasil'; }
        else if($request->pilihan == 'perbaiki' && ($request->statusKon == 0 || $request->statusKon == -2)) $status = 2; //print('dua revisi');ubah jadi revisi
        // else if {$status = 1; $role = 3; $pesan = 'Berhasil'; print('dua terima');}//ubah jadi penjual
        // else if($request->pilihan == 'tolak') {$status = 0; $pesan = 'Gagal'; print('tiga tolak');}
        // print('<hr>'.$status.'<>'.$role.'<->'.$pesan.'<==>'.$request->catatan.'<-=->'.$request->pilihan.
        //     '<hr>user '.$request->user.' <> idkon '.$request->konfirmasi.' <==> transaksi '.$request->transaksi.' <-=-> statuskon'.$request->statusKon);

        // return back()->withInput([
        //     'username' => $attributes['username'],
        //     'email' => $attributes['email'],
        //     'nama' => $attributes['nama'],
        //     'nomor_telepon' => $attributes['nomor_telepon'],
        //     ])->withErrors(['msg'=>'error']);

        // /*
        $ubah = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->join('transaksi_koin','konfirmasi_penjual.transaksi_id','=','transaksi_koin.id')
            ->where("users.role","=",2)
            ->where('users.id','=',$request->user)
            ->where('konfirmasi_penjual.id','=',$request->konfirmasi)
            ->where('transaksi_koin.id','=',$request->transaksi)
            ->update([
                'users.role' => $role,
                'konfirmasi_penjual.catatan' => $request->catatan,
                'konfirmasi_penjual.status_konfirmasi' => $status,
                "transaksi_koin.admin_id" => auth()->user()->id,
                'transaksi_koin.status' => $pesan,
            ]);
        return redirect()->route('konfirmasi');
        // */
    }
}
