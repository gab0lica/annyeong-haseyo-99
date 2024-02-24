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
                        {{-- <h4 class="text-dark font-weight-bolder m-0">Daftar Penjual</h4> --}}
                        <h6 class="mb-1">
                            {{ auth()->user()->nama }} {{--  __('Alec Thompson') --}}
                        </h6>
                        <h6 class="mb-0 text-lg font-weight-bold">
                            <i class="fas fa-coins text-warning text-gradient text-lg p-1"></i> {{ $koin }} Koin
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
                    {{-- @if (auth()->user()->role == 3)
                    <h6 class="mb-0 text-lg font-weight-bold">
                        <i class="fas fa-users text-info text-gradient opacity-10 px-2"></i> {{ $pengikut }} Pengikut
                    </h6>
                    @else --}}
                    <h6 class="mb-0 text-lg font-weight-bold">
                        <i class="fas fa-{{ Request::is('daftar-penjual/ikuti') ? 'users' : 'check'}} text-gradient text-success opacity-10 px-2"></i>
                        @if(Request::is('daftar-penjual/ikuti'))
                        {{ count($penjual) }} Penjual
                        @else
                        {{ $ikutlelang }} Lelang
                        @endif
                         yang Diikuti
                    </h6>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid text-center">
        <hr class="horizontal dark my-4">
        <h4 class="text-dark px-2 font-weight-bolder m-0">Daftar Penjual</h4>
        {{-- <span class="text-sm font-weight-bold"></span> --}}
        <div class="my-2">
            <a href="#" class="btn bg-gradient-info dropdown-toggle " data-bs-toggle="dropdown" id="navbarDropdownMenuLink">
                {{Request::is('daftar-penjual/semua') ? 'Semua Penjual' :  (Request::is('daftar-penjual/ikuti') ? 'Penjual yang Diikuti' : '' ) }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li> <a class="dropdown-item {{ Request::is('daftar-penjual/semua') ? 'font-weight-bolder' : '' }}" href="{{ url('/daftar-penjual/semua')}}"> Semua Penjual </a> </li>
                <li> <a class="dropdown-item {{ Request::is('daftar-penjual/ikuti') ? 'font-weight-bolder' : '' }}" href="{{ url('/daftar-penjual/ikuti')}}"> Penjual yang Diikuti </a> </li>
            </ul>
        </div>
        <hr class="horizontal dark my-4">
    </div>

    <div class="container-fluid py-3">
        <div class="card h-100">
            <div class="card-body p-3">
                <div class="row mx-1">
                <ul class="list-group">
                    @if(count($penjual) == 0)
                    <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                        <h5 class="text-secondary font-weight-bold mx-auto">
                            {{Request::is('daftar-penjual/ikuti') ? 'Anda Belum Mengikuti Penjual' : 'Tidak Ada Penjual'}}
                        </h5>
                    </li>
                    @else
                    @for ($data = 0; $data < count($penjual); $data++)
                    <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                        <div class="avatar me-3 w-5">

                        <img src="{{$penjual[$data]['gambar'] != null || $penjual[$data]['gambar'] != '' ? $penjual[$data]['gambar'] : '../pic/uni-user-1.png'}}" alt="{{$penjual[$data]['nama']}}" class="border-radius-lg shadow">
                        </div>
                        <div class="d-flex align-items-start flex-column justify-content-center">
                            <h5 class="mb-0">{{$penjual[$data]['nama']}}<i class="fas fa-address-card text-info text-gradient opacity-10 px-2"></i></h5>
                            <span class="mb-0 text-sm text-secondary">{{ auth()->user()->id != $penjual[$data]['id'] ? '@'.$penjual[$data]['username'] : 'Anda'}}</span>
                            <span class="mb-0 text-md text-dark">{{ $penjual[$data]['ttg']}}</span>
                        </div>
                        <h6 class="text-dark font-weight-bold pe-3 ps-0 mb-0 text-end ms-auto"><i class="fas fa-users text-info text-gradient opacity-10 px-2"></i>{{ $penjual[$data]['pengikut'] }} Pengikut</h6>
                        @if(auth()->user()->id != $penjual[$data]['id'])
                        <a class="btn {{$penjual[$data]['ikut'] == 1 ? 'btn-outline-dark' : 'bg-gradient-info'}} mb-0" href="{{ url('/ikuti-penjual/'.$penjual[$data]['id']) }}">
                            {{$penjual[$data]['ikut'] == 1 ? 'Tidak Ikuti' : 'Ikuti'}}
                        </a>
                        @endif
                    </li>
                    @php
                        // $coba = rand(0,6);//kalo sudah ada lelang, dimatikan
                        $lelang = $penjual[$data]['lelang'];
                    @endphp
                    @if(Request::is('daftar-penjual/ikuti'))
                    @if(count($lelang) == 0)
                    <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                        <h5 class="text-secondary font-weight-bold mx-auto">
                            {{$penjual[$data]['ikut'] == 1 ? 'Belum ada Lelang yang akan Dirilis' : 'Belum ada Lelang yang Berlangsung'}}
                        </h5>
                    </li>
                    @else
                    <li class="list-group-item border-0 d-flex align-items-center m-0 p-0">
                        <h5 class="text-secondary font-weight-bold mx-auto">Lelang yang akan Dirilis</h5>
                    </li>
                    {{-- <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2"> --}}
                    <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
                        @for ($i = 0; $i < count($lelang); $i+=3)
                        @if ($lelang[$i]['mode'] == -1)
                        <div class="column">
                        <div class="col-xl-12 col-md-6 mb-xl-0 mb-4 mt-4">
                            <div class="card card-blog card-plain pb-0 p-3">
                                <div class="position-relative">
                                    <a class="d-block shadow-xl border-radius-xl">
                                    <img src="{{$lelang[$i]['gambar'] == null ? '../assets/img/home-decor-'.rand(1,3).'.jpg' : $lelang[$i]['gambar']}}"
                                        alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                    </a>
                                </div>
                                <div class="card-body px-1 pb-0">
                                    <a href="{{url('/lihat-lelang/'.$lelang[$i]['lelang'])}}" title="Lihat Lelang ini">
                                        <h5 class="">
                                            {{$lelang[$i]['produk'] }}
                                        </h5>
                                    </a>
                                    {{-- <span class="text-end text-secondary mb-2 text-sm">
                                        {{$penjual[$data]['nama'].' (@'.$penjual[$data]['username'].')'}}
                                    </span> --}}
                                    <p class="mb-4 text-lg">
                                        <i class="fas fa-map-pin text-info text-gradient pe-2 p-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Kota {{$penjual[$data]['kota']}}</span><br>
                                        <i class="fas fa-coins text-warning text-gradient me-1 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['harga'] }} Koin</span><br>
                                        <i class="fas fa-hourglass-start text-primary text-gradient me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['mulai'] }}</span><br>
                                        <i class="fas fa-hourglass-end text-gray-200 me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['selesai'] }}</span><br>
                                        {{-- <i class="fas fa-file-signature text-primary text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['detail'] }}</span><br> --}}
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                    <a href="{{url('/lihat-lelang/'.$lelang[$i]['lelang'])}}" title="Buka Lelang" class="btn bg-gradient-info btn-sm mb-0">
                                        {{-- <button type="button" class=""> --}}
                                        {{ $lelang[$i]['mulai'] <= $hari_ini && $lelang[$i]['selesai'] >= $hari_ini ? 'Buka Lelang' : 'Lihat Detail'}}
                                        {{-- </button> --}}
                                    </a>
                                    <div class="avatar-group mt-2">
                                        @if($lelang[$i]['ikut'] > 0)
                                        {{-- <span class="text-end text-secondary mx-3 text-sm">Belum Ada Peserta</span>
                                        @else --}}
                                        @for ($k = 0; $k < ($lelang[$i]['ikut'] <= 3 ? $lelang[$i]['ikut']*4 : $lelang[$i]['ikut']); $k++)
                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Penggemar yang Ikut'>
                                        <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                        </a>
                                        @endfor
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
                        @for ($i = 1; $i < count($lelang); $i+=3)
                        @if ($lelang[$i]['mode'] == -1)
                        <div class="column">
                        <div class="col-xl-12 col-md-6 mb-xl-0 mb-4 mt-4">
                            <div class="card card-blog card-plain pb-0 p-3">
                                <div class="position-relative">
                                    <a class="d-block shadow-xl border-radius-xl">
                                    <img src="{{$lelang[$i]['gambar'] == null ? '../assets/img/home-decor-'.rand(1,3).'.jpg' : $lelang[$i]['gambar']}}"
                                        alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                    </a>
                                </div>
                                <div class="card-body px-1 pb-0">
                                    <a href="{{url('/lihat-lelang/'.$lelang[$i]['lelang'])}}" title="Lihat Lelang ini">
                                        <h5 class="">
                                            {{$lelang[$i]['produk'] }}
                                        </h5>
                                    </a>
                                    {{-- <span class="text-end text-secondary mb-2 text-sm">
                                        {{$penjual[$data]['nama'].' (@'.$penjual[$data]['username'].')'}}
                                    </span> --}}
                                    <p class="mb-4 text-lg">
                                        <i class="fas fa-map-pin text-info text-gradient pe-2 p-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Kota {{$penjual[$data]['kota']}}</span><br>
                                        <i class="fas fa-coins text-warning text-gradient me-1 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['harga'] }} Koin</span><br>
                                        <i class="fas fa-hourglass-start text-primary text-gradient me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['mulai'] }}</span><br>
                                        <i class="fas fa-hourglass-end text-gray-200 me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['selesai'] }}</span><br>
                                        {{-- <i class="fas fa-file-signature text-primary text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['detail'] }}</span><br> --}}
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                    <a href="{{url('/lihat-lelang/'.$lelang[$i]['lelang'])}}" title="Buka Lelang" class="btn bg-gradient-info btn-sm mb-0">
                                        {{-- <button type="button" class=""> --}}
                                        {{ $lelang[$i]['mulai'] <= $hari_ini && $lelang[$i]['selesai'] >= $hari_ini ? 'Buka Lelang' : 'Lihat Detail'}}
                                        {{-- </button> --}}
                                    </a>
                                    <div class="avatar-group mt-2">
                                        @if($lelang[$i]['ikut'] > 0)
                                        {{-- <span class="text-end text-secondary mx-3 text-sm">Belum Ada Peserta</span>
                                        @else --}}
                                        @for ($k = 0; $k < ($lelang[$i]['ikut'] <= 3 ? $lelang[$i]['ikut']*4 : $lelang[$i]['ikut']); $k++)
                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Penggemar yang Ikut'>
                                        <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                        </a>
                                        @endfor
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
                        @for ($i = 2; $i < count($lelang); $i+=3)
                        @if ($lelang[$i]['mode'] == -1)
                        <div class="column">
                        <div class="col-xl-12 col-md-6 mb-xl-0 mb-4 mt-4">
                            <div class="card card-blog card-plain pb-0 p-3">
                                <div class="position-relative">
                                    <a class="d-block shadow-xl border-radius-xl">
                                    <img src="{{$lelang[$i]['gambar'] == null ? '../assets/img/home-decor-'.rand(1,3).'.jpg' : $lelang[$i]['gambar']}}"
                                        alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                    </a>
                                </div>
                                <div class="card-body px-1 pb-0">
                                    <a href="{{url('/lihat-lelang/'.$lelang[$i]['lelang'])}}" title="Lihat Lelang ini">
                                        <h5 class="">
                                            {{$lelang[$i]['produk'] }}
                                        </h5>
                                    </a>
                                    {{-- <span class="text-end text-secondary mb-2 text-sm">
                                        {{$penjual[$data]['nama'].' (@'.$penjual[$data]['username'].')'}}
                                    </span> --}}
                                    <p class="mb-4 text-lg">
                                        <i class="fas fa-map-pin text-info text-gradient pe-2 p-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Kota {{$penjual[$data]['kota']}}</span><br>
                                        <i class="fas fa-coins text-warning text-gradient me-1 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['harga'] }} Koin</span><br>
                                        <i class="fas fa-hourglass-start text-primary text-gradient me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['mulai'] }}</span><br>
                                        <i class="fas fa-hourglass-end text-gray-200 me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['selesai'] }}</span><br>
                                        {{-- <i class="fas fa-file-signature text-primary text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['detail'] }}</span><br> --}}
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                    <a href="{{url('/lihat-lelang/'.$lelang[$i]['lelang'])}}" title="Buka Lelang" class="btn bg-gradient-info btn-sm mb-0">
                                        {{-- <button type="button" class=""> --}}
                                        {{ $lelang[$i]['mulai'] <= $hari_ini && $lelang[$i]['selesai'] >= $hari_ini ? 'Buka Lelang' : 'Lihat Detail'}}
                                        {{-- </button> --}}
                                    </a>
                                    <div class="avatar-group mt-2">
                                        @if($lelang[$i]['ikut'] > 0)
                                        {{-- <span class="text-end text-secondary mx-3 text-sm">Belum Ada Peserta</span>
                                        @else --}}
                                        @for ($k = 0; $k < ($lelang[$i]['ikut'] <= 3 ? $lelang[$i]['ikut']*4 : $lelang[$i]['ikut']); $k++)
                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Penggemar yang Ikut'>
                                        <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                        </a>
                                        @endfor
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
                    {{-- </li> --}}
                    @endif
                    <hr>
                    @endif
                    @endfor
                    @endif
                </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
