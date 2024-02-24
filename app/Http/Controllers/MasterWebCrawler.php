<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DOMXPath;
use PhpParser\Node\Stmt\HaltCompiler;
use Stichoza\GoogleTranslate\GoogleTranslate;// di vendor/stichoza/google-translate-php/GoogleTranslate

use function App\Http\Controllers\getTanggal as ControllersGetTanggal;

function getTanggal() {//buat laporan
    date_default_timezone_set('Asia/Jakarta');
    return date("Y-m-d H:i:s");
}

class MasterWebCrawler extends Controller
{
    //dari controller webcrawler.php yg awalnya bernama Crawlering
    //khusus ketika pakai file_get_contents() perlu try catch
    //ALL DONE

    //0/ tampilkan menu crawler
    public function getStart($web){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        return view('user-admin/crawlering/crawler-link',[
            'web' => $web,
            'error'=> false,
            'pesan' => "Crawler Mulai",
            'lv1'=> [],
            'lv2'=> [],
        ]);
    }

    //1/ buat crawler
    public function getCrawler($web){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        //content crawlering
        $tglcrawlering = getTanggal();//date('d').'-';
        // $tanggal = ( (int) date('d') );
        // $jam = ( (int) date('H') )+7;
        // if($jam >= 24) {$tanggal += 1; $jam = "0".($jam - 24);}
        // elseif($jam < 10) {$jam = "0".$jam;}
        // if($tanggal < 10) $tglcrawlering = date("Y-m")."-0".$tanggal.' '.$jam.date(':i:s');
        // else if ($tanggal < 32) $tglcrawlering = date("Y-m-").$tanggal.' '.$jam.date(':i:s');

        $idadmin = auth()->user()->id;
        $lv1= array();
        $lv2= array();//level2-3
        // $seleksilv1= array();
        // $saved1= array();
        // $seleksilv2= array();
        // $saved2= array();
        $pesan = "Crawler Berhasil";
        $errurl = "";
        $rotasi = 0;
        $masuklv1 = 'Level 1 dalam proses.';
        $masuklv2 = 'Level 2 dalam proses.';

        //set time max u/ load dalam detik //15menit
        set_time_limit(900);
        $level = 1;
        $hrefs = array();
        $url = 'https://www.dispatch.co.kr/';//if ($web == 'dsp')
        if($web == 'ktm') $url = 'http://www.koreatimes.com/section/109';
        else if($web == 'khd') $url ='http://www.koreaherald.com/kpop'; //https://www.koreaherald.com/list.php?ct=020409000000&np=1

        while ($level < 3) {
            // mencoba dengan trycatch
            if($level == 1) {//level 1
                try {
                // print("level ke-".$level."<br>");
                //alternatif1
                $context = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
                $html = file_get_contents($url, false, $context);
                // if ($html !== false) { //end alternatif1
                $dom = new \DOMDocument();// ('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($html);
                libxml_use_internal_errors($internalErrors);
                $aTags = $dom->getElementsByTagName('a');
                foreach ($aTags as $aTag) {
                    $isi = $aTag->getAttribute('href');
                    $konten = '';

                    //dari dispatch: include 'category' ato '/(include angka)'
                    //=> dispatch.co.kr = jumlah 40 data = 7 (tiap category) + 5 (home banner) + 4+1 (news) + 6 (photos) + 4 (feature) + 4 (exclusive) + 9 (artist)
                    if($web == 'dsp' && (preg_match('/category/', $isi) || preg_match('/\/(\d+)/', $isi))) $konten = "https://www.dispatch.co.kr".$isi;
                    //dari koreatimes
                    //=> koreatimes.com = jumlah 32 data = 11 (page_num) + 1 (photoS) + 20 (list_sec)
                    else if($web == 'ktm') { $pertama = $aTag->parentNode;
                        $kedua = $pertama->parentNode;
                        $ketiga = $kedua->parentNode->getAttribute('class');
                        if($pertama->getAttribute('class') === "page_num" || $kedua->getAttribute('class') === "photoS" ||
                            $kedua->getAttribute('class') === "list_sec" || $ketiga === "list_sec"){
                            if(preg_match('/\?/', $isi)) $konten = 'http://www.koreatimes.com/section/109'.$isi; //include '?'
                            else if(strpos($isi, '/') === 0) $konten = 'http://www.koreatimes.com'.$isi;  //include '/' di awal
                            else $konten = $isi;
                        }}
                    //dari koreaherald
                    //=> koreaherald.com = jumlah 26 data = 15 (main_sec_li main_sec_li_only) + 11 (paging)
                    else if($web == 'khd') { $pertama = $aTag->parentNode;
                        $kedua = $pertama->parentNode->getAttribute('class');
                        if(($kedua === "category_detail_layout" || $kedua === "detail_item_list" ||
                            $kedua === "category_detail_list" || $kedua === "number")
                            && $isi != "/list.php?ct=020409000000&np=1"){///list.php?ct=020409000000&np=1&mp=1
                            if(strpos($isi, '/') === 0) $konten = "http://www.koreaherald.com".$isi;
                            else $konten = "http://www.koreaherald.com/".$isi;
                            // print($kedua." --> ".$konten."<br>");
                        }
                    }

                    $idx = false;
                    $cekkonten = DB::table('berita')->where("link","=", $konten)->count();
                    foreach ($hrefs as $key) if($key == $konten) $idx = true;
                    if(!$idx && $konten != '' && $cekkonten == 0) {$hrefs[] = $konten; $lv1[] = $konten;}
                    $rotasi += 1;
                }
                // print("jumlah lv1 [".count($lv1)."]<br>");
                } catch (\Throwable $e) {
                    $error = true;
                    $salah = $errurl;
                    $errurl = $salah."Terjadi kesalahan: pada level ".$level." rotasi ".$rotasi." dengan url ".$url." yaitu ". $e->getMessage() . PHP_EOL . " ";
                    // $pesan = $masuklv1." ".$masuklv2." Terjadi kesalahan: pada level ".$level." rotasi ".$rotasi." dengan url ".$url." yaitu ". $e->getMessage() . PHP_EOL;
                    // return view('user-admin/crawlering/crawler-link',[
                    //     'web' => $web,
                    //     'error'=> true,
                    //     'pesan'=> $pesan,
                    //     'lv1'=> $seleksilv1,
                    //     'lv2'=> $seleksilv2,
                    //     'saved1'=> $saved1,
                    //     'saved2'=> $saved2,
                    // ]);
                }
                $masuklv1 = "Crawler Level 1 Berhasil, selesai dalam ".$rotasi." putaran.";
                // print($masuklv1);
                // } //alternatif1
                // else $pesan = "Gagal mengambil konten dari URL.";
                //end alternatif1

                //simpan dbase dan seleksi u/ interface yang sudah ada di dbase LEVEL1
                foreach ($lv1 as $link) {
                    $idweb = 1;
                    $status = 1; //hindari yg ga perlu ambil konten (selain ktm konten entertainment)
                    if($web == 'dsp') {//dispatch
                        if(!preg_match('/\/(\d+)/', $link)) $status = 0;}
                    else if($web == 'ktm') {//koreatimes
                        $idweb = 2;
                        if(!preg_match('/article\/(\d+)/', $link)) $status = 0;}
                    else if($web == 'khd') { //koreaherald
                        $idweb = 3;
                        if(!preg_match('/view/', $link)) $status = 0;}

                    //select dulu baru insert
                    // $dbase = DB::table('berita')->where("link","=", $link)->get(['berita_id']);
                    // if(count($dbase) == 0){
                        $db = DB::table('berita')->insert(
                            array(
                            "link" => $link,
                            "web_id" => $idweb,
                            "level" => 1,
                            "admin_id" => $idadmin,
                            "status" => $status,
                            'tgl_crawler' => $tglcrawlering,
                        ) );
                        // if($db == 1) $seleksilv1[] = $link;
                    // }
                    // else { $saved1[]=$link; }
                }
            }
            else if($web == 'dsp') {//level2 & level3
                // print("level ke-".$level."<br>");
                $listURL = [];//$hrefs;

                //SELECT * FROM `berita` WHERe status=0 and ((web_id=1 and link like '%/category/%') or (web_id=2 and link like '%/section/109%') or (web_id=3 and link like '%/list.php?ct=020409000000/%')) ORDER BY `berita`.`berita_id` ASC, `berita`.`web_id` ASC
                $nomor = 1; $kalimat = '%/category/%';
                if($web == 'ktm') {$nomor = 2; $kalimat = '%/section/109%';}
                else if($web == 'khd') {$nomor = 3; $kalimat = '%/list.php%';}
                $listingURL = DB::table('berita')
                    // ->whereraw("`status` = 0 and `web_id` = '.$nomor.' and link like '.$kalimat.'")
                    ->where('status','=',0)
                    ->where('web_id','=',$nomor)
                    ->where('link','like',$kalimat)
                    ->where('tgl_crawler','=',$tglcrawlering)
                    // ->orderBy(['berita_id','asc'],['web_id','asc'])
                    ->orderByRaw('berita_id asc, web_id asc')
                    ->select('link')
                    ->get();
                // print($nomor.' ini ada '.count($listingURL).' > '.$kalimat.'<hr>');
                foreach($listingURL as $i => $urlbaru) $listURL[] = $urlbaru->link;//print($i." -> ".$urlbaru->link."<hr>");
                // print('haloo');
                // $hlm = 'http://www.koreaherald.com/list.php?ct=020409000000`&`np=1';//list.php?ct=020409000000

                foreach ($listURL as $crawl) {
                    if($web == 'dsp' || $web == 'ktm' || ($web == 'khd' && !preg_match('/view.php/',$crawl)) ){
                        try{
                            $url = $crawl;
                            $html = file_get_contents($url); //Fatal error karena terlalu banyak load (*solusi)
                            $dom = new \DOMDocument();
                            $internalErrors = libxml_use_internal_errors(true);
                            $dom->loadHTML($html);
                            libxml_use_internal_errors(false);
                            $aTags = $dom->getElementsByTagName('a');
                            foreach ($aTags as $aTag) {
                                $isi = $aTag->getAttribute('href');
                                $konten = '';

                                //dari dispatch: include 'category' ato '/(include angka)'
                                //jadi 1 krn level3 tidak perlu load lagi => list yg disimpen = '/(angka)' => total 100++ data
                                if($web == 'dsp' && preg_match('/\/(\d+)/', $isi)) $konten = "https://www.dispatch.co.kr".$isi;
                                //dari koreatimes: include '/article..' atau '/section/109..' dan '../article..' atau '../section/109..'
                                //jadi 1 krn level3 akan load semua topik selain entertainment => list yg disimpen = '../section/109..' (ttg kpop) && '../article..' => total 300++ data
                                if($web == 'ktm' && $isi !== 'http://www.koreatimes.com/section/109'
                                    && (preg_match('/section\/109/', $isi) || preg_match('/article\/(\d+)/', $isi))){
                                    if(substr($isi, 0, strlen('http://www.koreatimes.com/')) === 'http://www.koreatimes.com/') $konten = $isi;
                                    else $konten = 'http://www.koreatimes.com'.$isi; }
                                //dari koreaherald
                                //jadi 1 krn level3 tidak perlu load lagi => list yg disimpen = '/list.php?..' dari paging karena '/view.php?..' tidak banyak href baru => total 100++ data
                                else if($web == 'khd') {//substr($crawl, 0, strlen($hlm)) === $hlm
                                    $pertama = $aTag->parentNode;
                                    $kedua = $pertama->parentNode->getAttribute('class');
                                    if($kedua === "category_detail_list") {
                                        if(strpos($isi, '/') === 0) $konten = "http://www.koreaherald.com".$isi;
                                        else $konten = "http://www.koreaherald.com/".$isi;
                                            // print("kedua ".$kedua." -- ".$konten."<br>");
                                    }
                                }
                                // print(preg_match('/list.php/',$crawl)."--".$crawl."<br>");

                                $idx = false;
                                $cekkonten = DB::table('berita')->where("link","=", $konten)->count();
                                foreach ($hrefs as $key) if($key == $konten) $idx = true;
                                if(!$idx && $konten != '' && $cekkonten == 0) {$hrefs[] = $konten; $lv2[] = $konten;}
                            }
                            $rotasi += 1;
                            // print($rotasi.". ".$crawl." >> ".preg_match('/view.php/',$crawl)."--".count($aTags)." -- ".count($hrefs)."<br>");
                        } catch (\Throwable $e) {
                            $error = true;
                            $salah = $errurl;
                            $errurl = $salah." Terjadi kesalahan: pada level ".$level." rotasi ".$rotasi." dengan url ".$url." yaitu ". $e->getMessage();
                        }
                    }
                }
                // print("jumlah lv".$level." [".count($lv1)."]<br>");
                $masuklv2 = "Crawler Level 2 Berhasil, selesai dalam ".$rotasi." putaran.";
            }

            $level += 1;
            // if(count($hrefs) == 0) { $level=3; print('nol');}
            if($web == 'khd') $level = 3;
        }
        // print(count($hrefs)."= JUMLAH AKHIRNYA <br>");
        // if(count($seleksilv1)+count($saved1) == count($lv1)) $masuklv1 = "Level 1 berhasil tersimpan dalam database, selesai dalam ".$rotasi." putaran.";

        //simpan dbase dan seleksi u/ interface yang sudah ada di dbase LEVEL2
        foreach ($lv2 as $link) {
            $idweb = 1; //dispatch
            $status = 1; //hindari yg ga perlu ambil konten
            if($web == 'dsp' && !preg_match('/\/(\d+)/', $link)) $status = 0;
            else if($web == 'ktm'){//koreatimes
                $idweb = 2;
                if(!preg_match('/article\/(\d+)/', $link)) $status = 0;}
            else if($web == 'khd') { //koreaherald
                $idweb = 3;
                if(!preg_match('/view/', $link)) $status = 0;}

            //select dulu baru insert
            // $dbase = DB::table('berita')->where("link","=", $link)->get(['berita_id']);
            // if(count($dbase) == 0){
                // && ( $link != 'http://www.koreatimes.com/section/109' && $link != 'koreaherald.com/list.php?ct=020409000000&np=1&mp=1' && $link != 'koreaherald.com/list.php?ct=020409000000')
                $db = DB::table('berita')->insert(
                    array(
                    "link" => $link,
                    "web_id" => $idweb,
                    "level" => 2,
                    "admin_id" => $idadmin,
                    "status" => $status,
                    'tgl_crawler' => $tglcrawlering,
                ) );
                // if($db == 1) $seleksilv2[] = $link;
            // }
            // else {$saved2[]=$link;}
        }
        // if(count($seleksilv2)+count($saved2) == count($lv2)) $masuklv2 = "Level 2 berhasil tersimpan dalam database.";

        // $lv1 = $seleksilv1;
        // $lv2 = $seleksilv2;
        // $dbase1 = DB::table('berita')
        //     ->where("web_id","=", $idweb)
        //     ->where("tgl_crawler","=",$tglcrawlering)
        //     ->where("level","=",1)
        //     ->orderBy('berita_id','asc')
        //     ->get('link');
        // foreach ($dbase1 as $value) {
        //     $good = true;
        //     foreach ($saved1 as $sv) {if($value->link == $sv) $good = false;}
        //     if($good) $lv1[] = $value->link;
        // }
        // $dbase2 = DB::table('berita')
        //     ->where("web_id","=", $idweb)
        //     ->where("tgl_crawler","=",$tglcrawlering)
        //     ->where("level","=",2)
        //     ->orderBy('berita_id','asc')
        //     ->get('link');
        // foreach ($dbase2 as $value) {
        //     $good = true;
        //     foreach ($saved2 as $sv) {if($value->link == $sv) $good = false;}
        //     if($good) $lv2[] = $value->link;
        // }

        //end content crawlering

        $error = false;
        if(strlen($errurl) > 0) {
            $error = true;
            // foreach($errurl as $err) {$e = $salah; $salah = $e.'. '.$err;}
            $pesan = $masuklv1." ".$masuklv2." ".$errurl;
        }
        return view('user-admin/crawlering/crawler-link',[
            'web' => $web,
            'error'=> $error,
            'pesan' => $pesan,
            'lv1'=> $lv1,
            'lv2'=> $lv2,
        ]);
    }

