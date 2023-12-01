<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function getTanggal() {
    date_default_timezone_set('Asia/Jakarta');
    return date("Y-m-d H:i:s");
}

class ControllerBerita extends Controller
{
    //all done
    //buka semua berita
    public function getBerita($web){
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $orderRaw = 'berita.berita_id desc';//berita_konten.konten_id
        $idweb = 0; //all web
        if($web == 'dsp') {
            //dispatch
            $idweb = 1;
            $orderRaw = 'berita_konten.tgl_publikasi desc';//tgl_idn juga bisa
        }
        else if($web == 'ktm') {
            //koreatimes
            $idweb = 2;
            $orderRaw = 'berita_konten.tgl_publikasi desc';
        }
        else if($web == 'khd') {
            //koreaherald
            $idweb = 3;
            // $orderRaw = 'berita.berita_id desc';//masih belum betul karena tgl dalam tulisan
        }

        $berita = [];
        $dbase = [];
        /*
        SELECT berita_konten.tgl_idn, berita.web_id FROM berita join berita_konten on berita.berita_id=berita_konten.berita_id where berita.web_id=1 order by berita_konten.tgl_idn desc;
        SELECT berita_konten.tgl_publikasi, berita.web_id FROM berita join berita_konten on berita.berita_id=berita_konten.berita_id where berita.web_id=2 order by berita_konten.tgl_publikasi desc;
        SELECT berita_konten.tgl_publikasi, berita.web_id FROM berita join berita_konten on berita.berita_id=berita_konten.berita_id where berita.web_id=3 order by berita_konten.tgl_publikasi desc;
        */
        if($idweb == 0 && $web == 'semua'){
            $dbase = DB::table('berita_konten')
                ->join('berita','berita_konten.berita_id','=','berita.berita_id')
                ->whereRaw("berita.status = 3 and berita_konten.tgl_publikasi like '%2023%'")//status = 3 (bhs idn)
                ->select(['berita.*','berita_konten.judul_idn','berita_konten.desk_idn','berita_konten.tgl_idn'])
                ->orderBy('berita_konten.berita_id','desc')
                ->get();
        } else {
            $dbase = DB::table('berita_konten')
                ->join('berita','berita_konten.berita_id','=','berita.berita_id')
                ->whereRaw("berita.web_id =".$idweb." and berita.status = 3 and berita_konten.tgl_publikasi like '%2023%'")//status = 3 (bhs idn)
                // ->where("berita.status","=",3)//status = 3 (bhs idn)
                ->select(['berita.*','berita_konten.judul_idn','berita_konten.desk_idn','berita_konten.tgl_idn'])
                ->orderByRaw($orderRaw)
                // ->orderBy('berita_konten.berita_id','desc')
                ->get();
        }
        $dsp = DB::table('berita')->where("web_id","=", 1)->where("status","=",3)->count();
        $ktm = DB::table('berita')->where("web_id","=", 2)->where("status","=",3)->count();
        $khd = DB::table('berita')->where("web_id","=", 3)->where("status","=",3)->count();
        $artis = DB::table('artis')->orderBy('nama','asc')->get();
        // print("jumlah : ".count($dbase)."<hr>");

        foreach ($dbase as $value) {//$key =>
            $strjudul = substr($value->judul_idn,0,(2*strlen($value->judul_idn))/2);
            $posisititik1 = strpos($value->judul_idn,'...');
            $posisititik2 = strpos($value->judul_idn,'..');
            $posisititik3 = strpos($value->judul_idn,'. ');
            $titik = 0;
            if($posisititik1 > 0) $titik = $posisititik1;
            else if ($posisititik2 > 0) $titik = $posisititik2;
            else if ($posisititik3 > 0) $titik = $posisititik3;
            if($titik > 0) $strjudul = substr($value->judul_idn,0,$titik);
            if(strlen($strjudul) < strlen($value->judul_idn)) {$jdl = $strjudul.'...';$strjudul = $jdl;}

            //ambil gambar
            //dsp SELECT count(*) FROM `berita_konten` WHERE desk_idn like '%dispatch.cdnser.be/cms-content/uploads%' src="https://dispatch.cdnser.be/cms-content/uploads/2023/09/15/396f2336-b872-4381-8de2-912be078379f.jpg"
            //ktm SELECT count(*) FROM `berita_konten` WHERE desk_idn like '%image.koreatimes.com/article%' src="http://image.koreatimes.com/article/2023/09/07/20230907103239641.jpg"
            //khd SELECT count(*) FROM `berita_konten` WHERE desk_idn like '%res.heraldm.com/content/image%' src="//res.heraldm.com/content/image/2023/09/15/20230915000475_0.jpg"
            $src = str_replace('data-src','src',$value->desk_idn);
            $html_string = $src;
            $pattern = '/src="([^"]+)"/'; // Ekspresi reguler untuk mencari URL di dalam atribut src
            $url = '';
            if (preg_match($pattern, $html_string, $matches) &&
            (preg_match('/dispatch/', $html_string) || preg_match('/koreatimes/', $html_string) || preg_match('/heraldm/', $html_string))) {
                $url = $matches[1]; // Ambil URL yang cocok
                // print("ke-".$key." - ".$url."<br>");
            } else $url = 'nope';
            $berita[] = [
                'id' => $value->berita_id,
                'link' => $value->link,
                'level' => $value->level,
                'status' => $value->status,
                'web' => $value->web_id,
                'judul' => $strjudul,
                'idnjudul' => $value->judul_idn,
                'gambar' => $url,
                'tanggal' => $value->tgl_idn
            ];
            // print($url.'<hr>');
        }

        return view('user-fans/berita/berita',[
            'web'=> $web,
            'dsp'=> $dsp,
            'ktm'=> $ktm,
            'khd'=> $khd,
            'error' => false,
            'cari' => null,
            'listArtis' => $artis,
            'artis' => null,
            'berita' => $berita
            ]
        );
    }

