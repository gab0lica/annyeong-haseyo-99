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
                            <i class="fas fa-coins text-warning text-gradient text-gradient text-lg p-1"></i> {{ $koin }} Koin
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
                        @if($koin <= 0 && $pesan != 'penggemar')<span class="font-weight-bold text-danger text-sm">(Anda harus Membeli Koin untuk Registrasi)</span>@endif
                    </h6>
                    @else --}}
                    <h6 class="mb-0 text-lg font-weight-bold">
                        <i class="fas fa-check text-success opacity-10 px-2"></i> {{ $ikutlelang }} Lelang yang Diikuti
                        {{-- @if($koin <= 0 && $pesan != 'penggemar')<span class="font-weight-bold text-danger text-sm">(Anda harus Membeli Koin untuk Registrasi)</span>@endif --}}
                    </h6>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid text-center">
        <hr class="horizontal dark my-4">
        <h4 class="text-dark px-2 font-weight-bolder m-0">
            Sejarah Mengikuti Lelang
        </h4>
        {{-- <li class="list-group-item border-0 d-flex align-items-center m-0 p-0 text-center"> --}}
            <h6 class="text-dark font-weight-bold mx-auto">
                {{-- <u>Status Lelang pada Penawaran Terakhir Anda</u><br> --}}
                <i class="fas fa-coins text-dark text-gradient me-2 py-1" aria-hidden="true"></i><span class="col-md-5 font-weight-bold mb-2 text-sm">Sedang Berjalan</span> |
                <i class="fas fa-trophy text-success text-gradient me-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Anda sebagai Pemenang</span> |
                <i class="fas fa-coins text-danger text-gradient me-2 py-1" aria-hidden="true"></i><span class="col-md-5 font-weight-bold mb-2 text-sm">Lelang Selesai</span><br>
            </h6>
        {{-- </li> --}}
        {{-- <span class="text-sm font-weight-bold">Lelang yang sedang Berlangsung</span> --}}
        <button type="button" class="btn bg-gradient-primary my-2" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">
            Filter Lelang <i class="fas fa-filter text-lg text-white ms-2" aria-hidden="true"></i>
        </button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Filter Lelang</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <form action="/filter-sejarah" method="POST" role="form" class="m-0 p-0">
                    <div class="modal-body">
                        {{-- 'my-auto' target="_blank"--}}
                        @csrf
                        {{-- <input type="hidden" id="web" name="web" value="{{$berita[$i]['web']}}"> --}}
                        {{-- <span class="font-weight-bold text-danger text-sm">(Pastikan Tanggal dan Jam Selesai Lelang adalah <strong>Setelah Tanggal dan Jam Lelang Dimulai yang Ditentukan</strong>)</span> --}}
                        <ul class="list-group">
                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white font-weight-bold">
                            {{$errors->first()}}
                                {{-- Lelang Anda perlu diperbaiki. <br>Dimohon untuk mengisi dengan benar sesuai dengan catatan perbaikan. --}}
                            </span>
                        </div>
                        @endif
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <div class='row'>
                                <div class='col-md-4 my-auto'><strong class="text-dark">Tanggal Mulai</strong> </div>
                                {{-- <span class="text-danger text-md">*</span> --}}
                                <div class='col-md-8 px-0'>
                                    <div class="form-group my-0">
                                        {{-- @if(count($detail) > 0)<span class="font-weight-bold text-danger">{{$detail['penawar'] > 0 ? '(Tanggal Dimulai Tidak Bisa Diubah karena Sudah Ada Penawar)' : ''}}</span>@endif --}}
                                        <div class="row my-2">
                                            <div class='col-md-6'>
                                                {{-- min='sama dg value' value='{{ $mode == 'baru' && $pesan == 'buat' ? date('Y-m-d',strtotime($hari_ini)) : $detail['mulai'] }}' --}}
                                                {{-- {{count($detail) > 0 ? ($detail['status'] == 3 || $detail['penawar'] > 0 ? 'disabled' : '') : ''}} --}}
                                            <input id="mulai" name="mulai" type="date" class="form-control" value="{{ date('Y-m-d',strtotime( $filter['mulai'] == null ? $hari_ini : $filter['mulai'] )) }}">
                                            </div>
                                            <div class='col-md-6'>
                                                {{-- min='sama dg value' value="{{ $mode == 'baru' && $pesan == 'buat' ? date('H:i',strtotime($hari_ini)) : $detail['jamMulai'] }}" --}}
                                                {{-- {{count($detail) > 0 ? ($detail['status'] == 3 || $detail['penawar'] > 0 ? 'disabled' : '') : ''}} --}}
                                            <input id="jamMulai" name="jamMulai" type="time" class="form-control" value="{{ date('H:i',strtotime( $filter['mulai'] == null ? $hari_ini : $filter['mulai'])) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <div class='row'>
                                <div class='col-md-4 my-auto'><strong class="text-dark">Tanggal Selesai</strong> </div>
                                {{-- <span class="text-danger text-md">*</span> --}}
                                <div class='col-md-8 px-0'>
                                    <div class="form-group my-0">
                                        <div class="row py-2">
                                            <div class='col-md-6'>
                                                {{-- min='{{ date('Y-m-d',strtotime($hari_ini)) }}' --}}
                                                {{-- {{count($detail) > 0 ? ($detail['status'] == 3 ? 'disabled' : '') : ''}} --}}
                                                {{-- value="{{ $mode == 'baru' && $pesan == 'buat' ? date('Y-m-d',strtotime($hari_ini)) : $detail['selesai'] }}" --}}
                                                <input id="selesai" name="selesai" type="date" class="form-control" value="{{ date('Y-m-d',strtotime( $filter['selesai'] == null ? $hari_ini : $filter['selesai'] )) }}">
                                            </div>
                                            <div class='col-md-6'>
                                                {{-- min="{{ date('H:i',strtotime($hari_ini)) }}" --}}
                                                {{-- {{count($detail) > 0 ? ($detail['status'] == 3 ? 'disabled' : '') : ''}} --}}
                                                {{-- value="{{ $mode == 'baru' && $pesan == 'buat' ? date('H:i',strtotime($hari_ini)) : $detail['jamSelesai'] }}" --}}
                                                <input id="jamSelesai" name="jamSelesai" type="time" class="form-control" value="{{ date('H:i',strtotime( $filter['selesai'] == null ? $hari_ini : $filter['selesai'])) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <div class='row'>
                                <div class='col-md-4 my-auto'><strong class="text-dark">Status Lelang</strong> </div>
                                {{-- <span class="text-danger text-md">*</span> --}}
                                <div class='col-md-8 px-0'>
                                    <div class="form-group my-0">
                                    <div class='row'>
                                        <div class='col-md-12'>
                                            <select class="form-control text-capitalize" id="status" name="status" value="{{$filter['status'] == 'berjalan' || $filter['status'] == 'selesai' ? $filter['status'] : ''}}">
                                                <option {{$filter['status'] == 'berjalan' || $filter['status'] == null ? 'selected' : ''}} value="berjalan"> Sedang Berjalan</option>
                                                <option {{$filter['status'] == 'menang' ? 'selected' : ''}} value="menang"> Menang</option>
                                                <option {{$filter['status'] == 'selesai' ? 'selected' : ''}} value="selesai"> Selesai</option>
                                            </select>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <a href="{{url('/sejarah-lelang')}}" class="btn bg-gradient-dark">Kembali Filter Semula</a>
                        <button type="submit" class="btn bg-gradient-primary">Kirim Filter</button>
                    </div>
                </form>
              </div>
            </div>
        </div>
        <hr class="horizontal dark my-4 mb-3">
    </div>

