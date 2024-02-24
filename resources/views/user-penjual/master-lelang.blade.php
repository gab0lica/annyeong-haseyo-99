
@extends('layouts.user_type.auth')

@section('content')
<div class="row">
    <div class="container-fluid">
        <div class="page-header min-height-200 border-radius-xl mt-2" style="background-image: url('../assets/img/home-decor-3.jpg'); background-position-y: 50%;">
            <span class="mask bg-gradient-dark opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ auth()->user()->gambar_profile != null || auth()->user()->gambar_profile != '' ? auth()->user()->gambar_profile : '../pic/uni-user-4.png' }}" alt="..."
                          class="w-100 border-radius-lg shadow-sm bg-gradient-dark">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h4 class="text-dark font-weight-bolder m-0">Master Lelang</h4>
                        <h6 class="mb-1">
                            {{ auth()->user()->nama }} {{--  __('Alec Thompson') --}}
                        </h6>
                    </div>
                </div>
                <div class="col-auto text-end my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 px-5"><!--col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3-->
                    <h6 class="mb-1">
                        @php
                            $inggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                            $indonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        @endphp
                        {{ str_replace($inggris,$indonesia,date('d F Y H:i:s',strtotime($hari_ini))) }}
                    </h6>
                    <h6 class="mb-0 text-lg font-weight-bold">
                        <i class="fas fa-coins text-warning text-gradient text-lg p-1"></i> {{ $koin }} Koin
                    </h6>
                    <h6 class="mb-0 text-lg font-weight-bold">
                        <i class="fas fa-users text-info text-gradient opacity-10 px-2"></i> {{ $pengikut }} Pengikut
                        {{-- @if($koin <= 0 && $pesan != 'penggemar')<span class="font-weight-bold text-danger text-sm">(Anda harus Membeli Koin untuk Registrasi)</span>@endif --}}
                    </h6>
                </div>
            </div>
        </div>
    </div>