    //2/ ambil semua link yg disimpan (korea)
    public function getLinks($web){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $idweb = 1; //dispatch
        $webnya = "and web_id = ".$idweb; //dispatch
        if($web == 'ktm') $idweb = 2; //koreatimes
        else if($web == 'khd') $idweb = 3; //koreaherald
        if($web != 'dsp') $webnya = "and web_id = ".$idweb." and (link like '%2023%' or link like '%2024%')";

        $berita = [];
        $dbase = DB::table('berita')
            // ->where("web_id","=", $idweb)
            // ->where("status",">",0)//status 1-2 (bhs kor)
            // ->where("status","<",3)//status 1-2 (bhs kor)
            // ->where('link', 'like','%2023%')
            ->whereRaw("status > 0 and status < 3 ".$webnya)
            // ->where("admin_id","=",auth()->user()->id)
            ->orderBy('status','desc')
            ->orderBy('berita_id','desc')
            ->get(['berita_id','link','level','tgl_crawler','status','admin_id']);

        //hilangkan link tahun 2023 ke bawah
        // $ubahStatusKTM = DB::table('berita')->whereRaw("link not like '%2023%' and status > 0 and web_id > 1")->update(['status' => 0]);

        // print(count($dbase)."<br>");
        $ubah = 0;//untuk ktm
        foreach ($dbase as $value) {
            if($value->status == 2) $ubah += 1;//untuk ktm

            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $tanggal_format = strtotime($value->tgl_crawler);
            $tgl_crawler = str_replace($bulanInggris, $bulanIndonesia, date("d F Y H:i:s", $tanggal_format));

            $berita[] = [
                'id' => $value->berita_id,
                'link' => $value->link,
                'level' => $value->level,
                'tgl' => $tgl_crawler,
                'status' => $value->status,
                'admin_id' => $value->admin_id
            ];
            // print($value->berita_id."-".$value->level." -- ".$value->status."- -".$value->link."<br>");
        }
        $idn = DB::table('berita')
            ->join('berita_konten','berita_konten.berita_id','=','berita.berita_id')
            ->whereRaw("berita.web_id = '$idweb' and berita.status = 3 and (berita_konten.tgl_publikasi like '%2023%' or berita.tgl_crawler like '%2024%')")
            // ->where("admin_id","=",auth()->user()->id)
            ->count();


        return view('user-admin/crawlering/crawler-konten',[
            'web' => $web,
            'bhs' => 'kor',
            'ubah' => $ubah,//untuk ktm
            'idn' => $idn,
            'berita' => $berita,
            'error' => false,
            'pesan' => ''
        ]);
    }

