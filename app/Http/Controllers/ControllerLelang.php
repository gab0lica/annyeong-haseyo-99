<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use PDO;

function getTanggal() {
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

function updateStatusLelang($mulai, $selesai, $lelang){
    $statusnya = 0;//tidak aktif
    $pesan = 'belum';
    $usermenang = [];
    $cekmulai = date("Y-m-d H:i:s", strtotime($mulai));
    $cekselesai = date("Y-m-d H:i:s", strtotime($selesai));

    if($cekmulai > getTanggal() && $lelang['status'] == 1) $statusnya = -1;//belum rilis
    else if($cekmulai <= getTanggal() && $cekselesai > getTanggal() && $lelang['status'] == 1) {$statusnya = 1;  $pesan = 'berjalan';}//masih berjalan
    else if($lelang['status'] == 2) {$statusnya = 2; $pesan = 'peringatan';}//revisi/perbaikan u/ form
    else if($lelang['status'] == 3) {//selesai, update status trans
        $statusnya = 3;
        $pesan = 'selesai';
        //jika ada yg gagal membayar >> transaksiUlang dari penjual
    }
    else if($cekselesai <= getTanggal() && $lelang['status'] == 1){//dibuat selesai
        $jumlahuser = DB::table('lelang_bid')
            ->join('lelang','lelang_bid.lelang_id','=','lelang.id')
            // ->join('users','lelang_bid.user_id','=','users.id')
            ->whereRaw('lelang.id='.$lelang['id'])
            ->selectRaw('lelang_bid.user_id')
            // ->orderByDesc('lelang_bid.koin_penawaran')
            ->count();
        if($jumlahuser == 1) {$statusnya = 1; $pesan = 'berjalan';}
        else{
            $statusnya = 3;
            // $lelang = DB::table('lelang')->whereRaw('id='.$lelang['id'])->get();
            $idtrans = ['00000','00000','00000'];
            $tgltrans = date("Ymd", strtotime($selesai));//dari tanggal selesai
            $counting = DB::table('transaksi_koin')->count();
            $iterasi = 1;
            while($iterasi <= 3){
                if(((int) $counting+$iterasi) < 10) $idtrans[$iterasi-1] = '0000'.((int) $counting+$iterasi);
                else if(((int) $counting+$iterasi) < 100) $idtrans[$iterasi-1] = '000'.((int) $counting+$iterasi);
                else if(((int) $counting+$iterasi) < 1000) $idtrans[$iterasi-1] = '00'.((int) $counting+$iterasi);
                else if(((int) $counting+$iterasi) < 10000) $idtrans[$iterasi-1] = '0'.((int) $counting+$iterasi);
                $iterasi += 1;
            }
            date_default_timezone_set('Asia/Jakarta');
            $idtrans[0] = 'ID'.$tgltrans.$idtrans[0];
            $idtrans[1] = 'ID'.$tgltrans.$idtrans[1];
            $idtrans[2] = 'ID'.$tgltrans.$idtrans[2];
            // }
            $tgl = getTanggal();
            // dd($idtrans);
            // SELECT koin_penawaran, user_id
            // FROM `lelang_bid` join lelang on lelang_bid.lelang_id=lelang.id
            // join users on lelang_bid.user_id=users.id
            // where lelang_id=5 and lelang.penjual_id=3
            // order by koin_penawaran desc;
            $usermenang = DB::table('lelang_bid')
                ->join('lelang','lelang_bid.lelang_id','=','lelang.id')
                ->join('users','lelang_bid.user_id','=','users.id')
                ->whereRaw('lelang.id='.$lelang['id'])
                ->selectRaw('lelang_bid.bid_id as bidpemenang, lelang_bid.koin_penawaran as koinpemenang,
                    lelang_bid.user_id as pemenang')//lelang.penjual_id as penjual, , users.nama as namapemenang
                ->orderByDesc('lelang_bid.koin_penawaran')
                ->get();
            if(count($usermenang) > 0){
                $pemenang = DB::table('transaksi_koin')->insert(
                    array(
                        // 'id' => $idnya,
                        'jenis' => 'lelang',
                        'koin' => ($usermenang[0]->koinpemenang)*-1,
                        'jumlah' => 1,
                        'total_bayar' => 0,
                        'user_id' => $usermenang[0]->pemenang,
                        'transaksi_kode' => $idtrans[0],
                        'tanggal' => getTanggal(),
                        'status' => 'Belum'//$status,
                    )
                );
                $penjual = DB::table('transaksi_koin')->insert(
                    array(
                        // 'id' => $idnya,
                        'jenis' => 'lelang-penjual',
                        'koin' => $usermenang[0]->koinpemenang,//+((int)(($lelang['persen-penjual']*$usermenang[0]->koinpemenang)/100))
                        'jumlah' => 1,
                        'total_bayar' => 0,
                        'user_id' => $lelang['penjual'],
                        'transaksi_kode' => $idtrans[1],
                        'tanggal' => $tgl,
                        'status' => 'Belum'//$status,
                    )
                );
                $admin = DB::table('transaksi_koin')->insert(
                    array(
                        // 'id' => $idnya,
                        'jenis' => 'lelang-admin',
                        'koin' => (int)((5*$usermenang[0]->koinpemenang)/100),
                        'jumlah' => 1,
                        'total_bayar' => 0,
                        'user_id' => $lelang['admin'],
                        'transaksi_kode' => $idtrans[2],
                        'tanggal' => $tgl,
                        'status' => 'Belum'//$status,
                    )
                );
                // $menang = DB::table('lelang_bid')
                //     ->whereRaw('lelang_id='.$lelang['id'].' and user_id='.$usermenang[0]->pemenang)
                //     ->update(['status' => 3]);//menang
                if($pemenang == 1 && $penjual == 1 && $admin == 1){
                    $kodetrans = [];
                    $kodetrans[0] = DB::table('transaksi_koin')->whereRaw("transaksi_kode = '$idtrans[0]'")->select(['id'])->get();
                    $kodetrans[1] = DB::table('transaksi_koin')->whereRaw("transaksi_kode = '$idtrans[1]'")->select(['id'])->get();
                    $kodetrans[2] = DB::table('transaksi_koin')->whereRaw("transaksi_kode = '$idtrans[2]'")->select(['id'])->get();

                    $bidmenang = DB::table('lelang_bid')
                        ->whereRaw('bid_id ='.$usermenang[0]->bidpemenang)
                        ->update(['menang'=> 1]);

                    $berakhir = DB::table('lelang')
                        ->whereRaw('id='.$lelang['id'])
                        ->update([
                            'status' => $statusnya,
                            'transaksi_pemenang' => $kodetrans[0][0]->id,
                            'transaksi_penjual' => $kodetrans[1][0]->id,
                            'transaksi_admin' => $kodetrans[2][0]->id,
                    ]);
                    if($berakhir == 1 && $bidmenang == 1) $pesan = 'selesai';
                }
            }
        }
        return ['status' => $statusnya, 'pesan' => 'belum-penawar'];
        // dd([
        //     'status berubah' => $lelang['status'].' jadi '.$statusnya,
        //     'tanggal' => [getTanggal(),$cekmulai,$cekselesai],
        //     (count($usermenang) > 1 ?
        //         ['menang' => $usermenang[0]->koinpemenang."/ id=".$usermenang[0]->pemenang.' ialah '.$usermenang[0]->namapemenang,
        //         'penjual' => 'id: '.auth()->user()->id,
        //         'admin' => 'id: '.$lelang['admin_id'].' dengan persen 5% = '.(int)((5*$usermenang[0]->koinpemenang)/100)]
        //         : '')
        // ]);
    }
    return ['status' => $statusnya, 'pesan' => $pesan];
    // print('<br>');
}

class ControllerLelang extends Controller
{
    //daftar penjual done
    public function getPenjual($mode) {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $penjual = [];
        $dbase = [];

        if($mode == 'semua'){
            $dbase = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1")
            ->selectRaw('users.id as id, users.username as username, users.nama as nama,
                users.status as status, users.created_at as created_at, users.updated_at as updated_at,
                users.gambar_profile as gambar, users.kota as kota, users.tentang_user as ttg')
            ->get();
        }
        else if($mode == 'ikuti') {
            $dbase = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->leftJoin('pengikut','pengikut.penjual_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1
                and pengikut.status=1 and pengikut.pengikut_id = ".auth()->user()->id)
            ->selectRaw('users.id as id, users.username as username, users.nama as nama,
                users.status as status, users.created_at as created_at, users.updated_at as updated_at,
                users.gambar_profile as gambar, users.kota as kota, users.tentang_user as ttg')
            ->get();
        }

        foreach ($dbase as $value) {
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $tanggal_format = strtotime($value->updated_at);
            $updated = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));
            $tanggal_format = strtotime($value->created_at);
            $created = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));

            $daftarlelang = [];
            if($mode != 'semua'){
                $lelang = DB::table('lelang')
                    ->whereRaw('penjual_id = '.$value->id)
                    ->selectRaw('id as lelang, nama_produk as produk, deskripsi_produk as detail, gambar_produk as gambar,
                    koin_minimal as harga, tanggal_mulai as mulai, tanggal_selesai as selesai, status as statuslelang')
                    ->get();
                foreach ($lelang as $item){
                    $tanggal_format = strtotime($item->mulai);
                    $mulai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
                    $tanggal_format = strtotime($item->selesai);
                    $selesai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
                    // $hari_ini = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", strtotime(getTanggal())));

                    $statusnya = 0;
                    if($item->mulai > getTanggal() && $item->statuslelang == 1) $statusnya = -1;//belum rilis
                    else $statusnya = 1;

                    $jumlahBid = DB::table('lelang_bid')->whereRaw('lelang_id = '.$item->lelang.' and status>=1')->count();

                    if($statusnya == -1){//belum rilis
                        $daftarlelang[] = [
                            'lelang' => $item->lelang,
                            'statuslelang' => $item->statuslelang,
                            'mode' => $statusnya,
                            'produk' => $item->produk,
                            'gambar' => $item->gambar,
                            'detail' => $item->detail,
                            'harga' => $item->harga,
                            'mulai' => $mulai,
                            'selesai' => $selesai,
                            'ikut' => $jumlahBid
                        ];
                    }
                }
            }
            $jumlahikut = DB::table('pengikut')->whereRaw('penjual_id = '.$value->id.' and status=1')->count('pengikut_id');
            $ikut = DB::table('pengikut')->whereRaw('penjual_id = '.$value->id.' and status=1 and pengikut_id = '.auth()->user()->id)->count();
            $penjual[] = [
                'id' => $value->id,
                'username' => $value->username,
                'nama' => $value->nama,
                'gambar' => $value->gambar,
                'kota' => $value->kota,
                'ttg' => $value->ttg,
                'created_at' => $created,
                'updated_at' => $updated,
                'status' => $value->status,
                'lelang' => $daftarlelang,
                'pengikut' => $jumlahikut,
                'ikut' => $ikut
            ];
            // foreach ($value as $key => $i) {
            //     print($key.' <br> '.$i.'<hr>');
            // }
        }
        // dd('disini',count($penjual));

        $ikutlelang = DB::table('lelang_bid')->whereRaw("status >= 1 and user_id = '".auth()->user()->id."'")->count();
        $pengikut = DB::table('pengikut')->whereRaw('penjual_id = '.auth()->user()->id.' and status=1')->count('pengikut_id');
        return view('user-fans/lelang/daftar-penjual',
            ['error' => false,
            'koin' => updateDeposito(getTanggal()),
            'pengikut' => $pengikut,
            'ikutlelang' => $ikutlelang,
            'hari_ini' => getTanggal(),
            'pesan' => 'belum',
            'penjual' => $penjual]
        );
    }

    //follow penjual done
    public function ikutiPenjual($id) {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $jadi = -1;
        $cari = DB::table('pengikut')->whereRaw("pengikut_id = ".auth()->user()->id." and penjual_id = ".$id)->get();
        if(count($cari) == 0){
            $ikuti = DB::table('pengikut')
            ->insert([
                "penjual_id" => $id,
                "pengikut_id" => auth()->user()->id,
                "status" => 1,
                'tanggal_mengikuti' => getTanggal()
            ]);
            if($ikuti == 1) return redirect()->route('daftarPenjual',['mode'=>'semua']);
        } else if(count($cari) == 1) {
            if($cari[0]->status == 0) $jadi = 1;
            else if($cari[0]->status == 1) $jadi = 0;
            $ubahIkuti = DB::table('pengikut')
                ->whereRaw("pengikut_id = ".auth()->user()->id." and penjual_id = ".$id)
                ->update( ["status" => $jadi] );
            if($ubahIkuti == 1) return redirect()->route('daftarPenjual',['mode'=>'semua']);
        }
        else return redirect()->route('daftarLelang');
    }

    //daftar lelang yg berjalan (ada filtering post)
    public function getAllLelang() {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $lelang = [];
        $error = false;
        $dbase = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->join('lelang','lelang.penjual_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1
                and lelang.status = 1 and tanggal_mulai<='".getTanggal()."' and tanggal_selesai>='".getTanggal()."'")
            ->selectRaw('users.id as user, users.username as username, users.nama as nama, users.kota as kota,
                lelang.id as lelang, lelang.nama_produk as produk, lelang.deskripsi_produk as detail, lelang.gambar_produk as gambar,
                lelang.koin_minimal as harga, lelang.tanggal_mulai as mulai, lelang.tanggal_selesai as selesai')
            // ->groupBy('id','username','nama','kota','created_at','updated_at','gambar')
            ->orderBy('lelang.tanggal_mulai','desc')
            ->get();

        foreach ($dbase as $value) {
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            // $tanggal_format = strtotime($value->updated_at);
            // $updated = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));
            // $tanggal_format = strtotime($value->created_at);
            // $created = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));

            $tanggal_format = strtotime($value->mulai);
            $mulai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
            $tanggal_format = strtotime($value->selesai);
            $selesai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));

            $userikut = DB::table('lelang_bid')->whereRaw('lelang_id = '.$value->lelang.' and user_id = '.auth()->user()->id.' and status >= 1')->count();
            $ikut = DB::table('lelang_bid')->whereRaw('lelang_id = '.$value->lelang.' and status>=1')->count();

            $lelang[] = [
                'lelang' => $value->lelang,
                'produk' => $value->produk,
                'gambar' => $value->gambar,
                'detail' => $value->detail,
                'harga' => $value->harga,
                // 'kelipatan' => $value->kelipatan,
                'mulai' => $mulai,
                'selesai' => $selesai,
                'user' => $value->user,
                'username' => $value->username,
                'nama' => $value->nama,
                'kota' => $value->kota,
                // 'created_at' => $created,
                // 'updated_at' => $updated,
                // 'pengikut' => $jumlahikut,
                'ikut' => $ikut,
                'userikut' => $userikut
            ];
        }
        $ikutlelang = DB::table('lelang_bid')->whereRaw("status >= 1 and user_id = '".auth()->user()->id."'")->count();
        $pengikut = DB::table('pengikut')->whereRaw('penjual_id = '.auth()->user()->id.' and status=1')->count();

        //filter
        $artis = DB::table('artis')->orderBy('nama','asc')->get();
        $penjual = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1")
            ->selectRaw('users.id as id, users.username as username, users.nama as nama')
            ->get();

        return view('user-fans/lelang/daftar-lelang',
            ['error' => $error,
            'koin' => updateDeposito(getTanggal()),
            'pengikut' => $pengikut,
            'ikutlelang' => $ikutlelang,
            'pesan' => 'belum',
            'penjual' => $penjual,
            'artis' => $artis,
            'filter' => ['penjual' => null,'artis' => null,'kategori' => null,'mulai' => null,'selesai' => null,'status' => null],
            'hari_ini' => getTanggal(),
            'lelang' => $lelang
        ]);
    }

    /*
username penjual,
range waktu lelang >> tanggal_mulai - tanggal_selesai,
kategori produk lelang,
nama atau grup artis yang termasuk di produknya,
artis favorit apabila data artis favorit sudah diisi di fitur profile.
    */
    //daftar lelang yg berjalan (filter)
    public function filterLelang(Request $req) {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        // dd($req);

        $kategori = null;
        $artis = null;
        $penjual = null;
        $mulai = date("Y-m-d", strtotime($req->mulai));
        $jamMulai = date("H:i", strtotime($req->jamMulai));
        $selesai = date("Y-m-d", strtotime($req->selesai));
        $jamSelesai = date("H:i", strtotime($req->jamSelesai));
        $tgl_mulai = $mulai.' '.$jamMulai;
        $tgl_selesai = $selesai.' '.$jamSelesai;

        if($tgl_mulai.':00' >= $tgl_selesai.':00') {
            return redirect()->back()
                ->withErrors(
                    ['errornya' => 'Tanggal Dimulai Lelang adalah
                    Tanggal Sebelum Tanggal Selesai Lelang yang Ditentukan']);
        }
        dd($tgl_mulai,$tgl_selesai,$req->kategori,$req->artis,$req->penjual);

        // if($req->mulai == null) return redirect()->back()->withErrors(['mulai' => 'Wajib mengisi Tanggal Dimulai Lelang.']);
        // if($req->jamMulai == null) return redirect()->back()->withErrors(['jamMulai' => 'Wajib mengisi Jam Dimulai Lelang.']);
        // if($req->selesai == null) return redirect()->back()->withErrors(['selesai' => 'Wajib mengisi Tanggal Selesai Lelang.']);
        // if($req->jamSelesai == null) return redirect()->back()->withErrors(['jamSelesai' => 'Wajib mengisi Jam Selesai Lelang.']);

        // if($req->kategori == 'Tidak Ada')
        // if($req->artis == 'Tidak Ada')
        // if($req->penjual == 'Tidak Ada')
        $artis = DB::table('artis')->where(strtolower('nama'),'=',strtolower($req->artis))->count(['id']);

        //ini daftar lelang
        $lelang = [];
        $error = false;
        $dbase = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->join('lelang','lelang.penjual_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1
                and lelang.status = 1 and tanggal_mulai<='".getTanggal()."' and tanggal_selesai>='".getTanggal()."'")
            ->selectRaw('users.id as user, users.username as username, users.nama as nama, users.kota as kota,
                lelang.id as lelang, lelang.nama_produk as produk, lelang.deskripsi_produk as detail, lelang.gambar_produk as gambar,
                lelang.koin_minimal as harga, lelang.tanggal_mulai as mulai, lelang.tanggal_selesai as selesai')
            // ->groupBy('id','username','nama','kota','created_at','updated_at','gambar')
            ->orderBy('lelang.tanggal_mulai','desc')
            ->get();

        $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        foreach ($dbase as $value) {
            $tanggal_format = strtotime($value->mulai);
            $mulai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
            $tanggal_format = strtotime($value->selesai);
            $selesai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));

            $userikut = DB::table('lelang_bid')->whereRaw('lelang_id = '.$value->lelang.' and user_id = '.auth()->user()->id.' and status >= 1')->count();
            $ikut = DB::table('lelang_bid')->whereRaw('lelang_id = '.$value->lelang.' and status>=1')->count();

            if(($value->selesai >= $tgl_mulai.':00' && $value->selesai <= $tgl_selesai.':00') ||
                ($value->mulai <= $tgl_selesai.':00' && $value->mulai >= $tgl_mulai.':00') ||
                ($value->mulai <= $tgl_mulai.':00' && $value->selesai >= $tgl_selesai.':00')){
                // m0(mulai setiap lelang) <= s
                // print($value->mulai.' - <strong>'.$value->selesai.'</strong><br><strong>'.$tgl_mulai.':00</strong> - '.$tgl_selesai.':00<br>sbg mulai<hr>');
                // s0(selesai setiap lelang) >= m
                // print("<strong>".$value->mulai.'</strong> - '.$value->selesai.'<br>'.$tgl_mulai.':00 - <strong>'.$tgl_selesai.':00</strong> <br>sbg selesai <hr>');
                // m0(mulai setiap lelang) <= m && s0(selesai setiap lelang) >= s
                // print("<strong>".$value->mulai.'</strong> - <strong>'.$value->selesai.'</strong><br>'.$tgl_mulai.':00 - '.$tgl_selesai.':00 <br>sbg antara <hr>');
                $lelang[] = [
                    'lelang' => $value->lelang,
                    'produk' => $value->produk,
                    'gambar' => $value->gambar,
                    'detail' => $value->detail,
                    'harga' => $value->harga,
                    // 'kelipatan' => $value->kelipatan,
                    'mulai' => $mulai,
                    'selesai' => $selesai,
                    'user' => $value->user,
                    'username' => $value->username,
                    'nama' => $value->nama,
                    'kota' => $value->kota,
                    // 'created_at' => $created,
                    // 'updated_at' => $updated,
                    // 'pengikut' => $jumlahikut,
                    'ikut' => $ikut,
                    'userikut' => $userikut
                ];
            }
        }

        $ikutlelang = DB::table('lelang_bid')->whereRaw("status >= 1 and user_id = '".auth()->user()->id."'")->count();
        $pengikut = DB::table('pengikut')->whereRaw('penjual_id = '.auth()->user()->id.' and status=1')->count();

        //filter
        $artis = DB::table('artis')->orderBy('nama','asc')->get();
        $penjual = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1")
            ->selectRaw('users.id as id, users.username as username, users.nama as nama')
            ->get();
        $tanggal_format = strtotime($tgl_mulai);
        $tgl_mulai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
        $tanggal_format = strtotime($tgl_selesai);
        $tgl_selesai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));

        return view('user-fans/lelang/daftar-lelang',
            ['error' => $error,
            'koin' => updateDeposito(getTanggal()),
            'pengikut' => $pengikut,
            'ikutlelang' => $ikutlelang,
            'pesan' => 'belum',
            'penjual' => $penjual,
            'artis' => $artis,
            'filter' => ['penjual' => $req->penjual,'artis' => $req->artis, 'kategori' => $req->kategori, 'mulai' => $tgl_mulai, 'selesai' => $tgl_selesai, 'status' => $req->status],
            'hari_ini' => getTanggal(),
            'lelang' => $lelang]);
    }

    //update status lelang (cek koin user yg kasus bid lagi tapi belum bayar, done)
    //lihat lelang (belum dirilis, berjalan dan selesai)
    public function lihatLelang($id) {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $error = false;
        $pesan = 'tidak ikut';
        $lelang = [];
        $dbase = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->join('lelang','lelang.penjual_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1
                and lelang.id = ".$id)//.
            ->selectRaw('users.id as user, users.username as username, users.nama as nama, users.kota as kota,
                lelang.id as lelang,
                lelang.nama_produk as produk,
                lelang.gambar_produk as gambar,
                lelang.deskripsi_produk as detail,
                lelang.koin_minimal as harga,
                lelang.kategori as kategori,
                lelang.artis as artis,
                lelang.tanggal_mulai as mulai,
                lelang.tanggal_selesai as selesai,
                lelang.status as status,
                lelang.transaksi_pemenang as pemenang,
                lelang.transaksi_penjual as penjual,
                lelang.transaksi_admin as admin,
                lelang.admin_id as idadmin,
                lelang.catatan as catatan')
                // lelang.persentase_penjual as persenpenjual,
                // lelang.persentase_admin as persenadmin,
            ->get();

        foreach ($dbase as $value){
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            // $tanggal_format = strtotime($value->updated_at);
            // $updated = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));
            // $tanggal_format = strtotime($value->created_at);
            // $created = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));

            $tanggal_format = strtotime($value->mulai);
            $mulai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
            $tanggal_format = strtotime($value->selesai);
            $selesai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
            $statusnya = -1;//preview user yg follow
            $ambilstatus = updateStatusLelang($value->mulai, $value->selesai,
            [
                'id' => $id,
                'status' => $value->status,
                'penjual' => $value->user,
                'admin' => $value->idadmin,
            ]);
            // dd($statusnya['status'],$statusnya['pesan']);
            // if($value->mulai <= getTanggal() && $value->selesai >= getTanggal()) {
                // if(($value->status == 3 || $value->status == 1) && $ambilstatus['status'] == $value->status) $statusnya = 1;
                // else
                if($value->status == 0 || $value->status == 2) return redirect()->route('daftarLelang');//status=0/2
            // }

            $pengikut = DB::table('pengikut')->whereRaw('penjual_id = '.$value->user.' and status=1')->count();
            $ikut = DB::table('lelang_bid')->whereRaw('lelang_id = '.$value->lelang.' and status>=1')->get();
            $userikut = DB::table('lelang_bid')->whereRaw('lelang_id = '.$value->lelang.' and user_id = '.auth()->user()->id.' and status >= 1')->orderBy('tanggal_bid','desc')->get();
            $dbpemenang = DB::table('transaksi_koin')
                ->join('users','users.id','=','transaksi_koin.user_id')
                ->whereRaw("transaksi_koin.jenis = 'lelang' and transaksi_koin.id = '".$value->pemenang."'")
                ->selectRaw('users.nama as nama, transaksi_koin.koin as koin')
                ->get();
            if(count($userikut) >= 1) $pesan = 'ikut';
            // $item->nama == auth()->user()->nama
            $pemenang = [];
            if(count($dbpemenang) == 1) {
                $pemenang = [
                    'nama' => $dbpemenang[0]->nama,
                    'koin' => $dbpemenang[0]->koin,
                    'idtrans' => $value->pemenang
                ];
            }
            // dd($pemenang);

            $lelang[] = [
                'lelang' => $value->lelang,
                'produk' => $value->produk,
                'gambar' => $value->gambar,
                'detail' => $value->detail,
                'harga' => $value->harga,
                'kategori' => $value->kategori,
                'artis' => $value->artis,
                'mulai' => $mulai,
                'selesai' => $selesai,
                'status' => ($ambilstatus['status'] == 1 || $ambilstatus['status'] == 3 ? $ambilstatus['status'] : ($ambilstatus['status'] == -1 ? 1 : 0)),
                'mode' => $ambilstatus['pesan'],
                'pemenang' => $pemenang,
                'penjual' => $value->penjual,
                'admin' => $value->admin,
                // 'catatan' => $value->catatan,
                'user' => $value->user,
                'username' => $value->username,
                'nama' => $value->nama,
                'kota' => $value->kota,
                'pengikut' => $pengikut,
                'ikutlelang' => $ikut,
                'userikut' => $userikut,//array
            ];
            // dd($ambilstatus['status']);
        }

        return view('user-fans/lelang/lihat-lelang',
            [
            'error' => $error,
            'koin' => updateDeposito(getTanggal()),
            // 'pengikut' => $pengikut,
            'hari_ini' => getTanggal(),
            'pesan' => $pesan,
            'lelang' => $lelang
        ]);
    }

    //bid lelang done (sudah cek apa ada lelang yg belum dibayar)
    public function ikutLelang(Request $req) {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $carilelang = DB::table('lelang')->whereRaw('id = '.$req->id.' and status >= 1')->get();
        $cariBid = DB::table('lelang_bid')->whereRaw('lelang_id = '.$req->id.' and status >= 1 and user_id = '.auth()->user()->id)->get();
        // bid_id	lelang_id	user_id	koin_penawaran	tanggal_bid	status	ganti_bid
        // dd($req->jumlah > updateDeposito(getTanggal()),$req->id, $req->jumlah,count($cariBid),count($carilelang));

        //jika belum bayar yg dimenangkan
        $darilelang = DB::table('transaksi_koin')
            ->select(DB::raw('SUM(koin * jumlah) as total_koin'))
            ->where('user_id','=',auth()->user()->id)
            ->where('status', 'Belum')
            ->where('jenis', 'lelang')
            ->first();
        // dd((int)$req->jumlah,(int)updateDeposito(getTanggal()),(int)$req->jumlah > (int)updateDeposito(getTanggal()));
        $deposito = updateDeposito(getTanggal());
        $jumlahnya = (int)($deposito)+(int)($darilelang->total_koin);

        if((int)$req->jumlah > $jumlahnya) return redirect()->back()->with(['koin',updateDeposito(getTanggal())])->withErrors(['Deposito Koin Anda Tidak Mencukupi.']);
        if($req->jumlah == $carilelang[0]->koin_minimal) return redirect()->back()->with(['koin',updateDeposito(getTanggal())])->withErrors(['Jumlah Penawaran Anda Harus Lebih Besar daripada Koin Penawaran Awal.']);
        if((int)$req->jumlah > (int)$deposito) return redirect()->back()->with(['koin',updateDeposito(getTanggal())])->withErrors(['Jumlah Penawaran Anda Lebih Besar daripada Deposito Koin Anda.']);
        if(count($cariBid) == 0){
            $insertBid = DB::table('lelang_bid')
            ->insert([
                'lelang_id'	=> $req->id,
                'user_id' => auth()->user()->id,
                'koin_penawaran' => $req->jumlah,
                'tanggal_bid' => getTanggal(),
                'status'=> 1,
                'menang'=> 0,
            ]);
            if($insertBid == 1) return redirect()->back()->with(['success','Penawaran Anda Berhasil.'],['koin',updateDeposito(getTanggal())]);
        }
        else if(count($cariBid) == 1){
            $updatedBid = DB::table('lelang_bid')
                ->whereRaw('lelang_id = '.$req->id.' and user_id ='.auth()->user()->id)
                ->update([
                    'koin_penawaran' => $req->jumlah,
                    'tanggal_bid' => getTanggal(),
                    'status'=> 2,
                ]);
                if($updatedBid == 1) return redirect()->back()->with(['success','Penawaran Anda Berhasil.'],['koin',updateDeposito(getTanggal())]);
        }
        else return redirect()->back();
    }

    //update status lelang
    //sejarah lelang (ada filtering post) done
    public function sejarahLelang() {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $sejarah = [];
        $error = false;
        $dbase = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->join('lelang','lelang.penjual_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1 and lelang.status >= 1")
            ->selectRaw('users.id as user, users.username as username, users.nama as nama, users.kota as kota,
                lelang.id as lelang, lelang.nama_produk as produk, lelang.deskripsi_produk as detail, lelang.gambar_produk as gambar,
                lelang.koin_minimal as harga, lelang.tanggal_mulai as mulai, lelang.tanggal_selesai as selesai,
                lelang.status as status, lelang.admin_id as admin, lelang.transaksi_pemenang as pemenang')//lelang.persentase_penjual as persenpenjual, lelang.persentase_admin as persenadmin
            // ->groupBy('id','username','nama','kota','created_at','updated_at','gambar')
            ->orderBy('lelang.tanggal_mulai','desc')
            ->get();

        foreach ($dbase as $value) {
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $tanggal_format = strtotime($value->mulai);
            $mulai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
            $tanggal_format = strtotime($value->selesai);
            $selesai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));

            $statusnya = updateStatusLelang($value->mulai, $value->selesai,
            [
                'id' => $value->lelang,
                'status' => $value->status,
                'penjual' => $value->user,//auth()->user()->id,
                'admin' => $value->admin,
            ]);

            $ikut = [];
            $userikut = DB::table('lelang_bid')
                ->join('lelang','lelang.id','=','lelang_bid.lelang_id')
                ->whereRaw("lelang.id = '".$value->lelang."' and lelang.status >= 1 and lelang_bid.user_id = '".auth()->user()->id."'")
                ->selectRaw('lelang_bid.tanggal_bid as tgl, lelang_bid.koin_penawaran as koin')
                // ->groupBy('bid','tgl_bid')
                ->orderBy('lelang_bid.bid_id','desc')
                ->get();

            if(count($userikut) > 0) {
                $where = '';
                if($value->pemenang != null) $where = ' and id='.$value->pemenang;
                $pemenang = DB::table('transaksi_koin')->whereRaw("jenis = 'lelang' and user_id=".auth()->user()->id."".$where)->count();
                // print($pemenang."<br>");

                $tanggal_format = strtotime($userikut[0]->tgl);
                $ikut['tgl'] = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
                $ikut['jumlah'] = $userikut[0]->koin;
                $ikut['menang'] = $pemenang;
                $sejarah[] = [
                    'lelang' => $value->lelang,
                    'produk' => $value->produk,
                    'gambar' => $value->gambar,
                    'detail' => $value->detail,
                    'harga' => $value->harga,
                    'status' => $statusnya,
                    'mulai' => $mulai,
                    'selesai' => $selesai,
                    'user' => $value->user,
                    'username' => $value->username,
                    'nama' => $value->nama,
                    'kota' => $value->kota,
                    'ikut' => $ikut
                ];
                // print($statusnya['status']." == ".$statusnya['pesan']."<br>");
            }
        }
        // dd($sejarah);
        $ikutlelang = DB::table('lelang_bid')->whereRaw("status >= 1 and user_id = '".auth()->user()->id."'")->count();
        $pengikut = DB::table('pengikut')->whereRaw('penjual_id = '.auth()->user()->id.' and status=1')->count();

        return view('user-fans/lelang/sejarah-lelang',
            ['error' => $error,
            'koin' => updateDeposito(getTanggal()),
            'pengikut' => $pengikut,
            'ikutlelang' => $ikutlelang,
            'pesan' => 'belum',
            'filter' => ['mulai' => null, 'selesai' => null, 'status' => null],
            'hari_ini' => getTanggal(),
            'lelang' => $sejarah]);
    }

    // dg range waktu dan status lelang (berjalan dan menang/selesai))
    //sejarah lelang (filter) done
    public function filterSejarah(Request $req) {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $mulai = date("Y-m-d", strtotime($req->mulai));
        $jamMulai = date("H:i", strtotime($req->jamMulai));
        $selesai = date("Y-m-d", strtotime($req->selesai));
        $jamSelesai = date("H:i", strtotime($req->jamSelesai));
        $tgl_mulai = $mulai.' '.$jamMulai;
        $tgl_selesai = $selesai.' '.$jamSelesai;
        if($tgl_mulai.':00' >= $tgl_selesai.':00') {
            return redirect()->back()
                ->withErrors(
                    ['errornya' => 'Tanggal Dimulai Lelang adalah
                    Tanggal Sebelum Tanggal Selesai Lelang yang Ditentukan']);
        }

        // dd($tgl_mulai,$tgl_selesai,$req->status);

        $sejarah = [];
        $error = false;
        $dbase = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->join('lelang','lelang.penjual_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1 and lelang.status >= 1")
            ->selectRaw('users.id as user, users.username as username, users.nama as nama, users.kota as kota,
                lelang.id as lelang, lelang.nama_produk as produk, lelang.deskripsi_produk as detail, lelang.gambar_produk as gambar,
                lelang.koin_minimal as harga, lelang.tanggal_mulai as mulai, lelang.tanggal_selesai as selesai,
                lelang.status as status, lelang.admin_id as admin, lelang.transaksi_pemenang as pemenang')//lelang.persentase_penjual as persenpenjual, lelang.persentase_admin as persenadmin
            // ->groupBy('id','username','nama','kota','created_at','updated_at','gambar')
            ->orderBy('lelang.tanggal_mulai','desc')
            ->get();

        $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        foreach ($dbase as $value) {
            // print($i."/ ");
            // $tanggal_format = strtotime($value->updated_at);
            // $updated = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));
            // $tanggal_format = strtotime($value->created_at);
            // $created = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));

            $tanggal_format = strtotime($value->mulai);
            $mulai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
            $tanggal_format = strtotime($value->selesai);
            $selesai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));

            if(($value->selesai >= $tgl_mulai.':00' && $value->selesai <= $tgl_selesai.':00') ||
                ($value->mulai <= $tgl_selesai.':00' && $value->mulai >= $tgl_mulai.':00') ||
                ($value->mulai <= $tgl_mulai.':00' && $value->selesai >= $tgl_selesai.':00')){
                // m0(mulai setiap lelang) <= s
                // print($value->mulai.' - <strong>'.$value->selesai.'</strong><br><strong>'.$tgl_mulai.':00</strong> - '.$tgl_selesai.':00<br>sbg mulai<hr>');
                // s0(selesai setiap lelang) >= m
                // print("<strong>".$value->mulai.'</strong> - '.$value->selesai.'<br>'.$tgl_mulai.':00 - <strong>'.$tgl_selesai.':00</strong> <br>sbg selesai <hr>');
                // m0(mulai setiap lelang) <= m && s0(selesai setiap lelang) >= s
                // print("<strong>".$value->mulai.'</strong> - <strong>'.$value->selesai.'</strong><br>'.$tgl_mulai.':00 - '.$tgl_selesai.':00 <br>sbg antara <hr>');

                $statusnya = updateStatusLelang($value->mulai, $value->selesai,
                [
                    'id' => $value->lelang,
                    'status' => $value->status,
                    'penjual' => $value->user,//auth()->user()->id,
                    'admin' => $value->admin,
                ]);

                $ikut = [];
                $userikut = DB::table('lelang_bid')
                    ->join('lelang','lelang.id','=','lelang_bid.lelang_id')
                    ->whereRaw("lelang.id = '".$value->lelang."' and lelang.status >= 1 and lelang_bid.user_id = '".auth()->user()->id."'")
                    ->selectRaw('lelang_bid.tanggal_bid as tgl, lelang_bid.koin_penawaran as koin')
                    // ->groupBy('bid','tgl_bid')
                    ->orderBy('lelang_bid.bid_id','desc')
                    ->get();

                if(count($userikut) > 0) {
                    $where = '';
                    if($value->pemenang != null) $where = ' and id='.$value->pemenang;
                    $pemenang = DB::table('transaksi_koin')->whereRaw("jenis = 'lelang' and user_id=".auth()->user()->id."".$where)->count();
                    // print($pemenang."<br>");

                    $tanggal_format = strtotime($userikut[0]->tgl);
                    $ikut['tgl'] = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
                    $ikut['jumlah'] = $userikut[0]->koin;
                    $ikut['menang'] = $pemenang;
                    if(($req->status == 'menang' && $ikut['menang'] == 1) || $req->status == $statusnya['pesan']){
                        // print("<strong>menang (".$statusnya['pesan'].')</strong> '.$value->mulai.' - '.$value->selesai.'<br>'.$tgl_mulai.':00 - '.$tgl_selesai.':00<br> dengan status <strong>'.$req->status.'</strong><hr>');
                        // print("<strong>".$statusnya['pesan'].'</strong> '.$value->mulai.' - '.$value->selesai.'<br>'.$tgl_mulai.':00 - '.$tgl_selesai.':00<br> dengan status <strong>'.$req->status.'</strong><hr>');
                        // else print("<strong>bukan ".$statusnya['pesan'].'</strong> '.$value->mulai.' - '.$value->selesai.'<br>'.$tgl_mulai.':00 - '.$tgl_selesai.':00<br> dengan status <strong>'.$req->status.'</strong><hr>');

                        $sejarah[] = [
                            'lelang' => $value->lelang,
                            'produk' => $value->produk,
                            'gambar' => $value->gambar,
                            'detail' => $value->detail,
                            'harga' => $value->harga,
                            'status' => $statusnya,
                            'mulai' => $mulai,
                            'selesai' => $selesai,
                            'user' => $value->user,
                            'username' => $value->username,
                            'nama' => $value->nama,
                            'kota' => $value->kota,
                            'ikut' => $ikut
                        ];
                    }
                }
            }
        }
        // dd($sejarah);
        $ikutlelang = DB::table('lelang_bid')->whereRaw("status >= 1 and user_id = '".auth()->user()->id."'")->count();
        $pengikut = DB::table('pengikut')->whereRaw('penjual_id = '.auth()->user()->id.' and status=1')->count();

        $tanggal_format = strtotime($tgl_mulai);
        $tgl_mulai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
        $tanggal_format = strtotime($tgl_selesai);
        $tgl_selesai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));

        return view('user-fans/lelang/sejarah-lelang',
            ['error' => $error,
            'koin' => updateDeposito(getTanggal()),
            'pengikut' => $pengikut,
            'ikutlelang' => $ikutlelang,
            'pesan' => 'belum',
            'filter' => ['mulai' => $tgl_mulai, 'selesai' => $tgl_selesai, 'status' => $req->status],
            'hari_ini' => getTanggal(),
            'lelang' => $sejarah]);
    }

    //penjual - pengikutnya done
    public function getPengikut() {
        if(auth()->user()->role != 3 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $error = false;
        $pengikut = [];
        $dbase = DB::table('pengikut')
            ->join('users','users.id','=','pengikut.pengikut_id')
            ->whereRaw('pengikut.penjual_id = '.auth()->user()->id.' and pengikut.status=1')
            ->selectRaw('pengikut.pengikut_id as id, users.nama as nama, users.username as username')->get();

        foreach ($dbase as $value) {
            $pengikut[] = [
                'id' => $value->id,
                'username' => $value->username,
                'nama' => $value->nama
            ];
        }
        $ikut = DB::table('pengikut')->whereRaw('penjual_id = '.auth()->user()->id.' and status=1')->count();

        return view('user-penjual/pengikut',
            ['error' => $error,
            'koin' => updateDeposito(getTanggal()),
            'ikut' => $ikut,
            'pesan' => 'belum',
            'pengikut' => $pengikut,
        ]);
    }

    //update status lelang
    //penjual - master lelang done (ada filtering status lelang: masih berjalan, selesai, belum dirilis dan peringatan)
    public function masterLelang($status) {
        if(auth()->user()->role != 3 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $error = false;

        // print(count($duser));
        $pengikut = DB::table('pengikut')->whereRaw('penjual_id = '.auth()->user()->id.' and status=1')->count();
        $lelang = DB::table('lelang')->whereRaw('penjual_id = '.auth()->user()->id)->orderByDesc('tanggal_buat')->get();
        $master = [];

        foreach ($lelang as $value) {
            // $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            // $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $tanggal_format = strtotime($value->tanggal_buat);
            $buat = date("d F Y H:i:s", $tanggal_format);
            $tanggal_format = strtotime($value->tanggal_mulai);
            $mulai = date("d F Y H:i", $tanggal_format);
            $cekmulai = date("Y-m-d H:i:s", $tanggal_format);
            $tanggal_format = strtotime($value->tanggal_selesai);
            $selesai = date("d F Y H:i", $tanggal_format);
            $cekselesai = date("Y-m-d H:i:s", $tanggal_format);

            $statusnya = updateStatusLelang($value->tanggal_mulai, $value->tanggal_selesai,
            [
                'id' => $value->id,
                'status' => $value->status,
                'penjual' => auth()->user()->id,
                'admin' => $value->admin_id,
            ]);
            // 'persen-penjual' => $value->persentase_penjual,
            // 'persen-admin' => $value->persentase_admin,

            $ikutlelang = DB::table('lelang_bid')->whereRaw('lelang_id = '.$value->id)->count();//.' and status>=1'
            if($status == 'semua' || $status == $statusnya['pesan']){//menggunakan filter
                // print($statusnya['status']."--".$statusnya['pesan']."<br>");
                if($statusnya['status'] == 3 && $ikutlelang == 0) {
                    $statusnya['status'] = 1;
                    $statusnya['pesan'] = 'belum-penawar';
                }
                $master[] = [
                    'id' => $value->id,
                    'judul' => $value->nama_produk,
                    'gambar' => $value->gambar_produk,
                    'detail' => $value->deskripsi_produk,
                    'artis' => $value->artis,
                    'kategori' => $value->kategori,
                    'koin' => $value->koin_minimal,
                    // 'persen_penjual' => $value->persentase_penjual,
                    // 'persen_admin' => $value->persentase_admin,
                    'mulai' => $mulai,
                    'selesai' => $selesai,
                    'buat' => $buat,
                    'status' => $statusnya['status'],//$value->status,
                    // 'pemenang' => $value->transaksi_pemenang,
                    // 'penjual' => $value->transaksi_penjual,
                    // 'admin' => $value->transaksi_admin,
                    // 'statuskirim' as $value->status_pengiriman,
                    // 'alamat' as $value->alamat_pengiriman,
                    // 'catatan' => $value->catatan,
                    'pesan' => $statusnya['pesan'],
                    'ikut' => $ikutlelang
                ];
            }
        }
        // dd($master);

        return view('user-penjual/master-lelang',
            ['error' => $error,
            'koin' => updateDeposito(getTanggal()),
            'pengikut' => $pengikut,
            'pesan' => 'belum',
            'hari_ini' => getTanggal(),
            'lelang' => $master,
        ]);
    }

    //update status lelang
    //penjual - buka lelang yg baru / ubah nope belum perbaikan
    public function formLelang($id) {
        if(auth()->user()->role != 3 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $mode = 'baru';
        $pesan = 'buat';
        $detail = [];
        // $kategori = DB::table('lelang')->groupBy('kategori')->get(['kategori']);
        $artis = DB::table('artis')->orderBy('nama','asc')->get();
        if($id != 'baru') {
            $mode = $id;
            $pesan = 'ubah';
            $lelang = DB::table('lelang')->whereRaw('penjual_id = '.auth()->user()->id.' and id='.$id)->get();
            $penawar = DB::table('lelang_bid')->whereRaw('lelang_id = '.$id)->count();
            foreach ($lelang as $value) {
                $tanggal_format = strtotime($value->tanggal_buat);
                $buat = date("d F Y H:i:s", $tanggal_format);
                $mulai = date("Y-m-d", strtotime($value->tanggal_mulai));
                $jamMulai = date("H:i", strtotime($value->tanggal_mulai));
                $selesai = date("Y-m-d", strtotime($value->tanggal_selesai));
                $jamSelesai = date("H:i", strtotime($value->tanggal_selesai));

                $statusnya = updateStatusLelang($value->tanggal_mulai, $value->tanggal_selesai,[
                    'id' => $id,
                    'status' => $value->status,
                    'penjual' => auth()->user()->id,
                    'admin' => $value->admin_id,
                ]);
                // 'persen-penjual' => $value->persentase_penjual,
                // 'persen-admin' => $value->persentase_admin,
                $pesan = $statusnya['pesan'];
                if($statusnya['status'] == 3 && ($penawar == null || $penawar == 0)) {
                    $statusnya['status'] = 1;
                    $pesan = 'belum-penawar';
                }
                else if($statusnya['status'] == 2 || $statusnya['status'] == 3) {$pesan = $statusnya['pesan'];}//revisi/perbaikan dan selesai
                $detail = [
                    'id' => $id,
                    'judul' => $value->nama_produk,
                    'gambar' => $value->gambar_produk,
                    'detail' => $value->deskripsi_produk,
                    'artis' => $value->artis,
                    'kategori' => $value->kategori,
                    'koin' => $value->koin_minimal,
                    // 'persen_penjual' => $value->persentase_penjual,
                    // 'persen_admin' => $value->persentase_admin,
                    'mulai' => $mulai,
                    'jamMulai' => $jamMulai,
                    'selesai' => $selesai,
                    'jamSelesai' => $jamSelesai,
                    'buat' => $buat,
                    'status' => $statusnya['status'],
                    'pemenang' => $value->transaksi_pemenang,
                    'penjual' => $value->transaksi_penjual,
                    'admin' => $value->transaksi_admin,
                    'catatan' => $value->catatan,
                    'penawar' => ($penawar == null ? 0 : $penawar)
                ];
            }
            if(count($lelang) == 0) return redirect()->route('daftarLelang');
        }
        $pengikut = DB::table('pengikut')->whereRaw('penjual_id = '.auth()->user()->id.' and status=1')->count();

        // $jam =  ( (int) date('H') )+7;
        // if($jam >= 24) $jam = "0".($jam - 24).':'.date('i');
        // elseif($jam < 10) $jam = "0".$jam.':'.date('i');

        return view('user-penjual/form-lelang',[
            'mode' => $mode,
            'pesan' => $pesan,
            'pengikut' => $pengikut,
            'koin' => updateDeposito(getTanggal()),
            // 'kategori' => $kategori,
            'artis' => $artis,
            'hari_ini' => getTanggal(),
            // 'jam' => $jam,
            'detail' => $detail
        ]);
    }

    //belum buat setelah lelang berakhir (status=3) ato peringatan
    //penjual - kirim data lelang yg baru / ubah nope belum perbaikan
    public function isiLelang(Request $request) {
        if(auth()->user()->role != 3 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        // $attributes = request()->validate([
        //     'judul' => ['required','max:100'],
        //     'gambar' => ['required','image','between:1,10240', Rule::dimensions()->maxWidth(10000)->maxHeight(10000)],
        //     'detail' => ['required','max:1000'],
        //     'kategori' => ['required'],
        //     'pilihK' => ['required'],
        //     'artis' => ['required'],
        //     'pilihA' => ['required'],
        //     'koin' => ['required'],
        //     'mulai' => ['required'],
        //     'jamMulai' => ['required'],
        //     'selesai' => ['required'],
        //     'jamSelesai' => ['required'],
        // ],[
        //     'required' => 'Wajib Mengisi Seluruh Data Lelang',
        //     'judul.max'=> 'Panjang Judul lebih dari 100 karakter.',
        //     'detail.max' => 'Panjang Detail lebih dari 1000 karakter.',
        //     // 'koin.min' => 'Panjang Koin harus lebih dari 10 Koin.',
        //     'gambar.image' => 'Gambar Produk harus dalam file [.jpg / .jpeg / .png / .gif].',
        //     'gambar.between' => 'Ukuran Gambar Produk harus antara 1 KB dan 10 MB.',
        //     'gambar.dimensions' => 'Dimensi Gambar Produk melebihi batas maksimum.'
        // ]);

        $kategorinya = $request->kategori;
        $pilihartis = $request->pilihA;
        $buat = getTanggal();
        $mulai = date("Y-m-d", strtotime($request->mulai));
        $jamMulai = date("H:i", strtotime($request->jamMulai));
        $selesai = date("Y-m-d", strtotime($request->selesai));
        $jamSelesai = date("H:i", strtotime($request->jamSelesai));
        $tgl_mulai = $mulai.' '.$jamMulai;
        $tgl_selesai = $selesai.' '.$jamSelesai;
        $statusnya = 1;
        if ($statusnya == 0 && $request->catatan != null) $statusnya = 2;
        // else $statusnya = 0;

        $lelang = DB::table('lelang')->count();
        $ubah = [];
        if($request->pesan == 'ubah') {
            $ubah = DB::table('lelang')
            ->whereRaw("penjual_id = '".auth()->user()->id."' and id = '".$request->id."'")->selectRaw('admin_id, gambar_produk')->get();
        }

        $gmb = auth()->user()->gambar_profile;
        if($request->hasFile('gambar')){
            $nama = 'lelang';//C:\xampp\htdocs\projectTA\public
            $file = $request->gambar;
            $ext = $file->getClientOriginalExtension();
            $filename = "lelang-".($lelang+1).".".$ext;
            $file->move("C:\\xampp\htdocs\projectTA\public\\".$nama,$filename);

            if(count($ubah) == 1) $gmb = $ubah[0]->gambar_produk;
            $gmb = "../".$nama."/".$filename;
        }
        else if ($request->mode == 'baru') return redirect()->back()->withErrors(['gambar' => 'Wajib mengisi Gambar Produk.']);
        else $gmb = $request->foto;

        if($request->judul == null) return redirect()->back()->withErrors(['judul' => 'Wajib mengisi Nama Produk.']);
        else if(strlen($request->judul) > 100) return redirect()->back()->withErrors(['judul' => 'Nama Produk tidak lebih dari 100 Karakter.']);
        if($request->detail == null) return redirect()->back()->withErrors(['detail' => 'Wajib mengisi Detail Produk.']);
        else if(strlen($request->detail) > 1000) return redirect()->back()->withErrors(['detail' => 'Detail Produk tidak lebih dari 1000 Karakter.']);
        if($request->koin == null) return redirect()->back()->withErrors(['koin' => 'Wajib mengisi Harga Minimal Penawaran Produk.']);

        // dd([
        // getTanggal(),$tgl_mulai.':00',$tgl_selesai.':00',
        // getTanggal()>$tgl_mulai.':00',
        // getTanggal()>$tgl_selesai.':00'
        // $request->dimulai,
        // $request->mulai != null,
        // $request->dimulai != $request->mulai
        // ]);
        if($request->pesan == 'ubah'){
            if($request->penawar > 0 && $request->mulai != null) return redirect()->back()->withErrors(['mulai' => 'Lelang Anda sudah ada Penawar, maka Tanggal Dimulai Lelang Tidak Bisa Diubah.']);
            else if(getTanggal()>=$tgl_selesai.':00') return redirect()->back()->withErrors(['selesai' => 'Tanggal Selesai Lelang harus Diisi dengan Tanggal Setelah Saat ini.']);
        }
        else if($tgl_mulai.':00'>=$tgl_selesai.':00') return redirect()->back()->withErrors(['mulai' => 'Tanggal Dimulai Lelang harus Sebelum Tanggal Selesai Lelang']);
        else if($request->pesan == 'buat' && $request->mode == 'baru'){
            if($request->mulai == null) return redirect()->back()->withErrors(['mulai' => 'Wajib mengisi Tanggal Dimulai Lelang.']);
            if($request->jamMulai == null) return redirect()->back()->withErrors(['jamMulai' => 'Wajib mengisi Jam Dimulai Lelang.']);
            if($request->selesai == null) return redirect()->back()->withErrors(['selesai' => 'Wajib mengisi Tanggal Selesai Lelang.']);
            if($request->jamSelesai == null) return redirect()->back()->withErrors(['jamSelesai' => 'Wajib mengisi Jam Selesai Lelang.']);
            if(getTanggal()>$tgl_mulai.':00' || getTanggal()>$tgl_selesai.':00') return redirect()->back()->withErrors(['mulai' => 'Tanggal Dimulai Lelang atau Tanggal Selesai Lelang harus Diisi dengan Tanggal Setelah Saat ini.']);
        }

        if($request->artis != null){
            if(($request->pilihA == $request->artis)
                || ($request->pilihA == 'Tidak Ada' && $request->artis != 'Tidak Ada')
                || ($request->pilihA != 'Tidak Ada' && strtolower($request->artis) == 'tidak ada')) $pilihartis = $request->artis;
            else $pilihartis = $request->pilihA." ".$request->artis;
        }
        else $pilihartis = $request->pilihA;

        $artis = DB::table('artis')->where(strtolower('nama'),'=',strtolower($pilihartis))->count(['id']);
        // dd([$request->pesan,$request->artis,$request->pilihA, $pilihartis,$artis]);

        if($artis == 0 && $pilihartis != 'Tidak Ada') $artis = DB::table('artis')->insert(['nama' => $pilihartis,'status' => 1]);

        $admin = rand(4,13);
        if($request->mode == 'baru'){
            DB::table('lelang')
                ->insert([
                    'penjual_id' => auth()->user()->id,
                    'nama_produk' => $request->judul,
                    'gambar_produk' => $gmb,
                    'deskripsi_produk' => $request->detail,
                    'kategori' => $kategorinya,
                    'artis' => $pilihartis,
                    'koin_minimal' => $request->koin,
                    // 'persentase_penjual' => $request->persen_penjual,
                    // 'persentase_admin' => 5,
                    'tanggal_mulai' => $tgl_mulai,
                    'tanggal_selesai' => $tgl_selesai,
                    'tanggal_buat' => $buat,
                    'status' => 1,
                    'admin_id' => ($admin == 4 ? 1 : $admin)
                    // 'pemenang' => $value->transaksi_pemenang,
                    // 'penjual' => $value->transaksi_penjual,
                    // 'admin' => $value->transaksi_admin,
                    // 'statuskirim' => $value->status_pengiriman,
                    // 'alamat' => $value->alamat_pengiriman,
                    // 'catatan' => $value->catatan
                ]);
        } else if($request->pesan != 'selesai') {
            // dd([$request->id,auth()->user()->id, $ubah]);
            DB::table('lelang')
                ->whereRaw("penjual_id = ".auth()->user()->id." and id = ".$request->id)
                ->update([
                    'nama_produk' => $request->judul,
                    'gambar_produk' => $gmb,
                    'deskripsi_produk' => $request->detail,
                    'artis' => $pilihartis,
                    'kategori' => $kategorinya,
                    'koin_minimal' => $request->koin,
                    // 'persentase_penjual' => $request->persen_penjual,
                    // 'persentase_admin' => 5,
                    'tanggal_mulai' => ($tgl_mulai == '1970-01-01 07:00' ? $request->dimulai : $tgl_mulai),
                    'tanggal_selesai' => $tgl_selesai,
                    'status' => $statusnya,
                    'admin_id' => (count($ubah) == 1 ? ($ubah[0]->admin_id == null ? ($admin == 4 ? 1 : $admin) : $ubah[0]->admin_id) : ($admin == 4 ? 1 : $admin))
                    // 'tanggal_buat' => $buat,
                    // 'transaksi_pemenang' => $transaksi_pemenang,
                    // 'transaksi_penjual' => $transaksi_penjual,
                    // 'transaksi_admin' => $transaksi_admin,
                    // 'catatan' => $value->catatan
            ]);
        }

        $idnya = DB::table('lelang')->whereRaw("penjual_id = '".auth()->user()->id."' and nama_produk = '".$request->judul."'")->get('id');
        if(count($idnya) == 1) return redirect()->route('formLelang',['id'=> $idnya[0]->id]);
        // */
        // '/master-lelang'
        // return view('user-penjual/buat-lelang',[
        // ]);
    }

    //penjual - lihat penawar dari lelang done
    public function getPenawarLelang($id) {
        if(auth()->user()->role != 3 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $lelang = DB::table('lelang')->whereRaw('penjual_id = '.auth()->user()->id.' and id='.$id)->get();
        if(count($lelang) == 0) return redirect()->route('daftarLelang');

        $penawar = [];
        $dbase = DB::table('lelang_bid')
            ->leftJoin('users','users.id','=','lelang_bid.user_id')
            ->whereRaw('lelang_bid.lelang_id = '.$lelang[0]->id.' and lelang_bid.status >= 1')
            ->selectRaw('lelang_bid.bid_id as id, lelang_bid.koin_penawaran as koin,
                lelang_bid.tanggal_bid as tgl, lelang_bid.status as status,
                users.id as iduser, users.nama as nama')
            ->orderBy('lelang_bid.tanggal_bid','desc')
            ->get();
        $tertinggi = 0;
        $usertertinggi = null;
        foreach ($dbase as $value) {
            $i = false;
            $trans = DB::table('transaksi_koin')->whereRaw("user_id = '$value->iduser' and jenis = 'lelang'")->get();
            if($tertinggi == 0 || $value->koin > $tertinggi) {
                $tertinggi = $value->koin;
                $usertertinggi = $value->nama;
            }
            // dd(count($trans));
            $penawar[] = [
                'id' => $value->id,
                'koin' => $value->koin,
                'tgl'	=> $value->tgl,
                'nama' => $value->nama,
                'status' => $value->status,
                'menang' => ($lelang[0]->status == 3 && count($trans) > 0 ? ' sebagai Pemenang' : 0),
            ];
        }
        $ikut = DB::table('pengikut')->whereRaw('penjual_id = '.auth()->user()->id.' and status=1')->count();
        // dd($penawar);

        return view('user-penjual/penawar',[
            'penawar' => $penawar,
            'koin' => updateDeposito(getTanggal()),
            'hari_ini' => getTanggal(),
            'tertinggi' => [$tertinggi,$usertertinggi],
            'ikut' => $ikut,
            'detail' => ['id' => $lelang[0]->id, 'judul' => $lelang[0]->nama_produk]
        ]);
    }

    //penjual - penghasilan semua lelang
    public function getPenghasilan() {
        if(auth()->user()->role != 3 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $lelang = DB::table('lelang')->whereRaw('penjual_id = '.auth()->user()->id)->get();
        if(count($lelang) == 0) return redirect()->route('daftarLelang');

        $berjalan = 0;
        $awal = DB::table('lelang')
            ->selectRaw(DB::raw('SUM(koin_minimal) as total_koin'))
            ->whereRaw('penjual_id = '.auth()->user()->id)
            ->get();
        $akhir = DB::table('lelang')
            ->join('transaksi_koin','lelang.transaksi_penjual','=','transaksi_koin.id')
            ->select(DB::raw('SUM(transaksi_koin.koin * transaksi_koin.jumlah) as total_koin'))
            ->whereRaw('lelang.penjual_id = '.auth()->user()->id.
                ' and transaksi_koin.jenis=lelang-penjual and transaksi_koin.status=Berhasil')
            ->first();

        foreach ($lelang as $value) {
            $tanggal_format = strtotime($value->tanggal_buat);
            $buat = date("d F Y H:i:s", $tanggal_format);
            $mulai = date("Y-m-d", strtotime($value->tanggal_mulai));
            $jamMulai = date("H:i", strtotime($value->tanggal_mulai));
            $selesai = date("Y-m-d", strtotime($value->tanggal_selesai));
            $jamSelesai = date("H:i", strtotime($value->tanggal_selesai));

            $penawar = DB::table('lelang_bid')->whereRaw('lelang_id = '.$value->id)->count();
            $pemenang = DB::table('transaksi_koin')->whereRaw('id = '.$value->transaksi_pemenang)->count();
            $penjual = DB::table('transaksi_koin')->whereRaw('id = '.$value->transaksi_penjual)->count();
            $admin = DB::table('transaksi_koin')->whereRaw('id = '.$value->transaksi_admin)->count();
            $statusnya = updateStatusLelang($value->tanggal_mulai, $value->tanggal_selesai,[
                'id' => $value->id,
                'status' => $value->status,
                'penjual' => auth()->user()->id,
                'admin' => $value->admin_id,
            ]);
            $pesan = $statusnya['pesan'];
            if($statusnya['status'] == 3 && ($penawar == null || $penawar == 0)) {
                $statusnya['status'] = 1;$pesan = 'belum-penawar';
            }
            else if($statusnya['status'] == 1 && $statusnya['pesan'] == 'berjalan') {$berjalan += 1;}
            else if($statusnya['status'] == 2 || $statusnya['status'] == 3) {$pesan = $statusnya['pesan'];}//revisi/perbaikan dan selesai
            $master = [
                'id' => $value->id,
                'judul' => $value->nama_produk,
                'gambar' => $value->gambar_produk,
                'detail' => $value->deskripsi_produk,
                'artis' => $value->artis,
                'kategori' => $value->kategori,
                'koin' => $value->koin_minimal,
                'mulai' => $mulai,
                'jamMulai' => $jamMulai,
                'selesai' => $selesai,
                'jamSelesai' => $jamSelesai,
                'buat' => $buat,
                'status' => $statusnya['status'],
                'pesan' => $pesan,
                'pemenang' => $pemenang,
                'penjual' => $penjual,
                'admin' => $admin,
                'catatan' => $value->catatan,
                'penawar' => ($penawar == null ? 0 : $penawar)
            ];
        }
        // $dbase = DB::table('lelang_bid')
        //     ->leftJoin('users','users.id','=','lelang_bid.user_id')
        //     ->whereRaw('lelang_bid.lelang_id = '.$lelang[0]->id.' and lelang_bid.status >= 1')
        //     ->selectRaw('lelang_bid.bid_id as id, lelang_bid.koin_penawaran as koin,
        //         lelang_bid.tanggal_bid as tgl, lelang_bid.status as status,
        //         users.id as iduser, users.nama as nama')
        //     ->orderBy('lelang_bid.tanggal_bid','desc')
        //     ->get();
        // $tertinggi = 0;
        // $usertertinggi = null;
        // foreach ($dbase as $value) {
        //     $i = false;
        //     $trans = DB::table('transaksi_koin')->whereRaw("user_id = '$value->iduser' and jenis = 'lelang'")->get();
        //     if($tertinggi == 0 || $value->koin > $tertinggi) {
        //         $tertinggi = $value->koin;
        //         $usertertinggi = $value->nama;
        //     }
        //     // dd(count($trans));
        //     $penawar[] = [
        //         'id' => $value->id,
        //         'koin' => $value->koin,
        //         'tgl'	=> $value->tgl,
        //         'nama' => $value->nama,
        //         'status' => $value->status,
        //         'menang' => ($lelang[0]->status == 3 && count($trans) > 0 ? ' sebagai Pemenang' : 0),
        //     ];
        // }
        // $ikut = DB::table('pengikut')->whereRaw('penjual_id = '.auth()->user()->id.' and status=1')->count();
        // // dd($penawar);

        return view('user-penjual/penghasilan-lelang'//);
        ,[
            // 'penawar' => $penawar,
            'koin' => updateDeposito(getTanggal()),
            'hari_ini' => getTanggal(),
            // 'tertinggi' => [$tertinggi,$usertertinggi],
            'berjalan' => $berjalan,
            'awal' => $awal->total_koin,
            'akhir' => $akhir->total_koin,
            'master' => $master
        ]);
    }
}
