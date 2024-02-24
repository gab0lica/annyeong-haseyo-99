@extends('layouts.user_type.auth')

@section('content')

<div class="row">
    <div class="container-fluid">
        <div class="page-header min-height-200 border-radius-xl mt-2" style="background-image: url('../assets/img/home-decor-3.jpg'); background-position-y: 50%;">
            <span class="mask bg-gradient-dark opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6 my-4">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ auth()->user()->gambar_profile != null || auth()->user()->gambar_profile != '' ? auth()->user()->gambar_profile : '../pic/uni-user-4.png' }}" alt="..."
                          class="w-100 border-radius-lg shadow-sm bg-gradient-dark">
                        {{-- <a href="javascript:;" class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                            <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Image"></i>
                        </a> --}}
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->nama }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ (auth()->user()->role == 2 ? 'Penggemar (Fans)' : ($jenis == 'lelang-penjual' ? 'Penjual' : 'Penggemar (Fans) - Ikut Lelang')) }}
                        </p>
                    </div>
                </div>
                <div class="col-auto text-end my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 px-5"><!--col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3-->
                    <h6 class="mb-0 text-lg font-weight-bold">
                       <i class="fas fa-coins text-warning text-gradient text-lg me-1 py-1"></i> {{ $koinid }} Koin
                    </h6>
                    @if($status != 'Berhasil' && $statuskirim != 'Paket Diterima')
                    <span class="font-weight-bold text-danger text-sm">
                        {{ $jenis == 'lelang' && $status == 'Belum' ? '(Koin Anda belum dipotong dengan Jumlah Penawaran Anda)' :
                        ($jenis == 'lelang-penjual' ? '(Koin Anda belum ditambah dengan Hasil Lelang Anda)' : '')}}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <hr class="horizontal dark my-2">
        <h4 class="text-dark px-2 text-center font-weight-bolder m-0">Nota Lelang</h4>
        <hr class="horizontal dark">
    </div>

    <div class="container-fluid pt-0 py-4">
        <div class="row ">{{--"row mt-lg-n20 mt-md-n11 mt-n10">
        <div class="col-md-8 ">
          <div class="card z-index-0">
             --}}
            <div class="col-md-7 mx-auto">
                <div class="card h-100">
                <div class="card-body pt-4 p-3">
                    {{-- <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Newest</h6> --}}
                    <ul class="list-group">
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Transaksi ID</span>
                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                            {{ $kode }}
                        </span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                            <span class="mb-1 text-dark text-sm">Status Pembayaran</span>
                        <div class="d-flex align-items-center font-weight-bolder text-gradient
                        {{$status == 'Berhasil' ? 'text-success' :
                        ($status == 'Admin' ? 'text-warning' :
                        ($status == 'Belum' ? ( strtotime($maksimaltgl) < strtotime($hari_ini) ? 'text-danger' : 'text-info' ) : 'text-danger'))}} text-sm">
                            {{$status == 'Berhasil' ? $status :
                            ($status == 'Admin' ? 'Menunggu Konfirmasi' :
                            ($status == 'Belum' ? ( strtotime($maksimaltgl) < strtotime($hari_ini) ? 'Tidak Membayar' : 'Menunggu Pembayaran') :
                            ($status == 'Gagal' ? 'Gagal Membayar' :
                            ($status == 'Menunggu' ? 'Menunggu Pengiriman' : $status) )))}}
                        </div>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Tanggal {{$statuskirim == null || $statuskirim == 'Dalam Proses' || $statuskirim == 'Menunggu Pembayaran' ? 'Maksimal' : ''}} Pembayaran</span>
                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                        @php
                            date_default_timezone_set('Asia/Jakarta');
                            $inggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                            $indonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        @endphp
                        {{ $status == 'Belum' ? str_replace($inggris,$indonesia,date('d F Y',strtotime($maksimaltgl)))." 23:59:59" : str_replace($inggris,$indonesia,date('d F Y H:i:s',strtotime($pemenang['tglbayar']))) }}
                        </span>
                    </li>
                    <hr class="my-2 horizontal-dark">
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Jenis Nota</span>
                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                            {{$jenis == 'lelang' ? 'Pemenang Lelang' :
                            ($jenis == 'lelang-penjual' ? 'Penghasilan Penjual dari Lelang' : 'None')}}
                        </span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Nama Produk Merchandise</span>
                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                            {{ $produk }}
                        </span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 ps-0 mb-2 border-radius-lg">
                        <span class="mb-1 text-dark text-sm">{{$jenis == 'lelang' ? 'Jumlah Penawaran Koin yang Dibayar' :
                            ($jenis == 'lelang-penjual' ? 'Hasil Lelang Anda' : '')}}
                            {{-- <b>{{$jenis == 'lelang-penjual' ? $persen.'%' : ''}}</b> --}}
                        </span>
                        <div class="d-flex align-items-center text-md text-gradient font-weight-bolder {{$jenis == 'lelang-penjual' ? 'text-success' : 'text-danger'}}">
                            {{ $jenis == 'lelang' ? ($koin*-1)-($pengiriman['biaya'] != null ? $pengiriman['biaya']/1000 : 0) : ($jenis == 'lelang-penjual' ? $koin-($pengiriman['biaya'] != null ? $pengiriman['biaya']/1000 : 0) : '') }} Koin
                        </div>
                    </li>
                    @if($pengiriman['biaya'] != null)
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Jumlah Ongkir {{$jenis == 'lelang' ? 'yang diBayar' : ''}}</span>
                        <span class="d-flex align-items-center text-md font-weight-bolder text-gradient text-{{$jenis == 'lelang' ? 'danger' : 'success'}}">
                            {{$pengiriman['biaya']/1000}} Koin
                        </span>
                    </li>
                    <hr class="my-2 horizontal-dark">
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Total {{$jenis == 'lelang' ? 'yang harus dibayar' : ''}}</span>
                        <span class="d-flex align-items-center text-md font-weight-bolder text-gradient text-{{$jenis == 'lelang' ? 'danger' : 'success'}}">
                            {{ $jenis == 'lelang' ? ($koin*-1) : ($jenis == 'lelang-penjual' ? $koin : '') }} Koin
                        </span>
                    </li>
                    @endif
                    @if ($berhasil == true)
                    <hr class="my-2 horizontal-dark">
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Nama Penerima</span>
                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                            {{ $pemenang['userNama'] }}
                        </span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Nomor Telepon</span>
                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                            {{ $pemenang['userTelepon'] }}
                        </span>
                    </li>
                    {{-- {{echo $pemenang}} --}}
                    @php
                        // echo $statuskirim;
                    @endphp
                    @if( $alamatkirim != null)
                    <hr class="my-2 horizontal-dark">
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Status Pengiriman</span>
                        <span class="d-flex align-items-center font-weight-bolder text-gradient text-info text-sm">
                            {{ $statuskirim == null ? 'Menunggu Pembayaran' : (
                                $statuskirim == 'Dalam Proses' ? 'Cek Ongkos Pengiriman' : (
                                $statuskirim == 'Menunggu Pembayaran' ? 'Menunggu Pembayaran' : (
                                $statuskirim == 'Pengiriman' || $statuskirim == 1 ? 'Produk Dikemas' : (
                                $statuskirim == 2 ? 'Paket Diserahkan ke Kurir Ekspedisi '.($pengiriman['kurir'] == null ? '' : $pengiriman['kurir']) : (
                                $statuskirim == 3 ? 'Paket dalam Perjalanan' : (
                                $statuskirim == 4 ? 'Paket Telah Sampai di Ekspedisi '.($pengiriman['kurir'] == null ? '' : $pengiriman['kurir']).' Tujuan' : (
                                $statuskirim == 5 ? 'Paket Dikirim ke Alamat Tujuan' : (
                                $statuskirim == 6 ? 'Paket Telah Sampai Tujuan' : (
                                $statuskirim == 7 ? 'Paket Diterima' : $statuskirim)
                                ))))))))
                            }}
                        </span>
                    </li>
                    {{-- @endif
                    @if($alamatkirim != null) --}}
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Alamat Pengiriman</span>
                        <span class="d-flex align-items-center font-weight-bolder text-gradient text-dark text-sm">
                            {{  $alamatkirim != null ? $alamatkirim : ($jenis == 'lelang-penjual' ? 'Menunggu Pembayaran' : '-') }}
                        </span>
                    </li>
                    @endif
                    @if($pengiriman['asal'] != null && $jenis == 'lelang-penjual')
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Lokasi Asal (Anda)</span>
                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                            {{ $pengiriman['asal'] == null ? '-' : $pengiriman['asal'] }} <strong class="ms-2 font-weight-bolder text-danger">({{ auth()->user()->kota == null ? '-' : auth()->user()->kota }})</strong>
                        </span>
                    </li>
                    @endif
                    @if($pengiriman['tujuan'] != null && $jenis == 'lelang-penjual')
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="col-md-4 mb-1 text-dark text-sm">Lokasi Destinasi (Penggemar)</span>
                        <span class="text-dark text-end text-sm font-weight-bold">
                            {{ $pengiriman['tujuan'] == null ? '-' : $pengiriman['tujuan'] }} <strong class="ms-2 font-weight-bolder text-danger">({{ $alamatkirim }})</strong>
                        </span>
                    </li>
                    @endif
                    @if($pengiriman['kurir'] != null)
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Layanan Kurir</span>
                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                            {{ strtoupper($pengiriman['kurir']) == null ? '-' : strtoupper($pengiriman['kurir']) }} {{ $pengiriman['layanan'] == null ? '' : '('.$pengiriman['layanan'].')' }}
                        </span>
                    </li>
                    @endif
                    @if($pengiriman['berat'] != null && $jenis == 'lelang-penjual')
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Berat Paket</span>
                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                            {{ $pengiriman['berat'] == null ? '-' : $pengiriman['berat'] }} Gram
                        </span>
                    </li>
                    @endif
                    @if($pengiriman['waktu'] != null)
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Perkiraan Waktu Pengiriman (dalam Hari)</span>
                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                            {{ $pengiriman['waktu'] == null ? '-' :
                                ( strpos(strtolower($pengiriman['waktu']),'hari') == false
                                || strpos(strtolower($pengiriman['waktu']),'hari') == -1 ? $pengiriman['waktu'].' hari' :
                                str_replace('hari','hari',strtolower($pengiriman['waktu']))) }}
                        </span>
                    </li>
                    @endif
                    @php
                        // echo ($statuskirim == 'Pengiriman' ? 'disabled' : $statuskirim);
                        // echo $status . " " . $jenis;//menunggu pembayaran
                    @endphp
                    @if($jenis == 'lelang' && ($alamatkirim == null || $statuskirim == 'Menunggu Pembayaran'))
                    {{-- <hr class="my-2 horizontal-dark"> --}}
                    @php
                        if($alamatkirim == null){
                            $url = "/kirim-alamat";
                            $keterangan = 'Kirim Alamat Pengiriman';
                        }
                        else {
                            $url = "/bayar-lelang";
                            $keterangan = 'Bayar Lelang';
                        }
                    @endphp
                    <form action={{$url}} method="POST" role="form" class="text-center">
                        @csrf
                        <input type="hidden" id="lelang" name="lelang" value="{{$lelang}}">
                        <input type="hidden" id="trans" name="trans" value="{{$trans}}">
                        <input type="hidden" id="jenis" name="jenis" value="{{$jenis}}">
                        <input type="hidden" id="tanggal_bayar" name="tanggal_bayar" value="{{ $maksimaltgl }}">
                        {{-- <input type="hidden" id="pemenang" name="pemenang" value="{{ $pemenang }}">
                        <input type="hidden" id="penjual" name="penjual" value="{{ $penjual }}">
                        <input type="hidden" id="admin" name="admin" value="{{$admin}}"> --}}

                        {{-- <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md"> --}}
                        <div class="column col-xl-12">
                            @if(strtotime($hari_ini) <= strtotime($maksimaltgl) && $statuskirim == null)
                            <span class="text-sm text-center text-danger m-0 mb-3">
                                <u><strong>Pastikan Alamat Sesuai dengan Tempat Tujuan Anda dan Tidak Bisa Diganti !</strong></u> <br>
                            </span>
                            <div class="form-group px-0 my-0">
                                <textarea id="alamat" name="alamat" type="text" class="form-control" value="{{old('alamat')}}"></textarea>
                                {{-- onchange="cekAlamat()" --}}
                             </div>
                            @endif
                        </div>
                        {{-- </li> --}}
                        @if($koinid+$koin < 0 && $statuskirim == 'Menunggu Pembayaran')
                        {{-- setelah dikurangi yang dibayar, masuk sini berarti lebih dari 0 --}}
                        <div class="row">
                            <span class="text-sm text-center text-danger m-0">
                                <u><strong>Pastikan Deposito Koin Anda Cukup untuk Membayar Sejumlah Penawaran Anda!</strong></u> <br>
                            </span>
                        </div>
                        <a href="{{ url('/beli-koin') }}" target="_blank" class="btn bg-gradient-dark mx-auto my-2">
                            Beli Koin <i class="fas fa-money-bill text-lg ps-0 text-sm ps-2"></i>
                        </a>
                        @elseif(strtotime($hari_ini) <= strtotime($maksimaltgl) && ($statuskirim == 'Menunggu Pembayaran' || $alamatkirim == null))
                        {{-- bayar koin u/ pemenang --}}
                        <button type="submit" class="btn bg-gradient-dark my-2">{{ $keterangan }}</button>
                        @endif
                    </form>
                    @endif
                    @endif
                    <div class="row">
                        {{-- <span class="text-sm text-center text-danger m-0">
                            {{dd($jenis,$status,$alamatkirim,strtotime($maksimaltgl),strtotime($hari_ini),strtotime($hari_ini) <= strtotime($maksimaltgl));}}
                        </span> --}}
                        @if(($jenis == 'lelang-penjual' && $alamatkirim != null) || ($jenis == 'lelang' && $status == 'Berhasil' ))
                        <button type="button" class="col-md-3 btn bg-gradient-dark mx-auto" data-bs-toggle="modal" data-bs-target="#modalTracking">
                            Pengiriman <i class="fas fa-truck ps-0 text-sm ps-2"></i>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="modalTracking" tabindex="-1" role="dialog" aria-labelledby="modalTrackingMessageTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modalTrackingLabel">Pengiriman Produk</h5>
                                </div>
                                <form action={{"/status-pengiriman"}} method="POST" role="form" class="">
                                <div class="modal-body">
                                    @csrf
                                    @if($jenis == 'lelang-penjual')
                                    <div class="row mx-2">
                                        @if ($pengiriman['biaya'] == null)
                                        <span class="text-sm text-center text-dark m-0 mb-2">
                                            <u><strong>Data Pengiriman</strong></u> <br>
                                        </span>
                                        <a href="{{ url('/ongkir/'.$lelang) }}" target="_blank" class="col-md-7 btn bg-gradient-dark mx-auto">
                                            Cek Ongkos Pengiriman <i class="fas fa-money-bill ps-0 text-sm ps-2"></i>
                                        </a>
                                        @else
                                        <span class="text-sm text-center text-danger m-0 mb-2">
                                            <strong>Perhatian Status Pengiriman yang Telah Tersedia !</strong> <br>
                                        </span>
                                        @if($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show text-sm" role="alert">
                                                <span class="text-sm alert-text text-white font-weight-bold">
                                                {{ $errors->first() }}</span>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                    <i class="fa fa-close" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        @endif
                                        <select {{$statuskirim == 'Dalam Proses' || $statuskirim == 'Menunggu Pembayaran' || ($statuskirim > 6 && $statuskirim != 'Pengiriman') ? 'disabled' : ''}}
                                            class="form-control text-capitalize text-center" id="status" name="status">
                                            {{-- value="{{ $statuskirim == 'Dalam Proses' || $statuskirim == 7 ? old('kategori') : $statuskirim }}" --}}
                                            <option {{ ($statuskirim == 'Dalam Proses' ? 'selected' : ($statuskirim == 'Pengiriman' || $statuskirim > 0 ? 'disabled' : '')) }} value="-1">Cek Ongkos Pengiriman</option>
                                            <option {{ ($statuskirim == 'Menunggu Pembayaran' ? 'selected' : ($statuskirim == 'Pengiriman' || $statuskirim > 0 ? 'disabled' : '')) }} value="-2">Menunggu Pembayaran Pengiriman</option>
                                            <option {{ $statuskirim == 'Pengiriman' ? 'selected' : ($statuskirim > 1 ? 'disabled' : '') }} value="1">Produk Dikemas</option>
                                            <option {{ $statuskirim == 2 ? 'selected' : ($statuskirim > 2 && $statuskirim != 'Pengiriman' ? 'disabled' : '') }} value="2">Paket Diserahkan ke Kurir Ekspedisi {{$pengiriman['kurir'] == null ? '' : $pengiriman['kurir']}}</option>
                                            <option {{ $statuskirim == 3 ? 'selected' : ($statuskirim > 3 && $statuskirim != 'Pengiriman' ? 'disabled' : '') }} value="3">Paket dalam Perjalanan</option>
                                            <option {{ $statuskirim == 4 ? 'selected' : ($statuskirim > 4 && $statuskirim != 'Pengiriman' ? 'disabled' : '') }} value="4">Paket Telah Sampai di Ekspedisi {{$pengiriman['kurir'] == null ? '' : $pengiriman['kurir']}} Tujuan</option>
                                            <option {{ $statuskirim == 5 ? 'selected' : ($statuskirim > 5 && $statuskirim != 'Pengiriman' ? 'disabled' : '') }} value="5">Paket Dikirim ke Alamat Tujuan</option>
                                            <option {{ $statuskirim == 6 ? 'selected' : ($statuskirim > 6 && $statuskirim != 'Pengiriman' ? 'disabled' : '') }} value="6">Paket Telah Sampai Tujuan</option>
                                            {{-- <option {{ $statuskirim == 7 ? 'selected' : '' }} value="7">Paket Diterima</option> --}}
                                            {{-- @endforeach --}}
                                        </select>
                                        @endif
                                    </div>
                                    @endif
                                    @if ($pengiriman['biaya'] != null)
                                    <div class="row my-4">
                                        <span class="text-sm text-center text-dark m-0 mb-1">
                                            <u><strong>Status Pengiriman Saat Ini (Bertanda <span class="text-success text-gradient">Hijau</span>)</strong></u> <br>
                                        </span>
                                        <div class="timeline"><!-- timeline-one-side -->
                                            <div class="timeline-block mt-4 mb-3">
                                            <span class="timeline-step">
                                                <i class="fas fa-box-open text-{{($statuskirim != 'Menunggu Pembayaran' && $statuskirim >= 1) || $statuskirim == 'Pengiriman' ? 'success' : 'dark'}} text-gradient"></i>
                                            </span>
                                            <div class="timeline-content ms-0">
                                                <h6 class="text-dark text-sm text-end font-weight-bold mb-0">Produk Dikemas</h6>
                                                {{-- <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p> --}}
                                            </div>
                                            </div>
                                            <div class="timeline-block mt-4 mb-3">
                                            <span class="timeline-step">
                                                <i class="fas fa-landmark text-{{($statuskirim != 'Menunggu Pembayaran' && $statuskirim >= 2) && $statuskirim != 'Pengiriman' ? 'success' : 'dark'}} text-gradient"></i>
                                            </span>
                                            <div class="timeline-content ms-0">
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Paket Diserahkan ke Kurir Ekspedisi {{$pengiriman['kurir'] == null ? '' : strtoupper($pengiriman['kurir'])}}</h6>
                                                {{-- <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p> --}}
                                            </div>
                                            </div>
                                            <div class="timeline-block mt-4 mb-3">
                                            <span class="timeline-step">
                                                <i class="fas fa-truck text-info text-{{($statuskirim != 'Menunggu Pembayaran' && $statuskirim >= 3) && $statuskirim != 'Pengiriman' ? 'success' : 'dark'}} text-gradient"></i>
                                            </span>
                                            <div class="timeline-content ms-0">
                                                <h6 class="text-dark text-sm text-end font-weight-bold mb-0">Paket dalam Perjalanan</h6>
                                                {{-- <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p> --}}
                                            </div>
                                            </div>
                                            <div class="timeline-block mt-4 mb-3">
                                            <span class="timeline-step">
                                                <i class="fas fa-warehouse text-{{($statuskirim != 'Menunggu Pembayaran' && $statuskirim >= 4) && $statuskirim != 'Pengiriman' ? 'success' : 'dark'}} text-gradient"></i>
                                            </span>
                                            <div class="timeline-content ms-0">
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Paket Telah Sampai di Ekspedisi {{$pengiriman['kurir'] == null ? '' : strtoupper($pengiriman['kurir'])}} Tujuan</h6>
                                                {{-- <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">20 DEC 2:20 AM</p> --}}
                                            </div>
                                            </div>
                                            <div class="timeline-block mt-4 mb-3">
                                            <span class="timeline-step">
                                                <i class="fas fa-map-pin text-{{($statuskirim != 'Menunggu Pembayaran' && $statuskirim >= 5) && $statuskirim != 'Pengiriman' ? 'success' : 'dark'}} text-gradient"></i>
                                            </span>
                                            <div class="timeline-content ms-0">
                                                <h6 class="text-dark text-sm text-end font-weight-bold mb-0">Paket Dikirim ke Alamat Tujuan</h6>
                                                {{-- <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">18 DEC 4:54 AM</p> --}}
                                            </div>
                                            </div>
                                            <div class="timeline-block mt-4 mb-3">
                                            <span class="timeline-step">
                                                <i class="fas fa-house-user text-{{($statuskirim != 'Menunggu Pembayaran' && $statuskirim >= 6) && $statuskirim != 'Pengiriman' ? 'success' : 'dark'}} text-gradient"></i>
                                            </span>
                                            <div class="timeline-content ms-0">
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Paket Telah Sampai Tujuan</h6>
                                                {{-- <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">17 DEC</p> --}}
                                            </div>
                                            </div>
                                            <div class="timeline-block mt-4">
                                            <span class="timeline-step">
                                                <i class="fas fa-handshake text-{{($statuskirim != 'Menunggu Pembayaran' && $statuskirim >= 7) && $statuskirim != 'Pengiriman' ? 'success' : 'dark'}} text-gradient"></i>
                                            </span>
                                            <div class="timeline-content ms-0">
                                                <h6 class="text-dark text-sm text-end font-weight-bold mb-0">Paket Diterima</h6>
                                                @if($jenis == 'lelang-penjual' && $statuskirim < 7)<p class="text-danger font-weight-bold text-xs text-end">Menunggu Pemenang Menerima Paket</p>@endif
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @if(($jenis == 'lelang-penjual' && ($statuskirim < 6 || $statuskirim == 'Pengiriman')) || ($jenis == 'lelang' && $statuskirim == 6))
                                <div class="modal-footer">
                                    <input type="hidden" id="terima" name="terima" value="7">
                                    <input type="hidden" id="lelang" name="lelang" value="{{$lelang}}">
                                    <input type="hidden" id="trans" name="trans" value="{{$trans}}">
                                    <button type="submit" id='ubahStatus' name='ubahStatus' class="btn bg-gradient-dark" {{$statuskirim == 'Dalam Proses' || $statuskirim == 'Selesai' ? 'disabled' : ''}}>
                                        {{$jenis == 'lelang-penjual' ? 'Ubah Status' : ($statuskirim == 6 ? 'Paket Diterima' : 'Selesai')}}
                                    </button>
                                </div>
                                </form>
                                @endif
                              </div>
                            </div>
                        </div>
                        @endif
                        @if (strtotime($maksimaltgl) < strtotime($hari_ini) && $status == 'Belum' && $jenis == 'lelang-penjual' && $pemenang['status'] == 'Gagal')
                        <a href="{{ url('/transaksi-ulang/'.$lelang) }}" target="_blank" class="col-md-4 btn bg-gradient-danger mx-auto">
                            Buat Transaksi Ulang <i class="fas fa-file-signature text-lg ps-0 text-sm ps-2"></i>
                        </a>
                        @endif
                        <a href="{{ url(($jenis == 'lelang' ? '/lihat-lelang/' : '/form-lelang/').$lelang) }}" target="_blank" class="col-md-3 btn bg-gradient-dark mx-auto">
                            Lihat Lelang <i class="fas fa-file-contract text-lg ps-0 text-sm ps-2"></i>
                        </a>
                    </div>
                    </ul>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    // function cekAlamat(e) {
    //     console.log(e);
    //     //ajax ambil ongkir
    //     $.ajax({
    //         type: 'GET',
    //         url: "{{ url('/cek-ongkir') }}",
    //         data: {

    //         }
    //     })
    // }
</script>
