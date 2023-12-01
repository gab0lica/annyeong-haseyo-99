<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
    $total = -1;
    if($jumlahkoin == null) $total = 0;
    $deposito = DB::table('deposito_koin')
        ->where('user_id','=',auth()->user()->id)
        ->update([
            'koin' => $total,
            'tanggal_update' => $tgl
        ]);
    if($deposito == 1) return $jumlahkoin->total_koin;
}

function updateStatusLelang($mulai, $selesai, $lelang){
    $statusnya = 0;//tidak aktif
    $pesan = 'belum';
    $usermenang = [];
    $cekmulai = date("Y-m-d H:i:s", strtotime($mulai));
    $cekselesai = date("Y-m-d H:i:s", strtotime($selesai));

    //bila lelang tidak aktif, maka biarkan, status = 0
    if($cekmulai > getTanggal() && $lelang['status'] == 1) $statusnya = -1;//belum rilis
    else if($cekmulai <= getTanggal() && $cekselesai > getTanggal() && $lelang['status'] == 1) {$statusnya = 1;  $pesan = 'berjalan';}//masih berjalan
    else if($lelang['status'] == 2) {$statusnya = 2; $pesan = 'peringatan';}//revisi/perbaikan u/ form
    else if($lelang['status'] == 3) {//selesai, update status trans
        $statusnya = 3;
        $pesan = 'selesai';
        //jika ada yg gagal membayar
        // $tgltrans = date("Ymd", strtotime($selesai));//dari tanggal selesai
        // $idtrans = ['00000','00000','00000'];
        // $counting = DB::table('transaksi_koin')->count();
        // $iterasi = 1;
        // while($iterasi <= 3){
        //     if(((int) $counting+$iterasi) < 10) $idtrans[$iterasi-1] = '0000'.((int) $counting+$iterasi);
        //     else if(((int) $counting+$iterasi) < 100) $idtrans[$iterasi-1] = '000'.((int) $counting+$iterasi);
        //     else if(((int) $counting+$iterasi) < 1000) $idtrans[$iterasi-1] = '00'.((int) $counting+$iterasi);
        //     else if(((int) $counting+$iterasi) < 10000) $idtrans[$iterasi-1] = '0'.((int) $counting+$iterasi);
        //     $iterasi += 1;
        // }
        // date_default_timezone_set('Asia/Jakarta');
        // $idtrans[0] = 'ID'.$tgltrans.$idtrans[0];
        // $idtrans[1] = 'ID'.$tgltrans.$idtrans[1];
        // $idtrans[2] = 'ID'.$tgltrans.$idtrans[2];
        // $tgl = getTanggal();
        // $usermenang = DB::table('lelang_bid')
        //     ->join('lelang','lelang_bid.lelang_id','=','lelang.id')
        //     ->join('users','lelang_bid.user_id','=','users.id')
        //     ->whereRaw('lelang.id='.$lelang['id'])
        //     ->selectRaw('lelang.penjual_id as penjual, lelang_bid.koin_penawaran as koinpemenang,
        //         lelang_bid.user_id as pemenang, users.nama as namapemenang')
        //     ->orderByDesc('lelang_bid.koin_penawaran')
        //     ->get();
        // while(){

        // }
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
            $tgltrans = date("Ymd", strtotime($selesai));//dari tanggal selesai
            $idtrans = ['00000','00000','00000'];
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
                ->selectRaw('lelang.penjual_id as penjual, lelang_bid.koin_penawaran as koinpemenang,
                    lelang_bid.user_id as pemenang, users.nama as namapemenang')
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

                    $berakhir = DB::table('lelang')
                        ->whereRaw('id='.$lelang['id'])
                        ->update([
                            'status' => $statusnya,
                            'transaksi_pemenang' => $kodetrans[0][0]->id,
                            'transaksi_penjual' => $kodetrans[1][0]->id,
                            'transaksi_admin' => $kodetrans[2][0]->id,
                    ]);
                    if($berakhir == 1) $pesan = 'selesai';
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

class MasterLelang extends Controller
{
    //jenis: daftar/transaksi
    public function getLelang($jenis) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $jumlahtidak = 0;
        $jumlahselesai = 0;
        $lelang = [];
        $dbase = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->join('lelang','lelang.penjual_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1")// and tanggal_mulai<='".getTanggal()."' and tanggal_selesai>='".getTanggal()."'
            ->selectRaw('users.id as user, users.username as username, users.nama as nama, users.kota as kota,
                users.updated_at as updated_at, users.created_at as created_at,
                lelang.id as lelang, lelang.admin_id as admin,
                lelang.nama_produk as produk, lelang.deskripsi_produk as detail, lelang.gambar_produk as gambar,
                lelang.koin_minimal as harga, lelang.tanggal_mulai as mulai, lelang.tanggal_selesai as selesai, lelang.status as status')
            // ->groupBy('id','username','nama','kota','created_at','updated_at','gambar')
            ->orderBy('lelang.tanggal_mulai','desc')
            ->get();

        foreach ($dbase as $value) {
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $tanggal_format = strtotime($value->updated_at);
            $updated = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));
            $tanggal_format = strtotime($value->created_at);
            $created = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));

            $tanggal_format = strtotime($value->mulai);
            $mulai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
            $tanggal_format = strtotime($value->selesai);
            $selesai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));

            $jumlahikut = DB::table('pengikut')->whereRaw('penjual_id = '.$value->user.' and status=1')->count('pengikut_id');
            $ikut = DB::table('lelang_bid')
                ->whereRaw('lelang_id = '.$value->lelang.' and status>=1')
                ->selectRaw('user_id')
                // ->groupBy('user_id')
                ->get();

            // dd($value->status);
            if($value->status == 0) $jumlahtidak += 1;
            else if($value->status == 3) $jumlahselesai += 1;
            $lelang[] = [
                'lelang' => $value->lelang,
                'produk' => $value->produk,
                'gambar' => $value->gambar,
                'detail' => $value->detail,
                'harga' => $value->harga,
                'mulai' => $mulai,
                'selesai' => $selesai,
                'status' => $value->status,
                'user' => $value->user,
                'username' => $value->username,
                'nama' => $value->nama,
                'kota' => $value->kota,
                'admin'=> $value->admin,
                'created_at' => $created,
                'updated_at' => $updated,
                'pengikut' => $jumlahikut,
                'ikut' => count($ikut)
            ];
        }
        if($jenis != 'daftar') $lelang = [];
        else $jenis = 'lelang';

        // dd(count($lelang));
        $view = 'user-admin/lelang/data-'.$jenis;
        return view($view,[
            'error' => false,
            // 'koin' => updateDeposito(getTanggal()),
            'pesan' => 'belum',
            'tidak' => $jumlahtidak,
            'selesai' => $jumlahselesai,
            'lelang' => $lelang
            ]
        );
    }

    public function detailLelang($id) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        // dd(count($lelang));
        $error = false;
        $pesan = 'tidak ikut';
        $lelang = [];
        $dbase = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->join('lelang','lelang.penjual_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1
                and lelang.id = ".$id)
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
            ->get();

        foreach ($dbase as $value){
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

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
            // if($value->status == 0 || $value->status == 2) return redirect()->route('semuaLelang');//status=0/2

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
                'status' => $ambilstatus['status'],// == 1 || $ambilstatus['status'] == 3 ? $ambilstatus['status'] : ($ambilstatus['status'] == -1 ? 1 : 0)),
                'mode' => $ambilstatus['pesan'],
                'pemenang' => $pemenang,
                'penjual' => $value->penjual,
                'admin' => $value->admin,
                'idadmin' => $value->idadmin,
                'catatan' => $value->catatan,
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

        return view('user-admin/lelang/detail-lelang',[
            'error' => $error,
            'koin' => updateDeposito(getTanggal()),
            // 'pengikut' => $pengikut,
            'hari_ini' => getTanggal(),
            'pesan' => $pesan,
            'lelang' => $lelang
        ]
        // [
        //     'error' => false,
        //     'id' => $id,
        //     'pesan' => 'belum',
        //     'lelang' => $lelang
        // ]
        );
    }

    public function perbaikanLelang(Request $request) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $perbaiki = DB::table('lelang')
            ->whereRaw("id = ".$request->idlelang." and admin_id=".$request->idadmin)
            ->get();

        if(count($perbaiki) > 0 && $request->idadmin == auth()->user()->id){
            $perbaiki = DB::table('lelang')
                ->whereRaw("id = ".$request->idlelang." and admin_id=".$request->idadmin)
                ->update([
                    'status' => 2,
                    'catatan' => $request->catatan
                ]);
            return redirect()->route('detailLelang',['id'=> $request->idlelang]);
        }
        else return redirect()->route('detailLelang',['id'=> $request->idlelang]);
    }

    public function nonaktifLelang($id) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $nonaktif = DB::table('lelang')
            ->whereRaw("id = ".$id." and admin_id=".auth()->user()->id)
            ->get();

        if(count($nonaktif) > 0){
            $nonaktif = DB::table('lelang')
                ->whereRaw("id = ".$id." and admin_id=".auth()->user()->id)
                ->update([
                    'status' => 0,
                ]);
            return redirect()->route('detailLelang',['id'=> $id]);
        }
        else return redirect()->route('detailLelang',['id'=> $id]);
    }


    public function transaksiLelang($id) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $trans = DB::table('lelang')
            ->whereRaw("id = ".$id." and admin_id=".auth()->user()->id)
            ->get();

        // if(count($trans) > 0){
        //     $trans = DB::table('lelang')
        //         ->whereRaw("id = ".$id." and admin_id=".auth()->user()->id)
        //         ->update([
        //             'status' => 0,
        //         ]);
        //     return redirect()->route('detailLelang',['id'=> $id]);
        // }
        // else return redirect()->route('detailLelang',['id'=> $id]);
    }
}
