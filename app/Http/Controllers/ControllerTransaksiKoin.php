<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Psy\Readline\Hoa\Console;

//midtrans
// use Midtrans\Notification;
// use Midtrans\Transaction;

//rajaongkir
use Kavist\RajaOngkir\Facades\RajaOngkir;
use App\Models\Province;
use App\Models\City;

// use function App\Http\Controllers\updateDeposito as ControllersUpdateDeposito;

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
    // dd($jumlahkoin->total_koin != null);
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

class ControllerTransaksiKoin extends Controller
{
    /*
    //note
        //return dari halaman yg sama
        return response()->json(['success'=>'Sukses Membuat Token','snap'=>$snap]);
    function updateKoin(){
    }

    // penggemar: Penarikan koin ini bisa dilakukan setiap 7 (tujuh) hari sekali dengan menarik maksimal 100 (seratus) koin.
    // penjual: Penarikan koin ini bisa dilakukan setiap 3 (tiga) hari sekali dengan menarik maksimal 200 (dua seratus) koin
    // tarik	|fans	penjual
    // koin	|100	200
    // - - - - - - - - - - - - -
    // 15	    *6	    *13
    // 25	    *4	    *8
    // 40	    *2	    *5
    // 70	    *1	    *2
    */

    public function getDeposito() {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $depo = DB::table('transaksi_koin')
            ->whereRaw("user_id = ".auth()->user()->id." and (jenis = 'beli' or jenis = 'tukar')")
            ->orderBy('tanggal','desc')
            ->get();

        //perlu diubah lagi
        $transdepo = DB::table('transaksi_koin')
            // ->leftJoin('deposito_koin','deposito_koin.id','=','transaksi_koin.deposito_id')
            ->whereRaw("user_id = ".auth()->user()->id." and ((jenis = 'beli' and status = 'Berhasil') or jenis = 'tukar' or jenis='registrasi'
                or (jenis='lelang') or (jenis='lelang-penjual'))")// or jenis='lelang-penjual'
            ->orderBy('tanggal','desc')
            ->get();

        // $jumlah = DB::table('transaksi_koin')
        //     ->select(DB::raw('SUM(koin * jumlah) as total_koin'))
        //     ->where('user_id','=',auth()->user()->id)
        //     ->where('status', 'Berhasil')
        //     ->first();
        // $total = DB::table('deposito_koin')->where('user_id','=',auth()->user()->id)->get('koin');
        // dd(count($jumlahkoin));

        $total = updateDeposito(getTanggal());

        return view('user-fans/koin/deposito',[
            'depo' => $depo,
            'trans' => $transdepo,
            'koin' => $total//[0]->koin,
        ]);
    }