    //ktm bagian photonews (BELUM DIBUAT sbg tambahan)
    //2a/ buat iterasi cari kpop u/ ktm per 100
    public function selectingKonten(Request $req){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        // $pesan = "Ambil Konten Berhasil";
        $errurl = "";
        $dbase = DB::table('berita')
            ->where('web_id','=',2)
            ->where('status','=',1)
            // ->where("admin_id","=",auth()->user()->id)
            ->orderBy('berita_id','desc')
            ->get(['berita_id','link','status']);
        $datakonten = array();
        $limit = 0;
        $jumlah = 1;
        if($req->jumlah <= count($dbase)) $jumlah = $req->jumlah;
        if(count($dbase) > 0) { // == 0
        //     $datakonten = null;
        //     // print("<h4 style='margin:0'>Link ini bukan Korea Times, dengan ID ".$id."</h4><a href='http://localhost:8000/konten/' class='btn'>Kembali</a>");
        // }
        // else {
            while ($limit < $jumlah && count($dbase) > $limit) {//ganti limit sesuai kebutuhan
                // print("<p style='color:red'>".$status."</p><hr>");
                try {
                    $url = $dbase[$limit]->link;
                    // print($url."--> ");
                    set_time_limit(1800);
                    $html = file_get_contents($url); //Fatal error karena terlalu banyak load (*solusi)
                    $dom = new \DOMDocument();
                    $internalErrors = libxml_use_internal_errors(true);
                    $dom->loadHTML($html);
                    libxml_use_internal_errors($internalErrors);
                    $kpop = true;//untuk ktm
                    // if($web == 'ktm'){//koreatimes
                        //koreatimes bagian photonews diaktifkan lagi u/ diambil kontennya nanti
                        // lv2 ktm > http://www.koreatimes.com/photonews >>> take gambar

                        //khusus ktm seleksi entertainment (ketika ambil isinya aja baru cek)
                        // kalo pake $expression = "//div[@class='location_arti']/span/a/@href";//cek kategori (seleksi dulu yg ../section/109.., kalo bukan maka status=0)
                        $aTags = $dom->getElementsByTagName('a');
                        foreach ($aTags as $aTag) {
                            $kedua = $aTag->parentNode->parentNode->getAttribute('class');
                            if($kedua === 'location_arti' && $aTag->getAttribute('href') !== 'http://www.koreatimes.com/section/109/261') {
                                $kpop = false;
                            }
                        }
                        // print($kpop);
                        if(!$kpop) {//bukan kpop
                            $db = DB::table('berita')
                                ->where("berita_id","=", $dbase[$limit]->berita_id)
                                ->update( ["status" => 0] );
                            if($db == 1) {
                                $datakonten[] = ['id'=> $dbase[$limit]->berita_id,'status'=> 1];
                                // print(" <-- i ".$limit." - ".$dbase[$limit]->berita_id."<br>");
                                // print("<h4 style='margin:0'>Konten Korea Times dengan ID ".$id." bukan K-POP, Berhasil Update Status</h4><a href='http://localhost:8000/konten/' class='btn'>Kembali</a>");
                                // return redirect()->route('konten',['web'=> 'ktm']);
                            }
                        } else{
                            // if($status == 1){
                                $db = DB::table('berita')
                                    ->where("berita_id","=", $dbase[$limit]->berita_id)
                                    ->update( ["status" => 2] );//khusus ktm status sudah diperiksa
                                // print("<script>alert('ID ".$id." adalah K-pop');</script>");
                                // return redirect()->route('konten',['web'=> 'ktm']);
                                if($db == 1) {
                                    $datakonten[] = ['id'=> $dbase[$limit]->berita_id,'status'=> 1];
                                    // print(" <-- i ".$limit." - ".$dbase[$limit]->berita_id."<br>");
                                }
                            // }
                            // else print("<h3 style='margin:0'>Konten Korea Times sudah diseleksi</h3><br><hr><br>");
                        }
                    // }
                } catch (\Throwable $e){
                    // $datakonten[] = ['id'=> $dbase[$limit]->berita_id,'status'=> 0];
                    // print("Terjadi kesalahan: " . $e->getMessage() . " ==> line " . $e->getLine());
                    // $error = true;
                    $salah = $errurl;
                    $errurl = $salah."Terjadi kesalahan pada iterasi ".$limit." ID ".$dbase[$limit]->berita_id." dengan url ".$url." [". $e->getMessage() . PHP_EOL . "]<br>";
                }
                $limit+=1;
            }
        }
        // print("<hr>");
        // foreach ($datakonten as $key => $value) {
        //     print("id ".$key." - ".$value['id']."<br>");
        // }

        //return opsi-1
        return redirect()->route('konten',['web'=> 'ktm']);
        //return opsi-2
        // $berita = [];
        // $dbase = DB::table('berita')
        //     ->where("web_id","=",2)
        //     ->where("status",">",0)//status 1-2 (bhs kor)
        //     ->where("status","<",3)//status 1-2 (bhs kor)
        //     ->orderBy('status','desc')
        //     ->orderBy('berita_id','desc')
        //     ->get(['berita_id','link','level','status']);
        // $ubah = 0;//untuk ktm
        // foreach ($dbase as $value) {
        //     if($value->status == 2) $ubah += 1;//untuk ktm
        //     $berita[] = [
        //         'id' => $value->berita_id,
        //         'link' => $value->link,
        //         'level' => $value->level,
        //         'status' => $value->status,
        //         'admin_id' => $value->admin_id,
        //         'konten' => -1
        //     ];
        // }
        // $error = false;
        // if(strlen($errurl) > 0) {
        //     $error = true;
        //     // foreach($errurl as $err) {$e = $salah; $salah = $e.'. '.$err;}
        //     $pesan = $errurl;
        // }
        // return view('user-admin/crawlering/crawler-konten',[
        //     'web' => "ktm",
        //     'bhs' => 'kor',
        //     'ubah' => $ubah,//untuk ktm
        //     'berita' => $berita,
        //     'error' => $error,
        //     'pesan' => $pesan
        // ]);
    }