    //cari dg pencarian
    public function cariBerita(Request $req){
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        set_time_limit(1500);
        $tanggal_cari = getTanggal();//date('d').'-';
        // $tanggal = ( (int) date('d') );
        // $jam = ( (int) date('H') )+7;
        // if($jam >= 24) {$tanggal += 1; $jam = "0".($jam - 24);}
        // elseif($jam < 10) {$jam = "0".$jam;}
        // if($tanggal < 10) $tanggal_cari = date("Y-m")."-0".$tanggal.' '.$jam.date(':i:s');
        // else if ($tanggal < 32) $tanggal_cari = date("Y-m-").$tanggal.' '.$jam.date(':i:s');

        // /*
        $error = false;
        if($req->get('cari') == '') return redirect()->route('berita',['web' => 'semua']);

        //dbase berita dan berita_konten (relasi berita dan berita_cari dari kata_kunci request)
        $berita = [];
        $countberita = DB::table('berita_konten')
            ->join('berita','berita_konten.berita_id','=','berita.berita_id')
            ->whereRaw("berita.status = 3 and berita_konten.tgl_publikasi like '%2023%' and (".
                strtolower("berita_konten.judul_idn")." like '% ".strtolower($req->get('cari'))." %' or ".
                strtolower("berita_konten.desk_idn")." like '% ".strtolower($req->get('cari'))." %' )")
            // ->orWhere(strtolower("berita_konten.judul_idn"),"like",'%'.strtolower($req->get('cari')).'%')
            // ->orWhere(strtolower("berita_konten.desk_idn"),"like",'%'.strtolower($req->get('cari')).'%')
            ->select(['berita.*','berita.link as linknya','berita_konten.tgl_idn as tanggalnya','berita_konten.*'])
            ->orderBy('berita_konten.berita_id','desc')
            ->get();

        // cek jumlah berita dari berita_cari = berita_dicari
        //SELECT berita_dicari.cari_id, count(berita_dicari.berita_id), berita_cari.kata_kunci, berita_cari.jumlah_berita FROM berita_dicari join berita_cari on berita_dicari.cari_id = berita_cari.cari_id group by berita_dicari.cari_id

        //dbase berita_cari
        $countcari = DB::table('berita_cari')
            ->where(strtolower("kata_kunci"),"=",strtolower($req->get('cari')))
            ->get('cari_id');
        if(count($countcari) == 0){
            $db = DB::table('berita_cari')->insert(
            array('kata_kunci' => strtolower($req->get('cari')),
                'jumlah_berita' => count($countberita),
                'tanggal_cari' => $tanggal_cari) );
            if($db == 0) $error = true;
            $countcari = DB::table('berita_cari')->where("kata_kunci","like",'%'.strtolower($req->get('cari')).'%')->select('cari_id')->get();
        } else {
            $updated = DB::table('berita_cari')
                ->where("kata_kunci","=", $req->get('cari'))
                ->update( [
                    "jumlah_berita" => count($countberita),
                    "tanggal_cari" => $tanggal_cari
                    ] );
            if($updated == 0) $error = true;
        }

        // //dbase artis (relasi artis dan berita_cari dari kata_kunci request)
        // // SELECT id, nama FROM artis where lower(artis.nama) like lower('%TWICe%')
        $artis = DB::table('artis')->orderBy('nama','asc')->get();
        $countartis = DB::table('artis')
            ->where(strtolower("nama"),"like",'%'.strtolower($req->get('cari')).'%')
            ->get(['id','nama']);
        // print("cari kata > ".$req->cari."<br> -- total berita ".count($countberita)."<br> -- total artis ".count($countartis)."<hr>");//bisa artis berjumlah > 1
        // foreach ($countartis as $key => $value) {
        //     //relasi cari-artis
        //     $artisdicari = DB::table('artis_dicari')
        //         ->where('cari_id','=',$countcari[0]->cari_id)
        //         ->where("artis_id","=",$value->id)
        //         ->get();
        //     if(count($artisdicari) == 0){
        //         $dicari = DB::table('artis_dicari')->insert(
        //             array('cari_id' => $countcari[0]->cari_id, 'artis_id' => $value->id) );
        //         if($dicari == 0) $error = true;
        //     }

        //     // $artisberita = DB::table('berita_konten')
        //     //     ->join('berita','berita_konten.berita_id','=','berita.berita_id')
        //     //     ->where("berita_konten.judul_idn","like",'% '.$value->nama.' %')
        //     //     ->orWhere("berita_konten.desk_idn","like",'% '.$value->nama.' %')
        //     //     ->get(['berita.berita_id']);
        //     // print('artis ke-'.$key." -> ".$value->nama." = jumlah ".count($artisberita)."<br>");
        //     // foreach ($artisberita as $i => $item) {
        //     //     //relasi berita-artis
        //     //     $artisberita = DB::table('berita_artis')
        //     //         ->where("artis_id","=",$value->id)
        //     //         ->where('berita_id','=', $item->berita_id)
        //     //         ->get();
        //     //     if(count($artisberita) == 0){
        //     //         $beritacari = DB::table('berita_artis')->insert(
        //     //             array('artis_id' => $value->id, 'berita_id' => $item->berita_id) );
        //     //         if($beritacari == 0) $error = true;
        //     //     }
        //     // }
        // }

        //mencoba gabungkan berita-cari-artis >> masih salah karena twice dan twice tzuyu digabung jd 26*2 padahal twice aja yg nemu
        // select berita_cari.cari_id as 'id kata cari', artis.id as 'artis ke', artis.nama as 'namanya', berita.berita_id as 'berita ke' from berita_cari, artis, berita_konten join berita on berita_konten.berita_id=berita.berita_id where (berita_konten.judul_idn like '% twice %' or berita_konten.desk_idn like '% twice %') and berita_cari.kata_kunci like '%twice%' and lower(artis.nama) like '%twice%'

        foreach ($countberita as $value) {
            $strjudul = substr($value->judul_idn,0,(2*strlen($value->judul_idn))/2);
            $posisititik1 = strpos($value->judul_idn,'...');
            $posisititik2 = strpos($value->judul_idn,'..');
            $posisititik3 = strpos($value->judul_idn,'. ');
            $titik = 0;
            if($posisititik1 > 0) $titik = $posisititik1;
            else if ($posisititik2 > 0) $titik = $posisititik2;
            else if ($posisititik3 > 0) $titik = $posisititik3;
            if($titik > 0) $strjudul = substr($value->judul_idn,0,$titik);
            if(strlen($strjudul) < strlen($value->judul_idn)) {$jdl = $strjudul.'...';$strjudul = $jdl;}

            //ambil gambar
            $src = str_replace('data-src','src',$value->desk_idn);
            $html_string = $src;
            $pattern = '/src="([^"]+)"/';
            $url = '';
            if (preg_match($pattern, $html_string, $matches) &&
            (preg_match('/dispatch/', $html_string) || preg_match('/koreatimes/', $html_string) || preg_match('/heraldm/', $html_string))) {
                $url = $matches[1]; // Ambil URL yang cocok
            } else $url = 'nope';
            $berita[] = [
                'id' => $value->berita_id,
                'link' => $value->link,
                'level' => $value->level,
                'status' => $value->status,
                'web' => $value->web_id,
                'judul' => $strjudul,
                'idnjudul' => $value->judul_idn,
                'gambar' => $url,
                'tanggal' => $value->tanggalnya
            ];

            //relasi cari-berita
            // $countingdicari = DB::table('berita_dicari')
            //     ->where('cari_id','=',$countcari[0]->cari_id)
            //     ->where("berita_id","=",$value->berita_id)
            //     ->get('cari_id');
            // if(count($countingdicari) == 0){
            //     $dicari = DB::table('berita_dicari')->insert(
            //         array('cari_id' => $countcari[0]->cari_id, 'berita_id' => $value->berita_id) );
            //     if($dicari == 0) $error = true;
            // }
            // foreach ($countartis as $item) {
            //     $artisberita = DB::table('berita_konten')
            //         ->join('berita','berita_konten.berita_id','=','berita.berita_id')
            //         ->where("berita_konten.judul_idn","like",'% '.$item->nama.' %')
            //         ->orWhere("berita_konten.desk_idn","like",'% '.$item->nama.' %')
            //         ->get(['berita.berita_id']);
            //     if(count($artisberita) > 0){
            //         //relasi berita-artis
            //         $artisberita = DB::table('berita_artis')
            //             ->where("artis_id","=",$item->id)
            //             ->where('berita_id','=', $value->berita_id)
            //             ->get();
            //         if(count($artisberita) == 0){
            //             $beritacari = DB::table('berita_artis')->insert(
            //                 array('artis_id' => $item->id, 'berita_id' => $value->berita_id) );
            //             if($beritacari == 0) $error = true;
            //         }
            //     }
            // }
        }

        return view('user-fans/berita/berita',[
            'web'=> 'semua',
            'dsp'=> 0,
            'ktm'=> 0,
            'khd'=> 0,
            'error' => $error,
            'cari' => $req->get('cari'),
            'listArtis' => $artis,
            'artis' => $countartis,
            'berita' => $berita
            ]
        );
        // */
    }