    public function notaKoin($id) {//id = ID(nomor yg udh dipattern) = transaksi_kode
        if(auth()->user()->role == 1) {
            Auth::logout();
            return redirect('/login');
        }

        //cari di database
        $bayar = DB::table('transaksi_koin')
            ->where('transaksi_kode','=',$id)
            ->get();
        $status = null;
        $sukses = false;
        $selesai = -1;

        $tgl = getTanggal();//date('d').'-';
        // $tanggal = ( (int) date('d') );
        // $jam = ( (int) date('H') )+7;
        // if($jam >= 24) {$tanggal += 1; $jam = "0".($jam - 24);}
        // elseif($jam < 10) {$jam = "0".$jam;}
        // if($tanggal < 10) $tgl = date("Y-m")."-0".$tanggal.' '.$jam.date(':i:s');
        // else if ($tanggal < 32) $tgl = date("Y-m-").$tanggal.' '.$jam.date(':i:s');

        // $jumlahkoin = DB::table('transaksi_koin')
        //     ->select(DB::raw('SUM(koin * jumlah) as total_koin'))
        //     ->where('user_id','=',auth()->user()->id)
        //     ->where('status', 'Berhasil')
        //     ->first();
        $deposito = updateDeposito($tgl);

        if(count($bayar) == 1){
            //transaksi midtrans harus pending dulu!!
            // dd($statusmidtrans);
            $status = $bayar[0]->status;
            if($bayar[0]->jenis == 'beli'){
                $tgl = date('d').'-';
                $tipe = 'qris';
                $status_code = 0;
                $gross_amount = 0;
                $signature_key = '';
                if($bayar[0]->status == 'Nota' || $bayar[0]->status == 'Pending'){
                    // SAMPLE REQUEST START HERE
                    // Set your Merchant Server Key
                    \Midtrans\Config::$serverKey = config('midtrans.server_key');
                    // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
                    \Midtrans\Config::$isProduction = false;
                    // Set sanitization on (default)
                    \Midtrans\Config::$isSanitized = true;
                    // Set 3DS transaction for credit card to true
                    \Midtrans\Config::$is3ds = true;
                    $statusmidtrans = \Midtrans\Transaction::status($id);

                    foreach ($statusmidtrans as $key => $value) {
                        // print($key.' // '.$value.'<br>');
                        if($key == 'status_code') $status_code = $value;
                        else if($key == 'gross_amount') $gross_amount = $value;
                        else if($key == 'signature_key') $signature_key = $value;

                        // /*
                        if($key == 'payment_type' && $value == 'bank_transfer') $tipe = "Transfer - bca";
                        if($key == 'issuer') $tipe = $value;//bayarnya
                        else if($key == 'acquirer'){//pilihan midtrans
                            if($tipe != 'qris' && strtolower($tipe) != strtolower($value) && stripos($tipe, $value) === true) $tipe = "QRIS - ".$value.' dengan '.$tipe;
                            else $tipe = "QRIS - ".$value;
                        }
                        if($key == 'transaction_time') {
                            // if(date('a', strtotime($value)) == 'am')
                            $tgl = $value;
                        }
                        if($key == 'transaction_status') {
                            $status = $value;
                            // $caritrans = DB::table('transaksi_koin')->where('deposito_id','=',$bayar[0]->id)->count();
                            if($status == 'pending' && $bayar[0]->status == 'Nota') {
                                $pendings = DB::table('transaksi_koin')->where('transaksi_kode','=',$id)->update(['status' => 'Pending']);
                                if($pendings == 1) $sukses = true;
                            }
                            else if($status == 'settlement' && $bayar[0]->status == 'Pending') {// && $caritrans == 0
                                $hashed = hash('sha512', $id.$status_code.$gross_amount.config('midtrans.server_key'));
                                if($hashed == $signature_key){
                                    $selesai = DB::table('transaksi_koin')->where('transaksi_kode','=',$id)->update(['status' => 'Berhasil']);
                                }
                                // $jumlahkoin = DB::table('transaksi_koin')
                                //     ->select(DB::raw('SUM(koin * jumlah) as total_koin'))
                                //     ->where('user_id','=',auth()->user()->id)
                                //     ->where('status', 'Berhasil')
                                //     ->first();
                                // $ubahDepo = DB::table('deposito_koin')
                                //     ->where('user_id','=',auth()->user()->id)
                                //     ->update([
                                //         'koin' => $jumlahkoin->total_koin,
                                //         'tanggal_update' => $tgl
                                //     ]);
                                $ubahDepo = updateDeposito($tgl);
                                if($selesai == 1 && $ubahDepo == 1) $sukses = true;
                            }
                            else if(($status == 'failure' || $status == 'expire') && $bayar[0]->status != 'Gagal') {
                                $selesai = DB::table('transaksi_koin')->where('transaksi_kode','=',$id)->update(['status' => 'Gagal']);
                                if($selesai == 1) $sukses = true;
                            }
                        }
                    }
                    $tanggal = DB::table('transaksi_koin')->where('transaksi_kode','=',$id)
                        ->update(['tanggal' => $tgl,'transaksi_tipe' => $tipe]);
                }
                else if($bayar[0]->status == 'Belum'){
                    $bayar = DB::table('transaksi_koin')
                        ->where('transaksi_kode','=',$id)
                        ->update(['status' => 'Nota']);
                    $status = 'Nota';
                }
            }
            // else if($bayar[0]->jenis == 'tukar'){
            //     $bayar = DB::table('transaksi_koin')
            //         ->where('transaksi_kode','=',$id)
            //         ->update(['status' => 'Nota']);
            // }
            $nota = DB::table('transaksi_koin')->where('transaksi_kode','=',$id)->get();

            return view('user-fans/koin/nota',[
                'id' => $id,
                'koinid' => $deposito,//jumlahkoin->total_koin,
                'jenis' => $nota[0]->jenis,
                'koin' => $nota[0]->koin,
                'jumlah' => $nota[0]->jumlah,
                'total' => $nota[0]->total_bayar,
                'tanggal' => $nota[0]->tanggal,
                'snap'=> $nota[0]->token,
                'tipe'=> $nota[0]->transaksi_tipe,
                'status'=> $nota[0]->status,
                'statusmid'=> $status,
                'berhasil'=> $sukses
            ]);
        }
        else return redirect()->route('beli');
    }

    public function beliKoin() {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        //jumlah koin user cek di dbase
        // $jumlah = DB::table('transaksi_koin')
        //     ->select(DB::raw('SUM(koin * jumlah) as total_koin'))
        //     ->where('user_id','=',auth()->user()->id)
        //     ->where('status', 'Berhasil')
        //     ->first();

        // $deposito = DB::table('deposito_koin')
        //     ->where('user_id','=',auth()->user()->id)
        //     ->get('koin');
        $deposito = updateDeposito(getTanggal());

        return view('user-fans/koin/beli',['koin' => $deposito]);
    }