    //Request $req, get jadi tanpa Request $request
    //dsp bagian videos youtube dan fashion (BELUM DIBUAT sbg tambahan)
    //buat iterasi untuk per 100 link
    //2b/ bagian ambil konten, status 1/2 jd 3 sebagai akhir dari crawler
    public function getKonten(Request $req,$web){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $idweb = 1; //dispatch
        $dbase = null;
        $pesan = "Ambil Konten Berhasil";
        $errurl = "";
        $webnya = "and web_id = ".$idweb; //dispatch
        // $bagian = "Database";
        if($web == 'ktm'){//koreatimes
            $idweb = 2;
            $dbase = DB::table('berita')
                ->whereRaw("web_id = ".$idweb." and status = 2 and (link like '%2023%' or link like '%2024%')")
                ->orderBy('berita_id','desc')
                // ->where("admin_id","=",auth()->user()->id)
                ->get(['berita_id','link','status']);
        } else if($web == 'khd') {//koreaherald
            $idweb = 3;
            $dbase = DB::table('berita')
                ->whereRaw("web_id = ".$idweb." and status = 1 and (link like '%2023%' or link like '%2024%')")
                ->orderBy('berita_id','desc')
                // ->where("admin_id","=",auth()->user()->id)
                ->get(['berita_id','link','status']);
        } else {//dispatch
            $dbase = DB::table('berita')
                ->where('web_id','=',$idweb)
                ->where('status','=',1)
                // ->orWhere('status','=',3)
                ->orderBy('berita_id','desc')
                // ->where("admin_id","=",auth()->user()->id)
                ->get(['berita_id','link','status']);
        }
        // dd(count($dbase));

        // print("<p style='color:red'>".$status."</p><hr>");
        $datakonten = array();
        $iterasi = 0;
        $jumlah = 1;
        // if($web == 'dsp') $jumlah = 2;//5
        // else
        if($req->jumlah <= count($dbase)) $jumlah = $req->jumlah;
        else $jumlah = count($dbase);
        // dd($jumlah,count($dbase));
        if(count($dbase) > 0) {// == 0
            $tr = new GoogleTranslate('id',null); // Translates into Indonesia
            while ($iterasi < $jumlah && count($dbase) > $iterasi) {//, , ganti limit sesuai kebutuhan
                // print($iterasi." <hr> ");
                $url = $dbase[$iterasi]->link;
                $bagian = "Crawler Data ID ".$dbase[$iterasi]->berita_id;
                try {
                    // print($iterasi.") id: ".$dbase[$iterasi]->berita_id.', '.$dbase[$iterasi]->link." >> ");
                    set_time_limit(1500);
                    $html = file_get_contents($url); //Fatal error karena terlalu banyak load (*solusi)
                    $dom = new \DOMDocument();
                    $internalErrors = libxml_use_internal_errors(true);
                    $dom->loadHTML($html);
                    libxml_use_internal_errors($internalErrors);

                    $judul = '//div/class';
                    $subjudul = '//div/class';
                    $tglpublikasi = '//div/class';
                    $gambar = '//div/class';
                    // $caption = '//div/class';
                    $deskripsi = '//div/class';

                    // $kpop = true;//untuk ktm
                    if($web == 'ktm'){//koreatimes
                        $judul          = "//div[@class='tit_arti']/h4";//['tag' => 'h4', 'class' => 'tit_arti', 'asal' => 'div']; //judul
                        $subjudul       = "//p[@class='sub_1']";//['tag' => 'p', 'class' => 'sub_1', 'asal' => 0]; //sub-judul
                        $tglpublikasi   = "//span[@class='upload_date']";//['tag' => 'span', 'class' => 'upload_date', 'asal' => 0]; //tgl publikasi/upload = '2023-07-22  (토)'
                        $gambar         = "//div[@class='img_arti img_a2']/img";///@src ['tag' => 'img', 'class' => 'img_arti img_a2', 'asal' => 'div']; //gambar ++
                        // $caption        = "//*[@class='img_txt']";// ['tag' => 'p', 'class' => 'img_txt', 'asal' => 0]; //caption, related gambar
                        $deskripsi      = "//div[@id='print_arti']";// "//div[@class='print_arti']"; ['tag' => 'div', 'class' => 'print_arti', 'asal' => 0]; //deskripsi ++, pastikan stop stlh find gambar stlh krn bersamaan dg class div = gambar dan caption'
                    } else if($web == 'dsp'){//dispatch
                        //dispatch bagian videos youtube dan fashion, diaktifkan lagi u/ diambil kontennya nanti
                        // lv2 dsp > https://www.dispatch.co.kr/category/videos >>> take link yutube
                        // lv2 dsp > https://www.dispatch.co.kr/category/fashion >>> take gambar dg link img@src

                        //dsp no: sub-judul, caption
                        $judul          = "//div[@class='page-post-title']";//['tag' => 'div', 'class' => 'page-post-title', 'asal' => 0]; //judul
                        $tglpublikasi   = "//div[@class='post-date']";//['tag' => 'div', 'class' => 'post-date', 'asal' => 0]; //tgl publikasi = '2023.07.23 오전 10:03 | 20...'
                        $gambar         = "//article[@class='page-post-font page-post-article']/p/img";//['tag' => 'img', 'class' => 'post-image', 'asal' => 0]; // [@class='post-image']@src, gambar
                        $deskripsi      = "//article[@class='page-post-font page-post-article']/p";//['tag' => 'p', 'class' => 'page-post-font page-post-article', 'asal' => 'article']; //deskripsi, biasanya ada ini ../p'.$tambahan.'
                        // $tambahan = '/span/strong';
                    } else if($web == 'khd'){//koreaherald
                        //khd
                        $judul          = "//h1[@class='news_title']";//view_tit ['tag' => 'h1', 'class' => 'view_tit', 'asal' => 0];//judul
                        $subjudul       = "//h2[@class='news_title']";//view_tit_sub ['tag' => 'h2', 'class' => 'view_tit_sub', 'asal' => 0];//sub-judul
                        $tglpublikasi   = "//p[@class='news_date']";//div-view_tit_byline_r ['tag' => 'div', 'class' => 'view_tit_byline_r', 'asal' => 0];//tgl publikasi = 'Published : Jul 21, 2023 - 17:21        Updated :...'
                        $gambar         = "//img";//div[@class='img_box'] div[@class='view_con article']/table/tbody/tr/td/img[@src] ['tag' => 'img', 'class' => 'view_con article', 'asal' => 'div'];//gambar ++
                        // $caption        = "//*[@class='img_caption']";// div[@class='view_con_caption'] ['tag' => 'div', 'class' => 'view_con_caption', 'asal' => 0];//caption, related gambar
                        $deskripsi      = "//div[@class='text_box']/p";//view_con_t ['tag' => 'p', 'class' => 'view_con_t', 'asal' => 'div'];//deskripsi ++
                    }

                    $limit = 0;
                    $expression = '//';
                    $konten_jdl = '';
                    $konten_subjdl = '';
                    $konten_tgl = '';
                    $konten_gmb = array();
                    $konten_desk = '';
                    $trans_jdl = '';
                    $trans_subjdl = '';
                    $trans_tgl = '';
                    $trans_desk = '';
                    // print("judul-0 subjudul-1 tglpublikasi-2 gambar-3 caption-gambar-4 deskripsi-5<br>");
                    while ($limit < 8) {
                        // print($limit." - ");
                        // $bagian = "Ambil Data Berita ID ".$dbase[$iterasi]->berita_id." Bagian ".$limit+1;

                        //cara baru $limit=6
                        //1. dsp: div col-12 col-1g-8 > div page-post-title(judul), div post-date(tgl), article page-post-font page-post-article (gambar,caption,deskripsi > ambil yg p saja dan div paling bawah no)
                        //2. ktm: div contents > div title(judul&tgl), div conL > div news_area(gambar,caption,deskripsi)
                        //3. khd: div news_content > div news_title_area(judul&tgl), div news_text_area(gambar,caption,deskripsi)
                        $allkonten = "//article[@class='page-post-font page-post-article']"; //dsp col-12 col-1g-8
                        if($web == 'ktm') $allkonten = "//div[@id='print_arti']"; //ktm //news_area
                        else if($web == 'khd') $allkonten = "//div[@class='news_text_area']"; //khd

                        $xpath = new DOMXPath($dom);
                        if($limit == 0) $expression = $judul;
                        else if($limit == 1) $expression = $subjudul;
                        else if($limit == 2) $expression = $tglpublikasi;
                        else if($limit == 3) $expression = $gambar;
                        else if($limit == 4) $expression = $deskripsi;
                        else if($limit == 5) $expression = $allkonten;
                        else if($limit == 6) $expression = $deskripsi;// if($web == 'ktm') $expression = "//*[@class'deskripsinya']";
                        else if($limit == 7) $expression = $allkonten;
                        $pElements = $xpath->query($expression);

                        // print("count: ".$limit.'--'.count($pElements)." = ");
                        foreach ($pElements as $idx =>$element) {//$idx =>
                            // $element = $pElements->item(0);
                            $kosong = false;
                            $datakonten = $element->textContent;
                            $trimmedValue = trim($datakonten); // Menghapus spasi di depan dan belakang nilai atribut
                            // print("masuk ".$limit);
                            // print($datakonten);
                            $korea = 'ko';//kr
                            $transkonten = 'null';
                            if($limit < 4 || $limit == 6) {//dari korea, hindari limit 4 5 7
                                if($web != 'khd') $transkonten = $tr->translate($datakonten);
                                // GoogleTranslate::trans($datakonten, 'id', 'ko');
                                // $tr->getLastDetectedSource(); //cari bahasa apa yg ditranslate
                                // print($tr->setTarget('id')."<hr><br>");
                                // dd($tr->getResponse($datakonten)."<hr>");
                                $transkonten = $tr->setSource($korea)->setTarget('id')->translate($datakonten);
                            }
                            // print(($limit < 4 || $limit == 6) ? ($limit.' => '.$idx." > ".$transkonten."<hr>") : $limit.'--');
                            if($limit < 3) {
                                if($limit == 0) {
                                    $konten_jdl = $datakonten;
                                    $trans_jdl = ($transkonten != 'null' ? $transkonten : 'false');
                                }
                                else if($limit == 1){//dsp no, no asal
                                    if(strlen($trimmedValue) === 0) $kosong = true;
                                    if(!$kosong) {$konten_subjdl = $datakonten; $trans_subjdl  = ($transkonten != 'null' ? $transkonten : 'false');}
                                    // print("-1[".$datakonten."]<br>");
                                }
                                else if($limit == 2) {
                                    $konten_tgl = $datakonten;
                                    if($web != 'dsp') $trans_tgl  = ($transkonten != 'null' ? $transkonten : 'false');
                                    else $trans_tgl = $trimmedValue;
                                }
                            }
                            else if($limit == 3)  $element->setAttribute('class', 'gambarnya');
                            // {
                                // if($web == 'ktm') $konten_gmb[] = $datakonten;
                                // else {//if($web == 'dsp')
                                //     foreach ($element->attributes as $namaAtr) {//sementara ktm belum ada kriteria
                                //         if(($web == 'dsp' && preg_match('/uploads/', $namaAtr->value)) ||
                                //             ($web == 'khd' && $namaAtr->name == 'src' && preg_match('/res\.heraldm\.com\/content\/image/', $namaAtr->value))){//
                                //             $konten_gmb[] = $namaAtr->value;
                                //         }
                                //         print($namaAtr->name." - ".$namaAtr->value." --3<br>");
                                //     }
                                // }
                            // }
                            else if($limit == 4) {//deskripsi saja tanpa tag html
                                if(strlen($trimmedValue) === 0 || strlen($datakonten) == 2) {
                                    $kosong = true;
                                    // print("{ kosong } ");
                                }
                                if(!$kosong) {
                                    if($web == 'ktm') {//deskripsi ktm
                                        $turunan = $element->childNodes;
                                        $cleanedText = str_replace($turunan->item(1)->nodeValue, '', $datakonten);
                                        // $result = str_replace('(adsbygoogle = window.adsbygoogle || []).push({});', '', $cleanedText);
                                        // $cleanedText = str_replace('googletag.cmd.push(function() { googletag.display("div-gpt-ad-1647537398730-0"); });', '', $result);
                                        $datakonten = $cleanedText;

                                        for ($i=0; $i < $turunan->length; $i++) {
                                            // tag div 'img_arti img_a2' = turunan->item($i) & ->attributes->getNamedItem('class')->value == 'img_arti img_a2'
                                            // Menghapus kata yang cocok secara eksak
                                            if ($turunan->item($i)->hasAttributes()) {
                                                $gambar = $turunan->item($i);
                                                $konten_gmb[] = $gambar;
                                                $itemclass = $turunan->item($i)->attributes->getNamedItem('class');
                                                // if ($itemclass->value == 'img_arti img_a2') {
                                                //     // print($cleanedText."<hr><br>");
                                                //     // $transkonten = $tr->translate($cleanedText);
                                                // } else
                                                if ($itemclass) {
                                                    // print("dini udh selesai<br>");
                                                    $element->removeChild($turunan->item($i));
                                                    // $newElement = $dom->createElement('div', '');
                                                    // $newElement->setAttribute('class', 'sampingan ');
                                                    // $element->parentNode->replaceChild($newElement, $element);
                                                }
                                                // print("nomer:".$i."--".$itemclass->value."<hr>");
                                            }
                                        }
                                        $element->nodeValue = '';//dikosongkan
                                        foreach ($konten_gmb as $gambar) {
                                            $element->appendChild($gambar);
                                        }
                                        // print($element->nodeValue);
                                        // Buat elemen baru dengan isi yang baru
                                        $newElement = $dom->createElement('div', $datakonten);
                                        $newElement->setAttribute('class', 'deskripsinya');
                                        // Ganti elemen lama dengan elemen baru
                                        $element->appendChild($newElement);

                                        // $pecahandesk = array();
                                        // $kalimatArray = explode('.', $datakonten);
                                        // // Tampilkan kalimat-kalimat hasil pemisahan
                                        // foreach ($kalimatArray as $kalimatPisah) {
                                        //     if(strlen(trim($kalimatPisah)) > 1) {// Gunakan trim() untuk menghapus spasi ekstra
                                        //         $pecahandesk[] = trim($kalimatPisah).".";
                                        //     }
                                        // }
                                        // print($dom->saveHTML($element)."<hr><br><hr><br><hr><br>");
                                    }
                                    else $element->setAttribute('class', 'deskripsinya');
                                    // else $element->nodeValue = $transkonten; //$konten_desk[] = $datakonten; //selain ktm
                                }
                                // print("--4 ke 5--[".$datakonten."]<br>");
                            }
                            else if($limit == 5) $konten_desk = $dom->saveHTML($element);//menyimpan semua deskripsi dg tag html
                            else if($limit == 6){
                                if(strlen($trimmedValue) === 0 || strlen($datakonten) == 2) {
                                    $kosong = true;
                                    // print("{ kosong } ");
                                }
                                if(!$kosong) {
                                    if($web == 'ktm') {
                                        $turunan = $element->childNodes;
                                        // print("--8--[".$element->textContent."]<br>");
                                        // print("isinya [".$dom->saveHTML($element)."]");
                                        // print("turunannya ada [".$turunan->length."]");
                                        // print("deskripsi di [".($turunan->length-1)."] nama:".$turunan->item($turunan->length-1)->attributes->getNamedItem('class')->value." >> ".$transkonten."<br>");

                                        // $cleanedText = str_replace($turunan->item($turunan->length-1)->nodeValue, '', $datakonten);
                                        $result = str_replace('(adsbygoogle = window.adsbygoogle || []).push({});', '', $turunan->item($turunan->length-1)->nodeValue);
                                        $cleanedText = str_replace('googletag.cmd.push(function() { googletag.display("div-gpt-ad-1647537398730-0"); });', '', $result);
                                        $datakonten = $cleanedText;
                                        // $iddesk = -1;
                                        // $transkonten = $tr->setSource($korea)->setTarget('id')->translate($datakonten);//ko
                                        // $transkonten = $tr->translate($datakonten);
                                        $turunan->item($turunan->length-1)->textContent = ($transkonten != 'null' ? $transkonten : 'false');
                                    }
                                    else $element->textContent = ($transkonten != 'null' ? $transkonten : 'false'); //$konten_desk[] = $datakonten; //selain ktm
                                }
                            }
                            else if($limit == 7) $trans_desk = $dom->saveHTML($element);
                            // print("{".$idx."}<hr>");
                        }
                        // if($web == 'dsp'){
                        //     if($limit == 0) $limit = 2;
                        //     else if($limit == 3) $limit = 5;
                        //     else if($limit == 6) $limit = 8;
                        //     else $limit += 1;
                        // } else
                        $limit +=1;
                    }

                    // print("-------------------<br><h3 style='margin:0'>HASIL AKHIR</h3>-------------------<br>");
                    /*
                    print("j 0>".$konten_jdl."<br>");
                    if($web != 'dsp') print("s 1>".$konten_subjdl."<br>");
                    print("t 2>".$konten_tgl."<br>");
                    print("d>> ");print(strlen($konten_desk)."<>");
                    print($konten_desk."<br>");
                    print("tj 0>".$trans_jdl."<br>");
                    if($web != 'dsp') print("ts 1>".$trans_subjdl."<br>");
                    print("tt 2>".$trans_tgl."<br>");
                    print("td>> ");print(strlen($trans_desk)."<>");
                    print($trans_desk."<br>");
                    print("// strlen_jdl:".strlen($trans_jdl).'-- strlen_tgl:'.strlen($trans_tgl).'== strlen_desk:'.strlen($trans_desk).'<br>');
                    print("<hr><hr>");
                    */

                    //insert konten
                    // /*
                    // $bagian = "Insert Konten Berita ID ".$dbase[$iterasi]->berita_id;
                    // $urutan = 0;
                    // $inserting = 0;
                    // $jumlah = 1;//count($konten_desk) kalo array
                    $countingkonten = DB::table('berita_konten')->where("berita_id","=", $dbase[$iterasi]->berita_id)->count();
                    // print($countingkonten." countinga");
                    if(($dbase[$iterasi]->status == 1 || $dbase[$iterasi]->status == 2 && $web == 'ktm')
                    && strlen($konten_jdl) > 0 && strlen($konten_tgl) > 0 && strlen($konten_desk) > 0
                    && strlen($trans_jdl) != 'false' && strlen($trans_tgl) != 'false' && strlen($trans_desk) != 'false'){
                        if($countingkonten == 0){
                            // print("ID ".$dbase[$iterasi]->berita_id);//." jumlah ".$jumlah." ke urutan ".$urutan." dan insert ".$inserting);
                            // print("gambar> ".$ins_gmb." ke cap> ".$ins_cap." terus deskripsi> ".$ins_desk."<br>");
                            $db = DB::table('berita_konten')->insert(
                                array(
                                    'berita_id' => $dbase[$iterasi]->berita_id,
                                    'tgl_publikasi' => $konten_tgl,
                                    'judul' => $konten_jdl,
                                    'subjudul' => $konten_subjdl,
                                    'deskripsi' => $konten_desk,
                                    'judul_idn' => $trans_jdl != 'false' ? $trans_jdl : '',
                                    'sub_idn' => $trans_subjdl != 'false' ? $trans_subjdl : '',
                                    'tgl_idn' => $trans_tgl != 'false' ? $trans_tgl : '',
                                    'desk_idn' => $trans_desk != 'false' ? $trans_desk : '',
                                    'link' => '',//link untuk video youtube dari dsp
                                    'admin_id' => auth()->user()->id)
                                );
                            $countingkonten = DB::table('berita_konten')->where("berita_id","=", $dbase[$iterasi]->berita_id)->count();
                            if($db == 1 && $countingkonten == 1) {//$inserting = 1;//+=
                            // else print("Tidak Masuk > ".$urutan);
                            // $urutan += 1;
                            // print(" dari jumlah ".$jumlah." ke urutan ".$urutan." dan insert ".$inserting."<br>-------------------<br>");

                            // if($inserting == $jumlah) {
                                $updstatus = DB::table('berita')
                                    ->where("berita_id","=", $dbase[$iterasi]->berita_id)
                                    ->update( ["status" => 3] );
                                // if($updstatus == 1) print("masuk ".$iterasi.") beritaid: ".$dbase[$iterasi]->berita_id.'<br>');
                                // if($db == 1) {
                                //     $datakonten[] = ['id'=> $dbase[$iterasi]->berita_id,'status'=> 1];
                                //     print("<h4 style='margin:0'>Konten dengan ID ".$dbase[$iterasi]->berita_id." Berhasil Insert Konten</h4><a href='http://localhost:8000/konten/' class='btn'>Kembali</a>");
                                // }
                            }
                            // else print("tidak masukk karena countkonten:".$countingkonten." dan db:".$db."<hr><hr>");
                        }
                        else if($countingkonten == 1 && $dbase[$iterasi]->status == 1){
                            $db = DB::table('berita_konten')
                            ->where("berita_id","=", $dbase[$iterasi]->berita_id)
                            ->update( [
                                'tgl_publikasi' => $konten_tgl,
                                'judul' => $konten_jdl,
                                'subjudul' => $konten_subjdl,
                                'deskripsi' => $konten_desk,
                                'judul_idn' => $trans_jdl != 'false' ? $trans_jdl : '',
                                'sub_idn' => $trans_subjdl != 'false' ? $trans_subjdl : '',
                                'tgl_idn' => $trans_tgl != 'false' ? $trans_tgl : '',
                                'desk_idn' => $trans_desk != 'false' ? $trans_desk : '',
                                'link' => '',//link untuk video youtube dari dsp
                                'admin_id' => auth()->user()->id
                            ] );
                            $updstatus = DB::table('berita')
                                ->where("berita_id","=", $dbase[$iterasi]->berita_id)
                                ->update( ["status" => 3] );
                            // print('update disini<br>');
                        }
                    }

                } catch (\Throwable $e) {
                    // $datakonten[] = ['id'=> $dbase[$iterasi]->berita_id,'status'=> 0];
                    // print("Terjadi kesalahan: " . $e->getMessage() . " ==> line " . $e->getLine());
                    // $error = true;
                    $salah = $errurl;
                    $errurl = $salah."Terjadi kesalahan pada iterasi ".$iterasi." dengan url ".$url." [". $e->getMessage() . PHP_EOL . "]<hr>";
                }
                $iterasi+=1;
            }
        }
        // print($errurl);

        //opsi return-1
        return redirect()->route('konten',['web'=> $web]);
    }

