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
                        <h4 class="text-dark font-weight-bolder m-0">Profile Anda</h4>
                        <h6 class="mb-1">
                            {{ auth()->user()->nama }} {{--  __('Alec Thompson') --}}
                        </h6>
                        {{-- <p class="mb-0 font-weight-bold text-sm">
                            {{ (auth()->user()->role == 2 ? 'Penggemar (Fans)' : 'Penjual') }}
                        </p> --}}
                    </div>
                </div>
                {{-- @if ($mode == 'penggemar') --}}
                <div class="col-auto text-end my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 px-5"><!--col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3-->
                    <h6 class="mb-0 text-lg font-weight-bold">
                        <i class="fas fa-coins text-warning text-gradient text-lg p-1"></i> {{ $koin }} Koin
                    </h6>
                    <span class="text-sm">1 Koin = Rp 1.000,00 </span> <br>
                    @if($mode == 'registrasi' && $pesan == 'admin') <span class="font-weight-bold text-secondary text-sm">({{ 'Koin Anda belum dipotong dengan Biaya Registrasi'}})</span>@endif
                </div>
                {{-- @endif --}}
                {{-- @if (auth()->user()->role == 3)
                <div class="col-auto text-end my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 px-5"><!--col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3-->
                    <h6 class="mb-0 text-lg font-weight-bold">
                        <i class="fas fa-users text-info text-gradient opacity-10 px-2"></i> {{ $pengikut }} Pengikut
                    </h6>
                </div>
                @endif --}}
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
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ $mode == 'registrasi' ? 'Registrasi Penjual' : ($mode == 'profile' ? 'Profile Anda sebagai Penjual' : __('Profile Anda sebagai Penggemar')) }}
                    <span class="text-sm text-danger font-weight-bolder">{{$pesan == 'ulang' ? ' dalam Pemeriksaan Registrasi Ulang' : ''}}</span>
                </h5>
                <span class="mb-0 text-sm">{{ $mode == 'registrasi' ? 'Silakan mengisi ketentuan menjadi Penjual yang telah ditentukan' : __('Silakan ubah data profile sesuai kebutuhan Anda') }}</span>
            </div>
            <div class="card-body pt-4 p-3">
                <?php
                use Stichoza\GoogleTranslate\GoogleTranslate;
                $tr = new GoogleTranslate('id');
                ?>
                <form action="{{ $mode == 'registrasi' || $mode == 'profile' ? '/edit-penjual' : '/user-profile' }}"
                enctype="multipart/form-data" method="POST" role="form text-left">
                    @csrf
                    <input type="hidden" name="mode" id="mode" value="{{$mode}}">
                    @if (auth()->user()->role == 3)
                    <input type="hidden" name="kota" id="kota" value="{{auth()->user()->kota != null ? auth()->user()->kota : 'tidak'}}">
                    @endif
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @if($mode == 'registrasi' && $pesan == 'ulang')
                        <span class="alert-text text-white font-weight-bold">
                            Registrasi Anda perlu diisi ulang. <br>Dimohon untuk mengisi dengan benar sesuai dengan catatan konfirmasi.
                        </span>
                        @else
                        <span class="alert-text text-white font-weight-bold">
                            {{$errors->first()}}
                            <!-- $errors->first() ; print($tr->translate($errors->first())) -->
                        </span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                        @endif
                    </div>
                    @endif
                    @if(session('success'))
                        <div class="m-3 alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    @if (($mode == 'registrasi' || $mode == 'profile' && auth()->user()->role == 3))
                    {{-- registrasi --}}
                    <div class="row">
                        <div class="{{$mode == 'registrasi' ? 'col-md-6' : 'col-md-12'}}">
                            <div class="form-group">
                                <label for="username" class="form-control-label">{{ __('Username (sama dengan username sebagai Penggemar)') }}</label> {{-- for=user-username --}}
                                {{-- <div class="@error('username')border border-danger rounded-3 @enderror"> --}}
                                    <input class="form-control" value="{{ auth()->user()->username }}" type="text" id="username" name="username" disabled>
                                        {{-- @error('username')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p><!-- print($tr->translate($message)) -->
                                        @enderror --}}
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                @if($mode == 'registrasi')
                                <label for="koin"><u>{{ 'Biaya Registrasi' }}</u></label>
                                {{-- <div class="@error('koin') border border-danger rounded-3 @enderror"> --}}
                                <h5 class="mx-2 font-weight-bolder text-dark">20 Koin
                                    @if($koin < 20 && $pesan == 'tidak cukup')
                                    <span class="font-weight-bold text-danger text-sm">(Total Koin Anda kurang dari 20 Koin)</span>
                                    @elseif($koin > 0)
                                    <span class="mx-2 font-weight-bold text-secondary text-sm">({{ $pesan == 'sudah' || $pesan == 'admin' ? 'Anda telah membayar lunas Biaya Registrasi' : 'Koin Anda cukup untuk membayar Biaya Registrasi'}})</span>
                                    @endif
                                </h5>
                                {{-- </div> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="column">
                                {{-- <div class="col-md-6"> --}}
                                    <div class="form-group">
                                        <label for="ktp" class="form-control-label">{{ __('Nomor KTP') }} <span class="text-danger">*</span></label>
                                        {{-- <div class="@error('ktp') border border-danger rounded-3 @enderror"> --}}
                                            <input class="form-control" type="text" placeholder="Contoh Nomor KTP: 36XXX1001223XXXX" id="ktp" name="ktp"
                                                value="{{ count($penjual) > 0 ? ($penjual[0]['ktp'] == '' || $penjual[0]['ktp'] == null ? '' : $penjual[0]['ktp'] ) : '' }}"
                                                {{ count($penjual) > 0 ? ( $penjual[0]['konfirmasi'] > 0 ? '' : 'disabled' ) : '' }}>
                                            {{-- @error('ktp')
                                                <p class="text-danger text-xs mx-2">{{ $message }}</p><!-- print($tr->translate($message)) -->
                                            @enderror
                                        </div> --}}
                                    </div>
                                {{-- </div> --}}
                                @if(count($penjual) > 0 && $mode == 'registrasi')
                                {{-- <div class="col-md-6"> --}}
                                    <div class="form-group">
                                        <label for="ttg">{{ 'Catatan Konfirmasi Registrasi' }}</label>
                                        {{-- <div class="@error('ttg') border border-danger rounded-3 @enderror"> --}}
                                            <h6 class="mx-2 font-weight-bolder text-danger text-capitalize">
                                            {{-- <textarea disabled class="form-control" id="ttg" rows="3" placeholder="Keterangan mengenai Registrasi Penjual" name="catatan" id="catatan"> --}}
                                                {{ $penjual[0]['catatan'] == '' || $penjual[0]['catatan'] == null ? 'menunggu Konfirmasi' : $penjual[0]['catatan'] }}
                                            {{-- </textarea> --}}
                                            </h6>
                                        {{-- </div> --}}
                                    </div>
                                {{-- </div> --}}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-0">
                                <label for="foto" class="form-control-label">{{ __('Foto KTP') }} <span class="text-danger">*</span></label>
                                {{-- <div class="@error('foto') border border-danger rounded-3 @enderror"> --}}
                                    @if(count($penjual) > 0)
                                    <img src="{{ $penjual[0]['foto'] == '' || $penjual[0]['foto'] == null ? '' : $penjual[0]['foto'] }}" alt="Foto KTP"
                                        class="w-100 border-radius-lg shadow-sm bg-outline-dark">
                                    @endif
                                    @if(auth()->user()->role == 2)
                                    <input type="file" class="col-md-12 btn btn-link btn-sm p-2 text-dark" accept=".jpg, .jpeg, .png" id="foto" name="foto"
                                    value="{{ count($penjual) > 0 ? ($penjual[0]['foto'] == '' || $penjual[0]['foto'] == null ? '' : $penjual[0]['foto'] ) : ''}}"
                                    {{ count($penjual) > 0 ? ($penjual[0]['konfirmasi'] < 2 ? 'disabled' : '' ) : ''}}>
                                    {{-- @error('foto')
                                    <p class="text-danger text-xs mx-2">{{ $message }}</p><!-- print($tr->translate($message)) -->
                                    @enderror --}}
                                    @endif
                                    {{-- <input class="form-control" type="text" placeholder="Tombol Upload" id="foto" name="foto" value="" {{ auth()->user()->ktp == '' || auth()->user()->ktp == null ? 'Contoh Nomor KTP: 36XXX1001223XXXX' : auth()->user()->ktp }}> --}}
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <span class="text-danger">*</span><label class="font-weight-bold text-dark mb-0">Harap Mengisi Seluruh Data yang Tersedia</label>
                        </div>
                        <div class="col-md-6">
                            {{-- <div class="d-flex justify-content-end"> --}}
                                {{-- <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">Reply</a> --}}
                                <a href="{{ url('/user-profile') }}" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Kembali sebagai Penggemar' }}</a>
                            {{-- </div> --}}
                        </div>
                        @if ($mode != 'profile')
                        @if(count($penjual) > 0)<input type="hidden" name="transaksi" id="transaksi" value="{{$penjual[0]['trans']}}">@endif
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn bg-gradient-info btn-md mt-4 mb-4" {{ count($penjual) > 0 ? ( $penjual[0]['konfirmasi'] > 0 ? '' : 'disabled') : ($koin < 20 ? 'disabled' : '')}}>
                                    {{ ($mode == 'registrasi' && $pesan != 'admin' && $pesan != 'ulang' ? 'Kirim Registrasi' : ($penjual[0]['konfirmasi'] == 2 ? 'Kirim Ulang Registrasi' : 'Menunggu Konfirmasi' )) }}</button>
                            </div>
                        </div>
                        @endif
                    </div>
                    {{-- end registrasi --}}
                    @else
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="form-control-label">{{ __('Username') }}</label> {{-- for=user-username --}}
                                {{-- <div class="@error('username')border border-danger rounded-3 @enderror"> --}}
                                    <input class="form-control" value="{{ auth()->user()->username }}" type="text" id="username" name="username" disabled>
                                        {{-- @error('username')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p><!-- print($tr->translate($message)) -->
                                        @enderror
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-control-label">{{ __('Email') }}</label>
                                {{-- <div class="@error('email')border border-danger rounded-3 @enderror"> --}}
                                    <input class="form-control" value="{{ auth()->user()->email }}" type="email" placeholder="Email, contoh: user@example.com" id="email" name="email">
                                        {{-- @error('email')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p><!-- print($tr->translate($message)) -->
                                        @enderror
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama" class="form-control-label">{{ __('Nama Lengkap') }}</label> {{-- for=user-nama --}}
                                {{-- <div class="@error('nama')border border-danger rounded-3 @enderror"> --}}
                                    <input class="form-control" value="{{ auth()->user()->nama }}" type="text" placeholder="Nama Lengkap" id="nama" name="nama">
                                        {{-- @error('nama')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p><!-- print($tr->translate($message)) -->
                                        @enderror
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomor" class="form-control-label">{{ __('Nomor Telepon') }}</label> {{-- for=user.nomor_telepon --}}
                                {{-- <div class="@error('nomor') border border-danger rounded-3 @enderror"> --}}
                                    <input class="form-control" type="tel" placeholder="Nomor Telepon, contoh: 08XXxxxxX00" id="nomor" name="nomor" value="{{ auth()->user()->nomor_telepon }}">
                                        {{-- @error('nomor')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p><!-- print($tr->translate($message)) -->
                                        @enderror
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gambar">{{ 'Gambar Profile' }}</label>
                                {{-- <div class="@error('gambar') border border-danger rounded-3 @enderror"> --}}
                                {{-- <button type="button" class="btn btn-link btn-sm bg-gradient-dark col-md-12" id="gambar" name="gambar"> --}}
                                    <input type="file" class="col-md-12 btn btn-link btn-sm p-2 text-dark" accept=".jpg, .jpeg, .png" id="gambar" name="gambar">
                                    {{-- </button> --}}
                                    {{-- @error('gambar')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p><!-- print($tr->translate($message)) -->
                                    @enderror
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ttg">{{ 'Tentang Anda' }}</label>
                                {{-- <div class="@error('ttg') border border-danger rounded-3 @enderror"> --}}
                                    <textarea class="form-control" id="ttg" rows="3" placeholder="Tuliskan sesuatu tentang Anda" name="ttg">{{ auth()->user()->tentang_user }}</textarea>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kota" class="form-control-label">{{ __('Kota Tempat Tinggal') }} @if(auth()->user()->role == 3 && auth()->user()->kota == null)<span class="text-danger">* Harap Mengisi ini dengan Benar untuk data sebagai Penjual</span>@endif </label>
                                {{-- <div class="@error('kota') border border-danger rounded-3 @enderror"> --}}
                                    <input class="form-control" type="text" id="kota" name="kota" placeholder="Kota di Indonesia, bisa disertakan Provinsi, contoh: Tangerang, Jawa Barat" value="{{ auth()->user()->kota }}" {{ auth()->user()->role == 3 && auth()->user()->kota != null ? 'disabled' : ''}}>
                                        {{-- @error('kota')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="artis" class="form-control-label">{{ __('Nama Artis Favorit') }}</label>
                                {{-- <div class="@error('artis') border border-danger rounded-3 @enderror"> --}}
                                    <input class="form-control" type="text" id="artis" name="artis" placeholder="Nama Artis, contoh: Rocky ASTRO" value="{{ auth()->user()->artis }}">
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- <div class="d-flex justify-content-end"> --}}
                                {{-- <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">Reply</a> --}}
                                {{-- setelah daftar sbg penjual maka ini akan diubah namanya jadi profile penjual --}}
                                <a href="{{ auth()->user()->role == 3 ? url('/penjual/profile') : url('/penjual/registrasi') }}"
                                    class="btn bg-gradient-info btn-md mt-4 mb-4">{{auth()->user()->role == 3 ? 'Profile ' : 'Registrasi ' }}sebagai Penjual</a>
                            {{-- </div> --}}
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Ubah Profile' }}
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- profile.blade.php >> lebih banyak isinya --}}
    {{-- <div class="container-fluid py-4">
        <div class="row">
          <div class="col-12 col-xl-4">
            <div class="card h-100">
              <div class="card-header pb-0 p-3">
                <h6 class="mb-0">Platform Settings</h6>
              </div>
              <div class="card-body p-3">
                <h6 class="text-uppercase text-body text-xs font-weight-bolder">Account</h6>
                <ul class="list-group">
                  <li class="list-group-item border-0 px-0">
                    <div class="form-check form-switch ps-0">
                      <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault" checked>
                      <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault">Email me when someone follows me</label>
                    </div>
                  </li>
                  <li class="list-group-item border-0 px-0">
                    <div class="form-check form-switch ps-0">
                      <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault1">
                      <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault1">Email me when someone answers on my post</label>
                    </div>
                  </li>
                  <li class="list-group-item border-0 px-0">
                    <div class="form-check form-switch ps-0">
                      <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault2" checked>
                      <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault2">Email me when someone mentions me</label>
                    </div>
                  </li>
                </ul>
                <h6 class="text-uppercase text-body text-xs font-weight-bolder mt-4">Application</h6>
                <ul class="list-group">
                  <li class="list-group-item border-0 px-0">
                    <div class="form-check form-switch ps-0">
                      <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault3">
                      <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault3">New launches and projects</label>
                    </div>
                  </li>
                  <li class="list-group-item border-0 px-0">
                    <div class="form-check form-switch ps-0">
                      <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault4" checked>
                      <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault4">Monthly product updates</label>
                    </div>
                  </li>
                  <li class="list-group-item border-0 px-0 pb-0">
                    <div class="form-check form-switch ps-0">
                      <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault5">
                      <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault5">Subscribe to newsletter</label>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-12 col-xl-4">
            <div class="card h-100">
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
            </div>
          </div>
          <div class="col-12 col-xl-4">
            <div class="card h-100">
              <div class="card-header pb-0 p-3">
                <h6 class="mb-0">Conversations</h6>
              </div>
              <div class="card-body p-3">
                <ul class="list-group">
                  <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                    <div class="avatar me-3">
                      <img src="../assets/img/kal-visuals-square.jpg" alt="kal" class="border-radius-lg shadow">
                    </div>
                    <div class="d-flex align-items-start flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Sophie B.</h6>
                      <p class="mb-0 text-xs">Hi! I need more information..</p>
                    </div>
                    <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">Reply</a>
                  </li>
                  <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                    <div class="avatar me-3">
                      <img src="../assets/img/marie.jpg" alt="kal" class="border-radius-lg shadow">
                    </div>
                    <div class="d-flex align-items-start flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Anne Marie</h6>
                      <p class="mb-0 text-xs">Awesome work, can you..</p>
                    </div>
                    <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">Reply</a>
                  </li>
                  <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                    <div class="avatar me-3">
                      <img src="../assets/img/ivana-square.jpg" alt="kal" class="border-radius-lg shadow">
                    </div>
                    <div class="d-flex align-items-start flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Ivanna</h6>
                      <p class="mb-0 text-xs">About files I can..</p>
                    </div>
                    <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">Reply</a>
                  </li>
                  <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                    <div class="avatar me-3">
                      <img src="../assets/img/team-4.jpg" alt="kal" class="border-radius-lg shadow">
                    </div>
                    <div class="d-flex align-items-start flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Peterson</h6>
                      <p class="mb-0 text-xs">Have a great afternoon..</p>
                    </div>
                    <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">Reply</a>
                  </li>
                  <li class="list-group-item border-0 d-flex align-items-center px-0">
                    <div class="avatar me-3">
                      <img src="../assets/img/team-3.jpg" alt="kal" class="border-radius-lg shadow">
                    </div>
                    <div class="d-flex align-items-start flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Nick Daniel</h6>
                      <p class="mb-0 text-xs">Hi! I need more information..</p>
                    </div>
                    <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">Reply</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-12 mt-4">
            <div class="card mb-4">
              <div class="card-header pb-0 p-3">
                <h6 class="mb-1">Projects</h6>
                <p class="text-sm">Architects design houses</p>
              </div>
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                    <div class="card card-blog card-plain">
                      <div class="position-relative">
                        <a class="d-block shadow-xl border-radius-xl">
                          <img src="../assets/img/home-decor-1.jpg" alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                        </a>
                      </div>
                      <div class="card-body px-1 pb-0">
                        <p class="text-gradient text-dark mb-2 text-sm">Project #2</p>
                        <a href="javascript:;">
                          <h5>
                            Modern
                          </h5>
                        </a>
                        <p class="mb-4 text-sm">
                          As Uber works through a huge amount of internal management turmoil.
                        </p>
                        <div class="d-flex align-items-center justify-content-between">
                          <button type="button" class="btn btn-outline-primary btn-sm mb-0">View Project</button>
                          <div class="avatar-group mt-2">
                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Elena Morison">
                              <img alt="Image placeholder" src="../assets/img/team-1.jpg">
                            </a>
                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Milly">
                              <img alt="Image placeholder" src="../assets/img/team-2.jpg">
                            </a>
                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Nick Daniel">
                              <img alt="Image placeholder" src="../assets/img/team-3.jpg">
                            </a>
                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Peterson">
                              <img alt="Image placeholder" src="../assets/img/team-4.jpg">
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                    <div class="card card-blog card-plain">
                      <div class="position-relative">
                        <a class="d-block shadow-xl border-radius-xl">
                          <img src="../assets/img/home-decor-2.jpg" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                        </a>
                      </div>
                      <div class="card-body px-1 pb-0">
                        <p class="text-gradient text-dark mb-2 text-sm">Project #1</p>
                        <a href="javascript:;">
                          <h5>
                            Scandinavian
                          </h5>
                        </a>
                        <p class="mb-4 text-sm">
                          Music is something that every person has his or her own specific opinion about.
                        </p>
                        <div class="d-flex align-items-center justify-content-between">
                          <button type="button" class="btn btn-outline-primary btn-sm mb-0">View Project</button>
                          <div class="avatar-group mt-2">
                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Nick Daniel">
                              <img alt="Image placeholder" src="../assets/img/team-3.jpg">
                            </a>
                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Peterson">
                              <img alt="Image placeholder" src="../assets/img/team-4.jpg">
                            </a>
                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Elena Morison">
                              <img alt="Image placeholder" src="../assets/img/team-1.jpg">
                            </a>
                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Milly">
                              <img alt="Image placeholder" src="../assets/img/team-2.jpg">
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                    <div class="card card-blog card-plain">
                      <div class="position-relative">
                        <a class="d-block shadow-xl border-radius-xl">
                          <img src="../assets/img/home-decor-3.jpg" alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                        </a>
                      </div>
                      <div class="card-body px-1 pb-0">
                        <p class="text-gradient text-dark mb-2 text-sm">Project #3</p>
                        <a href="javascript:;">
                          <h5>
                            Minimalist
                          </h5>
                        </a>
                        <p class="mb-4 text-sm">
                          Different people have different taste, and various types of music.
                        </p>
                        <div class="d-flex align-items-center justify-content-between">
                          <button type="button" class="btn btn-outline-primary btn-sm mb-0">View Project</button>
                          <div class="avatar-group mt-2">
                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Peterson">
                              <img alt="Image placeholder" src="../assets/img/team-4.jpg">
                            </a>
                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Nick Daniel">
                              <img alt="Image placeholder" src="../assets/img/team-3.jpg">
                            </a>
                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Milly">
                              <img alt="Image placeholder" src="../assets/img/team-2.jpg">
                            </a>
                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Elena Morison">
                              <img alt="Image placeholder" src="../assets/img/team-1.jpg">
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                    <div class="card h-100 card-plain border">
                      <div class="card-body d-flex flex-column justify-content-center text-center">
                        <a href="javascript:;">
                          <i class="fa fa-plus text-secondary mb-3"></i>
                          <h5 class=" text-secondary"> New project </h5>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div> --}}
