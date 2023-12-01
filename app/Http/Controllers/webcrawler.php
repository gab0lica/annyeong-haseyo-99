<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Controllers\Log;
// use DOMDocument;
use DOMXPath;//library(?)
use Illuminate\Support\Facades\DB;
use Stichoza\GoogleTranslate\GoogleTranslate;//library(?) di vendor/stichoza/google-translate-php/GoogleTranslate

class webcrawler extends Controller //Crawlering
{
    /*
    // try {
    //     // Simulasi kesalahan, jika url "error" maka eksepsi akan dibangkitkan
    //     throw new Exception("Gagal mengambil data dari sumber");
    //     // Simulasi pengambilan data dari sumber
    //     // Misalnya:
    //     // $data = ...; (kode untuk mengambil data dari URL)
    //     // return $data;
    // } catch (Exception $e) {
    //     echo "Terjadi kesalahan: " . $e->getMessage() . PHP_EOL;
    // }
    // $dbase = DB::select('select berita_id , level, status, link from users where web_id=:id and status=1',['id'=>1]);
    // db::table('users')->skip(10)->take(3)->get(); //skip=limit (brp recored), take=offset (dari index+1)
    // let datanya = "https://pokeapi.co/api/v2/pokemon/?limit=10&offset="+halaman;//1-10
    */

