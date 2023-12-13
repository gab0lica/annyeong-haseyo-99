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

class MasterTransaksiKoin extends Controller
{
    //user: penggemar dan penjual
    public function getDeposito($user) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $usernya = 2;//penggemar
        if($user == 'penjual') $usernya = 3;

        $trans = DB::table('users')
            ->rightJoin('transaksi_koin','transaksi_koin.user_id','=','users.id')
            ->whereRaw("users.role = ".$usernya)//." and transaksi_koin.jenis != 'lelang'")
            ->selectRaw('count(transaksi_koin.id) as trans, users.id as iduser, users.username as username,  users.status as status, users.updated_at, users.created_at')
            ->groupBy(
                'iduser',
                'username',
                'users.updated_at',
                'users.created_at',
                'status')
            ->get();

        $deposito = [];
        foreach ($trans as $value) {
            // foreach ($value as $i => $item) print($i.' <--> '.$item.'<br>');
            // print("<hr>");
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $tanggal_format = strtotime($value->updated_at);
            $updated = str_replace($bulanInggris, $bulanIndonesia, date("d F Y", $tanggal_format));
            $tanggal_format = strtotime($value->created_at);
            $created = str_replace($bulanInggris, $bulanIndonesia, date("d F Y", $tanggal_format));

            $deposito[] = [
                'id' => $value->iduser,
                'username' => $value->username,
                'trans' => $value->trans,
                'status' => $value->status,
                'updated_at' => $updated,
                'created_at' => $created,
            ];
        }
        return view('user-admin/user/data-deposito',[
            'error' => false,
            'user' => $user,
            'deposito' => $deposito
            ]
        );
    }

    //done per user (penggemar ato penjual)
    public function userDeposito($id) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        // penggemar: Penarikan koin ini bisa dilakukan setiap 7 (tujuh) hari sekali dengan menarik maksimal 100 (seratus) koin.
        // penjual: Penarikan koin ini bisa dilakukan setiap 3 (tiga) hari sekali dengan menarik maksimal 200 (dua seratus) koin
        $depo = DB::table('transaksi_koin')
            ->leftJoin('users','transaksi_koin.user_id','=','users.id')
            // ->crossJoin('transaksi_koin')
            ->where('transaksi_koin.user_id','=',$id)
            ->selectRaw('users.id as user, users.username as username, users.nama as nama, users.role as role,
                transaksi_koin.id as deposito, transaksi_koin.transaksi_kode as kodedepo, transaksi_koin.transaksi_tipe as tipedepo,
                transaksi_koin.jenis as jenisdepo, transaksi_koin.admin_id as admindepo,
                transaksi_koin.koin as koindepo, transaksi_koin.jumlah as jumlahdepo, transaksi_koin.total_bayar as totaldepo,
                transaksi_koin.tanggal as tanggaldepo, transaksi_koin.status as statusdepo
                ')//transaksi_koin.jumlah_koin as jumlahkoin
                // transaksi_koin.id as trans, transaksi_koin.jenis as jenis, transaksi_koin.jumlah_koin as jumlah,
                // transaksi_koin.tanggal as tanggal, transaksi_koin.status as status,
            // ->orderBy('transaksi_koin.tanggal','desc')
            ->orderBy('transaksi_koin.tanggal','desc')
            ->get();

        $user = null; $sudah = false;
        $deposito = [];
        foreach ($depo as $key => $value) {
            if(!$sudah){
                $user = [
                    'id' => $value->user,
                    'username' => $value->username,
                    'nama' => $value->nama,
                    'role' => $value->role,
                ];
            }

            // if($value->jenisdepo == 'beli' || $value->jenisdepo == 'tukar' || $value->jenisdepo == 'registrasi'){
                // $jumlah = $value->koin*$value->jumlahdepo;
                // if($jumlah < 0) $jumlah *= -1;
                $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                $tanggal_format = strtotime($value->tanggaldepo);
                $tanggaldepo = str_replace($bulanInggris, $bulanIndonesia, date("d F Y H:i:s", $tanggal_format));

                $deposito[] = [
                    // 'trans' => $value->trans,
                    // 'jenis' => $value->jenis,
                    // 'jumlah' => $value->jumlah,
                    // 'tanggal' => $value->tanggal,
                    // 'status' => $value->status,
                    // 'jumlahkoin' => $jumlah,//$value->jumlahkoin,
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
                //kodedepo tipedepo jenisdepo admindepo koindepo jumlahdepo totaldepo tanggaldepo statusdepo
            // }
        }
        return view('user-admin/user/deposito',[
            'error' => false,
            'user' => $user,
            'deposito' => $deposito
        ]);
        // */
    }

    //done
    public function tukarDepo(Request $request) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
            print('masuk');
        }
        // print('disini');
        // $total = (($request->koin*((int) $request->jumlah))+2)*1000;
        $snapToken = '';
        $id = $request->transkode;

        // $tgl = date('d').'-';
        // $tanggal = ( (int) date('d') );
        // $jam = ( (int) date('H') )+7;
        // if($jam >= 24) {$tanggal += 1; $jam = "0".($jam - 24);}
        // elseif($jam < 10) {$jam = "0".$jam;}
        // if($tanggal < 10) {
        //     $tgl = date("Y-m")."-0".$tanggal.' '.$jam.date(':i:s');
        //     // $id = 'ID'.date("Ym").'0'.$tanggal.$idtrans;
        // }
        // else if ($tanggal < 32) {
        //     $tgl = date("Y-m-").$tanggal.' '.$jam.date(':i:s');
        //     // $id = 'ID'.date("Ym").$tanggal.$idtrans;
        // }
        $tgl = getTanggal();

        //cari data transaksi_koin
        $depo = DB::table('transaksi_koin')
            ->leftJoin('users','transaksi_koin.user_id','=','users.id')
            ->where('users.id','=',$request->userid)
            ->where('transaksi_koin.transaksi_kode','=',$id)
            // ->where('transaksi_koin.status','=','Admin')
            ->selectRaw('users.id as user, users.username as username, users.nama as nama, users.email as email, users.role as role,
                users.nomor_telepon as nomor, users.kota as kota, users.updated_at, users.created_at,
                transaksi_koin.id as trans, transaksi_koin.transaksi_kode as kodedepo, transaksi_koin.transaksi_tipe as tipedepo,
                transaksi_koin.jenis as jenisdepo, transaksi_koin.admin_id as admindepo, transaksi_koin.token as token,
                transaksi_koin.koin as koindepo, transaksi_koin.jumlah as jumlahdepo, transaksi_koin.total_bayar as totaldepo,
                transaksi_koin.tanggal as tanggaldepo, transaksi_koin.status as statusdepo')
            ->orderBy('transaksi_koin.tanggal','desc')
            ->get();

        // $id = '-';
        // foreach ($depo as $key => $value) {
        //     foreach ($value as $i => $item) {
        //         if($i == 'user' || $i == 'trans') print('<b>'.$i.'</b> = '.$item.'<br>');
        //         else if($i == 'kodedepo') $id = $item;
        //         print($i.' = '.$item.'<br>');
        //     }
        //     print('<hr>');
        // }

        //pembayaran
        // /*
        if(count($depo) == 0) return redirect()->route('dataDepo',['user'=>'penggemar']);
        else if($depo[0]->token == null){
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $id,
                    'gross_amount' => $depo[0]->totaldepo, // no decimal allowed for creditcard //tergantung koinnya berapa, 1 koin = 1k idr
                ),
                'customer_details' => array(
                    'name' => $depo[0]->nama,
                    'email' => $depo[0]->email,
                    // 'first_name'    => $depo[0]->nama,
                    'phone'         => $depo[0]->nomor,
                ),
                'item_details' => array(
                    array(
                        'id' => 1,
                        'price' => ($depo[0]->koindepo*-1000),
                        'quantity' => $depo[0]->jumlahdepo,
                        'name' => 'Paket '.($depo[0]->koindepo*-1).' Koin'
                    ),
                    array(
                        'id' => 2,
                        'price' => -3000,
                        'quantity' => 1,
                        'name' => "Biaya Admin"
                    ),
                ),
            );
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        }
        else $snapToken = $depo[0]->token;
        // $statusmidtrans = \Midtrans\Transaction::status($id);

        // print($snapToken."<hr>");
        // print($request->koin.'<->');
        // print(($request->koin*1000)."<hr>");
        // print($idtrans."<hr>");
        // dd($snapToken);
        // */

        $db = DB::table('transaksi_koin')
            ->where('user_id','=',$request->userid)
            ->where('transaksi_kode','=',$id)
            ->update(
            array(
                'admin_id' => auth()->user()->id,
                'token' => $snapToken,
                'tanggal' => $tgl,
                'status' => 'Belum'//$status,
            )
        );

        if($db == 1 && $snapToken != '') return redirect()->route('notaDepo',['id' => $id]);
        else return redirect()->back()->withErrors(['msg' => 'Transfer Koin Gagal.']);
        //end pembayaran
    }

    //done
    public function notaDepo($id) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        //cari di database
        $bayar = DB::table('transaksi_koin')
            // ->join('users','transaksi_koin.user_id','=','users.id')
            ->where('transaksi_kode','=',$id)->get();
            // ->get(['transaksi_koin.*','users.role as rolenya']);
        $status = null;
        $sukses = false;
        $selesai = -1;

        if(count($bayar) == 1){
            //transaksi midtrans harus pending dulu!!
            // dd($statusmidtrans);
            $status = $bayar[0]->status;
            if($bayar[0]->jenis == 'tukar'){
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
                        else if($key == 'signature_key') $signature_key = $value;// && $value == $bayar[0]->token

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
                                // $token = '458cce1a422e5f282a29c908c45a420ed19ac6421ff32fb817a0e850942d4bc9eab3cc35b0205fb39aca0d2c601f32c6f3cd9152896dd0c2d8842fd9afec8204';
                                // print($hashed.'<hr>'.$signature_key.'<hr>'.$token."<hr>".$bayar[0]->token);
                                // $trans = DB::table('transaksi_koin')
                                //     ->insert([
                                //         'jenis' => 'beli',
                                //         'jumlah_koin' => $bayar[0]->koin*$bayar[0]->jumlah,
                                //         'user_id' => auth()->user()->id,
                                //         'tanggal' => $tgl,
                                //         'deposito_id' => $bayar[0]->id,
                                //         'status' => 'Berhasil'
                                // ]);
                                if($selesai == 1) $sukses = true;
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
            $nota = DB::table('transaksi_koin')
                ->join('users','transaksi_koin.user_id','=','users.id')
                ->where('transaksi_kode','=',$id)
                ->get(['transaksi_koin.*','users.role as rolenya']);
            $jumlahkoin = DB::table('transaksi_koin')->where('user_id','=',auth()->user()->id)->where('status','=','Berhasil')->sum('koin');

            return view('user-admin/user/nota-deposito',[
                'id' => $id,
                'koinid' => $jumlahkoin,
                'jenis' => $nota[0]->jenis,
                'koin' => $nota[0]->koin,
                'jumlah' => $nota[0]->jumlah,
                'total' => $nota[0]->total_bayar,
                'tanggal' => $nota[0]->tanggal,
                'snap'=> $nota[0]->token,
                'tipe'=> $nota[0]->transaksi_tipe,
                'status'=> $nota[0]->status,
                'statusmid'=> $status,
                'berhasil'=> $sukses,
                'role' => $nota[0]->rolenya
            ]);
        }
        else return redirect()->route('dataDepo',['user' => 'penggemar']);
    }

    //transaksi koin ?? buat apa??
    // public function getKoin() {
    //     if(auth()->user()->role != 1 || auth()->user()->status == 0) {
    //         Auth::logout();
    //         return redirect('/login');
    //     }

    //     $deposito = [];
    //     // DB::table('koin?')
    //         // ->join('berita','konten_berita.berita_id','=','berita.berita_id')
    //         // ->where("berita.status","=",3)//status = 3 (bhs idn)
    //         // ->select(['berita.*','konten_berita.judul_idn','konten_berita.desk_idn'])
    //         // ->orderBy('berita.berita_id','desc')
    //         // ->get();
    //     return view('user-admin/user/transaksi',[
    //         // 'error' => false,
    //         // 'user' => $user,
    //         // 'deposito' => $deposito
    //         ]
    //     );
    // }
}
