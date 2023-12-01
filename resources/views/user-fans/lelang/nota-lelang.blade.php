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
                    @if($status == 'Belum')
                    <span class="font-weight-bold text-danger text-sm">
                        (Koin Anda belum {{ $jenis == 'lelang' ? 'dipotong dengan Jumlah Penawaran Anda' :
                        ($jenis == 'lelang-penjual' ? 'ditambah dengan Hasil Lelang Anda' : '')}})
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
                            ($status == 'Gagal' ? 'Gagal Membayar' : '' )))}}
                        </div>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Tanggal {{$statuskirim == null ? 'Maksimal' : ''}} Pembayaran</span>
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
                            {{$jenis == 'lelang' ? 'Lelang' :
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
                            {{ $jenis == 'lelang' ? $koin*-1 : ($jenis == 'lelang-penjual' ? $koin : '') }} Koin
                        </div>
                    </li>
                    <hr class="my-2 horizontal-dark">
                    {{-- @if ($jenis == 'lelang-penjual') --}}
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
                    {{-- @endif --}}
                    @if( $alamatkirim != null)
                    <hr class="my-2 horizontal-dark">
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Status Pengiriman</span>
                        <span class="d-flex align-items-center font-weight-bolder text-gradient text-info text-sm">
                        {{ $jenis == 'lelang' ?
                        ($statuskirim == null ? 'Menunggu Pembayaran' :
                        ($statuskirim == 'Dalam Proses' || $statuskirim == 'Pengiriman' ? 'Validasi dan Pengiriman' : $statuskirim)) :
                        ($jenis == 'lelang-penjual' ?
                        ($statuskirim == null ? 'Menunggu Pembayaran' :
                        ($statuskirim == 'Dalam Proses' ? 'Cek Ongkos Pengiriman' :
                        ($statuskirim == 'Pengiriman' ? 'Proses Pengiriman' : $statuskirim)))
                        : '') }}
                        </span>
                    </li>
                    @endif
                    @if($status != 'Belum')
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Alamat Pengiriman</span>
                        <span class="d-flex align-items-center font-weight-bolder text-gradient text-dark text-sm">
                            {{  $alamatkirim != null ? $alamatkirim : ($jenis == 'lelang-penjual' ? 'Menunggu Pembayaran' : '') }}
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
                        <span class="mb-1 text-dark text-sm">Lokasi Destinasi (Penggemar)</span>
                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
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
                    @if($pengiriman['biaya'] != null)
                    <hr class="my-2 horizontal-dark">
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Jumlah Ongkir</span>
                        <span class="d-flex align-items-center font-weight-bolder text-gradient text-dark text-sm">
                            Rp {{$pengiriman['biaya']}},-
                        </span>
                    </li>
                    {{-- <div class="row">
                        <span class="col-md-6 text-sm text-left text-dark m-0 mb-3">
                            Jumlah Ongkir
                        </span>
                        <span class="col-md-6 text-sm text-end text-dark m-0 mb-3">

                        </span>
                    </div> --}}
                    @endif
                    @if($jenis == 'lelang' && $status == 'Belum' && $alamatkirim == null)
                    {{-- <hr class="my-2 horizontal-dark"> --}}
                    <form action={{"/bayar-lelang"}} method="POST" role="form" class="text-center">
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
                            @if(strtotime($hari_ini) <= strtotime($maksimaltgl) && $status == 'Belum')
                            <span class="text-sm text-center text-danger m-0 mb-3">
                                <u><strong>Pastikan Alamat Sesuai dengan Tempat Tujuan Anda dan Tidak Bisa Diganti !</strong></u> <br>
                            </span>
                            <div class="form-group px-0 my-0">
                                <textarea id="alamat" name="alamat" type="text" class="form-control" value="{{old('alamat')}}"></textarea>
                             </div>
                            @endif
                        </div>
                        {{-- </li> --}}
                        @if($koinid+$koin < 0)
                        {{-- setelah dikurangi yang dibayar, masuk sini berarti lebih dari 0 --}}
                            <a href="{{ url('/beli-koin') }}" target="_blank" class="btn bg-gradient-dark mx-auto">
                                Beli Koin
                            </a>
                        @elseif(strtotime($hari_ini) <= strtotime($maksimaltgl) && $status == 'Belum')
                        {{-- bayar koin u/ pemenang --}}
                            <div class="row">
                                <span class="text-sm text-center text-danger m-0">
                                    <u><strong>Pastikan Deposito Koin Anda Cukup untuk Membayar Sejumlah Penawaran Anda!</strong></u> <br>
                                </span>
                            </div>
                        @endif
                        <button type="submit" class="btn bg-gradient-dark my-2">Bayar</button>
                    </form>
                    @endif
                    <div class="row">
                        {{-- <span class="text-sm text-center text-danger m-0">
                            {{dd($jenis,$status,$alamatkirim,strtotime($maksimaltgl),strtotime($hari_ini),strtotime($hari_ini) <= strtotime($maksimaltgl));}}
                        </span> --}}
                        @if($jenis == 'lelang-penjual' && $alamatkirim != null)
                        <button type="button" class="col-md-3 btn bg-gradient-dark mx-auto" data-bs-toggle="modal" data-bs-target="#modalIkutLelang">
                            Pengiriman <i class="fas fa-truck ps-0 text-sm ps-2"></i>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="modalIkutLelang" tabindex="-1" role="dialog" aria-labelledby="modalIkutLelangMessageTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modalIkutLelangLabel">Pengiriman Produk</h5>
                                </div>
                                <form action={{"/status-pengiriman"}} method="POST" role="form" class="">
                                <div class="modal-body">
                                      @csrf
                                      <div class="row mx-2">
                                        @if ($pengiriman['biaya'] == null)
                                        <span class="text-sm text-center text-dark m-0 mb-2">
                                            <u><strong>Data Pengiriman</strong></u> <br>
                                        </span>
                                        <a href="{{ url('/ongkir/'.$lelang) }}" target="_blank" class="col-md-7 btn bg-gradient-dark mx-auto">
                                            Cek Ongkos Pengiriman <i class="fas fa-money-bill ps-0 text-sm ps-2"></i>
                                        </a>
                                        @endif
                                        <span class="text-sm text-center text-dark m-0 mb-1">
                                            <u><strong>Status Pengiriman</strong></u> <br>
                                        </span>
                                        <span class="text-sm text-center text-danger m-0 mb-2">
                                            <strong>Perhatian Status Pengiriman yang Telah Tersedia !</strong> <br>
                                        </span>
                                        <select {{$statuskirim == 'Dalam Proses' || $statuskirim == 'Selesai' ? 'disabled' : ''}}
                                            class="form-control text-capitalize text-center" id="status" name="status"
                                            value="{{ $statuskirim == 'Dalam Proses' || $statuskirim == 'Selesai' ? old('kategori') : $statuskirim }}">
                                            <option {{ $statuskirim == 'Dalam Proses' ? 'selected' : '' }}>Validasi dan Pengiriman</option>
                                            {{-- <option {{ $statuskirim != 'Dalam Proses' && $statuskirim == "" ? 'selected' : '' }}></option> --}}
                                            <option {{ $statuskirim != 'Dalam Proses' && $statuskirim == "Produk Dikemas dalam Paket" ? 'selected' : '' }}>Produk Dikemas dalam Paket</option>
                                            <option {{ $statuskirim != 'Dalam Proses' && $statuskirim == "Paket Diserahkan ke Kurir Ekspedisi".($pengiriman['kurir'] == null ? '' : $pengiriman['kurir']) ? 'selected' : '' }}>Paket Diserahkan ke Kurir Ekspedisi {{$pengiriman['kurir'] == null ? '' : $pengiriman['kurir']}}</option>
                                            <option {{ $statuskirim != 'Dalam Proses' && $statuskirim == "Paket dalam Perjalanan" ? 'selected' : '' }}>Paket dalam Perjalanan</option>
                                            <option {{ $statuskirim != 'Dalam Proses' && $statuskirim == "Paket Telah Sampai di Ekspedisi ".($pengiriman['kurir'] == null ? '' : $pengiriman['kurir'])." Tujuan" ? 'selected' : '' }}>Paket Telah Sampai di Ekspedisi {{$pengiriman['kurir'] == null ? '' : $pengiriman['kurir']}} Tujuan</option>
                                            <option {{ $statuskirim != 'Dalam Proses' && $statuskirim == "Paket Dikirim ke Alamat Tujuan" ? 'selected' : '' }}>Paket Dikirim ke Alamat Tujuan</option>
                                            <option {{ $statuskirim != 'Dalam Proses' && $statuskirim == "Paket Telah Sampai Tujuan" ? 'selected' : '' }}>Paket Telah Sampai Tujuan</option>
                                            <option {{ $statuskirim != 'Dalam Proses' && $statuskirim == "Selesai" ? 'selected' : '' }}>Paket Diterima</option>
                                            {{-- @endforeach --}}
                                        </select>
                                        <input type="hidden" id="lelang" name="lelang" value="{{$lelang}}">
                                        <input type="hidden" id="trans" name="trans" value="{{$trans}}">
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id='ubahStatus' name='ubahStatus' class="btn bg-gradient-dark" {{$statuskirim == 'Dalam Proses' || $statuskirim == 'Selesai' ? 'disabled' : ''}}>
                                            Ubah Status
                                        </button>
                                    </div>
                                </form>
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

