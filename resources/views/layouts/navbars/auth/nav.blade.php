<!-- Navbar --> {{--  class navbar kalo posisi tetep waktu scroll dan ukuran main class pake max-height-vh-100: .. position-sticky blur shadow-blur mt-2 left-auto top-1 z-index-sticky ; id="navbarBlur"--}}
<nav data-scroll='true' navbar-scroll="true" class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-blur border-radius-xl left-auto bg-white">
    <div class="container-fluid py-1 px-3 bg-white border-radius-lg">
        <nav aria-label="breadcrumb">
            {{-- .. class='bg-gray-100 bg-transparent' style="background-color: #e3bef9;"> --}}
            <ol class="breadcrumb bg-white mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm text-dark">
                <a class="opacity-5 text-dark" href="{{ auth()->user()->role == 1 ? url('/berita-aggregator/grafik') : url('/berita/semua') }}">
                    {{ auth()->user()->role == 1 ? 'Admin' : (auth()->user()->role == 2 ? 'Penggemar' : 'Penjual') }}
                </a>
            </li>
            <li class="breadcrumb-item text-sm active text-capitalize text-dark" aria-current="page">
        	{{-- Route::get('konten-{web}/{status}', [MasterWebCrawler::class,'cekStatus']); --}}
                {{ ( Request::is('crawler/*') || Request::is('crawlering/*') ? 'Web Crawler ' :
                ( Request::is('konten/*') || Request::is('konten-*/*')
                    // ('-dsp/0') || Request::is('konten-dsp/1')
                    // || Request::is('konten-ktm/0') || Request::is('konten-ktm/1')|| Request::is('konten-ktm/2')
                    // || Request::is('konten-khd/0') || Request::is('konten-khd/1')
                    ? 'Catcher Konten Berita' :
                ( Request::is('deposito-koin') || Request::is('beli-koin') || Request::is('tukar-koin')
                    || Request::is('daftar-pengikut') ? str_replace('-', ' ', Request::path()) :
                ( Request::is('berita-aggregator/*') || Request::is('detail-aggregator') || Request::is('halaman-berita/*') ? 'Aggregator Berita' : //|| Request::is('berita-baca/*')
                ( Request::is('berita/*') || Request::is('cari-berita') || Request::is('lihat-berita/*') ? 'Berita Terbaru' :
                ( Request::is('sejarah-berita/*') || Request::is('cari-sejarah') ? 'Sejarah Bacaan' :
                ( Request::is('user/*') || Request::is('konfirmasi-penjual') ? 'Laporan Daftar User' :
                ( Request::is('user-profile') || Request::is('penjual/profile') || Request::is('penjual/registrasi') || Request::is('profile/admin') ? 'Profile' :
                ( Request::is('daftar-lelang') || Request::is('lihat-lelang/*') ? 'Daftar Lelang' :
                (  Request::is('sejarah-lelang') ? 'Sejarah Lelang' :
                ( Request::is('daftar-penjual/*') || Request::is('lihat-penjual/*') ? 'Daftar Penjual' :
                ( Request::is('master-lelang') || Request::is('form-lelang/*') || Request::is('penghasilan-lelang') || Request::is('daftar-penawar/*') ? 'Master Lelang' :
                ( Request::is('nota-koin/*') ? 'Nota Transaksi Koin' :
                ( Request::is('nota-lelang/*') ? 'Nota Lelang' :
                ( Request::is('transaksi-koin/*') ? 'Transaksi Koin' :
                ( Request::is('deposito/*') ? 'Laporan Transaksi Koin' :
                ( Request::is('lelang/*') ? 'Laporan Lelang' :
                ( Request::is('deposito-penggemar/*') || Request::is('deposito-penjual/*') || Request::is('detail-deposito/*') ? 'Detail Deposito' :
                ( Request::is('ongkir/*') || Request::is('ongkir') ? 'Cek Ongkos Pengiriman' :
                'Berubah'
                )))))))))))))))))))}}
            </li>
            </ol>
            <h6 class="font-weight-bolder mb-0 text-capitalize text-dark">
                {{ ( Request::is('*/dsp') || Request::is('*-dsp/*') ? 'Dispatch' :
                ( Request::is('*/ktm') || Request::is('*-ktm/*') ? 'The Korea Times' :
                ( Request::is('*/khd') || Request::is('*-khd/*') ? 'Korea Herald' :
                ( Request::is('berita-aggregator/*') ? 'Laporan Aggregator Konten Berita'.(Request::is('/grafik') ? ' (Dalam Grafik)' : '') :
                ( Request::is('detail-aggregator') ? 'Detail Laporan Aggregator' :
                ( Request::is('halaman-berita/*') ? 'Halaman Berita yang akan Ditampilkan' :
                 //Request::is('berita-baca/*') || Request::is('detail-baca') ? 'Daftar User Membaca Berita'.(Request::is('/grafik') ? ' (Dalam Grafik)' : '') :
                ( Request::is('*/semua') ?
                    ( Request::is('berita/semua') || Request::is('sejarah-berita/semua') ? 'Berita dari Semua Website Korea' :
                    'Daftar Penjual') :
                ( Request::is('cari-*') ? 'Cari Berita' :
                ( Request::is('lihat-berita/*') ? 'Membaca Berita' :
                ( Request::is('profile/admin') ? 'Admin' :
                ( Request::is('*/penggemar') || Request::is('deposito-penggemar/*') ? (
                    Request::is('deposito/penggemar') ? str_replace('/', ' ', Request::path()) : 'Penggemar') :
                ( Request::is('*/penjual') || Request::is('deposito-penjual/*') ? (
                    Request::is('deposito/penjual') ? str_replace('/', ' ', Request::path()) : 'Penjual') :
                ( Request::is('user-profile') || Request::is('penjual/profile') ? 'Profile Anda' :
                ( Request::is('penjual/registrasi') ? 'Registrasi Penjual' :
                ( Request::is('deposito-koin') || Request::is('daftar-pengikut') ? str_replace('-', ' ', Request::path())." Anda" :
                ( Request::is('beli-koin') || Request::is('tukar-koin') || Request::is('konfirmasi-penjual')
                    || Request::is('daftar-lelang') || Request::is('sejarah-lelang') ? str_replace('-', ' ', Request::path()) :
                ( Request::is('lihat-lelang/*') ? 'Lihat Lelang' :
                ( Request::is('daftar-penjual/semua') ? 'Semua Penjual yang Aktif' :
                ( Request::is('daftar-penjual/ikuti') ? 'Mengikuti Penjual' :
                ( Request::is('lihat-penjual/*') ? 'Lihat Penjual' :
                ( Request::is('nota-koin/*') || Request::is('detail-deposito/*')? 'Detail Nota' :
                ( Request::is('transaksi-koin/*') ? 'Detail Transaksi' :
                ( Request::is('koin/transaksi') ? 'Transaksi Koin' :
                ( Request::is('lelang/transaksi') ? 'Transaksi Penghasilan Lelang' :
                ( Request::is('lelang/daftar') ? 'Daftar Lelang' :
                // ( Request::is('lelang/laporan') ? 'Lampiran Lelang' :
                ( Request::is('master-lelang') ? 'Semua Daftar Lelang yang dibuat' :
                ( Request::is('form-lelang/baru') ? 'Buat Lelang Baru' :
                ( Request::is('form-lelang/*') ? 'Ubah Lelang' :
                ( Request::is('penghasilan-lelang') ? 'Penghasilan Lelang' :
                ( Request::is('daftar-penawar/*') ? 'Daftar Semua Penawar pada Lelang' :
                ( Request::is('ongkir/*') || Request::is('ongkir') ? 'Cek Ongkos Pengiriman' :
                    'Berubah'
                )))))))))))))))))))))))))))))))}}
            </h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar">
            {{-- <div class="nav-item d-flex align-self-end">
                <a href="/documentation/getting-started/overview.html" target="_blank" class="btn bg-gradient-dark active mb-0 text-black" role="button" aria-pressed="true">
                    Dokumentasi <!-- https://www.creative-tim.com/product/soft-ui-dashboard-laravel, Download -->
                </a>
            </div>
            <div class="ms-md-3 pe-md-3 d-flex align-items-center">
            <div class="input-group">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="Ketik disini...">
            </div>
            </div>--}}
            <ul class="navbar-nav justify-content-end">
            @if(auth()->user()->role == 3)
            <li class="nav-item d-flex align-items-center ps-4">
                <a href="{{ url('/master-lelang/semua') }}" class="nav-link text-body font-weight-bold px-0">
                    <i class="fas fa-store text-gradient text-primary px-1 me-sm-1"></i>
                    <span class="d-sm-inline d-none text-dark p-0 pe-1">Master Lelang</span>
                </a>
            </li>
            <li class="nav-item d-flex align-items-center ps-4">
                <a href="{{ url('/daftar-pengikut') }}" class="nav-link text-body font-weight-bold px-0">
                    <i class="fas fa-users text-gradient text-info px-1 me-sm-1"></i>
                    <span class="d-sm-inline d-none text-dark p-0 pe-1">Pengikut Anda</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->role != 1)
            <li class="nav-item d-flex align-items-center ps-4">
                <a href="{{ url('/deposito-koin') }}" class="nav-link text-body font-weight-bold px-0">
                    <i class="fas fa-wallet text-gradient text-warning px-1 me-sm-1"></i>
                    <span class="d-sm-inline d-none text-dark p-0 pe-1">Deposito Anda</span>
                </a>
            </li>
            @endif
            <li class="nav-item d-flex align-items-center ps-4">
                <a href="{{ auth()->user()->role == 1 ? url('/profile/admin') : url('/user-profile') }}" class="nav-link text-body font-weight-bold px-0">
                    <i class="fas fa-user-edit text-dark px-1 me-sm-1"></i>
                    <span class="d-sm-inline d-none text-dark p-0 pe-1">{{ auth()->user()->nama }}</span>
                </a>
            </li>
            <li class="nav-item d-flex align-items-center ps-4">
                <a href="{{ url('/logout')}}" target="_blank" class="nav-link text-body font-weight-bold px-0">
                    <i class="fas fa-door-open text-gradient text-danger px-1 me-sm-1"></i>
                    <span class="d-sm-inline d-none text-dark p-0 pe-1">Keluar</span>
                </a>
            </li>
            <li class="nav-item d-xl-none px-3 d-flex align-items-center"><!--awalnya ps-3 jd px-3-->
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                </div>
                </a>
            </li>
            {{-- <li class="nav-item px-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                </a>
            </li>
            <li class="nav-item dropdown px-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer"></i>
                </a>
                <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                    <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                        <!-- <div class="my-auto">
                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                        </div> -->
                        <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                        <svg width="12px" height="12px" viewBox="0 0 46 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>customer-support</title>
                            <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Rounded-Icons" transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                    <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                                        <g id="customer-support" transform="translate(1.000000, 0.000000)">
                                            <path class="color-background" d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z" id="Path" opacity="0.59858631"></path>
                                            <path class="color-foreground" d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z" id="Path"></path>
                                            <path class="color-foreground" d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z" id="Path"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                            <span class="font-weight-bold">New message</span> from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                            <i class="fa fa-clock me-1"></i>
                            13 minutes ago
                        </p>
                        </div>
                    </div>
                    </a>
                </li>
                <li class="mb-2">
                    <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                        <div class="my-auto">
                        <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                            <span class="font-weight-bold">New album</span> by Travis Scott
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                            <i class="fa fa-clock me-1"></i>
                            1 day
                        </p>
                        </div>
                    </div>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                        <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>credit-card</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(453.000000, 454.000000)">
                                    <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                    <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                </g>
                                </g>
                            </g>
                            </g>
                        </svg>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                            Payment successfully completed
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                            <i class="fa fa-clock me-1"></i>
                            2 days
                        </p>
                        </div>
                    </div>
                    </a>
                </li>
                </ul>
            </li>--}}
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