    //2c-1
    public function cekStatusDSP($status){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $idweb = 1; //dispatch
        $berita = [];
        $dbase = null;
        // if($status == 0) {
            $dbase = DB::table('berita')
            ->where("web_id","=", $idweb)
            ->where("status","=",$status)//status 1-2 (bhs kor)
            // ->where("admin_id","=",auth()->user()->id)
            ->orderBy('status','desc')
            ->orderBy('berita_id','desc')
            ->get(['berita_id','link','level','tgl_crawler','status','admin_id']);
        // }
        // else if($status == 1) {
        //     $dbase = DB::table('berita')
        //     ->where("web_id","=", $idweb)
        //     ->where("status","=",1)
        //     // ->where("admin_id","=",auth()->user()->id)
        //     ->orderBy('status','desc')
        //     ->orderBy('berita_id','desc')
        //     ->get(['berita_id','link','level','tgl_crawler','status','admin_id']);
        // }

        // print(count($dbase)."<br>");
        $ubah = 0;//untuk ktm
        foreach ($dbase as $value) {
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $tanggal_format = strtotime($value->tgl_crawler);
            $tgl_crawler = str_replace($bulanInggris, $bulanIndonesia, date("d F Y H:i:s", $tanggal_format));

            $berita[] = [
                'id' => $value->berita_id,
                'link' => $value->link,
                'level' => $value->level,
                'tgl' => $tgl_crawler,
                'status' => $value->status,
                'admin_id' => $value->admin_id
            ];
            // print($value->berita_id."-".$value->level." -- ".$value->status."- -".$value->link."<br>");
        }
        $idn = DB::table('berita')->where("web_id","=", $idweb)->where("status","=", 3)->count();

        return view('user-admin/crawlering/crawler-konten',[
            'web' => 'dsp',
            'bhs' => 'cek',
            'ubah' => $ubah,//untuk ktm
            'idn' => $idn,
            'berita' => $berita,
            'error' => false,
            'pesan' => $status
        ]);
    }

