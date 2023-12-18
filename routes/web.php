<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ControllerBerita;
use App\Http\Controllers\ControllerLelang;
use App\Http\Controllers\ControllerTransaksiKoin;
// use App\Http\Controllers\ControllerUserProfile;
use App\Http\Controllers\MasterWebCrawler;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\MasterLelang;
use App\Http\Controllers\MasterTransaksiKoin;
use App\Http\Controllers\MasterUsers;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('all/dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('all/billing');
	})->name('billing');

	// Route::get('profile', function () {
	// 	return view('profile');
	// })->name('profile');

	// Route::get('rtl', function () {
	// 	return view('rtl');
	// })->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('all/tables');
	})->name('tables');

    // Route::get('virtual-reality', function () {
	// 	return view('virtual-reality');
	// })->name('virtual-reality');

    // Route::get('static-sign-in', function () {
	// 	return view('static-sign-in');
	// })->name('sign-in');

    // Route::get('static-sign-up', function () {
	// 	return view('static-sign-up');
	// })->name('sign-up');

    // Route::get('/login', function () {
	// 	return view('dashboard');
	// })->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);

	//admin, controller crawlering = all berita, search by option (unknown) >> tampilin dg tabel, web = dsp/ktm/khd
    //master...
    Route::get('profile/admin', [MasterUsers::class,'create']);
    Route::post('profile/admin', [MasterUsers::class,'store']);
    Route::get('crawler/{web}', [MasterWebCrawler::class,'getStart']);
    Route::get('crawlering/{web}', [MasterWebCrawler::class,'getCrawler']);
	Route::get('konten/{web}', [MasterWebCrawler::class,'getLinks'])->name('konten');
	Route::get('konten-dsp/{status}', [MasterWebCrawler::class,'cekStatusDSP']);
	Route::get('konten-ktm/{status}', [MasterWebCrawler::class,'cekStatusKTM']);
	Route::get('konten-khd/{status}', [MasterWebCrawler::class,'cekStatusKHD']);
	Route::post('select/ktm', [MasterWebCrawler::class,'selectingKonten']);
	Route::post('getting/{web}', [MasterWebCrawler::class,'getKonten']);
	// Route::get('terjemahan/{web}', [MasterWebCrawler::class,'gettingLinks'])->name('terjemahan');
	// Route::get('translating/{web}', [MasterWebCrawler::class,'getTranslate']);
    Route::get('berita-aggregator/{web}', [MasterWebCrawler::class,'getAggregator'])->name('aggregator');
    Route::post('detail-aggregator', [MasterWebCrawler::class,'detailAggregator']);
    Route::get('halaman-berita/{id}',[MasterWebCrawler::class,'lihatHalaman'])->name('lihatHalaman');
    Route::get('status-link/{id}', [MasterWebCrawler::class,'ubahLink']);
    Route::get('user/{user}', [MasterUsers::class,'getDaftarUser'])->name('daftarUser');//user: penggemar/penjual
    Route::get('status/{user}/{id}', [MasterUsers::class,'ubahStatus']);//user: penggemar/penjual
    Route::get('konfirmasi-penjual', [MasterUsers::class,'konfirmasiPenjual'])->name('konfirmasi');
    Route::post('konfirmasi', [MasterUsers::class,'ubahKonfirmasi']);
    Route::get('lelang/{jenis}', [MasterLelang::class,'getLelang'])->name('semuaLelang');//jenis: daftar/transaksi/laporan?
    Route::get('detail-lelang/{id}', [MasterLelang::class,'detailLelang'])->name('detailLelang');
    Route::post('perbaikan-lelang', [MasterLelang::class,'perbaikanLelang']);
    Route::get('non-aktif/{id}',[MasterLelang::class,'nonaktifLelang']);
    Route::get('transaksi-lelang/{id}', [MasterLelang::class,'transaksiLelang']);
    Route::get('deposito/{user}', [MasterTransaksiKoin::class,'getDeposito'])->name('dataDepo');//user: penggemar/penjual
    Route::get('deposito-penggemar/{id}', [MasterTransaksiKoin::class,'userDeposito']);//user: penggemar
    Route::get('deposito-penjual/{id}', [MasterTransaksiKoin::class,'userDeposito']);//user: penjual
    Route::post('transfer-koin', [MasterTransaksiKoin::class,'tukarDepo']);//user: penggemar/penjual
    Route::get('detail-deposito/{id}', [MasterTransaksiKoin::class,'notaDepo'])->name('notaDepo');//user: penggemar/penjual

    //penggemar dan penjual
    //controller...
    Route::get('/user-profile', [InfoUserController::class, 'create']);//semua user, dengan beda mode di function
	Route::post('/user-profile', [InfoUserController::class, 'store']);//semua user, dengan beda mode di function
    Route::get('berita/{web}', [ControllerBerita::class,'getBerita'])->name('berita');
    Route::post('cari-berita', [ControllerBerita::class,'cariBerita']);
    Route::get('lihat-berita/{id}', [ControllerBerita::class,'bukaBerita'])->name('lihatberita');
    Route::get('suka-berita/{mode}/{id}', [ControllerBerita::class,'sukaBerita']);//langsung kembali bukaberita
    Route::get('sejarah-berita/{web}', [ControllerBerita::class,'getSejarahBerita'])->name('sejarahberita');
    Route::post('cari-sejarah', [ControllerBerita::class,'cariBacaan']);
    Route::get('daftar-lelang', [ControllerLelang::class,'getAllLelang'])->name('daftarLelang');
    Route::post('filter-lelang', [ControllerLelang::class,'filterLelang']);
    Route::get('lihat-lelang/{id}', [ControllerLelang::class,'lihatLelang']);
    Route::get('daftar-penjual/{mode}', [ControllerLelang::class,'getPenjual'])->name('daftarPenjual');
    Route::get('ikuti-penjual/{id}', [ControllerLelang::class,'ikutiPenjual']);
    Route::post('ikut-lelang', [ControllerLelang::class,'ikutLelang']);
    // Route::get('pengikut-lelang/{id}', [ControllerLelang::class,'pengikutLelang']);
    Route::get('sejarah-lelang', [ControllerLelang::class,'sejarahLelang']);
    Route::post('filter-sejarah', [ControllerLelang::class,'filterSejarah']);
    Route::get('deposito-koin', [ControllerTransaksiKoin::class,'getDeposito'])->name('deposito');
    Route::get('beli-koin', [ControllerTransaksiKoin::class,'beliKoin'])->name('beli');
    Route::post('beli-koin', [ControllerTransaksiKoin::class,'buatBeli']);
    Route::get('tukar-koin', [ControllerTransaksiKoin::class,'tukarKoin']);
    Route::post('tukar-koin', [ControllerTransaksiKoin::class,'buatTukar']);
    Route::get('nota-koin/{id}', [ControllerTransaksiKoin::class,'notaKoin'])->name('nota');
    Route::get('transaksi-koin/{id}', [ControllerTransaksiKoin::class,'lihatTransaksi'])->name('lihatTransaksi');
    Route::get('transaksi-ulang/{id}', [ControllerTransaksiKoin::class,'transaksiUlang']);
    Route::post('bayar-lelang', [ControllerTransaksiKoin::class,'bayarLelang']);//lelang
    Route::post('kirim-alamat', [ControllerTransaksiKoin::class,'kirimAlamat']);

    //tambahan penjual
    Route::get('penjual/{mode}', [InfoUserController::class, 'getPenjual']); //dan penggemar jadi penjual (registrasi)
	Route::post('edit-penjual', [InfoUserController::class, 'ubahPenjual']); //dan penggemar jadi penjual (registrasi)
    Route::get('master-lelang/{status}', [ControllerLelang::class,'masterLelang']);
    Route::get('form-lelang/{id}', [ControllerLelang::class,'formLelang'])->name('formLelang');
    Route::post('isi-lelang', [ControllerLelang::class,'isiLelang']);
    Route::get('penghasilan-lelang', [ControllerLelang::class,'getPenghasilan']);
    Route::get('daftar-pengikut',[ControllerLelang::class,'getPengikut']);
    Route::get('daftar-penawar/{id}',[ControllerLelang::class,'getPenawarLelang']);
    Route::post('/status-pengiriman', [ControllerTransaksiKoin::class,'statusPengiriman']);
    Route::get('/ongkir/{idlelang}', [ControllerTransaksiKoin::class,'getOngkir'])->name('ongkir');
    Route::post('/ongkir', [ControllerTransaksiKoin::class,'cekOngkir']);
    Route::post('/set-ongkir', [ControllerTransaksiKoin::class,'bayarOngkir']);
    Route::get('/kota/{provinsi}', [ControllerTransaksiKoin::class,'getKota']);
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	// Route::get('/login/forgot-password', [ResetController::class, 'create']);
	// Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password', [ResetController::class, 'resetPass'])->name('password.reset');// /{token}
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');