    //lihat berita
    public function bukaBerita($id){
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $tanggal_buka = getTanggal();// date('d').'-';
        // $tanggal = ( (int) date('d') );
        // $jam = ( (int) date('H') )+7;
        // if($jam >= 24) {$tanggal += 1; $jam = "0".($jam - 24);}
        // elseif($jam < 10) {$jam = "0".$jam;}
        // if($tanggal < 10) $tanggal_buka = date("Y-m")."-0".$tanggal.' '.$jam.date(':i:s');
        // else if ($tanggal < 32) $tanggal_buka = date("Y-m-").$tanggal.' '.$jam.date(':i:s');

        //artis
        // // SELECT lower(berita_cari.kata_kunci), lower(artis.nama) FROM berita_cari join artis on berita_cari.artis_id=artis.id where lower(berita_cari.kata_kunci) like '% twice %' or lower(artis.nama) like '% twice %'
        // $artis = DB::table('artis')->where('nama','like','% '.$attributes['artis'].' %')->count(['id']);
        // if($artis == 0) $artis = DB::table('artis')->insert(['nama' => $attributes['artis'],'status' => 1]);

        // /*
        $konten = null;
        $dbase = DB::table('berita_konten')
            ->join('berita','berita_konten.berita_id','=','berita.berita_id')
            ->where("berita.status","=",3)//status = 3 (bhs idn)
            ->where("berita_konten.berita_id","=",$id)
            ->select(['berita.*','berita.link as linknya','berita_konten.*'])
            ->get();

        //status link = 0/-1
        if(count($dbase) == 0) return redirect()->route('berita',['web' => 'semua']);

        foreach ($dbase as $value) {
            $cleaned = $value->desk_idn;
            if($value->web_id == 1){//dispatch
                $src = str_replace('data-src','src',$value->desk_idn);
                $center = str_replace('text-align: center;', 'text-align: left;',$src);
                $width = str_replace('style="width:100%', 'style="width:50%;"',$center);
                $cleaned = str_replace('gambarnya','gambarnya h-50',$width);
            } else if($value->web_id == 2){//koreatimes
                $gambar         = "img_arti img_a2";
                $jadigmb = str_replace('gambarnya','gambar',$cleaned);
                $gmb = str_replace($gambar,'gambarnya',$jadigmb);
                $caption        = "img_txt";
                $cleaned = str_replace($caption,'captionnya',$gmb);

            } else if($value->web_id == 3){//koreaherald
                $gambar         = "img_box";
                $jadigmb = str_replace('gambarnya','gambar',$cleaned);
                $gmb = str_replace($gambar,'gambarnya h-50',$jadigmb);
                $caption        = "img_caption";
                $cap = str_replace($caption,'captionnya',$gmb);
                $deskripsi      = "text_box";
                $des = str_replace('deskripsinya','deskripsi',$cap);
                $cleaned = str_replace($deskripsi,'deskripsinya',$des);
            }
            $tampilan = str_replace("1 ","",$cleaned);
            $caption = str_replace('captionnya','captionnya text-xs',$tampilan);
            $desk = str_replace('deskripsinya','deskripsinya text-sm',$caption);
            $konten = [
                'id' => $value->berita_id,
                'link' => $value->linknya,
                'status' => $value->status,
                'web' => $value->web_id,
                'konten' => $value->konten_id,
                'idn'=>[
                    'judul' => $value->judul_idn,
                    'sub' => $value->sub_idn,
                    'tanggal' => $value->tgl_idn,
                    'deskripsi' => $desk
                ],
            ];
            // print("linkknya: ".$value->linknya."<br>");
        }

        //dbase berita_baca
        $error = false;
        $jumlahsuka = -1;//baru buka
        $countbaca = DB::table('berita_baca')->where("user_id","=",auth()->user()->id)->where("berita_id","=",$id)->get('suka');
        if(count($countbaca) == 0){
            $db = DB::table('berita_baca')->insert(
            array('user_id' => auth()->user()->id, 'berita_id' => $id,
                'suka' => -1, 'tanggal_baca' => $tanggal_buka) );
            if($db == 1) $error = true;
        } else {
            $jumlahsuka = $countbaca[0]->suka;
            $updated = DB::table('berita_baca')
                ->where("user_id","=",auth()->user()->id)
                ->where("berita_id","=",$id)
                ->update( ["tanggal_baca" => $tanggal_buka] );
            if($updated == 1) $error = true;
        }

        // foreach ($konten as $key => $isi) {
        //     # code...
        //     if($key != "raw" && $key != "idn") print("*) ".$key." (".strlen($isi).") => ".$isi."<br>");
        //     else {
        //         print("<hr>masuk: ".$key."<br>");
        //         foreach ($isi as $k => $dalam) {
        //             if($k != "deskripsi") print("*) ".$k." (".strlen($dalam).") => ".$dalam."<br>");
        //             else if ($key == "idn") print("*deskripsi) ".$k." (".strlen($dalam).") => ".$dalam."<br>");
        //             else print("deskripsinya ".$k."<br>");
        //         }
        //     }
        // }

        return view('user-fans/berita/halaman-berita',[
            'error' => $error,
            'suka' => $jumlahsuka,
            'konten' => $konten
            ]
        );
        // */
    }

