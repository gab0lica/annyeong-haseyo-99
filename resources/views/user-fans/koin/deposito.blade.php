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
                        <h4 class="text-dark font-weight-bolder m-0">Deposito Koin</h4>
                        <h6 class="mb-1">
                            {{ auth()->user()->nama }}
                        </h6>
                        {{-- <p class="mb-0 font-weight-bold text-sm">
                            {{ (auth()->user()->role == 2 ? 'Penggemar (Fans)' : 'Penjual') }}
                        </p> --}}
                    </div>
                </div>
                <div class="col-auto text-end my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 px-5"><!--col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3-->
                    <h6 class="mb-0 text-lg font-weight-bold">
                        <i class="fas fa-coins text-warning text-gradient text-lg p-1"></i> {{ $koin }} Koin
                    </h6>
                    <span class="text-sm">1 Koin = Rp 1.000,00 </span>
                </div>
            </div>
        </div>
    </div>

    @if (count($depo) == 0 || $koin == 0)
    <div class="container-fluid text-center">
        <hr class="horizontal dark my-2">
        <a href="{{ url('/beli-koin')}}" class="btn btn-rounded text-dark">
            Beli Koin
            <i class="fas fa-exclamation fa-money-bill-wave text-lg me-1"></i>
        </a>
        {{-- <h4 class="text-dark px-2 font-weight-bolder m-0">Deposito Koin</h4> --}}
        {{-- <span class="text-sm font-weight-bold">1 Koin = Rp 1.000,00 </span><!-- 1 Koin = KRW 1.000 (Kurs Korean Won) = Rp 1.250,- --> --}}
        <hr class="horizontal dark my-2">
    </div>
    @endif
    <div class="container-fluid pt-0 py-4">
        <div class="row">
            <div class="col-md-5 mt-4">
                <div class="card h-100 mb-4">
                <div class="card-header pb-0 px-3">
                    <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-0">Catatan Pembayaran</h6><!--(Isi dan Tarik)-->
                    </div>
                    @if(count($depo) > 0)
                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <i class="fas fa-receipt me-2"></i><!--far fa-calendar-alt-->
                        <small> {{count($depo)}}</small><!--23-3-2023-->
                    </div>
                    @endif
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    {{-- <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Menunggu Pembayaran</h6> --}}
                    <ul class="list-group">
                    @if(count($depo) == 0)
                    <li class="list-group-item justify-content-between">
                        <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark text-sm">Tidak Terdaftar Transaksi</h6>
                        </div>
                    </li>
                    @endif
                    @foreach ($depo as $item)
                    {{-- @if ($item->status == 'Pending' || $item->status == 'Belum') --}}
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                            <a href="{{ url('/nota-koin/'.$item->transaksi_kode)}}" title='{{$item->transaksi_kode}}' target="_blank" aria-label="{{$item->transaksi_kode}}" class="btn btn-link btn-rounded px-1 ps-2 ms-1 mb-0 me-3 d-flex align-items-center justify-content-center
                                {{ $item->jenis == 'beli' ? ($item->status == 'Berhasil' ? 'text-danger' : 'badge bg-gradient-dark') : ($item->jenis == 'tukar' ? ($item->status == 'Berhasil' ? 'text-success' : 'badge bg-gradient-success') : 'text-info')}}">
                                <i class="fas {{$item->status == 'Nota' ? 'fa-exclamation' : ($item->status == 'Gagal' ? 'fa-ban' : ($item->status == 'Berhasil' ? 'fa-money-bill-wave' : 'fa-hourglass-half' ))}} text-lg me-1"></i>
                            </a>
                            {{-- <a href='{{ url('/nota-koin/'.$item->transaksi_kode) }}' target='_blank'
                                class="btn btn-icon-only btn-rounded {{ $item->jenis == 'beli' ? ($item->status == 'Berhasil' ? 'btn-outline-danger' : 'bg-gradient-danger') : ($item->status == 'Berhasil' ? 'btn-outline-success' : 'bg-gradient-success')}} mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                                <i class="fas {{$item->status == 'Nota' ? 'fa-exclamation' : ($item->status == 'Gagal' ? 'fa-ban' : ($item->status == 'Berhasil' ? 'fa-check' : 'fa-hourglass-half' ))}}"></i>
                            </a> --}}
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">{{ $item->jenis == 'beli' ? 'Beli '.$item->jumlah.' Menu '.$item->koin : 'Tukar '.$item->jumlah.' Menu '.($item->koin*-1)}} Koin</h6>
                                <span class="text-xs">{{$item->tanggal.($item->jenis == 'beli' ?
                                    ($item->status == 'Berhasil' ? ' (Berhasil)' :
                                    ($item->status == 'Pending' ? ' (Menunggu Pembayaran)' :
                                    ($item->status == 'Gagal' ? ' (Gagal Membayar)' : ''))) :
                                    ($item->jenis == 'tukar' ? ($item->status == 'Admin' ? ' (Menunggu Konfirmasi)' : '') : ''))}}</span>
                            </div>
                            </div>
                            <div class="d-flex align-items-center {{ $item->jenis == 'beli' ? ($item->status == 'Berhasil' ? 'text-danger' : 'text-dark') : 'text-success'}} text-gradient text-sm font-weight-bolder">
                            {{ ($item->jenis == 'beli' ? '- Rp ' : '+ Rp ').($item->total_bayar/1000) }}.000,-
                            </div>
                        </li>
                    {{-- @endif --}}
                    @endforeach
                    </ul>
                </div>
                </div>
            </div>

            <div class="col-md-7 mt-4">
                <div class="card h-100 mb-4">
                <div class="card-header pb-0 px-3">
                    <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-0">Sejarah Transaksi Koin</h6>
                    </div>
                    @if(count($trans) > 0)
                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <i class="fas fa-receipt me-2"></i><!--far fa-calendar-alt-->
                        <small> {{count($trans)}}</small>
                    </div>
                    @endif
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    {{-- <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Newest</h6> --}}
                    <ul class="list-group">
                        @if(count($trans) == 0)
                        <li class="list-group-item justify-content-between">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">Tidak Terdaftar Transaksi</h6>
                            </div>
                        </li>
                        @endif
                        @foreach ($trans as $item)
                        {{-- @if () --}}
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                            <a href="{{ url('/transaksi-koin/'.$item->id)}}" target="_blank" class="btn btn-link btn-rounded px-1 ps-2 ms-2 mb-0 me-3 d-flex align-items-center justify-content-center
                                {{ $item->jenis == 'beli' ? ($item->status == 'Berhasil' ? 'text-success' : 'badge bg-gradient-success') :
                                ($item->jenis == 'tukar' ? ($item->status == 'Admin' ? 'badge bg-gradient-danger' : 'text-danger') :
                                ($item->jenis == 'lelang' ? ($item->status == 'Berhasil' ? 'text-danger' : 'badge bg-gradient-danger') :
                                ($item->jenis == 'lelang-penjual' ? ($item->status == 'Berhasil' ? 'text-success' : 'badge bg-gradient-success') : 'text-danger'
                                )))}}">
                                <i class="fas {{ $item->status == 'Berhasil' ?
                                    ($item->jenis == 'beli' || $item->jenis == 'tukar' ? 'fa-coins' :
                                    // ( ? 'fa-money-bill-wave' :
                                    ($item->jenis == 'registrasi' ? 'fa-user-check' :
                                    ($item->jenis == 'lelang' ? 'fa-file-signature' :
                                    ($item->jenis == 'lelang-penjual' ? 'fa-file-contract' : 'fa-file-lines')))) : ($item->status == 'Gagal' ? 'fa-ban' : 'fa-hourglass-half') }} text-lg me-1"></i>
                            </a>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">
                                    {{$item->jenis == 'beli' ? 'Beli Koin' :
                                    ($item->jenis == 'tukar' ? 'Tukar Koin' :
                                    ($item->jenis == 'registrasi' ? 'Registrasi Penjual' :
                                    // transaksi lelang (user)
                                    ($item->jenis == 'lelang' ? 'Pemenang Lelang' :
                                    // transaksi lelang (penjual)
                                    ($item->jenis == 'lelang-penjual' ? 'Penghasilan Lelang' : 'Lelang'
                                    ))))}}
                                </h6>
                                <span class="text-xs">{{ $item->tanggal." (".($item->jenis == 'beli' ? 'Berhasil' :
                                ($item->jenis == 'tukar' ?
                                ($item->status == 'Admin' ? "Menunggu Konfirmasi" : 'Berhasil') :
                                ($item->jenis == 'registrasi' ? ($item->status == 'Admin' ? 'Menunggu Konfirmasi' : $item->status) :
                                ($item->jenis == 'lelang' || $item->jenis == 'lelang-penjual' ? ($item->status == 'Berhasil' ? 'Berhasil' : 'Menunggu Pembayaran') : 'NOPE')))).")" }}</span>
                            </div>
                            </div>
                            <div class="d-flex align-items-center {{ $item->jenis == 'beli' ? ($item->status == 'Berhasil' ? 'text-success' : 'text-dark') :
                                ($item->jenis == 'tukar' ? 'text-danger' : ($item->jenis == 'registrasi' ? 'text-danger' :
                                ($item->jenis == 'lelang' ? ($item->status == 'Berhasil' ? 'text-danger' : 'bg-gradient-danger') :
                                ($item->jenis == 'lelang-penjual' ? ($item->status == 'Berhasil' ? 'text-success' : 'bg-gradient-success') : 'text-info'))))}} text-gradient text-sm font-weight-bolder">
                                {{ $item->jenis == 'beli' || $item->jenis == 'lelang-penjual' ? '+ '.$item->jumlah*$item->koin :
                                ($item->jenis == 'tukar' || $item->jenis == 'lelang' ? '- '.$item->jumlah*$item->koin*-1 :
                                ($item->jenis == 'registrasi' ? '- '.$item->koin*-1 :
                                '-+'.$item->koin )) }} Koin
                            </div>
                        </li>
                        {{-- @endif --}}
                        @endforeach
                    </ul>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