    //2c-2
    public function cekStatusKTM($status){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $idweb = 2; //koreatimes
        $berita = [];
        $dbase = null;
        // if($status == 0) {
            $dbase = DB::table('berita')
            ->where("web_id","=", $idweb)
            ->where("status","=",$status)//status 1-2 (bhs kor)
            // ->where("admin_id","=",auth()->user()->id)
            ->orderBy('status','desc')
            ->orderBy('berita_id','desc')
            ->get(['berita_id','link','level','tgl_crawler','status','admin_id']);
        // }
        // else if($status == 1) {
        //     $dbase = DB::table('berita')
        //     ->where("web_id","=", $idweb)
        //     ->where("status","=",1)
        //     // ->where("admin_id","=",auth()->user()->id)
        //     ->orderBy('status','desc')
        //     ->orderBy('berita_id','desc')
        //     ->get(['berita_id','link','level','tgl_crawler','status','admin_id']);
        // }
        // else if($status == 2) {
        //     //khusus ktm yg kpop
        //     $dbase = DB::table('berita')
        //     ->where("web_id","=",2)
        //     ->where("status","=",2)
        //     // ->where("admin_id","=",auth()->user()->id)
        //     ->orderBy('status','desc')
        //     ->orderBy('berita_id','desc')
        //     ->get(['berita_id','link','level','tgl_crawler','status','admin_id']);
        // }

        // print(count($dbase)."<br>");
        $ubah = 0;//untuk ktm
        foreach ($dbase as $value) {
            if($value->status == 2) $ubah += 1;//untuk ktm
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $tanggal_format = strtotime($value->tgl_crawler);
            $tgl_crawler = str_replace($bulanInggris, $bulanIndonesia, date("d F Y H:i:s", $tanggal_format));

            $berita[] = [
                'id' => $value->berita_id,
                'link' => $value->link,
                'level' => $value->level,
                'tgl' => $tgl_crawler,
                'status' => $value->status,
                'admin_id' => $value->admin_id
            ];
            // print($value->berita_id."-".$value->level." -- ".$value->status."- -".$value->link."<br>");
        }
        $idn = DB::table('berita')->where("web_id","=", $idweb)->where("status","=", 3)->count();

        return view('user-admin/crawlering/crawler-konten',[
            'web' => 'ktm',
            'bhs' => 'cek',
            'ubah' => $ubah,//untuk ktm
            'idn' => $idn,
            'berita' => $berita,
            'error' => false,
            'pesan' => $status
        ]);
    }

    //2c-3
    public function cekStatusKHD($status){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $idweb = 3; //koreaherald
        $berita = [];
        $dbase = null;
        // if($status == 0) {
            $dbase = DB::table('berita')
            ->where("web_id","=", $idweb)
            ->where("status","=",$status)//status 1-2 (bhs kor)
            // ->where("admin_id","=",auth()->user()->id)
            ->orderBy('status','desc')
            ->orderBy('berita_id','desc')
            ->get(['berita_id','link','level','tgl_crawler','status','admin_id']);
        // }
        // else if($status == 1) {
        //     $dbase = DB::table('berita')
        //     ->where("web_id","=", $idweb)
        //     ->where("status","=",1)
        //     // ->where("admin_id","=",auth()->user()->id)
        //     ->orderBy('status','desc')
        //     ->orderBy('berita_id','desc')
        //     ->get(['berita_id','link','level','tgl_crawler','status','admin_id']);
        // }

        // print(count($dbase)."<br>");
        $ubah = 0;//untuk ktm
        foreach ($dbase as $value) {
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $tanggal_format = strtotime($value->tgl_crawler);
            $tgl_crawler = str_replace($bulanInggris, $bulanIndonesia, date("d F Y H:i:s", $tanggal_format));

            $berita[] = [
                'id' => $value->berita_id,
                'link' => $value->link,
                'level' => $value->level,
                'tgl' => $tgl_crawler,
                'status' => $value->status,
                'admin_id' => $value->admin_id
            ];
            // print($value->berita_id."-".$value->level." -- ".$value->status."- -".$value->link."<br>");
        }
        $idn = DB::table('berita')->where("web_id","=", $idweb)->where("status","=", 3)->count();

        return view('user-admin/crawlering/crawler-konten',[
            'web' => 'khd',
            'bhs' => 'cek',
            'ubah' => $ubah,//untuk ktm
            'idn' => $idn,
            'berita' => $berita,
            'error' => false,
            'pesan' => $status
        ]);
    }