    //dump
    public function getting(){
        // if(strlen(trim($translatedTexts['cap'])) !== 0) {
        //     print("c ".$translatedTexts['cap']."<br>");
        //     // $arr = "halo. ; halo. haloww. ; haloow.";
        //     // Pisahkan kalimat berdasarkan pemisah ekspresi reguler (';')
        //     $kalimatArray = preg_split('/}{/', $translatedTexts['cap']);
        //     // Tampilkan kalimat-kalimat hasil pemisahan
        //     foreach ($kalimatArray as $kalimatPisah) {
        //         print("c [".trim($kalimatPisah)."]<br>"); //. PHP_EOL;  Gunakan trim() untuk menghapus spasi ekstra
        //     }
        // }
        // print("d ".$translatedTexts['desk']."<hr>");
        // $urutan = 1;
        // // Pisahkan kalimat berdasarkan pemisah ekspresi reguler (';')
        // $kalimatArray = preg_split('/}{/', $translatedTexts['desk']);// '/;\s*/' >> cari ';'
        // // Tampilkan kalimat-kalimat hasil pemisahan
        // foreach ($kalimatArray as $kalimatPisah) {
        //     // print($kalimatPisah);
        //     // print(strlen(trim($kalimatPisah)));
        //     print($urutan."--");
        //     // Menghitung panjang total kalimat
        //     $panjangKalimat = strlen($kalimatPisah);
        //     // Menghitung jumlah karakter spasi dalam kalimat
        //     $jumlahSpasi = substr_count($kalimatPisah, ' ') ;
        //     // print($jumlahSpasi);
        //     // Memeriksa apakah kalimat hanya berisi spasi
        //     // if ($jumlahSpasi === $panjangKalimat) print('kosong poll<br>');
        //     if(strlen(trim($kalimatPisah)) === 0) print('kosong<br>');
        //     else print("d [".trim($kalimatPisah)."]<br>"); //. PHP_EOL;  Gunakan trim() untuk menghapus spasi ekstra
        //     $urutan += 1;
        // }

        //cara dari chatgpt mirip dg cara1
        // $sourceLanguage = "kr"; // Ganti dengan kode bahasa tujuan yang sesuai, misalnya "fr" untuk bahasa Perancis
        // if($web == 'khd') $sourceLanguage = "en";
        //load payload untuk konten translate
        // $payload = array();
        // $limit = 0;
        // while($limit < 5){
        //     $kalimat = 'kalimat';
        //     if($limit == 0) $kalimat = $textsToTranslate['judul'];
        //     else if($limit == 1 && $textsToTranslate['sub'] != "sub") $kalimat = $textsToTranslate['sub'];
        //     else if($limit == 2) $kalimat = $textsToTranslate['tgl'];
        //     else if($limit == 3 && isset($textsToTranslate['caption'])) {
        //         foreach ($textsToTranslate['caption'] as $c) {
        //             $payload[] = array(
        //                 "q" => $c,
        //                 "target" => "id",
        //                 "source" => $sourceLanguage // 'kr', Ganti dengan kode bahasa sumber yang sesuai jika perlu
        //             );
        //         }
        //     }
        //     else if($limit == 4 && isset($textsToTranslate['desk'])) {
        //         foreach ($textsToTranslate['desk'] as $d) {
        //             $payload[] = array(
        //                 "q" => $d,
        //                 "target" => "id",
        //                 "source" => $sourceLanguage // 'kr', Ganti dengan kode bahasa sumber yang sesuai jika perlu
        //             );
        //         }
        //     }
        //     if($kalimat != 'kalimat' && $limit < 3){
        //         $payload[] = array(
        //             "q" => $kalimat,
        //             "target" => "id",
        //             "source" => $sourceLanguage // 'kr', Ganti dengan kode bahasa sumber yang sesuai jika perlu
        //         );
        //     }
        //     $limit+=1;
        // }
        // foreach ($payload as $idx => $alltext) {
        //     print($idx.") ");
        //     foreach ($alltext as $i => $text) {
        //         print($i." -> ".$text."<br>");
        //     }
        // }
        // Contoh penggunaan:
        // $textsToTranslate = array(
        //     "Hello, how are you?",
        //     "What is your name?",
        //     "Where are you from?"
        // );
        // sourcelanguage//awalnya disini, jd diatas
        // $translatedTexts = array();// ... batchTranslateTexts($textsToTranslate, $sourceLanguage);
        /*
        // Ganti 'YOUR_RAPIDAPI_KEY' dengan kunci API RapidAPI Anda
        $rapidApiKey = '0be9aeff2emsh011514ea6791ec1p191eb3jsn2d477508baae'; //'YOUR_RAPIDAPI_KEY';
        // Fungsi untuk melakukan panggilan API batch terjemahan menggunakan RapidAPI
        // function batchTranslateTexts($texts, $sourceLanguage) {
            global $rapidApiKey;
            $curl = curl_init();
            // Atur URL Endpoint
            $url = "https://google-translate1.p.rapidapi.com/language/translate/v2";
            // foreach ($textsToTranslate as $text) {
            //     $payload[] = array(
            //         "q" => $text,
            //         "target" => "id",
            //         "source" => $sourceLanguage // 'kr', Ganti dengan kode bahasa sumber yang sesuai jika perlu
            //     );
            // }
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode(array("target" => "id", "q" => $payload)),
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "x-rapidapi-host: google-translate1.p.rapidapi.com",
                    "x-rapidapi-key: $rapidApiKey"
                ],
            ]);
            $response = curl_exec($curl);
            $error = curl_error($curl);
            if ($error) {
                echo "Error: " . $error;
            } else {
                $data = json_decode($response, true);
                if (isset($data['data']['translations'])) {
                    $translatedTexts = array_column($data['data']['translations'], 'translatedText');
                    // return
                } else {
                    echo "Translation not available";
                }
            }
            curl_close($curl);
        // }
        //print yang sudah ditranslate
        // foreach ($payload as $idx => $alltext) {
        //     print($idx.") ");
        //     foreach ($alltext as $i => $text) {
        //         print($i." -> ".$text."<br>");
        //     }
        // }
        foreach ($translatedTexts as $index => $translatedText) {
            // echo "Original text: " . $textsToTranslate[$index] . PHP_EOL;
            print("Translated text: " . $translatedText."<br>");//. PHP_EOL;
            // echo PHP_EOL;
        }
        */

        //cara1 >> pakai cara ini dalam while
                // $curl = curl_init();
                // curl_setopt_array($curl, [
                //     CURLOPT_URL => "https://google-translate1.p.rapidapi.com/language/translate/v2",
                //     CURLOPT_RETURNTRANSFER => true,
                //     CURLOPT_ENCODING => "",
                //     CURLOPT_MAXREDIRS => 10,
                //     CURLOPT_TIMEOUT => 30,
                //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                //     CURLOPT_CUSTOMREQUEST => "POST",
                //     CURLOPT_POSTFIELDS =>
                //     // json_encode($payload),//array("target" => "id", "q" => '1', "source" => "ko")
                //     // "q=%EC%9D%B4%EB%8F%84%ED%98%84%2C%2014%EC%9D%BC%20%EB%B9%84%EA%B3%B5%EA%B0%9C%20%EC%9E%85%EB%8C%80%E2%80%A6%EA%B3%B5%EA%B5%B0%20%EA%B5%B0%EC%95%85%EB%8C%80%EC%84%9C%20%EB%B3%B5%EB%AC%B4%20%EC%98%88%EC%A0%95&target=id&source=ko",
                //     "q=".$kalimat."&target=id&source=ko",//이도현, 14일 비공개 입대…공군 군악대서 복무 예정
                //     CURLOPT_HTTPHEADER => [
                //         "Accept-Encoding: application/gzip",
                //         "X-RapidAPI-Host: google-translate1.p.rapidapi.com",
                //         "X-RapidAPI-Key: 0be9aeff2emsh011514ea6791ec1p191eb3jsn2d477508baae",
                //         "content-type: application/x-www-form-urlencoded"
                //     ],
                // ]);
                // $response = curl_exec($curl);
                // $err = curl_error($curl);
                // curl_close($curl);
                // if ($err) {
                //     echo "cURL Error #:" . $err;
                // } else {
                //     // echo $response."<br>";
                //     if($limit == 0) $translatedTexts['judul'] = $response;
                //     else if($limit == 1) $translatedTexts['sub'] = $response;
                //     else if($limit == 2) $translatedTexts['tgl'] = $response;
                //     else if($limit == 3) $translatedTexts['cap'] = $response;
                //     else if($limit == 4) $translatedTexts['desk'] = $response;
                // }

        //cara2
        /*
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://google-translate1.p.rapidapi.com/language/translate/v2', [
            'form_params' => [
                // 'q' => '이도현, 14일 비공개 입대…공군 군악대서 복무 예정',
                'target' => 'id',
                'source' => $sourceLanguage
            ],
            'headers' => [
                'Accept-Encoding' => 'application/gzip',
                'X-RapidAPI-Host' => 'google-translate1.p.rapidapi.com',
                'X-RapidAPI-Key' => '0be9aeff2emsh011514ea6791ec1p191eb3jsn2d477508baae',
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        ]);
        echo $response->getBody();
        */

        //cara3
        /*
        $request = new HttpRequest();
        $request->setUrl('https://google-translate1.p.rapidapi.com/language/translate/v2');
        $request->setMethod(HTTP_METH_POST);
        $request->setHeaders([
            'content-type' => 'application/x-www-form-urlencoded',
            'Accept-Encoding' => 'application/gzip',
            'X-RapidAPI-Key' => '0be9aeff2emsh011514ea6791ec1p191eb3jsn2d477508baae',
            'X-RapidAPI-Host' => 'google-translate1.p.rapidapi.com'
        ]);
        $request->setContentType('application/x-www-form-urlencoded');
        $request->setPostFields([
            'q' => '이도현, 14일 비공개 입대…공군 군악대서 복무 예정',
            'target' => 'id',
            'source' => 'ko'
        ]);
        try {
            $response = $request->send();
            echo $response->getBody();
        } catch (HttpException $ex) {
            echo $ex;
        }
        */

        //cara4
        /*
        $client = new http\Client;
        $request = new http\Client\Request;
        $body = new http\Message\Body;
        $body->append(new http\QueryString([
            'q' => '이도현, 14일 비공개 입대…공군 군악대서 복무 예정',
            'target' => 'id',
            'source' => 'ko'
        ]));
        $request->setRequestUrl('https://google-translate1.p.rapidapi.com/language/translate/v2');
        $request->setRequestMethod('POST');
        $request->setBody($body);
        $request->setHeaders([
            'content-type' => 'application/x-www-form-urlencoded',
            'Accept-Encoding' => 'application/gzip',
            'X-RapidAPI-Key' => '0be9aeff2emsh011514ea6791ec1p191eb3jsn2d477508baae',
            'X-RapidAPI-Host' => 'google-translate1.p.rapidapi.com'
        ]);
        $client->enqueue($request)->send();
        $response = $client->getResponse();
        echo $response->getBody();
        */
    }

