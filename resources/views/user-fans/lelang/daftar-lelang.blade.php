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
        <h4 class="text-dark px-2 font-weight-bolder m-0">Daftar Lelang</h4>
        {{-- <span class="text-sm font-weight-bold">Lelang yang sedang Berlangsung</span>  --}}
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
                <form action="/filter-lelang" method="POST" role="form" class="m-0 p-0">
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
                                <div class='col-md-4 my-auto'><strong class="text-dark">Penjual</strong> <span class="text-danger text-md">*</span></div>
                                <div class='col-md-8 px-0'>
                                    <div class="form-group my-0">
                                    {{-- <span class="font-weight-bold text-danger">(Apabila Nama Artis ada)</span> --}}
                                    <div class='row my-2'>
                                        @if (count($penjual) > 0)
                                        <div class='col-md-12'>
                                            {{-- <span class="font-weight-bold text-dark my-2"><u>Bagian Pilih Penjual yang Tersedia</u></span> --}}
                                            <select class="form-control" id="penjual" name="penjual" value="{{ $filter['penjual'] == null || $filter['penjual'] == 'Tidak Ada' ? old('penjual') : $filter['penjual'] }}">
                                                <option>{{'Tidak Ada'}}</option>
                                                @foreach ($penjual as $item)
                                                <option class="text-capitalize" value="{{ $item->id }}" {{ $filter['penjual'] == $item->id ? 'selected' : '' }}>{{"@".$item->username." - ".$item->nama}}</option>
                                                {{-- <option>{{$item->nama}}</option> --}}
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <div class='row'>
                                <div class='col-md-4 my-auto'><strong class="text-dark">Kategori Produk</strong> <span class="text-danger text-md">*</span></div>
                                <div class='col-md-8 px-0'>
                                    <div class="form-group my-0">
                                    <div class='row'>
                                        <div class='col-md-12'>
                                            <select class="form-control text-capitalize" id="kategori" name="kategori" value="{{ $filter['kategori'] == null ? old('kategori') : $filter['kategori'] }}">
                                                <option>{{'Tidak Ada'}}</option>
                                                <option {{  $filter['kategori'] == "K-Pop - Album" ? 'selected' : '' }}>K-Pop - Album</option>
                                                <option {{  $filter['kategori'] == "K-Pop - DVD Konser" ? 'selected' : '' }}>K-Pop - DVD Konser</option>
                                                <option {{  $filter['kategori'] == "K-Pop - OST" ? 'selected' : '' }}>K-Pop - OST</option>
                                                <option {{  $filter['kategori'] == "K-Pop - Rekaman LP" ? 'selected' : '' }}>K-Pop - Rekaman LP</option>
                                                <option {{  $filter['kategori'] == "K-Drama Soundtrack" ? 'selected' : '' }}>K-Drama Soundtrack</option>
                                                <option {{  $filter['kategori'] == "Blu-Ray" ? 'selected' : '' }}>Blu-Ray</option>
                                                <option {{  $filter['kategori'] == "DVD" ? 'selected' : '' }}>DVD</option>
                                                <option {{  $filter['kategori'] == "Photobook" ? 'selected' : '' }}>Photobook</option>
                                                <option {{  $filter['kategori'] == "Buku / Majalah" ? 'selected' : '' }}>Buku / Majalah</option>
                                                <option {{  $filter['kategori'] == "MD" ? 'selected' : '' }}>MD</option>
                                                <option {{  $filter['kategori'] == "Season's Greeting" ? 'selected' : '' }}>Season's Greeting</option>
                                                <option {{  $filter['kategori'] == "Lainnya" ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <div class='row'>
                                <div class='col-md-4 my-auto'><strong class="text-dark">Artis</strong> <span class="text-danger text-md">*</span></div>
                                <div class='col-md-8 px-0'>
                                    <div class="form-group my-0">
                                    {{-- <span class="font-weight-bold text-danger">(Apabila Nama Artis ada)</span> --}}
                                    <div class='row my-2'>
                                        @if (count($artis) > 0)
                                        <div class='col-md-12'>
                                            {{-- <span class="font-weight-bold text-dark my-2"><u>Bagian Pilih Artis yang Tersedia</u></span> --}}
                                            <select class="form-control" id="artis" name="artis" value="{{ $filter['artis'] == null ? old('artis') : $filter['artis'] }}">
                                                <option>{{'Tidak Ada'}}</option>
                                                @foreach ($artis as $item)
                                                <option class="text-capitalize" {{ $filter['artis'] == $item->nama ? 'selected' : '' }}>{{$item->nama}}</option>
                                                {{-- <option>{{$item->nama}}</option> --}}
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </li>
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
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <a href="{{url('/daftar-lelang')}}" class="btn bg-gradient-dark">Kembali Filter Semula</a>
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
                            Filter: Status {{Str::upper($filter['status'])}} dari {{$filter['mulai']}} - {{$filter['selesai']}}
                            @endif
                        </h5>
                    </li>
                    <hr class="horizontal dark">

                    <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
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
                                    <h5 class="">
                                        {{$lelang[$i]['produk'] }}
                                    </h5>
                                    <span class="text-end text-secondary mb-2 text-sm">
                                        {{'@'.$lelang[$i]['nama']}}
                                    </span>
                                    <p class="mb-3 text-lg">
                                        <i class="fas fa-map-pin text-info text-gradient pe-2 p-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Kota {{$lelang[$i]['kota']}}</span><br>
                                        <i class="fas fa-coins text-warning text-gradient me-1 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['harga'] }} Koin</span><br>
                                        <i class="fas fa-hourglass-start text-primary text-gradient me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['mulai'] }}</span><br>
                                        <i class="fas fa-hourglass-end text-gray-200 me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['selesai'] }}</span><br>
                                        {{-- <i class="fas fa-file-signature text-primary text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['detail'] }}</span><br> --}}
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                    <a href="{{$lelang[$i]['username'] != auth()->user()->username ? url('/lihat-lelang/'.$lelang[$i]['lelang']) : url('/form-lelang/'.$lelang[$i]['lelang'])}}" title="Buka Lelang"
                                        class="btn bg-gradient-info btn-sm mb-0">
                                        {{-- <button type="button" class=""> --}}
                                        Buka Lelang
                                        {{-- </button> --}}
                                    </a>
                                    <div class="avatar-group">
                                        @if($lelang[$i]['ikut'] > 0)
                                        @for ($k = 0; $k < ($lelang[$i]['ikut'] <= 2 ? $lelang[$i]['ikut']*2 : ($lelang[$i]['userikut'] == 1 ? 4 : 5)); $k++)
                                            <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Penggemar yang Ikut Lelang'>
                                            <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                            </a>
                                        @endfor
                                        @if($lelang[$i]['userikut'] == 1)
                                            <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Anda'>
                                            <img src="{{ auth()->user()->gambar_profile != null || auth()->user()->gambar_profile != '' ? auth()->user()->gambar_profile : '../pic/uni-user-4.png' }}" alt="Anda">
                                            </a>
                                        @endif
                                        {{-- @else
                                        <span class="text-end text-secondary mx-3 text-sm">Belum Ada Peserta</span> --}}
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
                                    <h5 class="">
                                        {{$lelang[$i]['produk'] }}
                                    </h5>
                                    <span class="text-end text-secondary mb-2 text-sm">
                                        {{'@'.$lelang[$i]['nama']}}
                                    </span>
                                    <p class="mb-3 text-lg">
                                        <i class="fas fa-map-pin text-info text-gradient pe-2 p-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Kota {{$lelang[$i]['kota']}}</span><br>
                                        <i class="fas fa-coins text-warning text-gradient me-1 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['harga'] }} Koin</span><br>
                                        <i class="fas fa-hourglass-start text-primary text-gradient me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['mulai'] }}</span><br>
                                        <i class="fas fa-hourglass-end text-gray-200 me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['selesai'] }}</span><br>
                                        {{-- <i class="fas fa-file-signature text-primary text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['detail'] }}</span><br> --}}
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                    <a href="{{$lelang[$i]['username'] != auth()->user()->username ? url('/lihat-lelang/'.$lelang[$i]['lelang']) : url('/form-lelang/'.$lelang[$i]['lelang'])}}" title="Buka Lelang"
                                        class="btn bg-gradient-info btn-sm mb-0">
                                        {{-- <button type="button" class=""> --}}
                                        Buka Lelang
                                        {{-- </button> --}}
                                    </a>
                                    <div class="avatar-group">
                                        @if($lelang[$i]['ikut'] > 0)
                                        @for ($k = 0; $k < ($lelang[$i]['ikut'] <= 2 ? $lelang[$i]['ikut']*2 : ($lelang[$i]['userikut'] == 1 ? 4 : 5)); $k++)
                                            <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Penggemar yang Ikut Lelang'>
                                            <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                            </a>
                                        @endfor
                                        @if($lelang[$i]['userikut'] == 1)
                                            <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Anda'>
                                            <img src="{{ auth()->user()->gambar_profile != null || auth()->user()->gambar_profile != '' ? auth()->user()->gambar_profile : '../pic/uni-user-4.png' }}" alt="Anda">
                                            </a>
                                        @endif
                                        {{-- @else
                                        <span class="text-end text-secondary mx-3 text-sm">Belum Ada Peserta</span> --}}
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
                                    <h5 class="">
                                        {{$lelang[$i]['produk'] }}
                                    </h5>
                                    <span class="text-end text-secondary mb-2 text-sm">
                                        {{'@'.$lelang[$i]['nama']}}
                                    </span>
                                    <p class="mb-3 text-lg">
                                        <i class="fas fa-map-pin text-info text-gradient pe-2 p-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">Kota {{$lelang[$i]['kota']}}</span><br>
                                        <i class="fas fa-coins text-warning text-gradient me-1 py-1" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['harga'] }} Koin</span><br>
                                        <i class="fas fa-hourglass-start text-primary text-gradient me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['mulai'] }}</span><br>
                                        <i class="fas fa-hourglass-end text-gray-200 me-2" aria-hidden="true"></i>  <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['selesai'] }}</span><br>
                                        {{-- <i class="fas fa-file-signature text-primary text-gradient me-2" aria-hidden="true"></i> <span class="col-md-5 font-weight-bold mb-2 text-sm">{{ $lelang[$i]['detail'] }}</span><br> --}}
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                    <a href="{{$lelang[$i]['username'] != auth()->user()->username ? url('/lihat-lelang/'.$lelang[$i]['lelang']) : url('/form-lelang/'.$lelang[$i]['lelang'])}}" title="Buka Lelang"
                                        class="btn bg-gradient-info btn-sm mb-0">
                                        {{-- <button type="button" class=""> --}}
                                        Buka Lelang
                                        {{-- </button> --}}
                                    </a>
                                    <div class="avatar-group">
                                        @if($lelang[$i]['ikut'] > 0)
                                        @for ($k = 0; $k < ($lelang[$i]['ikut'] <= 2 ? $lelang[$i]['ikut']*2 : ($lelang[$i]['userikut'] == 1 ? 4 : 5)); $k++)
                                            <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Penggemar yang Ikut Lelang'>
                                            <img alt="Image placeholder" src="../assets/img/team-{{ rand(1,8) }}.jpg">
                                            </a>
                                        @endfor
                                        @if($lelang[$i]['userikut'] == 1)
                                            <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title='Anda'>
                                            <img src="{{ auth()->user()->gambar_profile != null || auth()->user()->gambar_profile != '' ? auth()->user()->gambar_profile : '../pic/uni-user-4.png' }}" alt="Anda">
                                            </a>
                                        @endif
                                        {{-- @else
                                        <span class="text-end text-secondary mx-3 text-sm">Belum Ada Peserta</span> --}}
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