    public function buatBeli(Request $request) {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $total = (($request->koin*((int) $request->jumlah))+2)*1000;

        $idtrans = '00000';//dari dbase nanti
        $counting = DB::table('transaksi_koin')->count();
        if(((int) $counting+1) < 10) $idtrans = '0000'.((int) $counting+1);
        else if(((int) $counting+1) < 100) $idtrans = '000'.((int) $counting+1);
        else if(((int) $counting+1) < 1000) $idtrans = '00'.((int) $counting+1);
        else if(((int) $counting+1) < 10000) $idtrans = '0'.((int) $counting+1);

        // $tgl = date('d').'-';
        // $tanggal = ( (int) date('d') );
        // $jam = ( (int) date('H') )+7;
        // if($jam >= 24) {$tanggal += 1; $jam = "0".($jam - 24);}
        // elseif($jam < 10) {$jam = "0".$jam;}
        // if($tanggal < 10) {
        //     // $tgl = date("Y-m")."-0".$tanggal.' '.$jam.date(':i:s');
        //     $id = 'ID'.date("Ym").'0'.$tanggal.$idtrans;
        // }
        // else if ($tanggal < 32) {
        //     // $tgl = date("Y-m-").$tanggal.' '.$jam.date(':i:s');
        //     $id = 'ID'.date("Ym").$tanggal.$idtrans;
        // }
        $snapToken = '';
        date_default_timezone_set('Asia/Jakarta');
        $id = 'ID'.date('Ymd').$idtrans;
        $tgl = getTanggal();

        //pembayaran
        /*Install Midtrans PHP Library (https://github.com/Midtrans/midtrans-php)
        composer require midtrans/midtrans-php
        Alternatively, if you are not using **Composer**, you can download midtrans-php library
        (https://github.com/Midtrans/midtrans-php/archive/master.zip), and then require
        the file manually.
        require_once dirname(__FILE__) . '/pathofproject/Midtrans.php'; */

        // /*
        // SAMPLE REQUEST START HERE
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $id,
                'gross_amount' => $total, // no decimal allowed for creditcard //tergantung koinnya berapa, 1 koin = 1k idr
            ),
            'customer_details' => array(
                'name' => auth()->user()->nama,
                'email' => auth()->user()->email,
                'first_name'    => auth()->user()->nama,
                'phone'         => auth()->user()->nomor_telepon,
                // 'billing_address' => $billing_address,
                // 'shipping_address' => array(
                //     'address'       => "Manggis 90",
                //     'city'          => "Jakarta",
                //     'postal_code'   => "16601",
                // )
            ),
            'item_details' => array(
                array(
                    'id' => 1,
                    'price' => $request->koin*1000,
                    'quantity' => $request->jumlah,
                    'name' => 'Paket '.$request->koin.' Koin'
                ),
                array(
                    'id' => 2,
                    'price' => 2000,
                    'quantity' => 1,
                    'name' => "Biaya Admin"
                ),
            ),
        );

        /*
        // Optional
        $billing_address = array(
            'first_name'    => "Andri",
            'last_name'     => "Litani",
            'address'       => "Mangga 20",
            'city'          => "Jakarta",
            'postal_code'   => "16602",
            'phone'         => "081122334455",
            'country_code'  => 'IDN'
        );
        // Optional, remove this to display all available payment methods
        // $enable_payments = array('credit_card','qris');
        // Fill transaction details
        // $params = array(
        //     'enabled_payments' => $enable_payments,
        //     'transaction_details' => $transaction_details,
        //     'customer_details' => $customer_details,
        //     'item_details' => $item_details,
        // );
        // Optional
        $shipping_address = array(
            'first_name'    => "Obet",
            'last_name'     => "Supriadi",
            'address'       => "Manggis 90",
            'city'          => "Jakarta",
            'postal_code'   => "16601",
            'phone'         => "08113366345",
            'country_code'  => 'IDN'
        );
        */

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        // print($snapToken."<hr>");
        // print($request->koin.'<->');
        // print(($request->koin*1000)."<hr>");
        // print($idtrans."<hr>");
        // dd($snapToken);
        // */

        // $idnya = DB::table('transaksi_koin')->count()+1;
        $db = DB::table('transaksi_koin')->insert(
            array(
                // 'id' => $idnya,
                'jenis' => 'beli',
                'koin' => $request->koin,//koin
                'jumlah' => $request->jumlah,//jumlah
                'total_bayar' => $total,
                'user_id' => auth()->user()->id,
                'transaksi_kode' => $id,//ada transaksi_tipe
                'token' => $snapToken,
                'tanggal' => $tgl,
                'status' => 'Belum'//$status,
            )
        );
        if($db == 1 && $snapToken != '') return redirect()->route('nota',['id' => $id]);
        else return redirect()->back()->withErrors(['msg' => 'Beli Koin Gagal. Anda bisa cek Deposito Koin untuk info lebih lanjut.']);
        //end pembayaran
    }

    public function tukarKoin() {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        //jumlah koin user cek di dbase
        // $jumlah = DB::table('transaksi_koin')
        //     ->select(DB::raw('SUM(koin * jumlah) as total_koin'))
        //     ->where('user_id','=',auth()->user()->id)
        //     ->where('status', 'Berhasil')
        //     ->first();

        // $deposito = DB::table('deposito_koin')->where('user_id','=',auth()->user()->id)->get('koin');
        // $deposito = updateDeposito(getTanggal());

        return view('user-fans/koin/tukar',['koin' => updateDeposito(getTanggal())]);
    }

    public function buatTukar(Request $request) {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $tukarKoin = $request->koin*((int) $request->jumlah);
        $total = (($request->koin*((int) $request->jumlah))-3)*1000;//karena tukar ada admin 3k
        $deposito = updateDeposito(getTanggal());
        $caritukar = DB::table('transaksi_koin')->whereRaw("user_id = ".auth()->user()->id." and jenis = 'tukar' and status='Admin'")->count();
        if($caritukar >= 3) return redirect()->back()->withErrors(['error' => 'Permintaan Tukar Koin telah Melebihi Batas.']);
        else if($deposito < $tukarKoin) return redirect()->back()->withErrors(['error' => 'Koin Anda Tidak Mencukupi.']);
        else if(auth()->user()->role == 2 && $tukarKoin > 100) return redirect()->back()->withErrors(['error' => 'Maksimal Tukar Koin sebanyak 100 Koin.']);
        else if(auth()->user()->role == 3 && $tukarKoin > 200) return redirect()->back()->withErrors(['error' => 'Maksimal Tukar Koin sebanyak 200 Koin.']);

        $id = 'ID';
        $idtrans = '00000';//dari dbase nanti
        $counting = DB::table('transaksi_koin')->count();
        if(((int) $counting+1) < 10) $idtrans = '0000'.((int) $counting+1);
        else if(((int) $counting+1) < 100) $idtrans = '000'.((int) $counting+1);
        else if(((int) $counting+1) < 1000) $idtrans = '00'.((int) $counting+1);
        else if(((int) $counting+1) < 10000) $idtrans = '0'.((int) $counting+1);

        // $tgl = date('d').'-';
        // $tanggal = ( (int) date('d') );
        // $jam = ( (int) date('H') )+7;
        // if($jam >= 24) {$tanggal += 1; $jam = "0".($jam - 24);}
        // elseif($jam < 10) {$jam = "0".$jam;}
        // if($tanggal < 10) {
        //     // $tgl = date("Y-m")."-0".$tanggal.' '.$jam.date(':i:s');
        //     $id = 'ID'.date("Ym").'0'.$tanggal.$idtrans;
        // }
        // else if ($tanggal < 32) {
        //     // $tgl = date("Y-m-").$tanggal.' '.$jam.date(':i:s');
        //     $id = 'ID'.date("Ym").$tanggal.$idtrans;
        // }
        date_default_timezone_set('Asia/Jakarta');
        $id = 'ID'.date('Ymd').$idtrans;
        $tgl = getTanggal();

        $tukar = DB::table('transaksi_koin')->insert(
            array(
                'jenis' => 'tukar',
                'koin' => -1*$request->koin,//koin
                'jumlah' => $request->jumlah,//jumlah
                'total_bayar' => $total,
                'user_id' => auth()->user()->id,
                'transaksi_kode' => $id,//ada transaksi_tipe
                'tanggal' => $tgl,
                'status' => 'Admin'//$status,
            )
        );
        if($tukar == 1) {
            $pesan = 'success';//.$request->koin;
            return redirect('/tukar-koin')->with($pesan,'Permintaan Anda telah Dikirim. Harap Menunggu Konfirmasi.');
        }
        else return redirect()->back()->withErrors(['error' => 'Gagal Mengirim Permintaan Tukar Koin. Anda bisa Mengirim Ulang Kembali.']);
        //return redirect()->route('nota',['id' => $id]);
        // */
    }

    //bisa deposito (dalam transaksi koin) done
    public function lihatTransaksi($id) {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $deposito = updateDeposito(getTanggal());

        $transdepo = DB::table('transaksi_koin')
            // ->leftJoin('lelang','lelang.transaksi_pemenang','=','transaksi_koin.id','or',
            //     'lelang.transaksi_penjual','=','transaksi_koin.id')
            // ->leftJoin('deposito_koin','deposito_koin.id','=','transaksi_koin.deposito_id')
            ->whereRaw('user_id = '.auth()->user()->id.' and id = '.$id)
            ->selectRaw('jenis as jenis, transaksi_kode as kode,
                koin as koin, tanggal as tanggal,
                status as statusnya')
            ->get();
        $sukses = true;
        $jenis = (count($transdepo) == 1 ? $transdepo[0]->jenis : -1);
        // dd([$transdepo,strpos($jenis,'lelang') > -1]);

        if(count($transdepo) == 1){
            $jenis = $transdepo[0]->jenis;
            // foreach ($transdepo as $key => $value) {
            //     foreach ($value as $i => $item) print($key." -> ".$i." > ".$item."<br>");
            // }
            if($jenis == 'beli' || $jenis == 'tukar'){//beli dan tukar//$transdepo[0]->transaksi_kode != null
                return redirect()->route('nota',['id' =>
                    $transdepo[0]->kode
                ]);
            } else if ($jenis == 'registrasi'){
                return view('user-fans/koin/nota',[
                    'id' => $transdepo[0]->kode,
                    'koinid' => $deposito,//koinuser[0]->koin,
                    'jenis' => $transdepo[0]->jenis,
                    'koin' => $transdepo[0]->koin,
                    'jumlah' => 0,
                    'tanggal' => $transdepo[0]->tanggal,
                    'snap'=> null,
                    'tipe'=> null,
                    'status'=> $transdepo[0]->statusnya,
                    'statusmid'=> $transdepo[0]->statusnya,
                    'berhasil'=> $sukses
                ]);
            } else if (strpos($jenis,'lelang') > -1){
                $transUser = 'lelang.transaksi_pemenang';//user penggemar
                if($jenis == 'lelang-penjual') $transUser = 'lelang.transaksi_penjual';//penjual
                $transdepo = DB::table('transaksi_koin')
                    ->join('lelang',$transUser,'=','transaksi_koin.id')
                    // ->join('pengiriman','pengiriman.id','=','lelang.pengiriman_id')
                    ->whereRaw('transaksi_koin.user_id = '.auth()->user()->id.' and transaksi_koin.id = '.$id)
                    ->selectRaw('transaksi_koin.jenis as jenis, transaksi_koin.transaksi_kode as kode,
                        transaksi_koin.koin as koin, transaksi_koin.tanggal as tanggal,
                        transaksi_koin.status as statusnya,
                        lelang.id as idlelang, lelang.nama_produk as produk,
                        lelang.tanggal_selesai as selesai, lelang.transaksi_pemenang as pemenang, lelang.pengiriman_id as idkirim,
                        lelang.transaksi_penjual as penjual, lelang.transaksi_admin as admin')// lelang.persentase_penjual as persen,
                    ->get();
                // dd($transdepo[0]->idlelang);
                // $gagal = false;
                if(count($transdepo) == 0){//transaksi gagal bayar lelang
                    $transdepo = DB::table('transaksi_koin')
                        ->join('lelang','lelang.id','=','transaksi_koin.total_bayar')
                        // ->join('pengiriman','pengiriman.id','=','lelang.pengiriman_id')
                        ->whereRaw('transaksi_koin.user_id = '.auth()->user()->id.' and transaksi_koin.id = '.$id)
                        ->selectRaw('transaksi_koin.jenis as jenis, transaksi_koin.transaksi_kode as kode,
                            transaksi_koin.koin as koin, transaksi_koin.tanggal as tanggal,
                            transaksi_koin.status as statusnya,
                            lelang.id as idlelang, lelang.nama_produk as produk,
                            lelang.tanggal_selesai as selesai, lelang.transaksi_pemenang as pemenang, lelang.pengiriman_id as idkirim,
                            lelang.transaksi_penjual as penjual, lelang.transaksi_admin as admin')// lelang.persentase_penjual as persen,
                        ->get();
                    $sukses = false;
                    // dd($transdepo[0]->pemenang != $id);
                }
                if(count($transdepo) == 1){
                    $pengiriman = [];
                    if($transdepo[0]->idkirim != null) $pengiriman = DB::table('pengiriman')->whereRaw('id = '.$transdepo[0]->idkirim)->get();
                    // dd($pengiriman);
                    $menang = DB::table('transaksi_koin')
                        // ->join('','lelang.transaksi_pemenang','=','transaksi_koin.id')
                        ->join('users','transaksi_koin.user_id','=','users.id')
                        ->selectRaw('users.nama as userNama, users.kota as userKota, users.nomor_telepon as userTelepon,
                        transaksi_koin.tanggal as tglbayar, transaksi_koin.status as statusnya')
                        ->whereRaw('transaksi_koin.id = '.$transdepo[0]->pemenang)
                        ->get();
                    // dd(
                        // $transdepo[0]->jenis,
                        // $transdepo[0]->statusnya,
                        // $pengiriman[0]->alamat_tujuan
                        // strpos(strtolower($pengiriman[0]->waktu_perkiraan),'hari'),
                        // str_replace('hari','hari',strtolower($pengiriman[0]->waktu_perkiraan))
                    // );
                    $maksimal = date('Y-m-d',strtotime($transdepo[0]->selesai." + 7 days"))." 23:59:59";
                    // dd($maksimal,getTanggal(),getTanggal() > $maksimal);
                    return view('user-fans/lelang/nota-lelang',[
                        'koinid' => $deposito,//koinuser[0]->koin,
                        'trans' => $id,//id trans
                        'kode' => $transdepo[0]->kode,//trans kode
                        'pemenang'=> (count($menang) == 1 ? [
                            'userNama' => $menang[0]->userNama,
                            'tglbayar' => $menang[0]->tglbayar,
                            'status' => $menang[0]->statusnya,
                            'userTelepon' => $menang[0]->userTelepon,
                        ] : [
                            'userNama' => $menang[0]->userNama,
                            'tglbayar' => $menang[0]->tglbayar,
                            'status' => $menang[0]->statusnya,
                            'userTelepon' => $menang[0]->userTelepon,
                        ]),
                        'penjual'=> $transdepo[0]->penjual,
                        'admin'=> $transdepo[0]->admin,
                        'lelang' => $transdepo[0]->idlelang,
                        'jenis' => $transdepo[0]->jenis,
                        'produk' => $transdepo[0]->produk,
                        // 'persen' => $transdepo[0]->persen,
                        'statuskirim' => (count($pengiriman) == 1 ? $pengiriman[0]->status : null),
                        'alamatkirim' => (count($pengiriman) == 1 ? $pengiriman[0]->alamat_tujuan : null),
                        'pengiriman' => (count($pengiriman) == 1 ? [
                            'id' => $pengiriman[0]->id,
                            'asal' => $pengiriman[0]->asal,
                            'tujuan' => $pengiriman[0]->tujuan,
                            'kurir' => $pengiriman[0]->kurir,
                            'berat' => $pengiriman[0]->berat,
                            'biaya' => $pengiriman[0]->biaya,
                            'layanan' => $pengiriman[0]->layanan,
                            'waktu' => $pengiriman[0]->waktu_perkiraan,
                            'status' => $pengiriman[0]->status,
                            'alamat' => $pengiriman[0]->alamat_tujuan,
                            'tglkirim' => $pengiriman[0]->tanggal_kirim,
                            'tglubah' => $pengiriman[0]->tanggal_update,
                            ] : [
                                'asal' => null,
                                'tujuan' => null,
                                'kurir' => null,
                                'berat' => null,
                                'biaya' => null,
                                'layanan' => null,
                                'waktu' => null,
                                'status' => null,
                                'alamat' => null,
                                'tglkirim' => null,
                                'tglubah' => null,
                            ]),
                        'koin' => $transdepo[0]->koin,
                        'jumlah' => 0,
                        'maksimaltgl' => $maksimal,
                        'selesaitgl' => $transdepo[0]->selesai,//sebelumnya tanggal transkoin, jd tanggal selesai
                        'snap'=> null,
                        'tipe'=> null,
                        'status'=> $transdepo[0]->statusnya,
                        'berhasil'=> $sukses,
                        'hari_ini' => getTanggal()
                    ]);
                }
            }
        }
        else return redirect()->route('beli');
    }

    //update bayar koin yg menang lelang done
    public function bayarLelang(Request $request) {
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $lelang = DB::table('lelang')->whereRaw('id='.$request->lelang.' and transaksi_pemenang = '.$request->trans)
            ->selectRaw('transaksi_pemenang as pemenang, transaksi_penjual as penjual, transaksi_admin as admin')->get();
        // dd(count($lelang),$request->trans == $lelang[0]->pemenang);
        $statusAkhir = '';
        $tgl_bayar = getTanggal();

        if($tgl_bayar <= $request->tanggal_bayar) $statusAkhir = 'Berhasil';//bayar sebelum maksimal bayar
        else {//gagal untuk pemenang, penjual dan admin tidak (berhasil)
            $statusAkhir = 'Gagal';
            if(count($lelang) && $request->trans == $lelang[0]->pemenang){
                $pemenang = DB::table('transaksi_koin')
                    ->whereRaw('id ='.$lelang[0]->pemenang)
                    ->update(
                    array(
                        'status' => 'Gagal',
                        'total_bayar' => $request->lelang,//lelang_id
                        'tanggal' => $tgl_bayar,
                        'status' => ($statusAkhir)
                    )
                );

                $gagalbid = DB::table('lelang_bid')
                    ->whereRaw("user_id ='".auth()->user()->id."' and lelang_id='".$request->lelang."'")
                    ->update(['menang'=> -1]);

                if($pemenang == 1 && $gagalbid == 1) return redirect()->route('lihatTransaksi',['id' => $request->trans]);
            }
            return redirect()->route('lihatTransaksi',['id' => $request->trans]);
        }

        if(count($lelang) > 0){
            //sukses sebelum 7 hari deadline
            if($request->trans == $lelang[0]->pemenang){
                $pemenang = DB::table('transaksi_koin')
                    ->whereRaw('id ='.$lelang[0]->pemenang)
                    ->update(
                    array(
                        'tanggal' => $tgl_bayar,
                        'status' => ($statusAkhir != '' ? $statusAkhir : 'Belum')
                    )
                );
            }
            $penjual = DB::table('transaksi_koin')
                ->whereRaw('id ='.$lelang[0]->penjual)
                ->update(
                array(
                    'tanggal' => $tgl_bayar,
                    'status' => ($statusAkhir != '' ? $statusAkhir : 'Belum')
                )
            );
            $admin = DB::table('transaksi_koin')
                ->whereRaw('id ='.$lelang[0]->admin)
                ->update(
                array(
                    'tanggal' => $tgl_bayar,
                    'status' => ($statusAkhir != '' ? $statusAkhir : 'Belum')
                )
            );
            if($pemenang == 1 && $penjual == 1 && $admin == 1){
                // INSERT INTO `pengiriman`(`lelang_id`, `ongkir`, `asal`, `tujuan`, `kurir`, `berat`, `alamat_tujuan`, `status`)
                $idkirim = DB::table('pengiriman')->whereRaw('lelang_id ='.$request->lelang)->get('id');
                $pengiriman = -1;
                if(count($idkirim) == 0 && $statusAkhir != 'Gagal'){
                    $pengiriman = DB::table('pengiriman')->insert([
                    'lelang_id' => $request->lelang,
                    'alamat_tujuan' => $request->alamat,
                    'status' => ($statusAkhir != '' ?
                        ($statusAkhir == 'Berhasil' ? 'Dalam Proses' : 'Belum') : 'Belum')
                    ]);
                }
                $pembayaran = -1;
                if($pengiriman == 1) {
                    $idkirim = DB::table('pengiriman')->whereRaw('lelang_id ='.$request->lelang)->get('id');
                    $pembayaran = DB::table('lelang')->whereRaw('id='.$request->lelang)
                        ->update(['pengiriman_id' => (count($idkirim) == 1 ? ($idkirim[0]->id != -1 ? $idkirim[0]->id : 0): 0)]);
                    if($pembayaran == 1) return redirect()->route('lihatTransaksi',['id' => $request->trans]);
                }
                else return redirect()->route('lihatTransaksi',['id' => $request->trans]);
            }
            else return redirect()->route('deposito');
        }
        return redirect()->route('deposito');
    }

    //penjual
    // buat transaksi ulang jika gagal membayar done
    public function transaksiUlang($id) {
        if(auth()->user()->role != 3 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $lelang = DB::table('lelang')->whereRaw('id='.$id)->get();
        // /*
        $allbid = DB::table('lelang_bid')
            ->join('lelang','lelang_bid.lelang_id','=','lelang.id')
            // ->join('users','lelang_bid.user_id','=','users.id')
            ->whereRaw('lelang.id='.$lelang[0]->id)
            ->selectRaw('lelang_bid.bid_id as bid,
                lelang_bid.lelang_id as lelang,
                lelang_bid.user_id as user,
                lelang_bid.koin_penawaran as koin,
                lelang_bid.tanggal_bid as tgl,
                lelang_bid.status as status,
                lelang_bid.menang as menang')
            ->orderByDesc('lelang_bid.koin_penawaran')
            ->get();//count();
        // dd($allbid);
        // if($allbid == 1) {$statusnya = 1; $pesan = 'berjalan';}

        $iterasi = 0;
        $pemenangbaru = -1;
        print($pemenangbaru." id<-->lelang<-->user<-->koin<-->tgl<-->status<br>");
        // $pemenanglama = DB::table('transaksi_koin')
        //     ->whereRaw("id='".$lelang[0]->transaksi_pemenang."'")
        //     ->get();
        while ($iterasi < count($allbid)) {
            if($allbid[$iterasi]->menang > -1) {
                $pemenangbaru = $iterasi;
                $iterasi = count($allbid);
            }
            //else $pemenanglama[0]->status == 'Gagal'

            // print(count($pemenanglama)."<hr>");
            $iterasi+=1;
        }
        print($pemenangbaru.'/'.$allbid[$pemenangbaru]->bid."<-->");
        print($allbid[$pemenangbaru]->lelang."<-->");
        print($allbid[$pemenangbaru]->user."<--><strong>");
        print($allbid[$pemenangbaru]->koin."</strong><-->");
        print($allbid[$pemenangbaru]->tgl."<-->");
        print($allbid[$pemenangbaru]->status."<--> >> ");

        $tgltrans = date("Ymd", strtotime($lelang[0]->tanggal_selesai));//dari tanggal selesai
        $idtrans = '00000';
        $counting = DB::table('transaksi_koin')->count();
        $iterasi = 1;
        if(((int) $counting+$iterasi) < 10) $idtrans = '0000'.((int) $counting+$iterasi);
        else if(((int) $counting+$iterasi) < 100) $idtrans = '000'.((int) $counting+$iterasi);
        else if(((int) $counting+$iterasi) < 1000) $idtrans = '00'.((int) $counting+$iterasi);
        else if(((int) $counting+$iterasi) < 10000) $idtrans = '0'.((int) $counting+$iterasi);
        date_default_timezone_set('Asia/Jakarta');
        $idtrans = 'ID'.$tgltrans.$idtrans;
        $tgl = getTanggal();
        // dd($idtrans);
        if($pemenangbaru > 0){
            $pemenang = DB::table('transaksi_koin')
                ->whereRaw("jenis='lelang' and transaksi_kode='$idtrans'")
                ->count();
            if($pemenang == 0){
                $pemenang = DB::table('transaksi_koin')->insert(
                    array(
                        // 'id' => $idnya,
                        'jenis' => 'lelang',
                        'koin' => ($allbid[$pemenangbaru]->koin)*-1,
                        'jumlah' => 1,
                        'total_bayar' => 0,
                        'user_id' => $allbid[$pemenangbaru]->user,
                        'transaksi_kode' => $idtrans,
                        'tanggal' => $tgl,
                        'status' => 'Belum'//$status,
                    )
                );
            }
            $penjual = DB::table('transaksi_koin')
                ->whereRaw("jenis='lelang-penjual' and id=".$lelang[0]->transaksi_penjual)
                ->update(array(
                    // 'id' => $idnya,
                    'koin' => (($allbid[$pemenangbaru]->koin)-((int)((5*$allbid[$pemenangbaru]->koin)/100))),//+((int)(($lelang['persen-penjual']*$allbid[$pemenangbaru]->koin)/100))
                    // 'jumlah' => 1,
                    // 'total_bayar' => 0,
                    // 'user_id' => $lelang['penjual'],
                    'tanggal' => $tgl,
                    // 'status' => 'Belum'//$status,
            ));
            $admin = DB::table('transaksi_koin')
                ->whereRaw("jenis='lelang-admin'and id=".$lelang[0]->transaksi_admin)
                ->update(array(
                    // 'id' => $idnya,
                    'koin' => (int)((5*$allbid[$pemenangbaru]->koin)/100),
                    // 'jumlah' => 1,
                    // 'total_bayar' => 0,
                    // 'user_id' => $lelang['admin'],
                    'tanggal' => $tgl,
                    // 'status' => 'Belum'//$status,
            ));
            if($pemenang == 1 && $penjual == 1 && $admin == 1){
                // $kodetrans = [];
                $kodetrans = DB::table('transaksi_koin')->whereRaw("transaksi_kode = '$idtrans'")->select(['id'])->get();

                $bidmenang = DB::table('lelang_bid')
                    ->whereRaw('bid_id ='.$allbid[$pemenangbaru]->bid)
                    ->update(['menang'=> 1]);

                $berakhir = DB::table('lelang')
                    ->whereRaw('id='.$lelang[0]->id)
                    ->update([
                        'tanggal_selesai' => $tgl,
                        'transaksi_pemenang' => $kodetrans[0]->id,
                        // 'transaksi_penjual' => $kodetrans[1][0]->id,
                        // 'transaksi_admin' => $kodetrans[2][0]->id,
                ]);
                if($berakhir == 1) return redirect()->route('lihatTransaksi',$lelang[0]->transaksi_penjual);
            }
        }
        // else {
        //     //lelang harus berjalan lagi
        // }

        return redirect()->route('lihatTransaksi',$lelang[0]->transaksi_penjual);
        // */
    }

    //cek ongkir oleh penjual done
    // rajaongkir
    public function getOngkir($idlelang){
        if(auth()->user()->role != 3 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $lelang = DB::table('lelang')
            ->join('pengiriman','lelang.pengiriman_id','=','pengiriman.id')
            ->join('transaksi_koin','lelang.transaksi_pemenang','=','transaksi_koin.id')
            ->join('users','transaksi_koin.user_id','=','users.id')
            ->selectRaw('pengiriman.alamat_tujuan as alamatKirim, pengiriman.id as idKirim,
            users.nama as userNama, users.kota as userKota, users.nomor_telepon as userTelepon,
            lelang.nama_produk as produkLelang, transaksi_koin.id as idtrans')//, transaksi_koin.transaksi_kode as pemenang
            ->whereRaw('lelang.id = '.$idlelang)
            ->get();
        $dataLelang = [];
        if(count($lelang) == 1){
            $dataLelang = [
                'idKirim' => $lelang[0]->idKirim,
                'alamatKirim' => $lelang[0]->alamatKirim,
                'userNama' => $lelang[0]->userNama,
                // 'userKota' => $lelang[0]->userKota,
                'userTelepon' => $lelang[0]->userTelepon,
                'idLelang' => $idlelang,
                'produkLelang' => $lelang[0]->produkLelang,
                // 'transPemenang' => $lelang[0]->pemenang,
                'transID' => $lelang[0]->idtrans,
            ];
        }
        // dd($dataLelang);
        $provinces = Province::pluck('name', 'province_id');

        return view('user-penjual/cek-ongkir', [
            'depositoku' => updateDeposito(getTanggal()),
            'provinces' => $provinces,
            'req' => [
                'pro-asal' => null,
                'asal' => null,
                'pro-tujuan' => null,
                'tujuan' => null,
                'kurir' => null,
                'berat' => null,
            ],
            'biaya' => [],
            'lelang' => $dataLelang,
            // 'depo' => updateDeposito(getTanggal())
        ]);//compact('provinces')
    }

    //dari rajaongkir done
    public function getKota($id){
        if(auth()->user()->role != 3 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $city = City::where('province_id', $id)->pluck('name', 'city_id');
        return response()->json($city);
    }

    //cari pengiriman done
    public function cekOngkir(Request $request){
        if(auth()->user()->role != 3 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        // $province_origin = $request->province_origin;
        $city_origin = $request->city_origin;
        // $province_destination = $request->province_destination;
        $city_destination = $request->city_destination;

        $pro_asal = Province::where('province_id', $request->province_origin)->pluck('name');
        $asal = City::where('province_id', $request->province_origin)->where('city_id', $request->city_origin)->pluck('name');
        $pro_tujuan = Province::where('province_id', $request->province_destination)->pluck('name');
        $tujuan = City::where('province_id', $request->province_destination)->where('city_id', $request->city_destination)->pluck('name');

        $courier = $request->courier;
        $weight = $request->weight;
        if($request->city_origin == '' || $request->city_destination == '' || $request->courier == '' || $request->weight == ''){
            $pesan = 'Kota ';
            if($request->city_origin == '') $pesan = $pesan.'Asal';
            else if($request->city_destination == '') $pesan = $pesan.'Tujuan';
            else if($request->courier == '0') $pesan = 'Kurir';
            else if($request->weight == '') $pesan = 'Berat Kiriman';
            return back()->withInput([
                'city_origin' => $city_origin,
                'city_destination' => $city_destination,
                'courier' => $courier,
                'weight' => $weight
            ])->withErrors([
                'city_origin' => "Wajib mengisi $pesan."
            ]);
        }
        // dd($request);

        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $city_origin, // ID kota/kabupaten asal
            'destination'   => $city_destination, // ID kota/kabupaten tujuan
            'weight'        => $weight, // berat barang dalam gram
            'courier'       => $courier // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();
        // dd($cost);
        $biaya = [];
        foreach($cost[0]['costs'] as $item){
            $biaya[] = [
                'code' => strtoupper($cost[0]['code']),
                'servis' => $item['service'],
                'biaya' => $item['cost'][0]['value'],
                'hari' => $item['cost'][0]['etd']
            ];
        }
        // dd($biaya);
        $provinces = Province::pluck('name', 'province_id');

        return view('user-penjual/cek-ongkir',[
            'depositoku' => updateDeposito(getTanggal()),
            'provinces' => $provinces,
            'req' => [
                'pro-asal' => $pro_asal[0],
                'asal' => $asal[0],
                'pro-tujuan' => $pro_tujuan[0],
                'tujuan' => $tujuan[0],
                'kurir' => $courier,
                'berat' => $weight
            ],
            'lelang' => $dataLelang = [
                'idKirim' => $request->idKirim,
                'alamatKirim' => $request->alamatKirim,
                'userNama' => $request->userNama,
                // 'userKota' => $request->userKota,
                'userTelepon' => $request->userTelepon,
                'idLelang' => $request->idLelang,
                'produkLelang' => $request->produkLelang,
                // 'transPemenang' => $request->transPemenang,
                'transID' => $request->transID
            ],
            'biaya' => $biaya
        ]);
    }

    //pilih ongkir yg sesuai, buat pengiriman
    // bayar ongkir oleh penjual dg midtrans??
    public function bayarOngkir(Request $request){
        if(auth()->user()->role != 3 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        // dd($request->idKirim,$request->transID);
        $pengiriman = DB::table('pengiriman')
            // ->join('lelang','lelang_bid.lelang_id','=','lelang.id')
            // ->join('users','lelang_bid.user_id','=','users.id')
            ->whereRaw('id="'.$request->idKirim.'" and lelang_id='.$request->idLelang.' and alamat_tujuan="'.$request->alamatKirim.'"')
            // ->selectRaw('lelang.penjual_id as penjual, lelang_bid.koin_penawaran as koinpemenang,
            //     lelang_bid.user_id as pemenang, users.nama as namapemenang')
            // ->orderByDesc('lelang_bid.koin_penawaran')
            ->get();
        // while(){
        //     $usermenang[1]->koinpemenang
        // }
        if(count($pengiriman) == 1){
            $mengirim = DB::table('pengiriman')
                ->whereRaw('lelang_id="'.$request->idLelang.'" and alamat_tujuan="'.$request->alamatKirim.'"')
                ->update(array(
                    'asal' => $request->asal,
                    'tujuan' => $request->tujuan,
                    'kurir' => $request->kurir,
                    'berat' => $request->berat,
                    'layanan' => $request->servis,
                    'waktu_perkiraan' => $request->hari,
                    'biaya' => $request->biaya,
                    'status' => 'Pengiriman',
                    // 'tanggal_kirim' => '',
                    'tanggal_update' => getTanggal(),
                )
            );
            // dd((strlen($request->transPemenang)),$request->transPemenang);
            if($mengirim == 1) return redirect()->route('lihatTransaksi',['id' => $request->transID]);
        }
    }

    //ubah status sbg tracking
    public function statusPengiriman(Request $request) {
        if(auth()->user()->role != 3 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        // dd($request->lelang, $request->status,$request->trans);
        $pengiriman = DB::table('pengiriman')
            ->whereRaw('lelang_id='.$request->lelang)
            ->get();
        if(count($pengiriman) == 1){
            $mengirim = DB::table('pengiriman')
                ->whereRaw('lelang_id='.$request->lelang)
                ->update(array(
                    'status' => $request->status,
                )
            );
            if($mengirim == 1) return redirect()->route('lihatTransaksi',['id' => $request->trans]);
        }
        // else return redirect()->route('lihatTransaksi',['id' => $request->trans]);
    }
}