    //3a/ ambil semua link yg disimpan (indonesia)
    public function getAggregator($web){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        set_time_limit(1800);

        $dsp = DB::table('berita')
            ->join('berita_konten','berita_konten.berita_id','=','berita.berita_id')
            ->whereRaw("berita.web_id = 1 and berita.status = 4 and (berita_konten.tgl_publikasi like '%2023%' or berita.tgl_crawler like '%2024%')")
            // ->where("admin_id","=",auth()->user()->id)
            ->count();
        $ktm = DB::table('berita')
            ->join('berita_konten','berita_konten.berita_id','=','berita.berita_id')
            ->whereRaw("berita.web_id = 2 and berita.status = 4 and (berita_konten.tgl_publikasi like '%2023%' or berita.tgl_crawler like '%2024%')")
            // ->where("admin_id","=",auth()->user()->id)
            ->count();
        $khd = DB::table('berita')
            ->join('berita_konten','berita_konten.berita_id','=','berita.berita_id')
            ->whereRaw("berita.web_id = 3 and berita.status = 4 and (berita_konten.tgl_publikasi like '%2023%' or berita.tgl_crawler like '%2024%')")
            // ->where("admin_id","=",auth()->user()->id)
            ->count();
        $idweb = 1; //dispatch
        if ($web == 'dsp') { $ktm = 0; $khd = 0;}
        else if($web == 'ktm') {$idweb = 2; $dsp = 0; $khd = 0;} //koreatimes
        else if($web == 'khd') {$idweb = 3; $dsp = 0; $ktm = 0;} //koreaherald

        $jumlahLink = 0;
        $berita = [];
        $totalBulan = 0;
        if($web == 'semua' || $web == 'grafik'){
            $dbase = DB::table('berita_konten')
                ->join('berita','berita_konten.berita_id','=','berita.berita_id')
                ->whereRaw("berita.status = 4 and (berita_konten.tgl_publikasi like '%2023%' or berita.tgl_crawler like '%2024%')")//status = 3 (bhs idn)
                // ->where("berita.admin_id","=",auth()->user()->id)
                ->selectRaw('berita.web_id as web, berita.level as level, berita.tgl_crawler as tgl,
                count(berita.berita_id) as berita')
                // berita.berita_id as id, berita.link as link, berita.admin_id as berita_admin, berita_konten.admin_id as konten_admin')
                ->groupByRaw('berita.web_id, berita.level, berita.tgl_crawler')//berita.admin_id, berita_konten.admin_id
                ->orderBy('berita.berita_id','desc')
                ->get();
        } else {
            $dbase = DB::table('berita_konten')
                ->join('berita','berita_konten.berita_id','=','berita.berita_id')
                ->whereRaw("berita.web_id =".$idweb." and berita.status = 4 and (berita_konten.tgl_publikasi like '%2023%' or berita.tgl_crawler like '%2024%')")//status = 3 (bhs idn)
                // ->where("berita.admin_id","=",auth()->user()->id)
                ->selectRaw('berita.web_id as web, berita.level as level, berita.tgl_crawler as tgl,
                count(berita.berita_id) as berita')
                // berita.berita_id as id, berita.link as link, berita.admin_id as berita_admin, berita_konten.admin_id as konten_admin')
                ->groupByRaw('berita.web_id, berita.level, berita.tgl_crawler')//berita.admin_id, berita_konten.admin_id
                ->orderBy('berita.berita_id','desc')
                ->get();
        }

        if($web == 'grafik'){
            $countberita = DB::table('berita')->whereRaw("status=4")->groupBy('tgl_crawler');
            // $totalBulan['07']['total'] = $countberita;

            // $totalBulan = [];
            $totalBulan = [
                7 => ['bulan' => 'Juli' , 'total' => 0] ,
                8 => ['bulan' => 'Agustus' , 'Dispatch' => 0, 'The Korea Times' => 0, 'Korea Herald' => 0 ] ,
                9 => ['bulan' => 'September' , 'Dispatch' => 0, 'The Korea Times' => 0, 'Korea Herald' => 0 ] ,
                10 => ['bulan' => 'Oktober' , 'Dispatch' => 0, 'The Korea Times' => 0, 'Korea Herald' => 0 ] ,
                11 => ['bulan' => 'November' , 'Dispatch' => 0, 'The Korea Times' => 0, 'Korea Herald' => 0 ] ,
                12 => ['bulan' => 'Desember' , 'Dispatch' => 0, 'The Korea Times' => 0, 'Korea Herald' => 0 ] ,
                1 => ['bulan' => '2024' , 'Dispatch' => 0, 'The Korea Times' => 0, 'Korea Herald' => 0 ]
            ];

            $counting = 0;
            $bulan = 7;
            while ($counting < 6) {
                $kalimat = "tgl_crawler like '%-07-%' and status=4";
                if($counting == 1) $kalimat = "tgl_crawler like '%-08-%' and status=4";
                else if($counting == 2) $kalimat = "tgl_crawler like '%-09-%' and status=4";
                else if($counting > 2) $kalimat = "tgl_crawler like '%-".$bulan."-%' and status=4";
                $countberita = DB::table('berita')->selectRaw('web_id, count(web_id) as web')->whereRaw($kalimat)->groupBy('web_id')->get();
                foreach ($countberita as $item) {
                    if($item->web_id == 1) $totalBulan[$bulan]['Dispatch'] = $item->web;
                    else if($item->web_id == 2) $totalBulan[$bulan]['The Korea Times'] = $item->web;
                    else if($item->web_id == 3) $totalBulan[$bulan]['Korea Herald'] = $item->web;
                }
                // $countberita = DB::table('berita')->whereRaw($kalimat)->groupBy('web_id')->count();
                // $countberita = DB::table('berita')->whereRaw($kalimat)->groupBy('web_id')->count();
                $bulan += 1; $counting += 1;
            }
            $countberita = DB::table('berita')->selectRaw('web_id, count(web_id) as web')
                ->whereRaw("tgl_crawler like '%2024%' and status=4")->groupBy('web_id')->get();
            foreach ($countberita as $item) {
                if($item->web_id == 1) $totalBulan[1]['Dispatch'] = $item->web;
                else if($item->web_id == 2) $totalBulan[1]['The Korea Times'] = $item->web;
                else if($item->web_id == 3) $totalBulan[1]['Korea Herald'] = $item->web;
            }
        } else {
            // print(count($dbase));
            foreach ($dbase as $value) {
                $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                $tanggal_format = strtotime($value->tgl);
                $tgl_crawler = str_replace($bulanInggris, $bulanIndonesia, date("d F Y H:i:s", $tanggal_format));

                $berita[] = [
                    'web' => $value->web,
                    'level' => $value->level,
                    'tanggal' => $tgl_crawler,
                    // 'berita_admin' => $value->berita_admin,
                    // 'konten_admin' => $value->konten_admin,
                    'jumlah' => $value->berita,
                ];
                $jumlahLink += $value->berita;
            }
        }

        $pesan = ["salah",$jumlahLink];
        if( $jumlahLink == ($dsp+$ktm+$khd) ) $pesan = ["benar",$jumlahLink];

        // foreach ($totalBulan as $key => $value) {
        //     var_dump($value);
        //     print('<br>');
        // }

        // dd($totalBulan);

        return view('user-admin/crawlering/berita-aggregator',[
            'web'=> $web,
            'dsp'=> $dsp,
            'ktm'=> $ktm,
            'khd'=> $khd,
            'pesan' => $pesan,
            'berita' => $berita,
            'totalBulan' => $totalBulan
        ]);
    }

    //3b/ ambil semua link yg disimpan (indonesia) dan data baca jg like
    public function detailAggregator(Request $req){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        set_time_limit(1800);
        $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $bulanIndonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tanggal_format = str_replace($bulanIndonesia, $bulanInggris, $req->tanggal);
        $tgl_crawler = date("Y-m-d H:i:s", strtotime($tanggal_format));

        $berita = [];
        $linknya = DB::table('berita')
            ->join('berita_konten','berita_konten.berita_id','=','berita.berita_id')
            ->leftJoin('berita_baca','berita_baca.berita_id','=','berita.berita_id')
            ->whereRaw("berita.web_id = '$req->web' and berita.level = '$req->level' and berita.tgl_crawler = '$tgl_crawler' and berita.status = 4")
            ->selectRaw('berita.berita_id as id, berita.link as link,
                berita.admin_id as berita_admin, berita_konten.admin_id as konten_admin,
                berita_konten.konten_id as konten, count(berita_baca.tanggal_baca) as userbaca')
                ->groupByRaw('link, id, berita_admin, konten_admin, konten')
            ->orderBy('berita_konten.konten_id','asc')
            ->get();

        foreach ($linknya as $value) {
            $where = "berita.berita_id = '$value->id'";
            $suka = DB::table('berita_baca')
                ->join('berita','berita_baca.berita_id','=','berita.berita_id')
                ->whereRaw("berita_baca.suka = 1 and ".$where)
                ->groupBy('berita_baca.suka')
                ->count();
            $tidaksuka = DB::table('berita_baca')
                ->join('berita','berita_baca.berita_id','=','berita.berita_id')
                ->whereRaw("berita_baca.suka = -1 and ".$where)
                ->groupBy('berita_baca.suka')
                ->count();
            $belum = DB::table('berita_baca')
                    ->join('berita','berita_baca.berita_id','=','berita.berita_id')
                    ->whereRaw("berita_baca.suka = 0 and ".$where)
                    ->groupBy('berita_baca.suka')
                    ->count();
            $berita[] = [
                'id' => $value->id,
                'link' => $value->link,
                'berita_admin' => $value->berita_admin,
                'konten_admin' => $value->konten_admin,
                'konten' => $value->konten,
                'baca' => $value->userbaca,
                'suka' => $suka,
                'tidaksuka' => $tidaksuka,
                'belum' => $belum,
            ];
        }
        // dd($linknya);

        // if($req->jumlah == count($berita)){
            return view('user-admin/crawlering/detail-aggregator',[
                'req' => [
                    'web' => $req->web,
                    'level' => $req->level,
                    'tanggal' => $req->tanggal,
                    'jumlah' => $req->jumlah
                ],
                'berita' => $berita
            ]);
        // }
        // else return redirect()->route('aggregator',['web' => 'grafik']);
    }

    //4 mencoba buka halaman berita
    public function lihatHalaman($id) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        set_time_limit(1800);

        $error = false;
        $konten = null;
        $dbase = DB::table('berita_konten')
            ->join('berita','berita_konten.berita_id','=','berita.berita_id')
            ->where("berita_konten.berita_id","=",$id)
            ->selectRaw('berita.web_id, berita.berita_id, berita.status, berita.web_id,
                berita.link as linknya, berita.admin_id as berita_admin, berita_konten.*')
            ->get();
        // if(count($dbase) == 0) {
        //     $ubahstatus = DB::table('berita')->whereRaw("berita_id = ".$id)->update(['status' => 1]);
        //     if($ubahstatus) return redirect()->route('aggregator',['web' => 'semua']);
        // }

        foreach ($dbase as $value) {
            $cleaned = $value->desk_idn;
            if($value->web_id == '1'){//dispatch
                $src = str_replace('data-src','src',$value->desk_idn);
                $center = str_replace('text-align: center;', 'text-align: left;',$src);
                $width = str_replace('style="width:100%', 'style="width:50%;"',$center);
                $cleaned = str_replace('gambarnya','gambarnya h-50',$width);
            } else if($value->web_id == '2'){//koreatimes
                $gambar  = "img_arti img_a2";
                $jadigmb = str_replace('gambarnya','gambar',$cleaned);
                $gmb = str_replace($gambar,'gambarnya',$jadigmb);
                $caption = "img_txt";
                $cleaned = str_replace($caption,'captionnya',$gmb);

            } else if($value->web_id == '3'){//koreaherald
                $gambar = "img_box";
                $jadigmb = str_replace('gambarnya','gambar',$cleaned);
                $gmb = str_replace($gambar,'gambarnya h-50',$jadigmb);
                $caption = "img_caption";
                $cap = str_replace($caption,'captionnya',$gmb);
                $deskripsi = "text_box";
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
                'berita_admin' => $value->berita_admin,
                'konten_admin' => $value->admin_id,
                'idn'=>[
                    'judul' => $value->judul_idn,
                    'sub' => $value->sub_idn,
                    'tanggal' => $value->tgl_idn,
                    'deskripsi' => $desk
                ],
            ];
            // print("linkknya: ".$value->linknya."<br>");
        }

        $where = "berita.berita_id = '$id'";
        $suka = DB::table('berita_baca')
            ->join('berita','berita_baca.berita_id','=','berita.berita_id')
            ->whereRaw("berita_baca.suka = 1 and ".$where)
            ->groupBy('berita_baca.suka')
            ->count();
        $tidaksuka = DB::table('berita_baca')
            ->join('berita','berita_baca.berita_id','=','berita.berita_id')
            ->whereRaw("berita_baca.suka = -1 and ".$where)
            ->groupBy('berita_baca.suka')
            ->count();
        $belum = DB::table('berita_baca')
            ->join('berita','berita_baca.berita_id','=','berita.berita_id')
            ->whereRaw("berita_baca.suka = 0 and ".$where)
            ->groupBy('berita_baca.suka')
            ->count();

        // dd($suka,$tidaksuka,$belum);
        return view('user-admin/crawlering/halaman-berita',[
            'id'=> $id,
            'error' => $error,
            'konten' => $konten,
            'suka' => $suka,
            'tidaksuka' => $tidaksuka,
            'belum' => $belum,
        ]);
    }

    //5 ubah status jadi -1
    public function ubahLink($id){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        $webnya = DB::table('berita')->whereRaw("berita_id = ".$id)->get(['web_id']);
        $web = 'dsp';//dispatch
        if($webnya[0]->web_id == 2) $web = 'ktm';//koreatimes
        else if($webnya[0]->web_id == 3) $web = 'khd';//koreaherald

        $nonaktifkan = DB::table('berita')->whereRaw("berita_id = ".$id)->update(['status' => -1]);

        if($nonaktifkan) return redirect()->route('lihatHalaman',['id' => $id]);
        else return redirect()->route('aggregator',['web' => 'semua']);
    }

//catatan revisi
/*
2. Sesuaikan fitur program dengan alur yang direncanakan di buku.
Di buku alurnya berita diseleksi dulu oleh admin sebelum ditambahkan di halaman utama.
*/

    // -a tambahkan fitur untuk menandai berita mana saja yang belum direview
    //6 buka halaman cek berita u/ berita yang belum dicek/direview
    public function reviewBerita($web) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }
        set_time_limit(1800);

        $jumlahLink = 0;
        $berita = [];
        $idweb = 1; //dispatch
        if ($web == 'dsp') { $ktm = 0; $khd = 0;}
        else if($web == 'ktm') {$idweb = 2; $dsp = 0; $khd = 0;} //koreatimes
        else if($web == 'khd') {$idweb = 3; $dsp = 0; $ktm = 0;} //koreaherald

        $statusnya = "berita.status = 3 and ";
        $where = '';
        if($web == 'nonaktif'){
            $statusnya = "berita.status = -1 and ";//status 0 waktu web crawler, status -1 dinonaktifkan
        }
        if($web == 'admin'){
            $where = "(berita.admin_id =".auth()->user()->id." or berita_konten.admin_id =".auth()->user()->id.") and ";
        }
        else if($web != 'semua' && $web != 'nonaktif'){
            $where = "berita.web_id =".$idweb." and ";
        }

        $dsp = DB::table('berita')
            ->join('berita_konten','berita_konten.berita_id','=','berita.berita_id')
            ->whereRaw("berita.web_id = 1 and ".$where.$statusnya." (berita_konten.tgl_publikasi like '%2023%' or berita.tgl_crawler like '%2024%')")//(berita.tgl_crawler like '%2023-12-%' or berita.tgl_crawler like '%2024-01-%')")
            // ->where("admin_id","=",auth()->user()->id)
            ->count();
        $ktm = DB::table('berita')
            ->join('berita_konten','berita_konten.berita_id','=','berita.berita_id')
            ->whereRaw("berita.web_id = 2 and ".$where.$statusnya." (berita_konten.tgl_publikasi like '%2023%' or berita.tgl_crawler like '%2024%')")//(berita.tgl_crawler like '%2023-12-%' or berita.tgl_crawler like '%2024-01-%')")
            // ->where("admin_id","=",auth()->user()->id)
            ->count();
        $khd = DB::table('berita')
            ->join('berita_konten','berita_konten.berita_id','=','berita.berita_id')
            ->whereRaw("berita.web_id = 3 and ".$where.$statusnya." (berita_konten.tgl_publikasi like '%2023%' or berita.tgl_crawler like '%2024%')")//(berita.tgl_crawler like '%2023-12-%' or berita.tgl_crawler like '%2024-01-%')")
            // ->where("admin_id","=",auth()->user()->id)
            ->count();

        $dbase = DB::table('berita_konten')
            ->join('berita','berita_konten.berita_id','=','berita.berita_id')
            ->whereRaw($where.$statusnya."(berita_konten.tgl_publikasi like '%2023%' or berita.tgl_crawler like '%2024%')")//"(berita.tgl_crawler like '%2023-12-%' or berita.tgl_crawler like '%2024-01-%')")
            //status = 3 (bhs idn), berita.admin_id = auth()->user()->id, berita_konten.tgl_publikasi like '%2023%'
            ->selectRaw('berita.web_id as web, berita.level as level, berita.tgl_crawler as tgl, berita.status as statusnya,
                berita.berita_id as id, berita.link as link,
                berita.admin_id as berita_admin, berita_konten.admin_id as konten_admin,
                berita_konten.konten_id as konten')//count(berita.berita_id) as berita
            // ->groupByRaw('berita.web_id, berita.level, berita.tgl_crawler')//berita.admin_id, berita_konten.admin_id
            ->orderBy('berita.berita_id','desc')
            ->get();
        // $dbase = DB::table('berita')
        //     ->join('berita_konten','berita_konten.berita_id','=','berita.berita_id')
        //     // ->leftJoin('berita_baca','berita_baca.berita_id','=','berita.berita_id')
        //     ->whereRaw("berita.status = 3 and berita_konten.tgl_publikasi like '%2023%'")
        //     ->selectRaw('berita.web_id as web, berita.level as level, berita.tgl_crawler as tgl,
        //         berita.berita_id as id, berita.link as link,
        //         berita.admin_id as berita_admin, berita_konten.admin_id as konten_admin,
        //         berita_konten.konten_id as konten')//, count(berita_baca.tanggal_baca) as userbaca
        //     // ->groupByRaw('web, level, tgl, link, id, berita_admin, konten_admin, konten')
        //     ->orderBy('berita.berita_id','desc')
        //     ->get();

        // dd($web, count($dbase), $dsp, $ktm, $khd, $jumlahLink == ($dsp+$ktm+$khd) );
        foreach ($dbase as $value) {
            $bulanInggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bulanIndonesia = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
            $tanggal_format = strtotime($value->tgl);
            $tgl_crawler = str_replace($bulanInggris, $bulanIndonesia, date("d F Y H:i:s", $tanggal_format));

            $where = "berita.berita_id = '$value->id'";
            $bacanya = $suka = DB::table('berita_baca')
                ->join('berita','berita_baca.berita_id','=','berita.berita_id')
                ->whereRaw($where)
                // ->groupBy('berita_baca.suka')
                ->count();
            $suka = DB::table('berita_baca')
                ->join('berita','berita_baca.berita_id','=','berita.berita_id')
                ->whereRaw("berita_baca.suka = 1 and ".$where)
                ->groupBy('berita_baca.suka')
                ->count();
            $tidaksuka = DB::table('berita_baca')
                ->join('berita','berita_baca.berita_id','=','berita.berita_id')
                ->whereRaw("berita_baca.suka = -1 and ".$where)
                ->groupBy('berita_baca.suka')
                ->count();
            $belum = DB::table('berita_baca')
                    ->join('berita','berita_baca.berita_id','=','berita.berita_id')
                    ->whereRaw("berita_baca.suka = 0 and ".$where)
                    ->groupBy('berita_baca.suka')
                    ->count();

            $berita[] = [
                'web' => $value->web,
                'level' => $value->level,
                'tanggal' => $tgl_crawler,
                'status' => $value->statusnya,
                // 'jumlah' => $value->berita,
                'id' => $value->id,
                'link' => $value->link,
                'berita_admin' => $value->berita_admin,
                'konten_admin' => $value->konten_admin,
                'konten' => $value->konten,
                'baca' => $bacanya,//$value->userbaca,
                'suka' => $suka,
                'tidaksuka' => $tidaksuka,
                'belum' => $belum,
            ];

            $jumlahLink += 1;//$value->berita;
        }

        $pesan = ["salah",$jumlahLink];
        if( $jumlahLink == ($dsp+$ktm+$khd) ) $pesan = ["benar",$jumlahLink];

        return view('user-admin/crawlering/review-aggregator',[
            'web'=> $web,
            'dsp'=> $dsp,
            'ktm'=> $ktm,
            'khd'=> $khd,
            'pesan' => $pesan,
            'berita' => $berita
        ]);
    }

    // -a tambahkan fitur untuk menandai berita mana saja yang belum direview
    //6a ubah status jadi 4, menjadi siap ditayangkan
    public function tayangkanBerita($id){
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        //info: sebenernya bisa dijadikan 1 dg func ubahLink
        $siaptayang = DB::table('berita')->whereRaw("berita_id = ".$id)->update(['status' => 4]);

        if($siaptayang == 1) return redirect()->route('lihatHalaman',['id' => $id]);
        else return redirect()->route('lihatHalaman',['id' => $id]);
    }

    // -b tambahkan fitur preview artikel di halaman yang sama dengan halaman daftar berita yang belum direview untuk membantu mempercepat proses review berita
    //7 preview halaman berita yang sudah dicek/direview
    public function previewBerita($web) {
        if(auth()->user()->role != 1 || auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/login');
        }

        $idweb = 1;
        if($web == 'ktm') $idweb = 2;
        else if($web == 'khd') $idweb = 3;

        $id = 0;
        $idnya = DB::table('berita')->whereRaw("status = 4 and web_id = ".$idweb)->get(['berita_id']);
        if(count($idnya) > 0) $id = $idnya[0]->berita_id;

        if($id == 0) return redirect()->route('review',['web' => $web]);
        return redirect()->route('lihatHalaman',['id' => $id]);
    }
}