{{-- profile.blade.php >> lebih banyak isinya --}}
    <div class="container-fluid py-3">
        <div class="row">
            <div class="card h-100">
                <div class="card-body p-3">
                    {{-- <ul class="list-group"> --}}
                        {{-- @php
                            $coba = rand(0,6);//kalo sudah ada lelang, dimatikan
                        @endphp --}}
                    <div class="row">
                        <h5 class="text-dark text-gradient font-weight-bolder col-md-7">
                            @if(count($lelang) == 0)
                                {{Request::is('master-lelang/semua') ? 'Lelang Belum Dibuat' : 'Tidak ada Lelang Sesuai Filter'}}
                            @else
                                Urut Berdasarkan Tanggal Lelang Dibuat Sesuai Filter <span class="ps-3 font-weight-bolder text-dark text-gradient mb-2 text-sm">({{count($lelang)}} Lelang)</span>
                            @endif
                        </h5>
                        <div class="row col-md-5 text-end my-1">
                            <div class="col-md-8">
                                <a href="{{ url('/penghasilan-lelang') }}" class="btn bg-gradient-primary mx-auto">
                                    Penghasilan Anda <i class="fas fa-lg fa-chart-bar ps-2 pe-2 text-center text-white" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="#" class="btn bg-gradient-dark dropdown-toggle " data-bs-toggle="dropdown" id="navbarDropdownMenuLink">
                                    {{Request::is('master-lelang/semua') ? 'Semua Lelang' :
                                    (Request::is('master-lelang/belum') ? 'Belum Dirilis' :
                                    (Request::is('master-lelang/berjalan') ? 'Sedang Berjalan' :
                                    (Request::is('master-lelang/selesai') ? 'Selesai' :
                                    (Request::is('master-lelang/peringatan') ? 'Peringatan' :
                                    'Pilih Status Lelang' )))) }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li>
                                        <a class="dropdown-item {{ Request::is('master-lelang/semua') ? 'font-weight-bolder' : '' }}"
                                        href="{{ url('/master-lelang/semua')}}">
                                        Semua Lelang
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ Request::is('master-lelang/belum') ? 'font-weight-bolder' : '' }}"
                                        href="{{ url('/master-lelang/belum')}}">
                                        Belum Dirilis
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ Request::is('master-lelang/berjalan') ? 'font-weight-bolder' : '' }}"
                                        href="{{ url('/master-lelang/berjalan')}}">
                                        Sedang Berjalan
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ Request::is('master-lelang/selesai') ? 'font-weight-bolder' : '' }}"
                                        href="{{ url('/master-lelang/selesai')}}">
                                        Selesai
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ Request::is('master-lelang/peringatan') ? 'font-weight-bolder' : '' }}"
                                        href="{{ url('/master-lelang/peringatan')}}">
                                        Peringatan
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- add new --}}
                        {{-- <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
                            <div class="column mb-3">
                            <div class="col-xl-12 col-md-6 mb-xl-0">
                                <a href="{{url('/form-lelang/baru')}}" class="">
                                    <div class="card h-100 w-100 card-plain border m-0">
                                    <div class="card-body d-flex flex-column justify-content-center text-center">
                                        <i class="fa fa-plus text-secondary mb-2"></i>
                                        <h5 class=" text-secondary">Buat Lelang Baru</h5>
                                    </div>
                                    </div>
                                </a>
                            </div>
                            </div>
                        </div> --}}
                        {{-- end add new --}}
                        @if(count($lelang) > 0)
                        <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
                            @for ($i = 0; $i < count($lelang); $i+=2)
                            @php
                                $item = $lelang[$i];
                            @endphp
                            @if ($i == 0)
                            {{-- buat lelang baru --}}
                            <div class="column mb-3">
                                <div class="col-xl-12 col-md-6 mb-xl-0">
                                    <a href="{{url('/form-lelang/baru')}}" class="">
                                        <div class="card h-100 w-100 card-plain border m-0">
                                        <div class="card-body d-flex flex-column justify-content-center text-center">
                                            <i class="fa fa-plus text-secondary mb-2"></i>
                                            <h5 class=" text-secondary">Buat Lelang Baru</h5>
                                        </div>
                                        </div>
                                    </a>
                                </div>
                                </div>
                            </div>
                            {{-- lelang lainnya --}}
                            <div class="column mb-3">
                            <div class="col-xl-12 col-md-6 mb-xl-0">
                            <div class="card card-blog card-plain pb-0 p-3">
                                <div class="position-relative">
                                    <a class="d-block shadow-xl border-radius-xl" target="" href="{{url('/form-lelang/'.$item['id'])}}" class="btn bg-gradient-info btn-sm mb-0 btn-rounded" title='Lelang'>
                                    <img src="{{$item['gambar']}}" alt="Ubah Lelang" class="img-fluid shadow border-radius-xl">
                                    </a>
                                </div>
                                <div class="card-body pb-0 p-3">
                                    {{-- <a href="javascript:;"> --}}
                                        <div class="row">
                                            <h5 class="col-md-7">
                                                {{$item['judul']}}
                                            </h5>
                                            <span class="col-md-5 text-end text-secondary mb-1 text-sm">{{$item['kategori']}}</span>
                                        </div>
                                    {{-- </a> --}}
                                    <p class="mb-3 text-lg">
                                        <i class="fas fa-map-pin text-info text-gradient pe-3 p-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Kota {{auth()->user()->kota}}</span><br>
                                        <i class="fas fa-coins text-warning text-gradient me-2 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['koin']}} Koin</span><br>
                                        <i class="fas fa-hourglass-start text-primary text-gradient me-3" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ str_replace($inggris,$indonesia,date('d F Y H:i',strtotime($item['mulai']))) }}</span><br>
                                        <i class="fas fa-hourglass-end text-secondary me-3" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ str_replace($inggris,$indonesia,date('d F Y H:i',strtotime($item['selesai']))) }}</span><br>
                                        <i class="fas fa-file-signature text-info text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['detail']}}</span><br>
                                        <i class="fas fa-edit text-dark text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['buat']}}</span><br>
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="{{url('/form-lelang/'.$item['id'])}}" class="btn bg-gradient-{{$item['status'] == 3 ? 'success' : ($item['status'] == 0 || $item['status'] == 2 ? 'danger' : ($item['pesan'] == 'belum-penawar' ? 'warning' : 'info'))}} btn-sm mb-0 btn-rounded" title='Lelang'>
                                            {{$item['status'] == 3 ? 'Lihat Hasil' : ($item['status'] == 0 || $item['status'] == 2 ? 'Perbaiki' : ($item['pesan'] == 'belum-penawar' ? 'Ubah' : 'Lihat'))}} Lelang
                                        </a>
                                        <div class="avatar-group">
                                            @if($item['ikut'] > 0)
                                                <span class="font-weight-bold text-lg">{{$item['ikut'] > 4 ? $item['ikut'] : ''}}</span>
                                                @for ($k = 0; $k < ($item['ikut'] > 4 ? 1 : $item['ikut']); $k++)
                                                <a href="{{url('/daftar-penawar/'.$item['id'])}}" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Semua Penawar yang Ikut'>
                                                <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                                </a>
                                                @endfor
                                            @else
                                                <span class="font-weight-bold text-lg">0</span>
                                                <a href="#" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Semua Penawar yang Ikut'>
                                                    <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                            @else
                            <div class="column mb-3">
                            <div class="col-xl-12 col-md-6 mb-xl-0">
                            <div class="card card-blog card-plain pb-0 p-3">
                                <div class="position-relative">
                                    <a class="d-block shadow-xl border-radius-xl" target="" href="{{url('/form-lelang/'.$item['id'])}}" class="btn bg-gradient-info btn-sm mb-0 btn-rounded" title='Lelang'>
                                    <img src="{{$item['gambar']}}" alt="Ubah Lelang" class="img-fluid shadow border-radius-xl">
                                    </a>
                                </div>
                                <div class="card-body pb-0 p-3">
                                    {{-- <a href="javascript:;"> --}}
                                        <div class="row">
                                            <h5 class="col-md-7">
                                                {{$item['judul']}}
                                            </h5>
                                            <span class="col-md-5 text-end text-secondary mb-1 text-sm">{{$item['kategori']}}</span>
                                        </div>
                                    {{-- </a> --}}
                                    <p class="mb-3 text-lg">
                                        <i class="fas fa-map-pin text-info text-gradient pe-3 p-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Kota {{auth()->user()->kota}}</span><br>
                                        <i class="fas fa-coins text-warning text-gradient me-2 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['koin']}} Koin</span><br>
                                        <i class="fas fa-hourglass-start text-primary text-gradient me-3" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ str_replace($inggris,$indonesia,date('d F Y H:i',strtotime($item['mulai']))) }}</span><br>
                                        <i class="fas fa-hourglass-end text-secondary me-3" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ str_replace($inggris,$indonesia,date('d F Y H:i',strtotime($item['selesai']))) }}</span><br>
                                        <i class="fas fa-file-signature text-info text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['detail']}}</span><br>
                                        <i class="fas fa-edit text-dark text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['buat']}}</span><br>
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="{{url('/form-lelang/'.$item['id'])}}" class="btn bg-gradient-{{$item['status'] == 3 ? 'success' : ($item['status'] == 0 || $item['status'] == 2 ? 'danger' : ($item['pesan'] == 'belum-penawar' ? 'warning' : 'info'))}} btn-sm mb-0 btn-rounded" title='Lelang'>
                                            {{$item['status'] == 3 ? 'Lihat Hasil' : ($item['status'] == 0 || $item['status'] == 2 ? 'Perbaiki' : ($item['pesan'] == 'belum-penawar' ? 'Ubah' : 'Lihat'))}} Lelang
                                        </a>
                                        <div class="avatar-group">
                                            @if($item['ikut'] > 0)
                                                <span class="font-weight-bold text-lg">{{$item['ikut'] > 4 ? $item['ikut'] : ''}}</span>
                                                @for ($k = 0; $k < ($item['ikut'] > 4 ? 1 : $item['ikut']); $k++)
                                                <a href="{{url('/daftar-penawar/'.$item['id'])}}" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Semua Penawar yang Ikut'>
                                                <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                                </a>
                                                @endfor
                                            @else
                                                <span class="font-weight-bold text-lg">0</span>
                                                <a href="#" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Semua Penawar yang Ikut'>
                                                    <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                            @endif
                            @endfor
                        </div>
                        <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
                            @for ($i = 1; $i < count($lelang); $i+=2)
                            @php
                                $item = $lelang[$i];
                            @endphp
                            <div class="column mb-3">
                            <div class="col-xl-12 col-md-6 mb-xl-0">
                                <div class="card card-blog card-plain pb-0 p-3">
                                    <div class="position-relative">
                                        <a class="d-block shadow-xl border-radius-xl" target="" href="{{url('/form-lelang/'.$item['id'])}}" class="btn bg-gradient-info btn-sm mb-0 btn-rounded" title='Lelang'>
                                        <img src="{{$item['gambar']}}" alt="Ubah Lelang" class="img-fluid shadow border-radius-xl">
                                        </a>
                                    </div>
                                    <div class="card-body pb-0 p-3">
                                        {{-- <a href="javascript:;"> --}}
                                            <div class="row">
                                                <h5 class="col-md-7">
                                                    {{$item['judul']}}
                                                </h5>
                                                <span class="col-md-5 text-end text-secondary mb-1 text-sm">{{$item['kategori']}}</span>
                                            </div>
                                        {{-- </a> --}}
                                        <p class="mb-3 text-lg">
                                            <i class="fas fa-map-pin text-info text-gradient pe-3 p-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Kota {{auth()->user()->kota}}</span><br>
                                            <i class="fas fa-coins text-warning text-gradient me-2 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['koin']}} Koin</span><br>
                                            <i class="fas fa-hourglass-start text-primary text-gradient me-3" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ str_replace($inggris,$indonesia,date('d F Y H:i',strtotime($item['mulai']))) }}</span><br>
                                            <i class="fas fa-hourglass-end text-secondary me-3" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ str_replace($inggris,$indonesia,date('d F Y H:i',strtotime($item['selesai']))) }}</span><br>
                                            <i class="fas fa-file-signature text-info text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['detail']}}</span><br>
                                            <i class="fas fa-edit text-dark text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['buat']}}</span><br>
                                        </p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="{{url('/form-lelang/'.$item['id'])}}" class="btn bg-gradient-{{$item['status'] == 3 ? 'success' : ($item['status'] == 0 || $item['status'] == 2 ? 'danger' : ($item['pesan'] == 'belum-penawar' ? 'warning' : 'info'))}} btn-sm mb-0 btn-rounded" title='Lelang'>
                                                {{$item['status'] == 3 ? 'Lihat Hasil' : ($item['status'] == 0 || $item['status'] == 2 ? 'Perbaiki' : ($item['pesan'] == 'belum-penawar' ? 'Ubah' : 'Lihat'))}} Lelang
                                            </a>
                                            <div class="avatar-group">
                                                @if($item['ikut'] > 0)
                                                    <span class="font-weight-bold text-lg">{{$item['ikut'] > 4 ? $item['ikut'] : ''}}</span>
                                                    @for ($k = 0; $k < ($item['ikut'] > 4 ? 1 : $item['ikut']); $k++)
                                                    <a href="{{url('/daftar-penawar/'.$item['id'])}}" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Semua Penawar yang Ikut'>
                                                    <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                                    </a>
                                                    @endfor
                                                @else
                                                    <span class="font-weight-bold text-lg">0</span>
                                                    <a href="#" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Semua Penawar yang Ikut'>
                                                        <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            @endfor
                        </div>
                        <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
                            @for ($i = 2; $i < count($lelang); $i+=2)
                            @php
                                $item = $lelang[$i];
                            @endphp
                            <div class="column mb-3">
                            <div class="col-xl-12 col-md-6 mb-xl-0">
                                <div class="card card-blog card-plain pb-0 p-3">
                                    <div class="position-relative">
                                        <a class="d-block shadow-xl border-radius-xl" target="" href="{{url('/form-lelang/'.$item['id'])}}" class="btn bg-gradient-info btn-sm mb-0 btn-rounded" title='Lelang'>
                                        <img src="{{$item['gambar']}}" alt="Ubah Lelang" class="img-fluid shadow border-radius-xl">
                                        </a>
                                    </div>
                                    <div class="card-body pb-0 p-3">
                                        {{-- <a href="javascript:;"> --}}
                                            <div class="row">
                                                <h5 class="col-md-7">
                                                    {{$item['judul']}}
                                                </h5>
                                                <span class="col-md-5 text-end text-secondary mb-1 text-sm">{{$item['kategori']}}</span>
                                            </div>
                                        {{-- </a> --}}
                                        <p class="mb-3 text-lg">
                                            <i class="fas fa-map-pin text-info text-gradient pe-3 p-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Kota {{auth()->user()->kota}}</span><br>
                                            <i class="fas fa-coins text-warning text-gradient me-2 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['koin']}} Koin</span><br>
                                            <i class="fas fa-hourglass-start text-primary text-gradient me-3" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ str_replace($inggris,$indonesia,date('d F Y H:i',strtotime($item['mulai']))) }}</span><br>
                                            <i class="fas fa-hourglass-end text-secondary me-3" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ str_replace($inggris,$indonesia,date('d F Y H:i',strtotime($item['selesai']))) }}</span><br>
                                            <i class="fas fa-file-signature text-info text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['detail']}}</span><br>
                                            <i class="fas fa-edit text-dark text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['buat']}}</span><br>
                                        </p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="{{url('/form-lelang/'.$item['id'])}}" class="btn bg-gradient-{{$item['status'] == 3 ? 'success' : ($item['status'] == 0 || $item['status'] == 2 ? 'danger' : ($item['pesan'] == 'belum-penawar' ? 'warning' : 'info'))}} btn-sm mb-0 btn-rounded" title='Lelang'>
                                                {{$item['status'] == 3 ? 'Lihat Hasil' : ($item['status'] == 0 || $item['status'] == 2 ? 'Perbaiki' : ($item['pesan'] == 'belum-penawar' ? 'Ubah' : 'Lihat'))}} Lelang
                                            </a>
                                            <div class="avatar-group">
                                                @if($item['ikut'] > 0)
                                                    <span class="font-weight-bold text-lg">{{$item['ikut'] > 4 ? $item['ikut'] : ''}}</span>
                                                    @for ($k = 0; $k < ($item['ikut'] > 4 ? 1 : $item['ikut']); $k++)
                                                    <a href="{{url('/daftar-penawar/'.$item['id'])}}" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Semua Penawar yang Ikut'>
                                                    <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                                    </a>
                                                    @endfor
                                                @else
                                                    <span class="font-weight-bold text-lg">0</span>
                                                    <a href="#" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Semua Penawar yang Ikut'>
                                                        <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            @endfor
                        </div>
                        @endif

                        {{-- aslinya --}}
                        {{--
                        @foreach ($lelang as $item)
                        <div class="col-12 col-xl-4">
                            <div class="card card-blog card-plain pb-0 p-3">
                                <div class="position-relative">
                                    <a class="d-block shadow-xl border-radius-xl" target="" href="{{url('/form-lelang/'.$item['id'])}}" class="btn bg-gradient-info btn-sm mb-0 btn-rounded" title='Lelang'>
                                    <img src="{{$item['gambar']}}" alt="Ubah Lelang" class="img-fluid shadow border-radius-xl">
                                    </a>
                                </div>
                                <div class="card-body pb-0 p-3">
                                        <div class="row">
                                            <h5 class="col-md-7">
                                                {{$item['judul']}}
                                            </h5>
                                            <span class="col-md-5 text-end text-secondary mb-1 text-sm">{{$item['kategori']}}</span>
                                        </div>
                                    <p class="mb-3 text-lg">
                                        <i class="fas fa-map-pin text-info text-gradient pe-3 p-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Kota {{auth()->user()->kota}}</span><br>
                                        <i class="fas fa-coins text-warning text-gradient me-2 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['koin']}} Koin</span><br>
                                        <i class="fas fa-hourglass-start text-primary text-gradient me-3" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ str_replace($inggris,$indonesia,date('d F Y H:i',strtotime($item['mulai']))) }}</span><br>
                                        <i class="fas fa-hourglass-end text-secondary me-3" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ str_replace($inggris,$indonesia,date('d F Y H:i',strtotime($item['selesai']))) }}</span><br>
                                        <i class="fas fa-file-signature text-info text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['detail']}}</span><br>
                                        <i class="fas fa-edit text-dark text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{$item['buat']}}</span><br>
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="{{url('/form-lelang/'.$item['id'])}}" class="btn bg-gradient-{{$item['status'] == 3 ? 'success' : ($item['status'] == 0 || $item['status'] == 2 ? 'danger' : ($item['pesan'] == 'belum-penawar' ? 'warning' : 'info'))}} btn-sm mb-0 btn-rounded" title='Lelang'>
                                            {{$item['status'] == 3 ? 'Lihat Hasil' : ($item['status'] == 0 || $item['status'] == 2 ? 'Perbaiki' : ($item['pesan'] == 'belum-penawar' ? 'Ubah' : 'Lihat'))}} Lelang
                                        </a>
                                        <div class="avatar-group">
                                            @if($item['ikut'] > 0)
                                                <span class="font-weight-bold text-lg">{{$item['ikut'] > 4 ? $item['ikut'] : ''}}</span>
                                                @for ($k = 0; $k < ($item['ikut'] > 4 ? 1 : $item['ikut']); $k++)
                                                <a href="{{url('/daftar-penawar/'.$item['id'])}}" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Semua Penawar yang Ikut'>
                                                <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                                </a>
                                                @endfor
                                            @else
                                                <span class="font-weight-bold text-lg">0</span>
                                                <a href="#" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Semua Penawar yang Ikut'>
                                                    <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