    //suka suatu berita
    public function sukaBerita($mode,$id){
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $jadi = -1;
        $dbase = DB::table('berita_baca')->where("user_id","=",auth()->user()->id)->where("berita_id","=",$id)->get();
        if($dbase[0]->suka == -1) $jadi = 1;
        else if($dbase[0]->suka == 0) $jadi = 1;
        else if($dbase[0]->suka == 1) $jadi = 0;
        $updsuka = DB::table('berita_baca')
            ->where("berita_id","=", $id)
            ->update( ["suka" => $jadi] );
        if($updsuka == 1) {
            if($mode == 1) return redirect()->route('lihatberita',['id'=> $id]);
            else return redirect()->route('sejarahberita',['web'=> 'semua']);//suka dari sejarah, mode=2
        }
        else return redirect()->route('berita',['web'=> 'semua']);
    }

    //sudah baca berita
    public function getSejarahBerita($web){
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $idweb = 0; //all web
        if($web == 'dsp') $idweb = 1; //dispatch
        else if($web == 'ktm') $idweb = 2; //koreatimes
        else if($web == 'khd') $idweb = 3; //koreaherald
        $history = [];
        $dbase = DB::table('berita_baca')
            ->join('users','berita_baca.user_id','=','users.id')
            ->join('berita','berita_baca.berita_id','=','berita.berita_id')
            ->join('berita_konten','berita.berita_id','=','berita_konten.berita_id')
            ->where("users.id","=",auth()->user()->id)
            ->where("berita.status","=",3)
            ->select(['berita.berita_id as idnya','berita.link as linknya','berita.web_id as webnya',
                'berita_konten.konten_id as kontennya','berita_konten.judul_idn as judulnya',
                'berita_konten.sub_idn as subnya','berita_konten.tgl_idn as tanggalnya','berita_konten.desk_idn as deskripsine',
                'berita_baca.suka as sukanya','berita_baca.tanggal_baca as bacanya'])
            ->orderBy('berita_baca.tanggal_baca','desc')
            ->get();
        $cari = -1;
        $dsp = 0;
        $ktm = 0;
        $khd = 0;

        foreach ($dbase as $value) {
            $strjudul = substr($value->judulnya,0,(2*strlen($value->judulnya))/2);
            $posisititik1 = strpos($value->judulnya,'...');
            $posisititik2 = strpos($value->judulnya,'..');
            $posisititik3 = strpos($value->judulnya,'. ');
            $titik = 0;
            if($posisititik1 > 0) $titik = $posisititik1;
            else if ($posisititik2 > 0) $titik = $posisititik2;
            else if ($posisititik3 > 0) $titik = $posisititik3;
            if($titik > 0) $strjudul = substr($value->judulnya,0,$titik);

            //ambil gambar
            $src = str_replace('data-src','src',$value->deskripsine);
            $html_string = $src;
            $pattern = '/src="([^"]+)"/';
            $url = '';
            if (preg_match($pattern, $html_string, $matches) &&
            (preg_match('/dispatch/', $html_string) || preg_match('/koreatimes/', $html_string) || preg_match('/heraldm/', $html_string))) {
                $url = $matches[1];
            } else  $url = 'nope';

            if(($idweb == 0 && $web == 'semua') || $idweb == $value->webnya){
                $history[] = [
                    'id' => $value->idnya,
                    'link' => $value->linknya,
                    'web' => $value->webnya,
                    'tanggal' => $value->tanggalnya,
                    'konten' => $value->kontennya,
                    'gambar' => $url,
                    'judul' => $strjudul,
                    'suka' => $value->sukanya,
                    'baca' => $value->bacanya,
                ];
            // } else if($idweb == $value->webnya){
            //     $history[] = [
            //         'id' => $value->idnya,
            //         'link' => $value->linknya,
            //         'web' => $value->webnya,
            //         'tanggal' => $value->tanggalnya,
            //         'konten' => $value->kontennya,
            //         'gambar' => $url,
            //         'judul' => $strjudul,
            //         'suka' => $value->sukanya,
            //         'baca' => $value->bacanya,
            //     ];
            }
            if($value->webnya == 1) $dsp += 1; //dispatch
            if($value->webnya == 2) $ktm += 1; //koreatimes
            if($value->webnya == 3) $khd += 1; //koreaherald
        }

        return view('user-fans/berita/sejarah-berita',[
            'web'=> $web,
            'dsp'=> $dsp,
            'ktm'=> $ktm,
            'khd'=> $khd,
            'error' => false,
            'cari' => $cari,
            'history' => $history
            ]
        );
    }

