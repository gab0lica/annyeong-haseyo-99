{{-- @extends('layouts.user_type.auth')

@section('content') --}}
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../logo/icon-logo.png">
  <title>
    Annyeong Haseyo
  </title>
  {{--     Fonts and icons     --}}
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  {{-- Nucleo Icons --}}
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  {{-- Font Awesome Icons --}}
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  {{-- CSS Files --}}
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- dari projectFAI --}}
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <style>
      footer{
        position: fixed;
        bottom: 0px;
        left: 0px;
        right: 0px;
        text-align: center;
      }
  </style>
</head>
<body>

<div class="row">
    {{-- <div class="col-md-2"> --}}
    <img src="{{$req[2]}}" width="170" height="25" style="float:right;margin:50px 50px 0px 0px" alt="..."/>
    {{-- </div> --}}
    <p class="text-dark text-md m-0 p-0 px-3 pt-2">
        Tanggal Laporan: <strong>{{$hari_ini}}</strong></p>
    {{-- <p class="text-dark text-md m-0 p-0 px-3">
        Urutan Laporan: <strong>Berdasarkan Waktu Dimulai Lelang Terbaru</strong>
        <i class="fas fa-hourglass-start text-primary text-gradient me-1 py-1" aria-hidden="true"></i>
    </p> --}}
    <p class="text-dark text-md m-0 p-0 px-3">
        Laporan: <strong>{{$req[1]['admin'] == 'anda' ? 'Transaksi Pendapatan Anda' : ''}}</strong>
    </p>
    {{-- @if($req[1]['namapenjual'] != null) --}}
    <p class="text-dark text-md m-0 p-0 px-3">
        Penjual Lelang: <strong>{{$req[1]['namapenjual'] == '' ? '-' : $req[1]['namapenjual']}}</strong>
    </p>
    {{-- @endif
    @if($req[1]['mulai'] != null) --}}
    <p class="text-dark text-md p-0 px-3 pb-2">
        Tanggal dan Waktu Lelang: <strong>{{$req[1]['mulai'] != null ? ($req[1]['mulai']." - ".$req[1]['selesai']) : '-'}}</strong>
    </p>
    {{-- @endif --}}
</div>

@foreach($lelang as $idx => $data)

@if ($idx > 0)
<div class="row">
    <div class="align-items-center">
        <img src="{{$req[2]}}" width="170" height="25" style="vertical-align:middle;margin:0px 250px" alt="..."/>
    </div>
</div>
@endif