    //3/ ambil semua link yg disimpan kontennya (korea)
    public function gettingLinks($web){
        $idweb = 1; //dispatch
        if($web == 'ktm') $idweb = 2; //koreatimes
        else if($web == 'khd') $idweb = 3; //koreaherald

        $berita = [];
        $dbase = DB::table('berita')
            ->where("web_id","=", $idweb)
            ->where("status","=",3)//status 3 (bhs ke idn), jadi status = 4 (bhs idn)
            ->orderBy('status','desc')
            ->orderBy('berita_id','desc')
            ->get(['berita_id','link','level','status']);

        foreach ($dbase as $value) {
            // $countterjemah = DB::table('terjemahan_berita')->where("berita_id","=", $value->berita_id)->count();
            // $countkonten = DB::table('konten_berita')->where("berita_id","=", $value->berita_id)->count();
            // if ($countterjemah > 0 && $countkonten > 0) $presentase = ($countterjemah/$countkonten)*100;
            // else $presentase = 0;
            //presentase: ketika sudah diload tapi belum bisa semua, maka cari count konten dgn berita_id dan kasih status 'dalam proses' jika count > 0

            $berita[] = [
                'id' => $value->berita_id,
                'link' => $value->link,
                'level' => $value->level,
                'status' => $value->status,
                // 'konten' => $presentase
            ];
        }

        return view('user-admin/crawlering/crawler-konten',[
            'web' => $web,
            'bhs' => 'idn',
            'ubah' => 0,
            'total' => count($berita),
            'berita' => $berita,
            'error' => false,
            'pesan' => ''
        ]);
    }