    //cari di history dg pencarian
    public function cariBacaan(Request $req){
        if(auth()->user()->role == 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $history = [];
        $dbase = DB::table('berita_baca')
            ->join('users','berita_baca.user_id','=','users.id')
            ->join('berita','berita_baca.berita_id','=','berita.berita_id')
            ->join('berita_konten','berita.berita_id','=','berita_konten.berita_id')
            ->where("berita.status","=",3)
            ->where("berita_konten.judul_idn","like",'% '.$req->get('cari').' %')
            ->orWhere("berita_konten.desk_idn","like",'% '.$req->get('cari').' %')
            ->orWhere("berita_konten.judul_idn","like",'%'.$req->get('cari').'%')
            ->orWhere("berita_konten.desk_idn","like",'%'.$req->get('cari').'%')
            ->select(['berita.berita_id as idnya','berita.link as linknya','berita.web_id as webnya',
                'berita_konten.konten_id as kontennya','berita_konten.judul_idn as judulnya',
                'berita_konten.sub_idn as subnya','berita_konten.tgl_idn as tanggalnya','berita_konten.desk_idn as deskripsine',
                'berita_baca.user_id as user','berita_baca.suka as sukanya','berita_baca.tanggal_baca as bacanya'])
            ->get();

        foreach ($dbase as $value) {
            $strjudul = substr($value->judulnya,0,(2*strlen($value->judulnya))/2);
            $posisititik1 = strpos($value->judulnya,'...');
            $posisititik2 = strpos($value->judulnya,'..');
            $posisititik3 = strpos($value->judulnya,'. ');
            $titik = 0;
            if($posisititik1 > 0) $titik = $posisititik1;
            else if ($posisititik2 > 0) $titik = $posisititik2;
            else if ($posisititik3 > 0) $titik = $posisititik3;
            if($titik > 0) $strjudul = substr($value->judulnya,0,$titik);

            //ambil gambar
            $src = str_replace('data-src','src',$value->deskripsine);
            $html_string = $src;
            $pattern = '/src="([^"]+)"/';
            $url = '';
            if (preg_match($pattern, $html_string, $matches) &&
            (preg_match('/dispatch/', $html_string) || preg_match('/koreatimes/', $html_string) || preg_match('/heraldm/', $html_string))) {
                $url = $matches[1];
            } else  $url = 'nope';
            if($value->user == auth()->user()->id){
                $history[] = [
                    'id' => $value->idnya,
                    'link' => $value->linknya,
                    'web' => $value->webnya,
                    'tanggal' => $value->tanggalnya,
                    'konten' => $value->kontennya,
                    'gambar' => $url,
                    'judul' => $strjudul,
                    'suka' => $value->sukanya,
                    'baca' => $value->bacanya,
                ];
            }
        }

        $countartis = DB::table('artis')
            ->where(strtolower("nama"),"like",'%'.strtolower($req->get('cari')).'%')
            ->get(['id','nama']);

        return view('user-fans/berita/sejarah-berita',[
            'web'=> 'semua',
            'dsp'=> 0,
            'ktm'=> 0,
            'khd'=> 0,
            'error' => false,
            'cari' => $req->get('cari'),
            'artis' => $countartis,
            'history' => $history
            ]
        );
    }
}

