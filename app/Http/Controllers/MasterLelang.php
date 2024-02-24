<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// use PDF;
use Barryvdh\DomPDF\Facade\PDF;


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
        if($jumlahuser <= 1) {$statusnya = 1; $pesan = 'berjalan';}
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
        return ['status' => $statusnya, 'pesan' => ($jumlahuser == 0 ? 'belum' : 'satu')."-penawar"];
        // return ['status' => $statusnya, 'pesan' => 'belum-penawar'];
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
        $jumlahadmin = 0;
        $lelang = [];
        $label = [];
        $koinakhir = [];
        $persenadmin = [];

        $dbase = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->join('lelang','lelang.penjual_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1")// and tanggal_mulai<='".getTanggal()."' and tanggal_selesai>='".getTanggal()."'
            ->selectRaw('users.id as user, users.username as username, users.nama as nama, users.kota as kota,
                users.updated_at as updated_at, users.created_at as created_at,
                lelang.id as lelang, lelang.admin_id as admin,
                lelang.nama_produk as produk, lelang.deskripsi_produk as detail, lelang.gambar_produk as gambar,
                lelang.koin_minimal as harga, lelang.tanggal_mulai as mulai, lelang.tanggal_selesai as selesai, lelang.status as status,
                lelang.transaksi_pemenang as transpemenang, lelang.transaksi_admin as transadmin')
            // ->groupBy('id','username','nama','kota','created_at','updated_at','gambar')
            ->orderBy('lelang.tanggal_mulai','desc')
            ->get();

        foreach ($dbase as $i => $value) {
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
            // $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $tanggal_format = strtotime($value->updated_at);
            $updated = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));
            $tanggal_format = strtotime($value->created_at);
            $created = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));

            $tanggal_format = strtotime($value->mulai);
            $mulai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
            $tanggal_format = strtotime($value->selesai);
            $selesai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
            $ikut = DB::table('lelang_bid')
                ->whereRaw('lelang_id = '.$value->lelang.' and status>=1')
                ->selectRaw('user_id')
                // ->groupBy('user_id')
                ->get();
            $pemenang = DB::table('transaksi_koin')->whereRaw("jenis like '%lelang%' and id = '".$value->transpemenang."'")->get();
            $admin = DB::table('transaksi_koin')->whereRaw("jenis like '%lelang%' and id = '".$value->transadmin."'")->get();

            $koin = -1;
            $persen = -1;
            if($jenis == 'transaksi') {// && $value->admin == auth()->user()->id
                if($value->status == 3) $jumlahselesai += 1;
                if(count($pemenang) == 1) $koin = ($pemenang[0]->koin)*-1;
                else if($value->status < 3) $koin = 0;
                if(count($admin) == 1) $persen = $admin[0]->koin;
                else if($value->status < 3) $persen = 0;
                $jumlahadmin += 1;
                // $label[] = "No.".($i+1);
                // $koinakhir[] = ($koin > -1 ? $koin : $pemenang[0]->koin);
                // $persenadmin[] = ($persen > -1 ? $persen : $admin[0]->koin);
            } else if($jenis == 'daftar') {
                if($value->status == 0) $jumlahtidak += 1;
                else if($value->status == 3) $jumlahselesai += 1;
            }
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
                'created_at' => $created,
                'updated_at' => $updated,
                'admin'=> $value->admin,
                'pemenang' => ($jenis == 'transaksi' && count($pemenang) == 1 ? $koin : ($value->transpemenang == null ? 0 : $value->transpemenang)),
                'persenadmin'=> ($jenis == 'transaksi' && count($admin) == 1 ? $persen : ($value->transadmin == null ? 0 : $value->transadmin)),
                'ikut' => count($ikut)
            ];
        }
        if($jenis == 'daftar') $jenis = 'lelang';
        $penjual = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1")
            ->selectRaw('users.id as id, users.username as username, users.nama as nama')
            ->get();
        // dd(count($lelang));
        $view = 'user-admin/lelang/data-'.$jenis;

        return view($view,[
            'error' => false,
            'koin' => updateDeposito(getTanggal()),
            'pesan' => ['belum',[
                'penjual'=> null,
                // 'cari' => null,
                'mulai' => null,
                'selesai' => null,
                'admin' => null,
                'hari_ini' => getTanggal()
            ]],
            'penjual' => $penjual,
            'tidak' => $jumlahtidak,
            'selesai' => $jumlahselesai,
            'admin' => [$jumlahadmin,$label,$koinakhir,$persenadmin],
            'lelang' => $lelang,
        ]);
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
                lelang.pengiriman_id as idkirim,
                lelang.catatan as catatan')
            ->get();

        foreach ($dbase as $value){
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            // $bulanIndonesia = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
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
            if(count($userikut) >= 1) $pesan = 'ikut';

            $dbpemenang = DB::table('transaksi_koin')
                ->join('users','users.id','=','transaksi_koin.user_id')
                ->whereRaw("transaksi_koin.jenis = 'lelang' and transaksi_koin.id = '".$value->pemenang."'")
                ->selectRaw('users.nama as nama, transaksi_koin.transaksi_kode as kode,
                    transaksi_koin.koin as koin, transaksi_koin.status as status,
                    transaksi_koin.tanggal as tanggal')
                ->get();
            $pemenangnya = [
                'idtrans' => null,
                'nama' => null,
                'kode' => null,
                'koin' => null,
                'tanggal' => null,
                'status' => null,
                'maksimal' => null,
            ];
            $dbpenjual = DB::table('transaksi_koin')
                ->join('users','users.id','=','transaksi_koin.user_id')
                ->whereRaw("transaksi_koin.jenis = 'lelang-penjual' and transaksi_koin.id = '".$value->penjual."'")
                ->selectRaw('users.nama as nama, users.kota as kota, transaksi_koin.transaksi_kode as kode,
                    transaksi_koin.koin as koin, transaksi_koin.status as status,
                    transaksi_koin.tanggal as tanggal')
                ->get();
            $penjualnya = [
                'idtrans' => null,
                'nama' => null,
                'kode' => null,
                'koin' => null,
                'tanggal' => null,
                'status' => null,
                'maksimal' => null,
                'kota' => null,
            ];
            $dbadmin = DB::table('transaksi_koin')
                ->join('users','users.id','=','transaksi_koin.user_id')
                ->whereRaw("transaksi_koin.jenis = 'lelang-admin' and transaksi_koin.id = '".$value->admin."'")
                ->selectRaw('users.nama as nama, transaksi_koin.transaksi_kode as kode,
                    transaksi_koin.koin as koin, transaksi_koin.status as status,
                    transaksi_koin.tanggal as tanggal')
                ->get();
            $adminnya = [
                'idtrans' => null,
                'nama' => null,
                'kode' => null,
                'koin' => null,
                'tanggal' => null,
                'status' => null,
                'maksimal' => null,
            ];
            //pengiriman
            $pengiriman = [];
            if($value->idkirim != null) $pengiriman = DB::table('pengiriman')->whereRaw('id = '.$value->idkirim)->get();
            $kirimnya = [
                'asal' => null,
                'tujuan' => null,
                'kurir' => null,
                'berat' => null,
                'biaya' => null,
                'layanan' => null,
                'waktu' => null,
                'status' => null,
                'alamat' => null,
                'tglubah' => null
            ];
            // dd(count($dbpemenang),$value->pemenang,count($dbpenjual),$value->penjual,count($dbadmin),$value->admin,count($pengiriman));

            $maksimal = date('Y-m-d',strtotime($value->selesai." + 7 days"))." 23:59:59";
            if(count($dbpemenang) == 1 && count($dbpenjual) == 1 && count($dbadmin) == 1 &&
                count($pengiriman) == 1 && auth()->user()->id == $value->idadmin) {
                $pemenangnya = [
                    'idtrans' => $value->pemenang,
                    'nama' => $dbpemenang[0]->nama,
                    'kode' => $dbpemenang[0]->kode,
                    'koin' => $dbpemenang[0]->koin,
                    'tanggal' => $dbpemenang[0]->tanggal,
                    'status' => $dbpemenang[0]->status,
                    'maksimal' => $maksimal,
                ];
                $penjualnya = [
                    'idtrans' => $value->penjual,
                    'nama' => $dbpenjual[0]->nama,
                    'kode' => $dbpenjual[0]->kode,
                    'koin' => $dbpenjual[0]->koin,
                    'tanggal' => $dbpenjual[0]->tanggal,
                    'status' => $dbpenjual[0]->status,
                    'maksimal' => $maksimal,
                    'kota' => $dbpenjual[0]->kota,
                ];
                $adminnya = [
                    'idtrans' => $value->admin,
                    'nama' => $dbadmin[0]->nama,
                    'kode' => $dbadmin[0]->kode,
                    'koin' => $dbadmin[0]->koin,
                    'tanggal' => $dbadmin[0]->tanggal,
                    'status' => $dbadmin[0]->status,
                    'maksimal' => $maksimal,
                ];
                $kirimnya = ['id' => $pengiriman[0]->id,
                    'asal' => $pengiriman[0]->asal,
                    'tujuan' => $pengiriman[0]->tujuan,
                    'kurir' => $pengiriman[0]->kurir,
                    'berat' => $pengiriman[0]->berat,
                    'biaya' => $pengiriman[0]->biaya,
                    'layanan' => $pengiriman[0]->layanan,
                    'waktu' => $pengiriman[0]->waktu_perkiraan,
                    'status' => $pengiriman[0]->status,
                    'alamat' => $pengiriman[0]->alamat_tujuan,
                    'tglubah' => $pengiriman[0]->tanggal_update,
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
                'pemenang' => $pemenangnya,
                'penjual' => $penjualnya,
                'admin' => $adminnya,
                'idadmin' => $value->idadmin,
                'catatan' => $value->catatan,
                'pengiriman' => $kirimnya,
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

        //penawar lelang
        $penawar = [];
        $dbase = DB::table('lelang_bid')
            ->leftJoin('users','users.id','=','lelang_bid.user_id')
            ->whereRaw('lelang_bid.lelang_id = '.$id.' and lelang_bid.status >= 1')
            ->selectRaw('lelang_bid.bid_id as id, lelang_bid.koin_penawaran as koin,
                lelang_bid.tanggal_bid as tgl, lelang_bid.status as status, lelang_bid.menang as menang,
                users.id as iduser, users.nama as nama')
            ->orderBy('lelang_bid.tanggal_bid','desc')
            ->get();
        $tertinggi = 0;
        $usertertinggi = null;
        $tgltertinggi = 0;
        foreach ($dbase as $value) {
            // $trans = DB::table('transaksi_koin')->whereRaw("user_id = '$value->iduser' and jenis = 'lelang'")->get();
            if($tertinggi == 0 || $value->koin > $tertinggi || $value->menang == 1 || ($value->koin == $tertinggi && $value->tgl < $tgltertinggi)) {
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
                'menang' => ($value->menang == 1 ? ' sebagai Pemenang' : null),
            ];
        }
        //end penawar

        return view('user-admin/lelang/detail-lelang',[
            'error' => $error,
            'koin' => updateDeposito(getTanggal()),
            // 'pengikut' => $pengikut,
            'hari_ini' => getTanggal(),
            'pesan' => $pesan,
            'lelang' => $lelang,
            'penawar' => $penawar,
            'tertinggi' => [$tertinggi,$usertertinggi],
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
                    'status' => ($nonaktif[0]->status == 1 ? 0 : 1),
                ]);
            return redirect()->route('detailLelang',['id'=> $id]);
        }
        else return redirect()->route('detailLelang',['id'=> $id]);
    }

    public function cariTransaksi(Request $request) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $jumlahtidak = 0;
        $jumlahselesai = 0;
        $jumlahadmin = 0;
        $lelang = [];
        $label = [];
        $koinakhir = [];
        $persenadmin = [];

        // dd($request->admin == null,
        //     [$request->admin,
        //     $request->cari,
        //     $request->penjual,
        //     $request->mulai,
        //     $request->jamMulai,
        //     $request->selesai,
        //     $request->jamSelesai]
        // );

        $reqadmin = $request->admin;
        // $reqcari = $request->cari;//produk / judul
        $reqpenjual = $request->penjual;
        $filterpenjual = '';
        $tgl_mulai = $request->mulai.' '.$request->jamMulai.':00';
        $tgl_selesai = $request->selesai.' '.$request->jamSelesai.':00';
        if($tgl_mulai > $tgl_selesai) {
            return redirect()->back()
                ->withErrors(
                    ['errornya' => 'Tanggal Dimulai Lelang adalah
                    Tanggal Sebelum Tanggal Selesai Lelang yang Ditentukan']);
        }

        $dbase = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->join('lelang','lelang.penjual_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1")// and tanggal_mulai<='".getTanggal()."' and tanggal_selesai>='".getTanggal()."'
            ->selectRaw('users.id as user, users.username as username, users.nama as nama, users.kota as kota,
                users.updated_at as updated_at, users.created_at as created_at,
                lelang.id as lelang, lelang.admin_id as admin,
                lelang.nama_produk as produk, lelang.deskripsi_produk as detail, lelang.gambar_produk as gambar,
                lelang.koin_minimal as harga, lelang.tanggal_mulai as mulai, lelang.tanggal_selesai as selesai, lelang.status as status,
                lelang.transaksi_pemenang as transpemenang, lelang.transaksi_admin as transadmin')
            // ->groupBy('id','username','nama','kota','created_at','updated_at','gambar')
            ->orderBy('lelang.tanggal_mulai','desc')
            ->get();

        foreach ($dbase as $i => $value) {
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
            // $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $tanggal_format = strtotime($value->updated_at);
            $updated = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));
            $tanggal_format = strtotime($value->created_at);
            $created = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));

            $tanggal_format = strtotime($value->mulai);
            $mulai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
            $tanggal_format = strtotime($value->selesai);
            $selesai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));

            $masuk = [0,0];

            if(($reqadmin == 'anda' && auth()->user()->id == $value->admin) || $reqadmin == null) {
                // $masuk += 1; print($masuk."-33<br>");
                if($value->selesai >= $tgl_mulai && $value->selesai <= $tgl_selesai) $masuk[0] = 1;
                else if($value->mulai <= $tgl_selesai && $value->mulai >= $tgl_mulai) $masuk[0] = 2;
                else if($value->mulai <= $tgl_mulai && $value->selesai >= $tgl_selesai) $masuk[0] = 3;
                else if( $tgl_mulai == $tgl_selesai ) $masuk[0] = -1;
                if($reqpenjual == $value->user) {$masuk[1] = 2; $filterpenjual = $value->nama;}
                else if( $reqpenjual == 'Tidak Ada' ) $masuk[1] = -2;
                // if($reqcari != null) {
                //     $cariproduk = DB::table('lelang')->whereRaw(strtolower("nama_produk")." like '%".strtolower($reqcari)."%'")->get();
                //     if(count($cariproduk) > 0) $masuk[2] = 3;
                // }
                // else if($reqcari == null) $masuk[2] = -3;
            }

            // (if( ($$tgl_mulai == $tgl_selesai || ($value->selesai >= $tgl_mulai && $value->selesai <= $tgl_selesai) ||
            // ($value->mulai <= $tgl_selesai && $value->mulai >= $tgl_mulai) ||
            // ($value->mulai <= $tgl_mulai && $value->selesai >= $tgl_selesai)) ){
            if( ($masuk[0] > 0 || ($masuk[0] == -1 && $tgl_mulai == $tgl_selesai)) &&
                ($masuk[1] > 0 || ($masuk[1] == -2 && $reqpenjual == 'Tidak Ada')) ){
                //&& ($masuk[2] > 0 || ($reqcari == null && $masuk[2] == -3))
                // print($masuk[0]." = ".$masuk[1]." -masuk<br>");
                $ikut = DB::table('lelang_bid')
                    ->whereRaw('lelang_id = '.$value->lelang.' and status>=1')
                    ->selectRaw('user_id')
                    // ->groupBy('user_id')
                    ->get();
                $pemenang = DB::table('transaksi_koin')->whereRaw("jenis like '%lelang%' and id = '".$value->transpemenang."'")->get();
                $admin = DB::table('transaksi_koin')->whereRaw("jenis like '%lelang%' and id = '".$value->transadmin."'")->get();

                $koin = -1;
                $persen = -1;
                // if($value->admin == auth()->user()->id) {
                    if($value->status == 3) $jumlahselesai += 1;
                    if(count($pemenang) == 1) $koin = ($pemenang[0]->koin)*-1;
                    else if($value->status < 3) $koin = 0;
                    if(count($admin) == 1) $persen = $admin[0]->koin;
                    else if($value->status < 3) $persen = 0;
                    $jumlahadmin += 1;
                    // $label[] = "No.".($i+1);
                    // $koinakhir[] = ($koin > -1 ? $koin : $pemenang[0]->koin);
                    // $persenadmin[] = ($persen > -1 ? $persen : $admin[0]->koin);
                // }
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
                    'created_at' => $created,
                    'updated_at' => $updated,
                    'admin'=> $value->admin,
                    'pemenang' => (count($pemenang) == 1 ? $koin : ($value->transpemenang == null ? 0 : $value->transpemenang)),
                    'persenadmin'=> (count($admin) == 1 ? $persen : ($value->transadmin == null ? 0 : $value->transadmin)),
                    'ikut' => count($ikut)
                ];
            }
            // else print( $value->produk."/".$masuk[0]." = ".$masuk[1]." = ".$masuk[2]."-tidak<br>");
            // print("<hr>");
        }
        // dd($request->admin == null,
        //     [$request->admin,
        //     $request->cari,
        //     $request->penjual,
        //     $request->mulai,
        //     $request->jamMulai,
        //     $request->selesai,
        //     $request->jamSelesai],
        //     // $masuk,
        //     $lelang
        // );

        //filter
        $penjual = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1")
            ->selectRaw('users.id as id, users.username as username, users.nama as nama')
            ->get();
        // $tanggal_format = strtotime($tgl_mulai);
        // $tglmulai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
        // $tanggal_format = strtotime($tgl_selesai);
        // $tglselesai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));

        $reqdata = [
            'penjual' => $request->penjual,
            'namapenjual' => $filterpenjual,
            // 'cari' => $request->cari,
            'mulai' => ($tgl_mulai == $tgl_selesai ? null : $tgl_mulai),
            'selesai' => ($tgl_mulai == $tgl_selesai ? null : $tgl_selesai),
            'admin' => $request->admin,
            'hari_ini' => getTanggal(),
        ];

        // dd(count($lelang));
        $view = 'user-admin/lelang/data-transaksi';
        return view($view,[
            'error' => false,
            'koin' => updateDeposito(getTanggal()),
            'pesan' => ['sudah',$reqdata],
            'penjual' => $penjual,
            'tidak' => $jumlahtidak,
            'selesai' => $jumlahselesai,
            'admin' => [$jumlahadmin,$label,$koinakhir,$persenadmin],
            'lelang' => $lelang,
        ]);
    }

/*
//generate pdf
1) Instalasi Pustaka: Pastikan Anda telah menginstal pustaka PDF yang ingin Anda gunakan. Sebagai contoh, kita akan menggunakan DOMPDF.
composer require barryvdh/laravel-dompdf
Setelah menginstal, tambahkan service provider dan alias pada file config/app.php.
'providers' => [
    // ...
    Barryvdh\DomPDF\ServiceProvider::class,
],
'aliases' => [
    // ...
    'PDF' => Barryvdh\DomPDF\Facade::class,
],
*/
    public function buatLaporan(Request $request){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        //buat preview laporan, terus buat pdf
        //kirim reqdata dulu disini
        // dd($request);

        $jumlahtidak = 0;
        $jumlahselesai = 0;
        $jumlahadmin = 0;//total transaksi
        $lelang = [];
        $error = false;
        $pesan = 'tidak ikut';

        $reqadmin = $request->admin;
        $reqpenjual = $request->penjual;
        $filterpenjual = '';
        $tgl_mulai = $request->mulai;
        $tgl_selesai = $request->selesai;

        $dbase = DB::table('users')
            ->join('konfirmasi_penjual','konfirmasi_penjual.penggemar_id','=','users.id')
            ->join('lelang','lelang.penjual_id','=','users.id')
            ->whereRaw("users.role = 3 and users.status = 1 and konfirmasi_penjual.status_konfirmasi = 1")// and lelang.id = ".$id)
            ->selectRaw('users.id as user, users.username as username, users.nama as nama, users.kota as kota,
                users.updated_at as updated_at, users.created_at as created_at,
                lelang.id as lelang,
                lelang.nama_produk as produk,
                lelang.gambar_produk as gambar,
                lelang.deskripsi_produk as detail,
                lelang.koin_minimal as harga,
                lelang.kategori as kategori,
                lelang.artis as artis,
                lelang.tanggal_buat as buat,
                lelang.tanggal_mulai as mulai,
                lelang.tanggal_selesai as selesai,
                lelang.status as status,
                lelang.transaksi_pemenang as pemenang,
                lelang.transaksi_penjual as penjual,
                lelang.transaksi_admin as admin,
                lelang.admin_id as idadmin,
                lelang.pengiriman_id as idkirim,
                lelang.catatan as catatan')
            ->orderBy('lelang.tanggal_mulai','desc')
            ->get();

        $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        // $bulanIndonesia = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
        $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        foreach ($dbase as $i => $value) {

            //penjual
            $tanggal_format = strtotime($value->updated_at);
            $updated = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));
            $tanggal_format = strtotime($value->created_at);
            $created = str_replace($bulanInggris, $bulanIndonesia,date("d F Y", $tanggal_format));

            //lelang
            $tanggal_format = strtotime($value->buat);
            $buat = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
            $tanggal_format = strtotime($value->mulai);
            $mulai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));
            $tanggal_format = strtotime($value->selesai);
            $selesai = str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", $tanggal_format));

            $masuk = [0,0];

            if(($reqadmin == 'anda' && auth()->user()->id == $value->idadmin) || $reqadmin == null) {
                if($value->selesai >= $tgl_mulai && $value->selesai <= $tgl_selesai) $masuk[0] = 1;
                else if($value->mulai <= $tgl_selesai && $value->mulai >= $tgl_mulai) $masuk[0] = 2;
                else if($value->mulai <= $tgl_mulai && $value->selesai >= $tgl_selesai) $masuk[0] = 3;
                else if( $tgl_mulai == $tgl_selesai ) $masuk[0] = -1;
                if($reqpenjual == $value->user) {$masuk[1] = 2; $filterpenjual = $value->nama;}
                else if( $reqpenjual == 'Tidak Ada' ) $masuk[1] = -2;
            }

            if( ($masuk[0] > 0 || ($masuk[0] == -1 && $tgl_mulai == $tgl_selesai)) &&
                ($masuk[1] > 0 || ($masuk[1] == -2 && $reqpenjual == 'Tidak Ada')) ){

                $ambilstatus = updateStatusLelang($value->mulai, $value->selesai,
                [
                    'id' => $value->lelang,
                    'status' => $value->status,
                    'penjual' => $value->user,
                    'admin' => $value->idadmin,
                ]);

                $pengikut = DB::table('pengikut')->whereRaw('penjual_id = '.$value->user.' and status=1')->count();
                $ikut = DB::table('lelang_bid')->whereRaw('lelang_id = '.$value->lelang.' and status>=1')->get();
                $userikut = DB::table('lelang_bid')->whereRaw('lelang_id = '.$value->lelang.' and user_id = '.auth()->user()->id.' and status >= 1')->orderBy('tanggal_bid','desc')->get();
                if(count($userikut) >= 1) $pesan = 'ikut';

                $dbpemenang = DB::table('transaksi_koin')
                    ->join('users','users.id','=','transaksi_koin.user_id')
                    ->whereRaw("transaksi_koin.jenis = 'lelang' and transaksi_koin.id = '".$value->pemenang."'")
                    ->selectRaw('users.nama as nama, transaksi_koin.transaksi_kode as kode,
                        transaksi_koin.koin as koin, transaksi_koin.status as status,
                        transaksi_koin.tanggal as tanggal')
                    ->get();
                $pemenangnya = [
                    'idtrans' => null,
                    'nama' => null,
                    'kode' => null,
                    'koin' => null,
                    'tanggal' => null,
                    'status' => null,
                    'maksimal' => null,
                ];
                $dbpenjual = DB::table('transaksi_koin')
                    ->join('users','users.id','=','transaksi_koin.user_id')
                    ->whereRaw("transaksi_koin.jenis = 'lelang-penjual' and transaksi_koin.id = '".$value->penjual."'")
                    ->selectRaw('users.nama as nama, users.kota as kota, transaksi_koin.transaksi_kode as kode,
                        transaksi_koin.koin as koin, transaksi_koin.status as status,
                        transaksi_koin.tanggal as tanggal')
                    ->get();
                $penjualnya = [
                    'idtrans' => null,
                    'nama' => null,
                    'kode' => null,
                    'koin' => null,
                    'tanggal' => null,
                    'status' => null,
                    'maksimal' => null,
                    'kota' => null,
                ];
                $dbadmin = DB::table('transaksi_koin')
                    ->join('users','users.id','=','transaksi_koin.user_id')
                    ->whereRaw("transaksi_koin.jenis = 'lelang-admin' and transaksi_koin.id = '".$value->admin."'")
                    ->selectRaw('users.nama as nama, transaksi_koin.transaksi_kode as kode,
                        transaksi_koin.koin as koin, transaksi_koin.status as status,
                        transaksi_koin.tanggal as tanggal')
                    ->get();
                $adminnya = [
                    'idtrans' => null,
                    'nama' => null,
                    'kode' => null,
                    'koin' => null,
                    'tanggal' => null,
                    'status' => null,
                    'maksimal' => null,
                ];
                //pengiriman
                $pengiriman = [];
                if($value->idkirim != null) $pengiriman = DB::table('pengiriman')->whereRaw('id = '.$value->idkirim)->get();
                $kirimnya = [
                    'asal' => null,
                    'tujuan' => null,
                    'kurir' => null,
                    'berat' => null,
                    'biaya' => null,
                    'layanan' => null,
                    'waktu' => null,
                    'status' => null,
                    'alamat' => null,
                    'tglubah' => null
                ];
                // dd(count($dbpemenang),$value->pemenang,count($dbpenjual),$value->penjual,count($dbadmin),$value->admin,count($pengiriman));

                $maksimal = date('Y-m-d',strtotime($value->selesai." + 7 days"))." 23:59:59";
                if(count($dbpemenang) == 1 && count($dbpenjual) == 1 && count($dbadmin) == 1 &&
                    count($pengiriman) == 1 && auth()->user()->id == $value->idadmin) {
                    $pemenangnya = [
                        'idtrans' => $value->pemenang,
                        'nama' => $dbpemenang[0]->nama,
                        'kode' => $dbpemenang[0]->kode,
                        'koin' => $dbpemenang[0]->koin,
                        'tanggal' => $dbpemenang[0]->tanggal,
                        'status' => $dbpemenang[0]->status,
                        'maksimal' => $maksimal,
                    ];
                    $penjualnya = [
                        'idtrans' => $value->penjual,
                        'nama' => $dbpenjual[0]->nama,
                        'kode' => $dbpenjual[0]->kode,
                        'koin' => $dbpenjual[0]->koin,
                        'tanggal' => $dbpenjual[0]->tanggal,
                        'status' => $dbpenjual[0]->status,
                        'maksimal' => $maksimal,
                        'kota' => $dbpenjual[0]->kota,
                    ];
                    $adminnya = [
                        'idtrans' => $value->admin,
                        'nama' => $dbadmin[0]->nama,
                        'kode' => $dbadmin[0]->kode,
                        'koin' => $dbadmin[0]->koin,
                        'tanggal' => $dbadmin[0]->tanggal,
                        'status' => $dbadmin[0]->status,
                        'maksimal' => $maksimal,
                    ];
                    $kirimnya = ['id' => $pengiriman[0]->id,
                        'asal' => $pengiriman[0]->asal,
                        'tujuan' => $pengiriman[0]->tujuan,
                        'kurir' => $pengiriman[0]->kurir,
                        'berat' => $pengiriman[0]->berat,
                        'biaya' => $pengiriman[0]->biaya,
                        'layanan' => $pengiriman[0]->layanan,
                        'waktu' => $pengiriman[0]->waktu_perkiraan,
                        'status' => $pengiriman[0]->status,
                        'alamat' => $pengiriman[0]->alamat_tujuan,
                        'tglubah' => $pengiriman[0]->tanggal_update,
                    ];
                }

                //penawar lelang
                $penawar = [];
                $dbpenawar = DB::table('lelang_bid')
                    ->leftJoin('users','users.id','=','lelang_bid.user_id')
                    ->whereRaw('lelang_bid.lelang_id = '.$value->lelang.' and lelang_bid.status >= 1')
                    ->selectRaw('lelang_bid.bid_id as id, lelang_bid.koin_penawaran as koin,
                        lelang_bid.tanggal_bid as tgl, lelang_bid.status as status, lelang_bid.menang as menang,
                        users.id as iduser, users.nama as nama')
                    ->orderBy('lelang_bid.tanggal_bid','desc')
                    ->get();
                $tertinggi = 0;
                $usertertinggi = null;
                $tgltertinggi = 0;
                foreach ($dbpenawar as $item) {
                    if($tertinggi == 0 || $item->koin > $tertinggi || $item->menang == 1 || ($item->koin == $tertinggi && $item->tgl < $tgltertinggi)) {
                        $tertinggi = $item->koin;
                        $usertertinggi = $item->nama;
                    }
                    $penawar[] = [
                        'id' => $item->id,
                        'koin' => $item->koin,
                        'tgl'	=> $item->tgl,
                        'nama' => $item->nama,
                        'status' => $item->status,
                        'menang' => ($item->menang == 1 ? ' sebagai Pemenang' : null),
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
                    'buat' => $buat,
                    'mulai' => $mulai,
                    'selesai' => $selesai,
                    'status' => $ambilstatus['status'],// == 1 || $ambilstatus['status'] == 3 ? $ambilstatus['status'] : ($ambilstatus['status'] == -1 ? 1 : 0)),
                    'mode' => $ambilstatus['pesan'],
                    'pemenang' => $pemenangnya,
                    'penjual' => $penjualnya,
                    'admin' => $adminnya,
                    'idadmin' => $value->idadmin,
                    'catatan' => $value->catatan,
                    'pengiriman' => $kirimnya,
                    'user' => $value->user,
                    'username' => $value->username,
                    'nama' => $value->nama,
                    'kota' => $value->kota,
                    'created_at' => $created,
                    'updated_at' => $updated,
                    'pengikut' => $pengikut,
                    'ikutlelang' => $ikut,
                    'userikut' => $userikut,//array
                    'penawar' => $penawar,//array
                    'tertinggi' => [$tertinggi,$usertertinggi],
                ];

                if($ambilstatus['status'] == 3) $jumlahselesai += 1;
                $jumlahadmin += 1;
            }
            // else print( $value->produk."/".$masuk[0]." = ".$masuk[1]." = ".$masuk[2]."-tidak<br>");
            // print("<hr>");
        }

        //filter
        $reqdata = [
            'penjual' => $request->penjual,
            'namapenjual' => $filterpenjual,
            // 'cari' => $request->cari,
            'mulai' => ($tgl_mulai == $tgl_selesai ? null : str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", strtotime($tgl_mulai)))),
            'selesai' => ($tgl_mulai == $tgl_selesai ? null : str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i", strtotime($tgl_selesai)))),
            'admin' => $request->admin,
        ];
        // dd($reqdata);

        //gambar logo
        $path = 'C:\xampp\htdocs\projectTA\public\logo\logo-korea-10.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $datagambar = file_get_contents($path);
        $gambarnya = 'data:image/' . $type . ';base64,' . base64_encode($datagambar);

        // ini_set("max_execution_time", 600);

        //opsi1 pdf
        // // Buat objek TCPDF
        // $pdf = new TCPDF();

        // // Atur properti PDF (opsional)
        // $pdf->SetCreator('Your Name');
        // $pdf->SetAuthor('Your Name');
        // $pdf->SetTitle('Laporan PDF');

        // // Tambahkan konten ke PDF (sesuaikan dengan kebutuhan Anda)
        // $pdf->AddPage();
        // $pdf->SetFont('Arial', 'B', 16);
        // $pdf->Cell(40, 10, 'Laporan PDF');

        // // Simpan PDF atau kirim sebagai respons ke browser
        // $pdf->Output('laporan.pdf', 'I');
        //end opsi1 pdf

        //opsi2 pdf
        $viewnya = 'user-admin/lelang/data-laporan';
        // Ambil data dari model atau sumber data lainnya
        $data = [
            'title' => 'Contoh Laporan PDF',
            // 'content' => 'Ini adalah isi laporan PDF.'
            'error' => $error,
            'req' => ['pdf',$reqdata,$gambarnya],
            'koin' => updateDeposito(getTanggal()),
            'hari_ini' => str_replace($bulanInggris, $bulanIndonesia,date("d F Y H:i:s", strtotime(getTanggal()))),
            'pesan' => $pesan,
            'lelang' => $lelang,
        ];

        //opsi1 kepdf
        $pdf = PDF::loadView($viewnya, $data);

        //opsi2 kepdf
        // // Tampilkan view dalam string
        // $view = view($viewnya, $data)->render();//$data pengganti compact('data')
        // // Buat objek PDF
        // $pdf = PDF::loadHTML($view);

        //opsi1 simpanpdf
        // // Simpan atau kirimkan PDF sebagai respons
        // return $pdf->download('laporan'.getTanggal().'.pdf');//->setOptions(['defaultFont' => 'sans-serif'])

        //opsi2 simpanpdf
        return $pdf->stream('laporan'.getTanggal().'.pdf');

        //opsi3 simpanpdf
        // Simpan PDF ke server
        // return $pdf->save(storage_path('../public/laporan/reportBaru.pdf'));

        //opsi4 simpanpdf
        // Tampilkan link unduhan
        // return response()->json(['download_link' => asset('storage/reports/reportBaru.pdf')]);

        //opsi5 simpanpdf
        // Tampilkan file PDF di browser
        // return response($pdf->output(), 200, [
        //     'Content-Type' => 'application/pdf',
        //     'Content-Disposition' => 'inline; filename="reportBaru.pdf"'
        // ]);

        //tidak ush supaya bisa langsung ke pdf
        // return view($viewnya,[
        //     'error' => $error,
        //     'req' => ['pdf',$reqdata],
        //     'koin' => updateDeposito(getTanggal()),
        //     'hari_ini' => getTanggal(),
        //     'pesan' => $pesan,
        //     'lelang' => $lelang,
        // ]);
    }
}
