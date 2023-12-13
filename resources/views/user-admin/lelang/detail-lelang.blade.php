@extends('layouts.user_type.auth')

@section('content')
{{-- pake tampilan lihat lelang --}}
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
                        <h4 class="text-dark font-weight-bolder m-0">Lihat Lelang</h4>
                        <h6 class="mb-1">
                            (Nama Penawar) {{--  __('Alec Thompson') --}}
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
                        <i class="fas fa-coins text-warning text-gradient text-lg p-1"></i> (Jumlah Koin Penawar) Koin
                    </h6>
                    {{-- <h6 class="mb-0 text-lg font-weight-bold">
                        <i class="fas fa-users text-info text-gradient opacity-10 px-2"></i> {{ $pengikut }} Pengikut
                    </h6> --}}
                </div>
            </div>
        </div>
    </div>


{{-- profile.blade.php >> lebih banyak isinya --}}
<div class="container-fluid py-4">
@foreach ($lelang as $data)
    <div class="card bg-white">
      <div class="row">
        <div class="col-lg-5">
            <div class="column">
                <div class="col-xl-12 m-4">
                  <div class="card bg-white shadow-lg">
                    <div class="card-body position-relative p-3">
                        <h5 class="text-dark mb-2 font-weight-bolder"><u>Merchandise {{$data['produk']}}</u></h5>
                        <span class="text-dark mb-2">Berikut Gambar Produk Merchandise</span>
                        <img src="{{$data['gambar']}}" alt="img-blur-shadow" class="img-fluid border-radius-xl">
                        <div class="text-center mt-3">
                          @if ($data['status'] == 3 && $data['pemenang']['nama'] == auth()->user()->nama)
                          <a class="btn bg-gradient-info mb-0" href="{{url('/transaksi-koin/'.$data['pemenang']['idtrans'])}}">
                              <i class="fas fa-file-invoice ps-0 text-sm px-2"></i> Lihat Transaksi Lelang
                          </a>
                          @endif
                          {{-- @if ($data['status'] == 1 && count($data['userikut']) == 0) --}}
                            <button type="button" class="btn bg-gradient-dark btn-md mb-0" data-bs-toggle="modal" data-bs-target="#modalIkutLelang">
                                <i class="fas fa-money-check ps-0 text-sm px-2"></i>Ikut/Ubah Penawaran
                            </button>
                            <a class="btn bg-gradient-{{$data['status'] == 3 ? 'success' : 'info'}} mb-0" href="{{$data['idadmin'] == auth()->user()->id ? ($data['status'] == 3 ? url('/transaksi-lelang/'.$data['lelang']) : '#' ) : '#'}}">
                                <i class="fas fa-file-invoice ps-0 text-sm px-2"></i> Lihat Transaksi Lelang
                            </a>
                          <!-- Modal -->
                          <div class="modal fade" id="modalIkutLelang" tabindex="-1" role="dialog" aria-labelledby="modalIkutLelangMessageTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="modalIkutLelangLabel">Ikut Lelang</h5>
                                  </div>
                                  <div class="modal-body">
                                    {{-- <form action={{"/ikut-lelang"}} method="POST" role="form" class="my-2">
                                        @csrf --}}
                                        @if($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show text-sm" role="alert">
                                                <span class="text-sm alert-text text-white font-weight-bold">
                                                {{ $errors->first() }}</span>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                    <i class="fa fa-close" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        @endif
                                        <div class="row">
                                          <span class="text-sm text-center text-danger m-0 mb-3">
                                              <u><strong>Pastikan Anda telah Membaca Semua Ketentuan Lelang, khususnya Metode Lelang ! <br>
                                                Pastikan Anda Menyimak Jumlah Koin Penawaran Anda !</strong></u> <br>
                                            </span>
                                            <div class="input-group">
                                                {{-- <input type="hidden" id="ganti" name="ganti" value="{{$data['ganti']}}"> --}}
                                                <input type="number" class="form-control text-center font-weight-bolder text-md" id="jumlah" name="jumlah" min="{{$data['harga']}}" max="" value='{{$data['harga']}}'>
                                                <span class="input-group-text font-weight-bolder text-md">Koin</span>
                                            </div>
                                            <input type="hidden" id="id" name="id" value="{{$data['lelang']}}">
                                        </div>
                                    {{-- </form> --}}
                                  </div>
                                  {{-- <div class="modal-footer">
                                    <button type="button" id='penawaran' name='penawaran' class="btn bg-gradient-dark">Kirim Penawaran</button>
                                  </div> --}}
                                </div>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-12 m-4">
                    <div class="card bg-white shadow">
                        {{-- @if(count($data['userikut']) == 1) --}}
                        <div class="card-body p-3">
                            <ul class="list-group">
                            {{-- @foreach($data['userikut'] as $i => $item) --}}
                            <li class="list-group-item border-0 d-flex justify-content-between border-radius-lg">
                            <div class="col-md-12 alert alert-info alert-dismissible fade show text-sm" id="alert-success" role="alert">
                                <span class="alert-text text-white text-md font-weight-bolder">
                                    Sejarah Penawaran Anda
                                </span>
                                <br>
                                <span class="alert-text text-white text-md font-weight-bolder">
                                    (Ditampilkan setelah Melakukan Penawaran)
                                    {{-- {{($data['status'] == 3 || $item->status == 1 ? '' : '(Anda Tidak Bisa Melakukan Penawaran Lagi)')}} --}}
                                </span>
                            </div>
                            </li>
                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show text-sm" role="alert">
                                    <span class="text-sm alert-text text-white font-weight-bold">
                                    {{ $errors->first() }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <i class="fa fa-close" aria-hidden="true"></i>
                                    </button>
                                </div>
                            @endif
                            @php
                                $inggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                $indonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            @endphp
                            <li class="list-group-item border-0 d-flex justify-content-between px-2 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                    {{ str_replace($inggris,$indonesia,date('d F Y H:i:s',strtotime($hari_ini))) }}
                                </h6>
                                <span class="text-xs">Penawar</span>
                              </div>
                              <div class="d-flex align-items-center text-sm">
                                <span class="mb-0 text-md font-weight-bolder">
                                    999 Koin <i class="fas fa-coins text-warning text-gradient text-lg me-1 py-1"></i>
                                </span>
                              </div>
                            </li>
                            {{-- @endforeach --}}
                            </ul>
                        </div>
                        {{-- @endif --}}
                    </div>
                </div>
                <div class="col-xl-12 m-4">
                    <div class="card bg-white shadow">
                        <div class="card-body p-3">
                            <form action={{"/perbaikan-lelang"}} method="POST" role="form" class="my-2">
                                @csrf
                                <ul class="list-group">
                                <li class="list-group-item border-0 d-flex justify-content-between border-radius-lg">
                                <div class="col-md-12 my-0 alert alert-{{$data['status'] == 1 ? 'info' : ($data['status'] == 2 ? 'warning' : ($data['status'] == 3 ? 'success' : 'danger'))}} alert-dismissible fade show text-sm" id="alert-success" role="alert">
                                    <span class="alert-text text-white text-md font-weight-bolder">
                                        Catatan Perbaikan <br> (Tertera pada Form Lelang dari Penjual)
                                        <br>
                                        Status: {{$data['status'] == 1 ? 'Sedang Berjalan' : ($data['status'] == 2 ? 'Perbaikan' : ($data['status'] == 3 ? 'Selesai' : 'Non-Aktif'))}}
                                        @if($data['idadmin'] != auth()->user()->id)
                                        <hr>
                                        Perhatian ! <br>
                                        Admin dengan ID {{$data['idadmin']}} yang Bertanggungjawab Memberi Perbaikan dan Menonaktifkan Lelang !
                                        @endif
                                    </span>
                                    @if ($errors->any())
                                    <br>
                                    <span class="text-sm alert-text text-white font-weight-bold">
                                        {{ $errors->first() }}
                                    </span>
                                    @endif
                                </div>
                                </li>
                                <li class="list-group-item border-0 d-flex justify-content-between border-radius-lg">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea class="form-control" {{$data['idadmin'] == auth()->user()->id ? ($data['status'] < 2 ? '' : 'disabled') : 'disabled'}} rows="4" id="catatan" name="catatan" placeholder="Tuliskan Catatan Apabila Lelang Harus Diperbaiki">{{$data['catatan'] == null ? null : $data['catatan']}}</textarea>
                                            <input type="hidden" id="idlelang" name="idlelang" value="{{$data['lelang']}}">
                                            <input type="hidden" id="idadmin" name="idadmin" value="{{$data['idadmin']}}">
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <button type="submit" {{$data['idadmin'] == auth()->user()->id ? ($data['status'] < 2 ? '' : 'disabled') : 'disabled'}}
                                                id='perbaikan' name='perbaikan' class="btn bg-gradient-dark col-md-12">
                                                Kirim Catatan Perbaikan
                                            </button>
                                            <a href="{{$data['idadmin'] == auth()->user()->id ? ($data['status'] < 2 ? url('non-aktif/'.$data['lelang']) : '#') : '#' }}" class="btn bg-gradient-{{$data['status'] > 0 ? 'danger' : 'success'}} col-md-12"
                                                type="button" title="Lelang ID {{$data['lelang']}}">
                                                {{$data['status'] > 0 ? 'Non-Aktifkan' : 'Aktifkan'}} Lelang <i class="fas fa-{{$data['status'] > 0 ? 'ban' : 'check-circle'}} text-lg text-white me-2" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
          <div class="column">
            <div class="card m-4">
                <span class="mask bg-gradient-dark border-radius-xl opacity-8"></span>
                <div class="row m-4">
                <div class="col-md-4 mt-md-0 mt-4"><!-- col-md-6 mx-8 > biar di tengah-->
                  <div class="card shadow">
                      <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-warning shadow text-center border-radius-lg">
                          <i class="fas fa-coins opacity-10"></i>
                      </div>
                      </div>
                      <div class="card-body pt-0 p-3 text-center">
                      <span class="text-center mb-0">Koin Penawaran Awal</span>
                      {{-- <span class="text-xs">Belong Interactive</span> --}}
                      <hr class="horizontal dark my-3">
                      <h4 class="mb-0 text-md font-weight-bolder">{{$data['harga']}} <span class="mb-0 text-sm font-weight-bold"> Koin</span></h4>
                      </div>
                  </div>
                </div>
                <div class="col-md-4 mt-md-0 mt-4">
                  <div class="card shadow">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fas fa-hourglass-start opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <span class="text-center mb-0">Batas Awal Penawaran</span>
                      {{-- <span class="text-xs">Freelance Payment</span> --}}
                      <hr class="horizontal dark my-2">
                      <h6 class="mb-0 text-md font-weight-bolder">{{$data['mulai']}}</h6>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 mt-md-0 mt-4">
                  <div class="card shadow">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-secondary shadow text-center border-radius-lg">
                        <i class="fas fa-hourglass-end opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <span class="text-center mb-0">Batas Akhir Penawaran</span>
                      {{-- <span class="text-xs">Freelance Payment</span> --}}
                      <hr class="horizontal dark my-2">
                      <h6 class="mb-0 text-md font-weight-bolder">{{$data['selesai']}}</h6>
                    </div>
                  </div>
                </div>
                </div>
                <div class="row m-4 mt-0">
                    <div class="col-md-12 mt-md-0 mt-4"><!-- col-md-6 mx-8 > biar di tengah-->
                      <div class="card shadow">
                          <div class="card-header mx-4 p-3 text-center">
                          <div class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-lg">
                              <i class="fas fa-trophy opacity-10"></i>
                          </div>
                          </div>
                          <div class="card-body pt-0 p-3 text-center">
                          <span class="text-center mb-0">Pengumuman Pemenang</span>
                          {{-- <span class="text-xs">Belong Interactive</span> --}}
                          <hr class="horizontal dark my-3">
                          @if (count($data['pemenang']) > 0)
                            {{-- @foreach ($data['pemenang'] as $item) --}}
                            <h5 class="mb-0 text-md font-weight-bolder">
                                <span class="mb-0 text-sm font-weight-bold">Selamat </span> {{ $data['pemenang']['nama'] == auth()->user()->nama ? 'Anda' : $data['pemenang']['nama']}}
                                 <span class="mb-0 text-sm font-weight-bold">Menang dengan Penawaran</span>
                                {{ ($data['pemenang']['koin'])*-1 }} <span class="mb-0 text-sm font-weight-bold"> Koin</span>
                            </h5>
                            {{-- @endforeach --}}
                          @else
                            <span class="mb-0 text-sm text-uppercase text-danger text-gradient font-weight-bolder">
                                Nama Pemenang akan tertera di kolom ini. <br> Harap Menunggu Lelang Berakhir. Terimakasih.
                            </span>
                          @endif
                          </div>
                      </div>
                    </div>
                </div>
            </div>
              <div class="card m-4 shadow-lg">
                <div class="card-body p-3"><!--header pb-0-->
                    <h6 class="mb-3 text-sm font-weight-bolder">
                        <u>Deskripsi Produk Merchandise</u>
                    </h6>
                    <div class="row my-2">
                        <div class="col-4">
                            <span class="mb-1 text-sm">Nama Produk</span>
                        </div>
                        <div class="col-8">
                            <h5 class="mb-1 text-sm font-weight-bold">:  {{$data['produk']}}</h5>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-4">
                            <span class="mb-1 text-sm">Kategori Produk</span>
                        </div>
                        <div class="col-8">
                            <h5 class="mb-1 text-sm font-weight-bold">:  {{$data['kategori']}}</h5>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-4">
                            <span class="mb-1 text-sm">Artis yang Berkaitan</span>
                        </div>
                        <div class="col-8">
                            <h5 class="mb-1 text-sm font-weight-bold">:  {{$data['artis']}}</h5>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-4">
                            <span class="mb-1 text-sm">Detail Produk</span>
                        </div>
                        <div class="col-8">
                            <h5 class="mb-1 text-sm font-weight-bold">:  {{$data['detail']}} </h5>
                        </div>
                    </div>
                    <hr>
                    <h6 class="mb-3 text-sm font-weight-bolder">
                        <u>Metode Lelang</u>
                    </h6>
                    {{-- <div class="row my-2">
                        <div class="col-4">
                            <span class="mb-1 text-sm">Status Lelang</span>
                        </div>
                        <div class="col-8">
                            <h5 class="mb-1 text-sm font-weight-bold">:  {{$data['detail']}} </h5>
                        </div>
                    </div> --}}
                    <div class="row my-2">
                        <div class="col-4">
                            <span class="mb-1 text-sm">Jenis Metode</span>
                        </div>
                        <div class="col-8">
                            <h5 class="mb-1 text-sm font-weight-bolder">:  <i>"First Price Sealed Bid Auction"</i></h5>
                            <span class="mb-1 text-sm text-dark">(Penawaran Tertinggi Pertama menjadi Pemenang Lelang)</span>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-4">
                            <span class="mb-1 text-sm">Aturan Cara Penawaran</span>
                        </div>
                        <div class="col-8">
                            <h5 class="mb-1 text-sm font-weight-bold">:
                            </h5>
                        </div>
                    </div>
                    <div class="row my-2">
                        {{-- <div class="col-1">
                            <span class="mb-1 text-sm">1. </span>
                        </div> --}}
                        <div class="col-12">
                            <span class="mb-1 text-sm">
                                {{--
                            </span>
                        </div>
                        <div class="col-8">
                            <h5 class="mb-1 text-sm font-weight-bold"> --}}
                                <strong class="text-danger">Perhatian: Pastikan Deposito Koin Anda Mencukupi sesuai Jumlah Penawaran Anda saat Lelang telah Berakhir !</strong> <br>
                                1. Anda sebagai Penawar memiliki Kesempatan Penawaran sebanyak <strong class="text-dark">2 kali</strong>, sehingga
                                <strong class="text-danger">Jumlah Koin Penawaran yang Digunakan adalah Jumlah Penawaran Terakhir yang Anda masukkan</strong>. <br>
                                2. Penawaran bersifat <strong class="text-dark">Tertutup</strong> yang berarti <strong class="text-danger">Semua Penawaran yang telah dilakukan pada Lelang ini Tidak Ditampilkan</strong>. <br>
                                3. Jika Anda Menang saat Lelang telah Berakhir, <strong class="text-dark">Deposito Koin Anda akan dipotong sesuai Jumlah Penawaran Terakhir Anda pada Lelang</strong>. <br>
                                <strong class="text-danger">Harap Melunasi Jumlah Koin Penawaran Anda dalam waktu 7 hari setelah Lelang Berakhir apabila Deposito Koin Anda tidak Mencukupi Saat Ini !</strong> <br>
                                4. Jika Anda Kalah saat Lelang telah Berakhir, <strong class="text-dark">Deposito Koin Anda tidak akan dipotong sesuai Penawaran yang Anda masukkan</strong>.
                            </span>
                        </div>
                    </div>
                    <hr>
                    <h6 class="text-end mb-2 text-sm font-weight-bolder">
                        <u>Penjual</u>
                    </h6>
                    <h5 class="text-end mb-2 text-sm font-weight-bold">
                        {{$data['nama']." (@".$data['username'].")"}} <i class="fas fa-user-check ps-3 pe-0 text-lg text-success text-gradient px-2"></i>
                    </h5>
                    {{-- <h5 class="text-end mb-2 text-sm font-weight-bold">
                        {{$data['pengikut']}} <i class="fas fa-users text-lg text-dark text-gradient ps-3 pe-1"></i>
                    </h5> --}}
                    <h5 class="text-end mb-2 text-sm font-weight-bold">
                        Kota {{$data['kota']}} <i class="fas fa-map-pin text-lg text-info text-gradient ps-3 pe-2"></i>
                    </h5>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
@endforeach
  </div>
</div>

@endsection