    // buat iterasi untuk per 50 link (ganti!)
    // 3a/ bagian translate, status 3 jd 4 >> status sampai 3
    public function getTranslate($web){//, $id
        set_time_limit(1500);//solusi(*)
        $idweb = 1; //dispatch
        if($web == 'ktm') $idweb = 2; //koreatimes
        else if($web == 'khd') $idweb = 3; //koreaherald
        $idberita = DB::table('berita')
            ->where('web_id','=',$idweb)
            ->where('status','=',3)
            ->orderBy('berita_id','desc')
            ->get(['berita_id']);
        $iterasi = 0;
        if(count($idberita) > 0) {//== 0
            // print("<h4 style='margin:0'>Link ini belum diambil konten, dengan ID berita ".$id."</h4><a href='http://localhost:8000/konten/' class='btn'>Kembali</a>");
        // }
        // else{
            while ($iterasi < 1 && count($idberita) > $iterasi) {//ganti limit sesuai kebutuhan
                $dbase = DB::table('konten_berita')
                    ->join('berita','konten_berita.berita_id','=','berita.berita_id')
                    ->where("konten_berita.berita_id","=",$idberita[$iterasi]->berita_id)
                    ->select('konten_berita.*')
                    ->where('berita.web_id','=',$idweb)
                    // ->orderBy('urutan','asc')
                    ->get();

                $textsToTranslate = array();
                $textsToTranslate['id'] = array();
                $textsToTranslate['judul'] = 'judul';
                $textsToTranslate['sub'] = 'sub';
                $textsToTranslate['tgl'] = 'tgl';
                $textsToTranslate['caption'] = array();
                $textsToTranslate['desk'] = array();
                // foreach ($dbase as $key => $value) {
                    print($dbase[0]->berita_id." -- id<br>");
                    $value = $dbase[0];
                    $textsToTranslate['id'][] = $value->konten_id;
                //    if($key==0) {
                        $textsToTranslate['judul'] = $value->judul;
                        $textsToTranslate['tgl'] = $value->tgl_publikasi;
                        if($value->subjudul != null) $textsToTranslate['sub'] = $value->subjudul;

                        $textsToTranslate['desk'][] = $value->deskripsi;
                        // print($textsToTranslate['desk'][0]." -- ini deskripsi semuaa<br>");
                //         // print("id=[".$value->konten_id."] judul=[".$value->judul."] - ".$value->subjudul."tgl=[".$value->tgl_publikasi."]<br>");
                //     }
                //     // print($key." - ".$value->urutan.") ");
                //     // if($value->gambar != null) print($value->gambar." - ");
                //     if($value->caption != null && strlen($value->caption) === 0) {
                //         $textsToTranslate['caption'][] = $value->caption;
                //         // print($value->caption." >> ");
                //     }
                //     if($value->deskripsi != null) {
                //         $textsToTranslate['desk'][] = $value->deskripsi;
                //         // print($value->deskripsi."<br>");
                //     }
                // }

                $gambar = "//*[@class='gambarnya']";
                $caption = "//*[@class='captionnya']";
                $deskripsi = "//*[@class='deskripsinya']";
                // if($web == 'ktm'){//koreatimes
                //     $gambar         = "//div[@class='img_arti img_a2']/img/@src";//['tag' => 'img', 'class' => 'img_arti img_a2', 'asal' => 'div']; //gambar ++
                //     $caption        = "//p[@class='img_txt']";//['tag' => 'p', 'class' => 'img_txt', 'asal' => 0]; //caption, related gambar
                //     $deskripsi      = "//*[@id='print_arti']";// "//div[@class='print_arti']"; ['tag' => 'div', 'class' => 'print_arti', 'asal' => 0]; //deskripsi ++, pastikan stop stlh find gambar stlh krn bersamaan dg class div = gambar dan caption'
                // } else if($web == 'dsp'){//dispatch
                //     $caption         = "//p/img";//['tag' => 'img', 'class' => 'post-image', 'asal' => 0]; // [@class='post-image']@src, gambar
                //     $deskripsi      = "//p";//['tag' => 'p', 'class' => 'page-post-font page-post-article', 'asal' => 'article']; //deskripsi, biasanya ada ini ../p'.$tambahan.'
                // } else if($web == 'khd'){//koreaherald
                //     $gambar         = "//img";//div[@class='img_box'] div[@class='view_con article']/table/tbody/tr/td/img[@src] ['tag' => 'img', 'class' => 'view_con article', 'asal' => 'div'];//gambar ++
                //     $caption        = "//em[@class='img_caption']";//div[@class='view_con_caption'] ['tag' => 'div', 'class' => 'view_con_caption', 'asal' => 0];//caption, related gambar
                //     $deskripsi      = "//div[@class='text_box']/p";//view_con_t ['tag' => 'p', 'class' => 'view_con_t', 'asal' => 'div'];//deskripsi ++
                // }

                /*
                $turunan = $element->childNodes;
                // $anak2 = $element->childNodes->item(2);
                for ($i=0; $i < $turunan->length; $i++) {
                    # code...
                    if ($turunan->item($i)->hasAttributes()) {
                        $itemclass = $turunan->item($i)->attributes->getNamedItem('class');
                        if ($itemclass) {//->value == 'img_arti img_a2'
                            // $element->removeChild($turunan->item($i));
                            $cleanedText = str_replace($turunan->item($i)->nodeValue, '', $datakonten);
                            $datakonten = $cleanedText;
                        }
                        // print("nomer:".$i."--".$itemclass->value."<hr>");
                    }
                }
                $kalimatArray = explode('.', $datakonten);
                // Tampilkan kalimat-kalimat hasil pemisahan
                foreach ($kalimatArray as $kalimatPisah) {
                    if(strlen(trim($kalimatPisah)) > 1) $konten_desk[] = trim($kalimatPisah)."."; // Gunakan trim() untuk menghapus spasi ekstra
                }
                */

                // $expression = $gambar;
                // $html = htmlspecialchars($textsToTranslate['desk'][0]);
                // // print($html);
                // $dom = new \DOMDocument(); $dom->loadHTML($html);
                // $xpath = new DOMXPath($dom); $pElements = $xpath->query($expression);
                // print("gambar > ".$expression." == ".count($pElements)."ini counting.");
                // foreach ($pElements as $element) {//$idx =>
                //     print("disini");

                //     $konten_desk[] = $dom->saveHTML($element);
                //     echo "<h4>all konten:</h4>";
                //     echo $konten_desk[0]."<br>";
                // }

                // print("judul>".$textsToTranslate['judul']."<br>");
                // print("subjudul>".$textsToTranslate['sub']."<br>");
                // print("tanggal>".$textsToTranslate['tgl']."<br>");
                // if(isset($textsToTranslate['caption'])) {
                //     foreach ($textsToTranslate['caption'] as $valuecap) {
                //         print("caption> ");
                //         print($valuecap."<br>");
                //     }
                // }
                // print("dan<br>");
                // if(isset($textsToTranslate['desk'])) {
                //     foreach ($textsToTranslate['desk'] as $i => $valuedesk) {
                //         print("deskripsi ".$i.">");
                //         print($valuedesk."<br>");
                //     }
                // }
                // print("<hr>");

                $translatedTexts = array();// ... batchTranslateTexts($textsToTranslate, $sourceLanguage);
                $translatedTexts['judul'] = 'kalimat';
                $translatedTexts['sub'] = 'kalimat';
                $translatedTexts['tgl'] = 'kalimat';
                $translatedTexts['caption'] = array();
                $translatedTexts['desk'] = array();
                $limit = 0;
                while($limit < 5){//
                    $kalimat = 'kalimat';
                    if($limit == 0) $kalimat = $textsToTranslate['judul'];
                    else if($limit == 1 && $textsToTranslate['sub'] != "sub") $kalimat = $textsToTranslate['sub'];
                    else if($limit == 2) $kalimat = $textsToTranslate['tgl'];
                    else if($limit == 3 && isset($textsToTranslate['caption'])) $kalimat = '';
                    else if($limit == 4) $kalimat = '';//deskripsi pasti ada

                    if($kalimat != 'kalimat') {
                        //backup plan, cara1 disini
                        $tr = new GoogleTranslate('id'); // Translates into English
                        if($limit < 4) {
                            $response = $tr->translate($kalimat);
                            if($limit == 0) $translatedTexts['judul'] = $response;
                            else if($limit == 1) $translatedTexts['sub'] = $response;
                            else if($limit == 2) $translatedTexts['tgl'] = $response;
                        }
                        else if($limit == 3) {
                            foreach ($textsToTranslate['caption'] as $c) {
                                $response = $tr->translate($c);
                                $translatedTexts['cap'] = $response;
                            }
                        }
                        else if($limit == 4){
                            foreach ($textsToTranslate['desk'] as $i => $d) {
                                $tag1 = strpos($d, '<');
                                $tag2 = strpos($d, '>');
                                if ($tag1 !== false && $tag2 !== false) {
                                    // $de = strip_tags($d);
                                    $de = str_replace(['<', '>'], '', $d);
                                    $d = $de;
                                }
                                $response = $tr->translate($d);
                                $translatedTexts['desk'][] = $response;
                            }
                        }
                    }
                    $limit+=1;
                }

                // print("j ".$translatedTexts['judul']."<br>");
                // print("s ".$translatedTexts['sub']."<br>");
                // print("t ".$translatedTexts['tgl']."<br>");
                // if(isset($translatedTexts['caption'])) {
                //     foreach ($translatedTexts['caption'] as $valuecap) {
                //         print("caption> ");
                //         print($valuecap."<br>");
                //     }
                // }
                // print("dan<br>");
                // foreach ($translatedTexts['desk'] as $i => $valuedesk) {
                //     print("deskripsi ".$i.">");
                //     print($valuedesk."<br>");
                // }
                // print("<hr>");

                //insert translatedtext
                // $urutan = 0;
                // $jumlah = count($translatedTexts['desk']);
                // if(count($translatedTexts['caption']) > count($translatedTexts['desk'])) $jumlah = count($translatedTexts['caption']);
                // $inserting = 0;
                // try{
                //     if($jumlah > 0){
                //         $countingtranslate = DB::table('terjemahan_berita')->where("berita_id","=", $dbase[$iterasi]->berita_id)->count();
                //         if($countingtranslate > 0 && $countingtranslate < $jumlah) { $urutan = $countingtranslate; $inserting = $countingtranslate; }
                //         // print("web ".$web." dan jumlah ".$jumlah." ke urutan ".$urutan." dan insert ".$inserting."<br>");
                //         while($urutan < $jumlah){
                //             $ins_cap = ''; $ins_desk = '';
                //             if(count($textsToTranslate['id']) > $urutan) $idkonten = $textsToTranslate['id'][$urutan];
                //             if(count($translatedTexts['caption']) > $urutan) $ins_cap = $translatedTexts['caption'][$urutan];
                //             if(count($translatedTexts['desk']) > $urutan) $ins_desk = $translatedTexts['desk'][$urutan];
                //             // print("id> ".$idkonten." ke cap> ".$ins_cap." terus deskripsi> ".$ins_desk."<br>");
                //             $db = DB::table('terjemahan_berita')->insert(
                //                 array(
                //                     'konten_id' => $idkonten,
                //                     'berita_id' => $idberita[$iterasi]->berita_id,
                //                     'urutan' => $urutan+1,
                //                     'tgl_publikasi_idn' => $translatedTexts['tgl'],
                //                     'judul_idn' => $translatedTexts['judul'],
                //                     'subjudul_idn' => $translatedTexts['sub'],
                //                     'deskripsi_idn' => $ins_desk,
                //                     'caption_idn' => $ins_cap) );//link untuk video youtube dari dsp
                //             if($db == 1) $inserting += 1;
                //             // else print(" Tidak Masuk > ".$urutan);
                //             $urutan += 1;
                //         }
                //         // print(" dari jumlah ".$jumlah." ke urutan ".$urutan." dan insert ".$inserting."<br>-------------------<br>");
                //         if($inserting == $jumlah) {
                //             $db = DB::table('berita')
                //                 ->where("berita_id","=", $idberita[$iterasi]->berita_id)
                //                 ->update( ["status" => 4] );
                //             // if($db == 1) print("<h4 style='margin:0'>Konten dengan ID ".$id." Berhasil Insert Konten</h4><a href='http://localhost:8000/konten/' class='btn'>Kembali</a>");
                //         }
                //     }
                // }
                // catch (\Throwable $e) {
                //     // $datakonten[] = ['id'=> $dbase[$iterasi]->berita_id,'status'=> 0];
                //     print("Terjadi kesalahan: " . $e->getMessage() . " ==> line " . $e->getLine());
                // }
                $iterasi+=1;
            }
            // print("selesai");
        }
        //opsi1
        // return redirect()->route('terjemahan',['web'=> $web]);
        //opsi return-2
        // $berita = [];
        // $dbase = DB::table('berita')
        //     ->where("web_id","=", $idweb)
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
        //     'web' => $web,
        //     'bhs' => 'kor',
        //     'ubah' => $ubah,//untuk ktm
        //     'berita' => $berita,
        //     'error' => $error,
        //     'pesan' => $pesan //normal: "Ambil Konten Berhasil";

        // ]);
    }
}