{{-- profile.blade.php >> lebih banyak isinya --}}
    <div class="container-fluid py-3">
        <div class="card h-100">
            <div class="card-body p-3">
                <div class="row">
                {{-- <ul class="list-group"> --}}
                    {{-- @php
                        $coba = rand(0,6);//kalo sudah ada lelang, dimatikan
                        @endphp --}}
                    @if(count($lelang) == 0)
                    <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                        <h5 class="text-dark font-weight-bolder mx-auto">
                            {{ $filter['mulai'] == null ? 'Belum ada Lelang yang Diikuti' : 'Tidak Ada Lelang Sesuai Filter'}}
                        </h5>
                    </li>
                    @else
                    <li class="list-group-item border-0 d-flex align-items-center m-0 p-0">
                        <h5 class="text-dark font-weight-bolder mx-auto">
                            @if ($filter['mulai'] == null)
                            Urut Berdasarkan Waktu Dimulai Lelang Terbaru <i class="fas fa-hourglass-start text-primary text-gradient me-1 py-1" aria-hidden="true"></i>
                            @else
                            Filter: Status {{Str::upper($filter['status'])}} dari {{$filter['tglmulai']}} - {{$filter['tglselesai']}}
                            @endif
                        </h5>
                    </li>
                    <hr class="horizontal dark">
                    <div class="col-xl-4 col-md-6 mb-xl-0">
                        @for ($i = 0; $i < count($lelang); $i+=3)
                        <div class="column mb-3">
                        <div class="col-xl-12 col-md-6 mb-xl-0">
                            <div class="card card-blog card-plain pb-0 p-3">
                                <div class="position-relative">
                                    <a class="d-block shadow-xl border-radius-xl" target='_blank' href="{{$lelang[$i]['username'] != auth()->user()->username ? url('/lihat-lelang/'.$lelang[$i]['lelang']) : url('/form-lelang/'.$lelang[$i]['lelang'])}}" title="Lihat Lelang ini">
                                    <img src="{{$lelang[$i]['gambar'] == null ? '../assets/img/home-decor-'.rand(1,3).'.jpg' : $lelang[$i]['gambar']}}"
                                        alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                    </a>
                                </div>
                                <div class="card-body pb-0 p-3">
                                    <h5>
                                        {{$lelang[$i]['produk'] }}
                                    </h5>
                                    <span class="text-end text-secondary mb-1 text-sm">
                                        {{'@'.$lelang[$i]['nama']}}
                                    </span>
                                    <p class="mb-3 text-lg">
                                        <i class="fas fa-map-pin text-info text-gradient pe-2 p-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Kota {{$lelang[$i]['kota']}}</span><br>
                                        <i class="fas fa-coins text-warning text-gradient me-1 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['harga'] }} Koin</span><br>
                                        <i class="fas fa-hourglass-start text-primary text-gradient me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['mulai'] }}</span><br>
                                        <i class="fas fa-hourglass-end text-gray-200 me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['selesai'] }}</span><br>
                                        {{-- @if($lelang[$i]['ikut'] > 0) --}}
                                        <i class="fas fa-clock text-success text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Terakhir Ikut: {{ $lelang[$i]['ikut']['tgl'] }}</span><br>
                                        <i class="fas fa-{{$lelang[$i]['ikut']['menang'] == 1 ? 'trophy' : 'coins'}} text-{{$lelang[$i]['status']['pesan'] == 'berjalan' ? 'dark' : ($lelang[$i]['ikut']['menang'] == 1 ? 'success' : 'danger')}} text-gradient me-1 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Penawaran: {{ $lelang[$i]['ikut']['jumlah'] }} Koin</span><br>
                                        {{-- @endif --}}
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                    <a href="{{$lelang[$i]['username'] != auth()->user()->username ? url('/lihat-lelang/'.$lelang[$i]['lelang']) : url('/form-lelang/'.$lelang[$i]['lelang'])}}" title="Buka Lelang"
                                        class="btn bg-gradient-info btn-sm mb-0">
                                        {{-- <button type="button" class=""> --}}
                                        Buka Lelang
                                        {{-- </button> --}}
                                    </a>
                                    <div class="avatar-group">
                                        {{-- @if($lelang[$i]['ikut'] > 0)
                                        <span class="text-end text-secondary mx-3 text-sm">Terakhir Penawaran: {{$lelang[$i]['ikut']}}</span>
                                        @else
                                        @for ($k = 0; $k < ($lelang[$i]['ikut'] <= 3 ? $lelang[$i]['ikut']*4 : $lelang[$i]['ikut']); $k++)
                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Penggemar yang Ikut'>
                                        <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                        </a>
                                        @endfor
                                        @endif --}}
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        @endfor
                    </div>
                    <div class="col-xl-4 col-md-6 mb-xl-0">
                        @for ($i = 1; $i < count($lelang); $i+=3)
                        <div class="column mb-3">
                        <div class="col-xl-12 col-md-6 mb-xl-0">
                            <div class="card card-blog card-plain pb-0 p-3">
                                <div class="position-relative">
                                    <a class="d-block shadow-xl border-radius-xl" target='_blank' href="{{$lelang[$i]['username'] != auth()->user()->username ? url('/lihat-lelang/'.$lelang[$i]['lelang']) : url('/form-lelang/'.$lelang[$i]['lelang'])}}" title="Lihat Lelang ini">
                                    <img src="{{$lelang[$i]['gambar'] == null ? '../assets/img/home-decor-'.rand(1,3).'.jpg' : $lelang[$i]['gambar']}}"
                                        alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                    </a>
                                </div>
                                <div class="card-body pb-0 p-3">
                                    <h5>
                                        {{$lelang[$i]['produk'] }}
                                    </h5>
                                    <span class="text-end text-secondary mb-1 text-sm">
                                        {{'@'.$lelang[$i]['nama']}}
                                    </span>
                                    <p class="mb-3 text-lg">
                                        <i class="fas fa-map-pin text-info text-gradient pe-2 p-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Kota {{$lelang[$i]['kota']}}</span><br>
                                        <i class="fas fa-coins text-warning text-gradient me-1 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['harga'] }} Koin</span><br>
                                        <i class="fas fa-hourglass-start text-primary text-gradient me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['mulai'] }}</span><br>
                                        <i class="fas fa-hourglass-end text-gray-200 me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['selesai'] }}</span><br>
                                        {{-- @if($lelang[$i]['ikut'] > 0) --}}
                                        <i class="fas fa-clock text-success text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Terakhir Ikut: {{ $lelang[$i]['ikut']['tgl'] }}</span><br>
                                        <i class="fas fa-{{$lelang[$i]['ikut']['menang'] == 1 ? 'trophy' : 'coins'}} text-{{$lelang[$i]['status']['pesan'] == 'berjalan' ? 'dark' : ($lelang[$i]['ikut']['menang'] == 1 ? 'success' : 'danger')}} text-gradient me-1 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Penawaran: {{ $lelang[$i]['ikut']['jumlah'] }} Koin</span><br>
                                        {{-- @endif --}}
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                    <a href="{{$lelang[$i]['username'] != auth()->user()->username ? url('/lihat-lelang/'.$lelang[$i]['lelang']) : url('/form-lelang/'.$lelang[$i]['lelang'])}}" title="Buka Lelang"
                                        class="btn bg-gradient-info btn-sm mb-0">
                                        {{-- <button type="button" class=""> --}}
                                        Buka Lelang
                                        {{-- </button> --}}
                                    </a>
                                    <div class="avatar-group">
                                        {{-- @if($lelang[$i]['ikut'] > 0)
                                        <span class="text-end text-secondary mx-3 text-sm">Terakhir Penawaran: {{$lelang[$i]['ikut']}}</span>
                                        @else
                                        @for ($k = 0; $k < ($lelang[$i]['ikut'] <= 3 ? $lelang[$i]['ikut']*4 : $lelang[$i]['ikut']); $k++)
                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Penggemar yang Ikut'>
                                        <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                        </a>
                                        @endfor
                                        @endif --}}
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        @endfor
                    </div>
                    <div class="col-xl-4 col-md-6 mb-xl-0">
                        @for ($i = 2; $i < count($lelang); $i+=3)
                        <div class="column mb-3">
                        <div class="col-xl-12 col-md-6 mb-xl-0">
                            <div class="card card-blog card-plain pb-0 p-3">
                                <div class="position-relative">
                                    <a class="d-block shadow-xl border-radius-xl" target='_blank' href="{{$lelang[$i]['username'] != auth()->user()->username ? url('/lihat-lelang/'.$lelang[$i]['lelang']) : url('/form-lelang/'.$lelang[$i]['lelang'])}}" title="Lihat Lelang ini">
                                    <img src="{{$lelang[$i]['gambar'] == null ? '../assets/img/home-decor-'.rand(1,3).'.jpg' : $lelang[$i]['gambar']}}"
                                        alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                    </a>
                                </div>
                                <div class="card-body pb-0 p-3">
                                    <h5>
                                        {{$lelang[$i]['produk'] }}
                                    </h5>
                                    <span class="text-end text-secondary mb-1 text-sm">
                                        {{'@'.$lelang[$i]['nama']}}
                                    </span>
                                    <p class="mb-3 text-lg">
                                        <i class="fas fa-map-pin text-info text-gradient pe-2 p-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Kota {{$lelang[$i]['kota']}}</span><br>
                                        <i class="fas fa-coins text-warning text-gradient me-1 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['harga'] }} Koin</span><br>
                                        <i class="fas fa-hourglass-start text-primary text-gradient me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['mulai'] }}</span><br>
                                        <i class="fas fa-hourglass-end text-gray-200 me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['selesai'] }}</span><br>
                                        {{-- @if($lelang[$i]['ikut'] > 0) --}}
                                        <i class="fas fa-clock text-success text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Terakhir Ikut: {{ $lelang[$i]['ikut']['tgl'] }}</span><br>
                                        <i class="fas fa-{{$lelang[$i]['ikut']['menang'] == 1 ? 'trophy' : 'coins'}} text-{{$lelang[$i]['status']['pesan'] == 'berjalan' ? 'dark' : ($lelang[$i]['ikut']['menang'] == 1 ? 'success' : 'danger')}} text-gradient me-1 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Penawaran: {{ $lelang[$i]['ikut']['jumlah'] }} Koin</span><br>
                                        {{-- @endif --}}
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                    <a href="{{$lelang[$i]['username'] != auth()->user()->username ? url('/lihat-lelang/'.$lelang[$i]['lelang']) : url('/form-lelang/'.$lelang[$i]['lelang'])}}" title="Buka Lelang"
                                        class="btn bg-gradient-info btn-sm mb-0">
                                        {{-- <button type="button" class=""> --}}
                                        Buka Lelang
                                        {{-- </button> --}}
                                    </a>
                                    <div class="avatar-group">
                                        {{-- @if($lelang[$i]['ikut'] > 0)
                                        <span class="text-end text-secondary mx-3 text-sm">Terakhir Penawaran: {{$lelang[$i]['ikut']}}</span>
                                        @else
                                        @for ($k = 0; $k < ($lelang[$i]['ikut'] <= 3 ? $lelang[$i]['ikut']*4 : $lelang[$i]['ikut']); $k++)
                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Penggemar yang Ikut'>
                                        <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                        </a>
                                        @endfor
                                        @endif --}}
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        @endfor
                    </div>
                    @endif
                {{-- </ul> --}}
                </div>
            </div>
            {{-- modal dari data-user di admin --}}
            {{--
                                    <button type="button" class="btn-link text-lg btn m-0 p-0" data-bs-toggle="modal" data-bs-target="#exampleModalMessage{{$i}}">
                                        <a href="#"
                                            class="{{ Request::is('user/'.$user.'/'.$datauser[$i]['id']) ? 'active' : '' }}"
                                            title="User ID {{$datauser[$i]['id']}}">
                                            <i class="fas fa-user-edit text-dark me-2" aria-hidden="true"></i>
                                        </a>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalMessage{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h6 class="modal-title" id="exampleModalLabel">Data Diri User</h6>
                                              <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                              </button> -->
                                            </div>
                                            <div class="modal-body">
                                              <!-- <form>
                                                <div class="form-group">
                                                  <label for="recipient-name" class="col-form-label">Name</label>
                                                  <input type="text" class="form-control" value="Creative Tim" id="recipient-name">
                                                </div>
                                                <div class="form-group">
                                                  <label for="recipient-name" class="col-form-label">Alamat</label>
                                                  <textarea class="form-control" id="message-text"></textarea>
                                                </div>
                                              </form> -->
                                              <div class="card-header p-2">
                                                <img src="{{ $datauser[$i]['gambar_profile'] != null || $datauser[$i]['gambar_profile'] != '' ? $datauser[$i]['gambar_profile'] : '../pic/uni-user-4.png' }}"
                                                  alt="Gambar Profile Anda" class="w-20 h-20 m-2 border-radius-lg shadow-sm bg-gradient-dark">
                                                <p class="font-weight-bold {{$datauser[$i]['status'] == 0 ? 'text-danger' : 'text-success'}} text-left m-0">Masa Aktif: {{$datauser[$i]['created_at'].' - '.$datauser[$i]['updated_at']}}</p>
                                              </div>
                                              <hr>

                                              <div class="card-body">
                                                <ul class="list-group">
                                                    <h6 class="font-weight-bolder text-dark text-left"><u>Penggemar</u></h6>
                                               <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                        <span class="mb-1 text-dark text-sm">Username</span>
                                                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                            {{ $datauser[$i]['username'] }}
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                        <span class="mb-1 text-dark text-sm">Email</span>
                                                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                            {{ $datauser[$i]['email'] }}
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                        <span class="mb-1 text-dark text-sm">Nama Lengkap</span>
                                                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                            {{ $datauser[$i]['nama'] }}
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                        <span class="mb-1 text-dark text-sm">Nomor Telepon</span>
                                                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                            {{ $datauser[$i]['nomor_telepon'] }}
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                        <span class="mb-1 text-dark text-sm">Kota</span>
                                                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                            {{ $datauser[$i]['kota'] != null ? $datauser[$i]['kota'] : '-'}}
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                        <span class="mb-1 text-dark text-sm">Tentang Anda</span>
                                                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                            {{ $datauser[$i]['tentang_user'] != null ? $datauser[$i]['tentang_user'] : '-'}}
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                        <span class="mb-1 text-dark text-sm">Artis Favorit</span>
                                                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                            {{ $datauser[$i]['artis'] != null ? $datauser[$i]['artis'] : '-'}}
                                                        </span>
                                                    </li>
                                                    @if ($datauser[$i]['foto_ktp'] != 'tidak')
                                                    <hr>
                                                    <h6 class="font-weight-bolder text-dark text-left my-2"><u>Penjual</u></h6>
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                        <span class="mb-1 text-dark text-sm">Jumlah Pengikut</span>
                                                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                            {{ 0 }}
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                        <span class="mb-1 text-dark text-sm">Nomor KTP</span>
                                                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                            {{ $datauser[$i]['ktp'] }}
                                                        </span>
                                                    </li>
                                                    <span class="mb-0">Foto KTP</span><br>
                                                    <img src="{{ $datauser[$i]['foto_ktp'] }}" alt="Foto KTP Anda" class="my-2 w-100 border-radius-lg shadow-sm bg-outline-dark">
                                                    @endif
                                                </ul>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                                              <!-- <button type="button" class="btn bg-gradient-primary">Send message</button> -->
                                            </div>
                                          </div>
                                        </div>
                                    </div>
            --}}
            {{-- form dari lihat-penjual --}}
            {{--
            <div class="container-fluid text-center">
                <hr class="horizontal dark my-4">
                <span class="text-sm font-weight-bold">{{"Penjual @".$lelang['username']}}</span>
                <h4 class="text-dark px-2 font-weight-bolder m-0">{{$lelang['nama']}}</h4>
                <hr class="horizontal dark my-4">
            </div>
            <div class="container-fluid py-3">
                <div class="row">
                    <div class="card h-100">
                        <div class="card-body p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                <div class="avatar me-3 w-5">
                                <img src="{{$lelang['gambar']}}" alt="{{$lelang['nama']}}" class="border-radius-lg shadow">
                                </div>
                                <div class="d-flex align-items-start flex-column justify-content-center">
                                    <a href="{{url('/lihat-penjual/'.$lelang['id'])}}" title="Lihat Penjual">
                                        <h5 class="mb-0">{{$lelang['nama']}}<i class="fas fa-address-card text-info text-gradient opacity-10 px-2"></i></h5>
                                    </a>
                                <span class="mb-0 text-sm text-secondary">{{$lelang['username']}}</span>
                                </div>
                                <h6 class="text-dark font-weight-bold pe-3 ps-0 mb-0 text-end ms-auto"><i class="fas fa-users text-info text-gradient opacity-10 px-2"></i>{{ $lelang['pengikut'] }} Pengikut</h6>
                                <a class="btn {{$lelang['ikut'] == 1 ? 'btn-outline-dark' : 'bg-gradient-info'}} mb-0" href="{{ url('/ikuti-penjual/'.$lelang['id']) }}">
                                    {{$lelang['ikut'] == 1 ? 'Tidak Ikuti' : 'Ikuti'}}
                                </a>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                    <div class="col-md-8 d-flex align-items-center">
                                        <h6 class="mb-0">Profile Information</h6>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="javascript:;">
                                        <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i>
                                        </a>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <p class="text-sm">
                                    Hi, I’m Alec Thompson, Decisions: If you can’t decide, the answer is no. If two equally difficult paths, choose the one more painful in the short term (pain avoidance is creating an illusion of equality).
                                    </p>
                                    <hr class="horizontal gray-light my-4">
                                    <ul class="list-group">
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Full Name:</strong> &nbsp; Alec M. Thompson</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Mobile:</strong> &nbsp; (44) 123 1234 123</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp; alecthompson@mail.com</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Location:</strong> &nbsp; USA</li>
                                    <li class="list-group-item border-0 ps-0 pb-0">
                                        <strong class="text-dark text-sm">Social:</strong> &nbsp;
                                        <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                        <i class="fab fa-facebook fa-lg"></i>
                                        </a>
                                        <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                        <i class="fab fa-twitter fa-lg"></i>
                                        </a>
                                        <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                        <i class="fab fa-instagram fa-lg"></i>
                                        </a>
                                    </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
            --}}
        </div>
    </div>
</div>
@endsection
