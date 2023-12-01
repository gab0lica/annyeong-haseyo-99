
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
                        <h5 class="text-dark font-weight-bolder m-0">Daftar Penawar dari Lelang {{$detail['judul']}}</h5>
                        <a href="{{ url('/form-lelang/'.$detail['id']) }}" class="btn bg-gradient-dark btn-md m-1">
                            Kembali ke Lelang {{$detail['judul']}} <i class="fas fa-file-contract text-lg text-white mx-1" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="col-auto text-end my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 px-5"><!--col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3-->
                    {{-- <h6 class="mb-1">
                        {{ __('Penjual') }}
                    </h6> --}}
                    {{-- <h6 class="mb-1">
                        {{ auth()->user()->nama }}
                    </h6> --}}
                    <h6 class="mb-0 text-lg font-weight-bold">
                        <i class="fas fa-coins text-warning text-gradient text-lg p-1"></i> {{ $koin }} Koin
                    </h6>
                    <h6 class="mb-0 text-lg font-weight-bold">
                        <i class="fas fa-users text-info text-gradient opacity-10 px-2"></i> {{ $ikut }} Pengikut
                        {{-- @if($koin <= 0 && $pesan != 'penggemar')<span class="font-weight-bold text-danger text-sm">(Anda harus Membeli Koin untuk Registrasi)</span>@endif --}}
                    </h6>
                </div>
            </div>
        </div>
    </div>

{{-- profile.blade.php >> lebih banyak isinya --}}
    <div class="container-fluid py-3">
        {{-- <div class="row"> --}}
            <div class="card h-100">
                <div class="card-headerp-0 pt-2 text-center">
                    <h6 class="m-0 font-weight-bolder">Berdasarkan Tanggal Penawaran Terbaru</h6>
                </div>
                <div class="card-body p-2 pt-0">
                <div class="table-responsive p-1">
                    <table class="table align-items-center mb-0">
                    {{-- <ul class="list-group"> --}}
                        <thead>
                            <tr>
                                <th class="text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                    No.
                                </th>
                                <th class="col-md-3 text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                    Nama Penawar (Penggemar/Penjual Lain)
                                </th>
                                <th class="col-md-2 text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                    Kesempatan
                                </th>
                                <th class="col-md-3 text-center text-capitalize text-dark text-sm font-weight-bolder">
                                    <u>Tanggal</u>
                                </th>
                                <th class="col-md-3 text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                    Jumlah Koin
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($penawar) > 0)
                        @for ($i = 0; $i < count($penawar); $i+=1)
                        <tr class="text-dark">
                            <td class="ps-4">
                                <p class="text-sm mb-0">
                                    {{ ($i+1) }}.
                                </p>
                            </td>
                            <td class="">
                                <p class="text-sm text-center mb-0">
                                    {{$penawar[$i]['nama']}}
                                </p>
                            </td>
                            <td class="">
                                <p class="text-sm text-center {{$penawar[$i]['status'] == 1 ? '' : 'text-danger font-weight-bolder'}} mb-0">
                                    {{$penawar[$i]['status'] == 1 ? 'Pertama' : 'Kedua (Terakhir)'}}
                                </p>
                            </td>
                            <td class="">
                                @php
                                    $inggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                    $indonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                @endphp
                                <p class="text-sm text-center mb-0">
                                    {{ str_replace($inggris,$indonesia,date('d F Y H:i:s',strtotime($penawar[$i]['tgl']))) }}
                                </p>
                            </td>
                            <td class="{{$tertinggi[0] == $penawar[$i]['koin'] ? 'bg-gradient-success border-radius-xl text-white' : ''}}">
                                <p class="text-sm text-center font-weight-bolder mb-0">
                                    {{ $penawar[$i]['koin'] }} Koin
                                    @if ($tertinggi[0] == $penawar[$i]['koin'])
                                        <i class="fas fa-trophy text-lg text-white"></i> {{$penawar[$i]['menang'] != 0 ? $penawar[$i]['menang'] : ''}}
                                    @endif
                                </p>
                            </td>
                        </tr>
                        {{-- <li class="list-group-item border-0 d-flex align-items-center px-0">
                            <div class="col-md-5 d-flex align-items-start flex-column justify-content-center">
                                <h5 class="mb-0">{{$penawar[$i]['nama']}} <i class="fas fa-user text-info text-gradient opacity-10 px-2"></i></h5>
                                <span class="mb-0 text-sm text-secondary">
                                    Ke-{{$penawar[$i]['status']}}
                                </span>
                            </div>
                            <div class="col-md-5 align-items-center d-flex">
                                @php
                                    $inggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                    $indonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                    @endphp
                                <span class="mb-0 text-lg text-secondary">
                                    {{ str_replace($inggris,$indonesia,date('d F Y H:i:s',strtotime($penawar[$i]['tgl']))) }}
                                </span>
                            </div>
                            <div class="align-items-end">
                                <h5 class="mb-0">{{ $penawar[$i]['koin'] }} Koin <i class="fas fa-coins text-warning text-gradient opacity-10 px-2"></i></h5>
                                @if ($tertinggi[0] == $penawar[$i]['koin'] && $tertinggi[1] == $penawar[$i]['nama'])
                                <span class="mb-0 text-md text-success text-gradient font-weight-bolder">
                                    Tertinggi
                                </span>
                                @endif
                            </div>
                        </li> --}}
                        {{-- <hr> --}}
                        @endfor
                        @else
                            <tr class="text-dark">
                                <td class="ps-4">
                                    <p class="text-sm font-weight-bold mb-0">
                                        Belum Ada Penawar
                                    </p>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    {{-- </ul> --}}
                    </table>
                </div>
                </div>
            </div>
        {{-- </div> --}}
    </div>
</div>
@endsection

