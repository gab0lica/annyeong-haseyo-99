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
                        {{-- <a href="javascript:;" class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                            <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Image"></i>
                        </a> --}}
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h4 class="text-dark font-weight-bolder m-0">{{ $mode == 'baru' ? 'Buat Lelang Baru' : __('Ubah Lelang') }}</h4>
                        {{-- <h6 class="mb-1">
                            {{ auth()->user()->nama }}
                        </h6> --}}
                        <a href="{{ url('/master-lelang/semua') }}" class="btn bg-gradient-primary btn-md m-1">
                            Kembali ke Master Lelang <i class="fas fa-store text-lg text-white mx-1" aria-hidden="true"></i>
                        </a>
                        {{-- <p class="mb-0 font-weight-bold text-sm">
                            {{ (auth()->user()->role == 2 ? 'Penggemar (Fans)' : 'Penjual') }}
                        </p> --}}
                    </div>
                </div>
                <div class="col-auto text-end my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 px-5"><!--col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3-->
                    <h6 class="mb-0 text-lg font-weight-bold">
                        <i class="fas fa-coins text-warning text-gradient text-lg p-1"></i> {{ $koin }} Koin
                    </h6>
                    <h6 class="mb-0 text-lg font-weight-bold">
                        <i class="fas fa-users text-info text-gradient opacity-10 px-2"></i> {{ $pengikut }} Pengikut
                        {{-- @if($koin <= 0 && $pesan != 'penggemar')<span class="font-weight-bold text-danger text-sm">(Anda harus Membeli Koin untuk Registrasi)</span>@endif --}}
                    </h6>
                </div>
                {{-- <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 col-md-12 " data-bs-toggle="tab" href=""
                                    role="tab" aria-controls="overview" aria-selected="true" selected>
                                    <span class="ms-1 font-weight-bold text-sm text-dark">Ubah Gambar Profile</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab" href="{{ url('/profile') }}" role="tab" aria-controls="dashboard" aria-selected="false">
                                    <span class="ms-1">{{ __('Projects') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="card">
            <form action="/isi-lelang" enctype="multipart/form-data" method="POST" role="form text-left">
            <div class="card-header pb-0 px-3">
                <div class="row">
                    <div class="col-md-{{$mode == 'baru' ? 8 : 4}}">
                        <h5 class="mb-0">
                            {{ $mode == 'baru' ? 'Silakan mengisi Ketentuan Lelang yang tertera di bawah ini.' : __('Silakan ubah Data Lelang.') }}
                            {{-- <span class="text-sm text-danger font-weight-bolder">{{$pesan == 'peringatan' ? ' dalam Pemeriksaan Registrasi Ulang' : ''}}</span> --}}
                        </h5>
                        <span class="text-danger text-md">*</span><span class="text-dark text-sm mb-0">Harap Mengisi Seluruh Data yang Tersedia</span>
                    </div>
                    <div class="col-md-{{$mode == 'baru' ? 4 : 8}}">
                        <div class="d-flex justify-content-end">
                            @if ($mode != 'baru')<!-- && $pesan == 'ubah' -->
                            <a href="{{ url('/daftar-penawar/'.$detail['id']) }}" class="btn btn-outline-dark btn-md m-2">
                                {{$detail['penawar'] > 0 ? 'Daftar Semua Penawar' : 'Belum ada Penawar'}} <i class="fas {{$detail['penawar'] > 0 ? 'fa-users' : 'fa-users-slash'}} text-lg text-dark mx-2" aria-hidden="true"></i>
                            </a>
                            @endif
                            @if (count($detail) > 0)
                            {{-- ada 3, pemenang, admin, penjual, ini yg PEMENANG, PENJUAL --}}
                            @if ($detail['status'] == 3)
                            <a href="{{ url('/transaksi-koin/'.$detail['penjual']) }}" class="btn btn-outline-dark btn-md m-2">
                                Hasil Transaksi Lelang Anda <i class="fas fa-file-invoice text-lg text-dark mx-2" aria-hidden="true"></i>
                            </a>
                            @endif
                            @endif
                            <input id="mode" name="mode" type="hidden" value="{{ $mode }}">
                            <input id="pesan" name="pesan" type="hidden" value="{{ $pesan }}">
                            <input id="id" name="id" type="hidden" value="{{ $mode == 'baru' && $pesan == 'buat' ? $mode : $detail['id'] }}">
                            {{-- <input id="persen_admin" name="persen_admin" type="hidden" class="form-control text-center text-md" value="{{ $mode == 'baru' && $pesan == 'buat' ? 5 : $detail['persen_admin'] }}"> --}}
                            <input id='buat' name='buat' type="hidden" value="{{ $mode == 'baru' && $pesan == 'buat' ? $hari_ini : $detail['buat'] }}">
                            <input id='koin' name='koin' type="hidden" value="{{ $mode == 'baru' && $pesan == 'buat' ? $hari_ini : $detail['koin'] }}">
                            <input id='dimulai' name='dimulai' type="hidden" value="{{ $mode == 'baru' && $pesan == 'buat' ? $hari_ini : $detail['mulai']." ".$detail['jamMulai'] }}">
                            <input id='status' name='status' type="hidden" value="{{ $mode == 'baru' && $pesan == 'buat' ? 1 : $detail['status'] }}">
                            <input id='pemenang' name='pemenang' type="hidden" value="{{ $mode == 'baru' && $pesan == 'buat' ? 0 : $detail['pemenang'] }}">
                            <input id='penjual' name='penjual' type="hidden" value="{{ $mode == 'baru' && $pesan == 'buat' ? 0 : $detail['penjual'] }}">
                            <input id='admin' name='admin' type="hidden" value="{{ $mode == 'baru' && $pesan == 'buat' ? 0 : $detail['admin'] }}">
                            {{-- <input id='statuskirim' name='statuskirim' type="hidden" value="{{ $mode == 'baru' && $pesan == 'buat' ? 0 : $detail['statuskirim'] }}">
                            <input id='alamat' name='alamat' type="hidden" value="{{ $mode == 'baru' && $pesan == 'buat' ? 0 : $detail['alamat'] }}"> --}}
                            <input id='penawar' name='penawar' type="hidden" value="{{ $mode == 'baru' && $pesan == 'buat' ? 0 : $detail['penawar'] }}">
                            <button {{$pesan == 'selesai' ? 'disabled' : ''}} type="submit" class="btn bg-gradient-dark btn-md m-2">{{ $mode == 'baru' && $pesan == 'buat' ? 'Buat' : 'Ubah' }} Lelang</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                @csrf
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white font-weight-bold">
                    {{$errors->first()}}
                        {{-- Lelang Anda perlu diperbaiki. <br>Dimohon untuk mengisi dengan benar sesuai dengan catatan perbaikan. --}}
                    </span>
                </div>
                @endif
                @if($pesan == 'peringatan')
                {{-- $errors->any() --}}
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span class="alert-text text-white font-weight-bold">
                        <!-- $errors->first() ; print($tr->translate($errors->first())) -->
                            Lelang Anda perlu diperbaiki. <br>Dimohon untuk mengisi dengan benar sesuai dengan catatan perbaikan.
                        </span>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button> --}}
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                        <span class="alert-text text-white">
                        {{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif
                <ul class="list-group">
                @if ($mode != 'baru')
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <div class='row'>
                            <div class='col-md-4 my-auto'><strong class="text-dark"><u>{{ 'Status Lelang' }}</u></strong> </div>
                            <div class='col-md-8 px-0'>
                                <h6 class="mx-2 font-weight-bolder {{ $pesan == 'peringatan' && $detail['status'] == 2 ? 'text-danger' : 'text-secondary'}} text-capitalize">
                                    {{ $pesan == 'peringatan' && $detail['status'] == 2 ? 'Perbaikan' :
                                        ($detail['status'] == 1 ?
                                            ($pesan == 'belum-penawar' ? 'Dianggap Perbaikan Karena Lelang Selesai Tanpa Penawar' : 'Sedang Berjalan') :
                                        ($detail['status'] == -1 ? 'Belum Dirilis' :
                                        ($detail['status'] == 3 ? 'Lelang Selesai' : 'Selesai'))) }}
                                </h6>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <div class='row'>
                            <div class='col-md-4 my-auto'><strong class="text-dark"><u>{{ 'Catatan Lelang' }}</u></strong> </div>
                            <div class='col-md-8 px-0'>
                                <h6 class="mx-2 font-weight-bolder {{ $pesan == 'peringatan' && $detail['status'] == 2 ? 'text-danger' : 'text-secondary'}} text-capitalize">
                                    {{ $pesan == 'peringatan' && $detail['status'] == 2 ? $detail['catatan'] : 'Tidak Ada Catatan' }}
                                </h6>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <div class='row'>
                            <div class='col-md-4 my-auto'><strong class="text-dark"><u>{{ 'Tanggal Lelang Dibuat' }}</u></strong> </div>
                            <div class='col-md-8 px-0'>
                                <h6 class="mx-2 font-weight-bolder text-secondary text-capitalize">
                                    {{ $detail['buat'] }}
                                </h6>
                            </div>
                        </div>
                    </li>
                @endif
                    {{-- &nbsp; --}}
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <div class='row'>
                            <div class='col-md-4 my-auto'><strong class="text-dark">Nama Produk (sebagai Judul)</strong> <span class="text-danger text-md">*</span></div>
                            <div class='col-md-8 px-0'>
                                <div class="form-group my-0">
                                    <input {{count($detail) > 0 ? ($detail['status'] == 3 ? 'disabled' : '') : ''}} id="judul" name="judul" type="text" class="form-control" value="{{ $mode == 'baru' && $pesan == 'buat' ? old('judul') : $detail['judul'] }}">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <div class='row'>
                            <div class='col-md-4 my-auto'><strong class="text-dark">Gambar Produk</strong> <span class="text-danger text-md">*</span></div>
                            <div class='col-md-8 px-0'>
                                <div class="form-group my-0">
                                    {{-- <div class="@error('gambar') border border-danger rounded-3 @enderror"> --}}
                                        <span class="font-weight-bold text-danger">(Pastikan Gambar yang Ditampilkan dan Nama Produk dalam Gambar adalah Produk yang Sama)</span>
                                        @if(count($detail) > 0)
                                        <button type="button" class="btn-link btn m-0 px-2 py-0 text-sm text-capitalize" data-bs-toggle="modal" data-bs-target="#modalGambar">
                                            <a href="#" class="" title="Buka Gambar">
                                               <i class="fas fa-image text-lg text-dark me-2" aria-hidden="true"></i>  Buka Gambar Produk
                                            </a>
                                        </button>
                                        <input {{count($detail) > 0 ? ($detail['status'] == 3 ? 'disabled' : '') : ''}} id="gambar" name="gambar" type="file" class="mx-2" value="{{ $mode == 'baru' && $pesan == 'buat' ? old('gambar') : $detail['gambar'] }}">
                                        <input id="foto" name="foto" type="hidden" class="mx-2" value="{{ $detail['gambar'] }}">
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalGambar" tabindex="-1" role="dialog" aria-labelledby="modalGambarTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h6 class="modal-title" id="modalGambarLabel">Gambar Produk</h6>
                                                  {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                  </button> --}}
                                                </div>
                                                <div class="modal-body">
                                                  <div class="card-body">
                                                    <img src="{{ $detail['gambar'] == null ? '../pic/uni-user-4.png' : $detail['gambar'] }}"
                                                      alt="Gambar Produk" class="w-70 m-2 border-radius-lg shadow-sm bg-gradient-dark">
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn bg-gradient-dark" data-bs-dismiss="modal">Kembali</button>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                        {{-- <img src="{{ $detail['gambar'] == null ? old('gambar') : $detail['gambar'] }}" alt="gambar produk"
                                            class="w-100 border-radius-lg shadow-sm bg-outline-dark"> --}}
                                        @else
                                        <input {{count($detail) > 0 ? ($detail['status'] == 3 ? 'disabled' : '') : ''}} id="gambar" name="gambar" type="file" class="m-2" accept=".jpg, .jpeg, .png"
                                            value="{{ $mode == 'baru' && $pesan == 'buat' ? old('gambar') : $detail['gambar'] }}">
                                        {{-- @error('gambar')
                                        <p class="text-danger text-xs mx-2">{{ $message }}</p><!-- print($tr->translate($message)) -->
                                        @enderror --}}
                                        @endif
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <div class='row'>
                            <div class='col-md-4 my-auto'><strong class="text-dark">Detail Produk</strong> <span class="text-danger text-md">*</span></div>
                            <div class='col-md-8 px-0'>
                                <div class="form-group my-0">
                                    {{-- {{-- <div class="@error('desk') border border-danger rounded-3 @enderror"> --}}
                                        <textarea {{count($detail) > 0 ? ($detail['status'] == 3 ? 'disabled' : '') : ''}} id="detail"  name="detail" class="form-control" rows="3" placeholder="Berisi Syarat maupun Deskripsi Produk Merchandise">{{ $mode == 'baru' && $pesan == 'buat' ? old('detail') : $detail['detail'] }}</textarea>
                                    {{-- </div> --}}
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
                                    {{-- @if (count($kategori) > 0 && $kategori != []) --}}
                                    <div class='col-md-5'>
                                        <select {{count($detail) > 0 ? ($detail['status'] == 3 ? 'disabled' : '') : ''}} class="form-control text-capitalize" id="kategori" name="kategori" value="{{ $mode == 'baru' && $pesan == 'buat' ? old('kategori') : $detail['kategori'] }}">
                                            <option>{{'Tidak Ada'}}</option>
                                            {{-- @foreach ($kategori as $item) --}}
                                            {{--
                                                1 music&vinyl:	kpop,		concert dvd,	ost,	vinyl/LP
                                                2 movie&tv:	kdrama,		bluray,		dvd,	others >> sebagian besar script drama
                                                3 star shop:	photobook,	book/magazine,	md,	season's greeting,				shopping >> random (bisa sanrio x nct)
                                                --}}
                                            <option {{ $pesan != 'baru' && count($detail) > 0 ? ( $detail['kategori'] == "K-Pop - Album" ? 'selected' : '' ) : '' }}>K-Pop - Album</option>
                                            <option {{ $pesan != 'baru' && count($detail) > 0 ? ( $detail['kategori'] == "K-Pop - DVD Konser" ? 'selected' : '' ) : '' }}>K-Pop - DVD Konser</option>
                                            <option {{ $pesan != 'baru' && count($detail) > 0 ? ( $detail['kategori'] == "K-Pop - OST" ? 'selected' : '' ) : '' }}>K-Pop - OST</option>
                                            <option {{ $pesan != 'baru' && count($detail) > 0 ? ( $detail['kategori'] == "K-Pop - Rekaman LP" ? 'selected' : '' ) : '' }}>K-Pop - Rekaman LP</option>
                                            <option {{ $pesan != 'baru' && count($detail) > 0 ? ( $detail['kategori'] == "K-Drama Soundtrack" ? 'selected' : '' ) : '' }}>K-Drama Soundtrack</option>
                                            <option {{ $pesan != 'baru' && count($detail) > 0 ? ( $detail['kategori'] == "Blu-Ray" ? 'selected' : '' ) : '' }}>Blu-Ray</option>
                                            <option {{ $pesan != 'baru' && count($detail) > 0 ? ( $detail['kategori'] == "DVD" ? 'selected' : '' ) : '' }}>DVD</option>
                                            <option {{ $pesan != 'baru' && count($detail) > 0 ? ( $detail['kategori'] == "Photobook" ? 'selected' : '' ) : '' }}>Photobook</option>
                                            <option {{ $pesan != 'baru' && count($detail) > 0 ? ( $detail['kategori'] == "Buku / Majalah" ? 'selected' : '' ) : '' }}>Buku / Majalah</option>
                                            <option {{ $pesan != 'baru' && count($detail) > 0 ? ( $detail['kategori'] == "MD" ? 'selected' : '' ) : '' }}>MD</option>
                                            <option {{ $pesan != 'baru' && count($detail) > 0 ? ( $detail['kategori'] == "Season's Greeting" ? 'selected' : '' ) : '' }}>Season's Greeting</option>
                                            <option {{ $pesan != 'baru' && count($detail) > 0 ? ( $detail['kategori'] == "Lainnya" ? 'selected' : '' ) : '' }}>Lainnya</option>
                                            {{-- @endforeach --}}
                                        </select>
                                    </div>
                                    {{-- @endif --}}
                                    {{-- <div class='col-md-7'>
                                        <input id="kategori" name="kategori" type="text" class="form-control" placeholder='Tulis Nama Kategori Produk' value="{{ $mode == 'baru' && $pesan == 'buat' ? old('kategori') : $detail['kategori'] }}">
                                    </div> --}}
                                </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <div class='row'>
                            <div class='col-md-4 my-auto'><strong class="text-dark">Salah Satu Artis yang Terkait</strong> <span class="text-danger text-md">*</span></div>
                            <div class='col-md-8 px-0'>
                                <div class="form-group my-0">
                                {{-- <span class="font-weight-bold text-danger">(Apabila Nama Artis ada)</span> --}}
                                <div class='row my-2'>
                                    @if (count($artis) > 0)
                                    <div class='col-md-5'>
                                        <span class="font-weight-bold text-dark my-2"><u>Bagian Pilih Artis yang Tersedia</u></span>
                                        <select {{count($detail) > 0 ? ($detail['status'] == 3 ? 'disabled' : '') : ''}} class="form-control" id="pilihA" name="pilihA" value="{{ $mode == 'baru' && $pesan == 'buat' ? old('artis') : $detail['artis'] }}">
                                            <option>{{'Tidak Ada'}}</option>
                                            @foreach ($artis as $item)
                                            <option class="text-capitalize" {{ $pesan != 'baru' && count($detail) > 0 ? ($detail['artis'] == $item->nama ? 'selected' : '') : '' }}>{{$item->nama}}</option>
                                            {{-- <option>{{$item->nama}}</option> --}}
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    <div class='col-md-7'>
                                        <span class="font-weight-bold text-dark my-2"><u>Bagian Nama Artis Baru</u></span>
                                        <input {{count($detail) > 0 ? ($detail['status'] == 3 ? 'disabled' : '') : ''}} id="artis" name="artis" type="text" class="form-control" placeholder='Tulis Nama Artis yang Berkaitan dengan Produk' value="{{ $mode == 'baru' && $pesan == 'buat' ? old('artis') : '' }}">
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <div class='row'>
                            <div class='col-md-4 my-auto'><strong class="text-dark">Harga Penawaran Awal (dalam Koin)</strong> <span class="text-danger text-md">*</span></div>
                            <div class='col-md-8 px-0'>
                                <div class="form-group my-0">
                                <div class="input-group w-20">
                                    <input {{count($detail) > 0 ? ($detail['status'] == 3 || $detail['penawar'] > 0 ? 'disabled' : '') : ''}} id="koin" name="koin" type="number" class="form-control text-center text-md w-20" value="{{ $mode == 'baru' && $pesan == 'buat' ? 10 : $detail['koin'] }}" min="10">
                                    <span class="input-group-text font-weight-bold">Koin</span>
                                </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    {{-- <li class="list-group-item border-0 ps-0 text-sm">
                        <div class='row'>
                            <div class='col-md-4 my-auto'><strong class="text-dark">Persentase Penjual</strong> <span class="text-danger text-md">*</span></div>
                            <div class='col-md-8 px-0'>
                                <div class="form-group my-0">
                                <div class="input-group w-20">
                                    <input {{count($detail) > 0 ? ($detail['status'] == 3 ? 'disabled' : '') : ''}} id="persen_penjual" name="persen_penjual" type="number" min="1" max="20" class="form-control text-center text-md" value="{{ $mode == 'baru' && $pesan == 'buat' ? 1 : $detail['persen_penjual'] }}">
                                    <span class="input-group-text font-weight-bold">%</span>
                                </div>
                                </div>
                            </div>
                        </div>
                    </li> --}}
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <div class='row'>
                            <div class='col-md-4 my-auto'><strong class="text-dark">Persentase Admin</strong> <span class="text-danger text-md">*</span></div>
                            <div class='col-md-8 px-0'>
                                <div class="form-group my-0">
                                <div class="input-group w-20">{{--type number--}}
                                    <span class="text-lg text-gradient text-dark font-weight-bolder px-2">5 %</span>
                                </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <div class='row'>
                            <div class='col-md-4 my-auto'><strong class="text-dark">Tanggal Mulai</strong> <span class="text-danger text-md">*</span></div>
                            <div class='col-md-8 px-0'>
                                <div class="form-group my-0">
                                    @if(count($detail) > 0)<span class="font-weight-bold text-danger">{{$detail['penawar'] > 0 ? '(Tanggal Dimulai Tidak Bisa Diubah karena Sudah Ada Penawar)' : ''}}</span>@endif
                                    <div class="row my-2">
                                        <div class='col-md-6'>
                                            {{-- min='{{ $mode == 'baru' && $pesan == 'buat' ? date('Y-m-d',strtotime($hari_ini)) : '' }}' --}}
                                        <input {{count($detail) > 0 ? ($detail['status'] == 3 || $detail['penawar'] > 0 ? 'disabled' : '') : ''}} id="mulai" name="mulai" type="date" class="form-control"  value="{{ $mode == 'baru' && $pesan == 'buat' ? date('Y-m-d',strtotime($hari_ini)) : $detail['mulai'] }}">
                                        </div>
                                        <div class='col-md-6'>
                                            {{-- min="{{ $mode == 'baru' && $pesan == 'buat' ? date('H:i',strtotime($hari_ini)) : ''}}" --}}
                                        <input {{count($detail) > 0 ? ($detail['status'] == 3 || $detail['penawar'] > 0 ? 'disabled' : '') : ''}} id="jamMulai" name="jamMulai" type="time" class="form-control"  value="{{ $mode == 'baru' && $pesan == 'buat' ? date('H:i',strtotime($hari_ini)) : $detail['jamMulai'] }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <div class='row'>
                            <div class='col-md-4 my-auto'><strong class="text-dark">Tanggal Selesai</strong> <span class="text-danger text-md">*</span></div>
                            <div class='col-md-8 px-0'>
                                <div class="form-group my-0">
                                    <span class="font-weight-bold text-danger">(Pastikan Tanggal dan Jam Selesai Lelang setelah Tanggal dan Jam Dimulai)</span>
                                    <div class="row py-2">
                                        <div class='col-md-6'>
                                             {{-- min='{{ date('Y-m-d',strtotime($hari_ini)) }}' --}}
                                        <input {{count($detail) > 0 ? ($detail['status'] == 3 ? 'disabled' : '') : ''}} id="selesai" name="selesai" type="date" class="form-control" value="{{ $mode == 'baru' && $pesan == 'buat' ? date('Y-m-d',strtotime($hari_ini)) : $detail['selesai'] }}">
                                        </div>
                                        <div class='col-md-6'>
                                             {{-- min="{{ date('H:i',strtotime($hari_ini)) }}" --}}
                                        <input {{count($detail) > 0 ? ($detail['status'] == 3 ? 'disabled' : '') : ''}} id="jamSelesai" name="jamSelesai" type="time" class="form-control" value="{{ $mode == 'baru' && $pesan == 'buat' ? date('H:i',strtotime($hari_ini)) : $detail['jamSelesai'] }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