{{-- <div class="card"> --}}
    {{-- <hr class="horizontal dark my-2"> --}}

    {{-- <div class="container-fluid"> --}}
        <div class="card m-4">
            <div class="card-header p-0 pt-2 text-center">
                <h5 class="text-dark font-weight-bolder p-0 px-3">Data Lelang <u>{{$data['produk']}}</u></h5>
                {{-- <hr class="horizontal dark my-2"> --}}
                {{-- <strong class="text-danger text-sm">(Daftar ini Hanya Ditampilkan untuk Admin Penanggungjawab Lelang)</strong> --}}
                {{-- <h6 class="font-weight-bolder m-0 mb-2">Berdasarkan Tanggal Penawaran Terbaru</h6> --}}
            </div>
            <div class="card-body p-2 pt-0">
                <ul class="list-group px-3">
                    {{-- <hr class="my-2 horizontal-dark"> --}}
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Tanggal Buat Lelang: </span>
                        <span class="font-weight-bolder text-gradient text-dark text-sm">
                            {{$data['buat']}}
                        </span>
                    </li>
                    {{-- <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Nama Produk sebagai Judul: </span>
                        <span class="font-weight-bolder text-gradient text-dark text-sm">
                            {{$data['produk']}}
                        </span>
                    </li> --}}
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Kategori Produk: </span>
                        <span class="font-weight-bolder text-gradient text-dark text-sm">
                            {{$data['kategori']}}
                        </span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Artis yang Terkait: </span>
                        <span class="font-weight-bolder text-gradient text-dark text-sm">
                            {{$data['artis']}}
                        </span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Detail Produk: </span>
                        <span class="font-weight-bolder text-gradient text-dark text-sm">
                            {{$data['detail']}}
                        </span>
                    </li>
                    {{-- <hr class="my-2 horizontal-dark"> --}}
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Harga Penawaran Awal: </span>
                        <span class="font-weight-bolder text-gradient text-dark text-sm">
                            {{$data['harga']}} Koin
                        </span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Tanggal Mulai Lelang: </span>
                        <span class="font-weight-bolder text-gradient text-dark text-sm">
                            {{$data['mulai']}}
                        </span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Tanggal Selesai Lelang: </span>
                        <span class="font-weight-bolder text-gradient text-dark text-sm">
                            {{$data['selesai']}}
                        </span>
                    </li>
                    {{-- <hr class="my-2 horizontal-dark"> --}}
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Admin Penanggung Jawab: </span>
                        <span class="text-gradient text-dark text-sm font-weight-{{$data['idadmin'] == auth()->user()->id ? 'bolder' : 'bold'}}">
                            {{$data['idadmin'] == auth()->user()->id ? 'Anda' : "Admin ID ".$data['idadmin']}}
                        </span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Status Lelang: </span>
                        <span class="text-gradient font-weight-bolder {{ $data['mode'] == 'peringatan' && $data['status'] == 2 ? 'text-danger' : 'text-dark'}} text-capitalize text-sm">
                            {{ $data['mode'] == 'peringatan' && $data['status'] == 2 ? "Perbaikan  (".$detail['catatan'].")" :
                            ($data['status'] == 1 ? ($data['mode'] == 'belum-penawar' ? 'Dianggap Perbaikan Karena Lelang Selesai Tanpa Penawar' : 'Sedang Berjalan') :
                            ($data['status'] == -1 ? 'Belum Dirilis' :
                            ($data['status'] == 3 ? 'Lelang Selesai' : 'Non-Aktif'))) }}
                            </h6>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    {{-- </div> --}}
    {{-- <hr class="horizontal dark my-2 mb-4"> --}}

@if ($data['idadmin'] == auth()->user()->id)
    @if(count($data['penawar']) > 0)
    {{-- <div class="container-fluid"> --}}
        <div class="card m-4">
            <div class="card-header p-0 pt-2 text-center">
                <h5 class="text-dark font-weight-bolder p-0 px-3">Daftar Penawar Lelang <u>{{$data['produk']}}</u></h5>
                {{-- <strong class="text-danger text-sm">(Daftar ini Hanya Ditampilkan untuk Admin Penanggungjawab Lelang)</strong> --}}
                <h6 class="font-weight-bolder p-0 px-3">Berdasarkan Tanggal Penawaran Terbaru</h6>
                {{-- <hr class="horizontal dark my-2"> --}}
            </div>
            @if(count($data['penawar']) > 0)
            <div class="card-body p-2 pt-0">
                <div class="table-responsive p-1">
                    <table class="table align-items-center mb-0">
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
                        {{-- @if (count($data['penawar']) > 0) --}}
                        @for ($i = 0; $i < count($data['penawar']); $i+=1)
                        <tr class="text-dark">
                            <td class="ps-4">
                                <p class="text-sm mb-0">
                                    {{ ($i+1) }}.
                                </p>
                            </td>
                            <td class="">
                                <p class="text-sm text-center mb-0">
                                    {{$data['penawar'][$i]['nama']}}
                                </p>
                            </td>
                            <td class="">
                                <p class="text-sm text-center {{$data['penawar'][$i]['status'] == 1 ? '' : 'text-danger font-weight-bolder'}} mb-0">
                                    {{$data['penawar'][$i]['status'] == 1 ? 'Pertama' : 'Kedua (Terakhir)'}}
                                </p>
                            </td>
                            <td class="">
                                @php
                                    $inggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                    $indonesia = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
                                    // $indonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                @endphp
                                <p class="text-sm text-center mb-0">
                                    {{ str_replace($inggris,$indonesia,date('d F Y H:i:s',strtotime($data['penawar'][$i]['tgl']))) }}
                                </p>
                            </td>
                            <td class="{{$data['tertinggi'][0] == $data['penawar'][$i]['koin'] && $data['tertinggi'][1] == $data['penawar'][$i]['nama'] ? 'text-success' : ''}}">
                                <p class="text-sm text-center font-weight-bolder mb-0">
                                    {{ $data['penawar'][$i]['koin'] }} Koin
                                    @if ($data['tertinggi'][0] == $data['penawar'][$i]['koin'] && $data['tertinggi'][1] == $data['penawar'][$i]['nama'])
                                        (Pemenang)
                                        {{-- <i class="fas fa-trophy text-lg text-white"></i> {{$data['penawar'][$i]['menang'] != null ? $data['penawar'][$i]['menang'] : ''}} --}}
                                    @endif
                                </p>
                            </td>
                        </tr>
                        @endfor
                        {{-- @else
                            <tr class="text-dark">
                                <td class="ps-4">
                                    <p class="text-sm font-weight-bold mb-0">
                                        Belum Ada Penawar
                                    </p>
                                </td>
                            </tr>
                        @endif --}}
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    {{-- </div> --}}
    {{-- <hr class="horizontal dark my-2 mb-4"> --}}
    @endif

    @if ($data['pemenang']['koin'] != null && $data['penjual']['koin'] != null && $data['admin']['koin'] != null)
    {{-- <div class="container-fluid"> --}}
        <div class="card m-4">
            <div class="card-header p-0 pt-2 text-center">
                <h5 class="text-dark font-weight-bolder p-0 px-3">Transaksi Lelang <u>{{$data['produk']}}</u></h5>
                <span class="text-danger text-sm font-weight-bolder p-0 px-3"> <u>Persentase Admin <strong class="text-lg">5%</strong> dari Jumlah Penawaran Akhir</u> </span>
                {{-- <strong class="text-danger text-sm">(Daftar ini Hanya Ditampilkan untuk Admin Penanggungjawab Lelang)</strong> --}}
                @if ($data['status'] == 1)
                <h6 class="font-weight-bolder p-0 px-3">{{$data['pemenang']['maksimal']}}</h6>
                @endif
                {{-- <hr class="horizontal dark my-2"> --}}
            </div>
            <div class="card-body p-2 pt-0">
                <div class="table-responsive p-1">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="col-md-2 text-secondary text-sm font-weight-bolder opacity-7">
                                    ID transaksi
                                </th>
                                <th class="col-md-3 text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                    Nama User
                                </th>
                                <th class="col-md-3 text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                    Koin
                                </th>
                                <th class="col-md-3 text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                    tanggal pembayaran
                                </th>
                                <th class="col-md-2 text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr class="text-dark">
                            <td class="ps-4">
                                <p class="text-sm mb-0">
                                    {{-- {{ ($i+1) }}. --}}
                                    {{$data['pemenang']['kode']}}
                                </p>
                            </td>
                            <td class="">
                                <p class="text-sm text-center mb-0">
                                    <strong>{{$data['pemenang']['nama']}}</strong> (Pemenang Lelang)
                                </p>
                            </td>
                            <td class="">
                                <p class="text-sm text-center mb-0">
                                    Penawaran Akhir <strong>{{ ($data['pemenang']['koin']*-1) - ($data['pengiriman']['biaya']/1000) }}</strong>
                                    @if ($data['pengiriman']['biaya'] != null)
                                    + Ongkir <strong>{{ ($data['pengiriman']['biaya']/1000) }}</strong> <i class="p-1 text-lg fas fa-coins text-gradient text-warning" aria-hidden="true"></i>
                                    @endif
                                </p>
                            </td>
                            <td class="">
                                @php
                                    $inggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                    $indonesia = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
                                    // $indonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                @endphp
                                <p class="text-sm text-center mb-0">
                                    {{ str_replace($inggris,$indonesia,date('d F Y H:i:s',strtotime($data['pemenang']['tanggal']))) }}
                                </p>
                            </td>
                            <td class="">
                                <p class="text-sm text-center text-gradient font-weight-bolder text-{{$data['pemenang']['status'] == 'Berhasil' ? 'success' : 'info'}} mb-0">
                                    {{ $data['pemenang']['status'] }}
                                </p>
                            </td>
                        </tr>
                        <tr class="text-dark">
                            <td class="ps-4">
                                <p class="text-sm mb-0">
                                    {{-- {{ ($i+1) }}. --}}
                                    {{$data['penjual']['kode']}}
                                </p>
                            </td>
                            <td class="">
                                <p class="text-sm text-center mb-0">
                                    <strong>{{$data['penjual']['nama']}}</strong> (Penjual Pemilik Lelang)
                                </p>
                            </td>
                            <td class="">
                                <p class="text-sm text-center mb-0">
                                    Penghasilan Lelang <strong>{{ $data['penjual']['koin'] - ($data['pengiriman']['biaya']/1000) }}</strong>
                                    @if($data['pengiriman']['biaya'] != null)
                                    + Ongkir <strong>{{ ($data['pengiriman']['biaya']/1000) }}</strong> <i class="p-1 text-lg fas fa-coins text-gradient text-warning" aria-hidden="true"></i>
                                    @endif
                                </p>
                            </td>
                            <td class="">
                                @php
                                    $inggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                    $indonesia = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
                                    // $indonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                @endphp
                                <p class="text-sm text-center mb-0">
                                    {{ str_replace($inggris,$indonesia,date('d F Y H:i:s',strtotime($data['penjual']['tanggal']))) }}
                                </p>
                            </td>
                            <td class="">
                                <p class="text-sm text-center text-gradient font-weight-bolder text-{{$data['penjual']['status'] == 'Berhasil' ? 'success' : 'info'}} mb-0">
                                    {{ $data['penjual']['status'] }}
                                </p>
                            </td>
                        </tr>
                        <tr class="text-dark">
                            <td class="ps-4">
                                <p class="text-sm mb-0">
                                    {{-- {{ ($i+1) }}. --}}
                                    {{$data['admin']['kode']}}
                                </p>
                            </td>
                            <td class="">
                                <p class="text-sm text-center mb-0">
                                    <strong>{{$data['admin']['nama']}}</strong> (Admin Penanggungjawab Lelang)
                                </p>
                            </td>
                            <td class="">
                                <p class="text-sm text-center mb-0">
                                    Pendapatan Hasil Lelang <strong>{{ $data['admin']['koin'] }}</strong> <i class="p-1 text-lg fas fa-coins text-gradient text-warning" aria-hidden="true"></i>
                                </p>
                            </td>
                            <td class="">
                                @php
                                    $inggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                    $indonesia = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
                                    // $indonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                @endphp
                                <p class="text-sm text-center mb-0">
                                    {{ str_replace($inggris,$indonesia,date('d F Y H:i:s',strtotime($data['admin']['tanggal']))) }}
                                </p>
                            </td>
                            <td class="">
                                <p class="text-sm text-center text-gradient font-weight-bolder text-{{$data['admin']['status'] == 'Berhasil' ? 'success' : 'info'}} mb-0">
                                    {{ $data['admin']['status'] }}
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    {{-- </div> --}}
    {{-- <hr class="horizontal dark my-2 mb-4"> --}}
    @endif

    @if ($data['pengiriman']['biaya'] != null)
    {{-- <div class="container-fluid"> --}}
        <div class="card m-4">
            <div class="card-header p-0 pt-2 text-center">
                <h5 class="text-dark font-weight-bolder p-0 px-3">Pengiriman Lelang <u>{{$data['produk']}}</u></h5>
                {{-- <button type="button" class="btn bg-gradient-dark m-1 mb-0" data-bs-toggle="modal" data-bs-target="#modalTracking">
                    Lihat Pengiriman <i class="fas fa-truck ps-0 text-sm ps-2"></i>
                </button>
                <div class="modal fade" id="modalTracking" tabindex="-1" role="dialog" aria-labelledby="modalTrackingMessageTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="modalTrackingLabel">Tracking Pengiriman</h5>
                          <button type="button" class="btn btn-link text-secondary" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                        </div>
                        <div class="modal-body">
                            @if ($data['pengiriman']['biaya'] != null)
                            <div class="row my-4">
                                <span class="text-sm text-center text-dark m-0 mb-1">
                                    <u><strong>Status Pengiriman Saat Ini (Bertanda <span class="text-success text-gradient">Hijau</span>)</strong></u> <br>
                                </span>
                                <div class="timeline">
                                    <div class="timeline-block mt-4 mb-3">
                                    <span class="timeline-step">
                                        <i class="fas fa-box-open text-{{($data['pengiriman']['status'] != 'Menunggu Pembayaran' && $data['pengiriman']['status'] >= 1) || $data['pengiriman']['status'] == 'Pengiriman' ? 'success' : 'dark'}} text-gradient"></i>
                                    </span>
                                    <div class="timeline-content ms-0">
                                        <h6 class="text-dark text-sm text-end font-weight-bold mb-0">Produk Dikemas</h6>
                                    </div>
                                    </div>
                                    <div class="timeline-block mt-4 mb-3">
                                    <span class="timeline-step">
                                        <i class="fas fa-landmark text-{{($data['pengiriman']['status'] != 'Menunggu Pembayaran' && $data['pengiriman']['status'] >= 2) && $data['pengiriman']['status'] != 'Pengiriman' ? 'success' : 'dark'}} text-gradient"></i>
                                    </span>
                                    <div class="timeline-content ms-0">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Paket Diserahkan ke Kurir Ekspedisi {{$data['pengiriman']['kurir'] == null ? '' : strtoupper($data['pengiriman']['kurir'])}}</h6>
                                    </div>
                                    </div>
                                    <div class="timeline-block mt-4 mb-3">
                                    <span class="timeline-step">
                                        <i class="fas fa-truck text-info text-{{($data['pengiriman']['status'] != 'Menunggu Pembayaran' && $data['pengiriman']['status'] >= 3) && $data['pengiriman']['status'] != 'Pengiriman' ? 'success' : 'dark'}} text-gradient"></i>
                                    </span>
                                    <div class="timeline-content ms-0">
                                        <h6 class="text-dark text-sm text-end font-weight-bold mb-0">Paket dalam Perjalanan</h6>
                                    </div>
                                    </div>
                                    <div class="timeline-block mt-4 mb-3">
                                    <span class="timeline-step">
                                        <i class="fas fa-warehouse text-{{($data['pengiriman']['status'] != 'Menunggu Pembayaran' && $data['pengiriman']['status'] >= 4) && $data['pengiriman']['status'] != 'Pengiriman' ? 'success' : 'dark'}} text-gradient"></i>
                                    </span>
                                    <div class="timeline-content ms-0">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Paket Telah Sampai di Ekspedisi {{$data['pengiriman']['kurir'] == null ? '' : strtoupper($data['pengiriman']['kurir'])}} Tujuan</h6>
                                    </div>
                                    </div>
                                    <div class="timeline-block mt-4 mb-3">
                                    <span class="timeline-step">
                                        <i class="fas fa-map-pin text-{{($data['pengiriman']['status'] != 'Menunggu Pembayaran' && $data['pengiriman']['status'] >= 5) && $data['pengiriman']['status'] != 'Pengiriman' ? 'success' : 'dark'}} text-gradient"></i>
                                    </span>
                                    <div class="timeline-content ms-0">
                                        <h6 class="text-dark text-sm text-end font-weight-bold mb-0">Paket Dikirim ke Alamat Tujuan</h6>
                                    </div>
                                    </div>
                                    <div class="timeline-block mt-4 mb-3">
                                    <span class="timeline-step">
                                        <i class="fas fa-house-user text-{{($data['pengiriman']['status'] != 'Menunggu Pembayaran' && $data['pengiriman']['status'] >= 6) && $data['pengiriman']['status'] != 'Pengiriman' ? 'success' : 'dark'}} text-gradient"></i>
                                    </span>
                                    <div class="timeline-content ms-0">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Paket Telah Sampai Tujuan</h6>
                                    </div>
                                    </div>
                                    <div class="timeline-block mt-4">
                                    <span class="timeline-step">
                                        <i class="fas fa-handshake text-{{($data['pengiriman']['status'] != 'Menunggu Pembayaran' && $data['pengiriman']['status'] >= 7) && $data['pengiriman']['status'] != 'Pengiriman' ? 'success' : 'dark'}} text-gradient"></i>
                                    </span>
                                    <div class="timeline-content ms-0">
                                        <h6 class="text-dark text-sm text-end font-weight-bold mb-0">Paket Diterima</h6>
                                        @if($data['pengiriman']['status'] < 7)<p class="text-danger font-weight-bold text-xs text-end">Menunggu Pemenang Menerima Paket</p>@endif
                                    </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                      </div>
                    </div>
                </div> --}}
                {{-- <hr class="horizontal dark my-2"> --}}
                {{-- <strong class="text-danger text-sm">(Daftar ini Hanya Ditampilkan untuk Admin Penanggungjawab Lelang)</strong> --}}
                {{-- <h6 class="font-weight-bolder m-0 mb-2">Berdasarkan Tanggal Penawaran Terbaru</h6> --}}
            </div>
            <div class="card-body p-2 pt-0">
                <ul class="list-group px-3">
                    @if($data['pengiriman']['alamat'] != null)
                    {{-- <hr class="my-2 horizontal-dark"> --}}
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Status Pengiriman: </span>
                        <span class="font-weight-bolder text-gradient text-info text-sm">
                            {{ $data['pengiriman']['status'] == null ? 'Menunggu Pembayaran' : (
                                $data['pengiriman']['status'] == 'Dalam Proses' ? 'Cek Ongkos Pengiriman' : (
                                $data['pengiriman']['status'] == 'Menunggu Pembayaran' ? 'Menunggu Pembayaran' : (
                                $data['pengiriman']['status'] == 'Pengiriman' || $data['pengiriman']['status'] == 1 ? 'Produk Dikemas' : (
                                $data['pengiriman']['status'] == 2 ? 'Paket Diserahkan ke Kurir Ekspedisi '.($data['pengiriman']['kurir'] == null ? '' : $data['pengiriman']['kurir']) : (
                                $data['pengiriman']['status'] == 3 ? 'Paket dalam Perjalanan' : (
                                $data['pengiriman']['status'] == 4 ? 'Paket Telah Sampai di Ekspedisi '.($data['pengiriman']['kurir'] == null ? '' : $data['pengiriman']['kurir']).' Tujuan' : (
                                $data['pengiriman']['status'] == 5 ? 'Paket Dikirim ke Alamat Tujuan' : (
                                $data['pengiriman']['status'] == 6 ? 'Paket Telah Sampai Tujuan' : (
                                $data['pengiriman']['status'] == 7 ? 'Paket Diterima' : $data['pengiriman']['status'])
                                ))))))))
                            }}
                        </span>
                    </li>
                    {{-- @endif
                    @if($data['pengiriman']['alamat'] != null) --}}
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Alamat Pengiriman: </span>
                        <span class="font-weight-bolder text-gradient text-dark text-sm">
                            {{  $data['pengiriman']['alamat'] != null ? $data['pengiriman']['alamat'] : '-' }}
                        </span>
                    </li>
                    @endif
                    @if($data['pengiriman']['asal'] != null)
                    {{--  && $jenis == 'lelang-penjual' --}}
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Lokasi Asal (Anda): </span>
                        <span class="text-dark text-sm font-weight-bold">
                            {{ $data['pengiriman']['asal'] == null ? '-' : $data['pengiriman']['asal'] }} <strong class="ms-2 font-weight-bolder text-danger">({{ $data['penjual']['kota'] == null ? '-' : $data['penjual']['kota'] }})</strong>
                        </span>
                    </li>
                    @endif
                    @if($data['pengiriman']['tujuan'] != null)
                    {{--  && $jenis == 'lelang-penjual' --}}
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Lokasi Destinasi (Penggemar): </span>
                        <span class="text-dark text-end text-sm font-weight-bold">
                            {{ $data['pengiriman']['tujuan'] == null ? '-' : $data['pengiriman']['tujuan'] }} <strong class="ms-2 font-weight-bolder text-danger">({{ $data['pengiriman']['alamat'] }})</strong>
                        </span>
                    </li>
                    @endif
                    @if($data['pengiriman']['kurir'] != null)
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Layanan Kurir: </span>
                        <span class="text-dark text-sm font-weight-bold">
                            {{ strtoupper($data['pengiriman']['kurir']) == null ? '-' : strtoupper($data['pengiriman']['kurir']) }} {{ $data['pengiriman']['layanan'] == null ? '' : '('.$data['pengiriman']['layanan'].')' }}
                        </span>
                    </li>
                    @endif
                    @if($data['pengiriman']['berat'] != null)
                    {{--  && $jenis == 'lelang-penjual' --}}
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Berat Paket: </span>
                        <span class="text-dark text-sm font-weight-bold">
                            {{ $data['pengiriman']['berat'] == null ? '-' : $data['pengiriman']['berat'] }} Gram
                        </span>
                    </li>
                    @endif
                    @if($data['pengiriman']['waktu'] != null)
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Perkiraan Waktu Pengiriman (dalam Hari: )</span>
                        <span class="text-dark text-sm font-weight-bold">
                            {{ $data['pengiriman']['waktu'] == null ? '-' :
                                ( strpos(strtolower($data['pengiriman']['waktu']),'hari') == false
                                || strpos(strtolower($data['pengiriman']['waktu']),'hari') == -1 ? $data['pengiriman']['waktu'].' hari' :
                                str_replace('hari','hari',strtolower($data['pengiriman']['waktu']))) }}
                        </span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    {{-- </div> --}}
    @endif
@endif
{{-- <hr class="my-4 horizontal-dark"> --}}

{{-- </div> --}}
@endforeach
<footer class="footer">
    <div class="row align-items-center">
        <div class="copyright text-center text-sm text-muted m-2">
            © <script>
                document.write(new Date().getFullYear())
            </script>
            Annyeong Haseyo! Berita Terbaru tentang Hiburan Korea dan K-POP dari
            Dispatch, The Korea Times dan Korea Herald
            juga Lelang Merchandise Harga Terjangkau
        </div>
    </div>
</footer>

{{-- @include('layouts.footers.auth.footer') --}}
{{-- <footer></footer> --}}

<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>
<script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="../assets/js/plugins/fullcalendar.min.js"></script>
<script src="../assets/js/plugins/chartjs.min.js"></script>

{{-- Github buttons --}}
<script async defer src="https://buttons.github.io/buttons.js"></script>
{{-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc --}}
<script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>

</body>
</html>

{{-- @endsection --}}
