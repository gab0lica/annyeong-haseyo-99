@extends('layouts.user_type.guest')

@section('content')
<main class="main-content mt-0 mb-1"><!--tidak ada mb-1-->
    <section>
        <div class="page-header min-vh-80"><!--section-height-75 = min-vh-100-->
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-5 mb-2"><!--mt-8 = mt-4-->
                            <div class="card-header pb-0 text-left bg-transparent">
                                {{-- <h4 class="mb-0">Change password</h4> --}}
                                {{-- <h2 class="font-weight-bolder text-info text-gradient mt-0">Annyeong Haseyo</h2> --}}
                                <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="#">
                                    <img src="../logo/logo-korea-10.jpg" class="navbar-brand-img w-80 h-100" alt="...">
                                </a>
                                <h5 class="font-weight-bolder text-dark mb-0">Membuat Password Baru</h5>
                                <span class="text-danger">*</span><label class="font-weight-bold text-dark mb-0">Harap Mengisi Seluruh Data yang Tersedia</label>
                            </div>
                            {{-- <div class="card-header pb-0 text-left bg-transparent">
                                <h4 class="mb-0 text-secondary">Forgot your password? Enter your email here</h4>
                            </div> --}}
                            <div class="card-body">
                                <form action="/reset-password" method="POST" role="form text-left">
                                    @if(session('success'))
                                        <div class="alert alert-success alert-dismissible fade show m-0" id="alert-success" role="alert">
                                            <span class="alert-text text-white">
                                            {{ session('success') }}</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                <i class="fa fa-close" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    @endif
                                    @csrf
                                    {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}
                                    <div>
                                        <label for="username">Username</label><span class="text-danger">*</span>
                                        <div>
                                            <input id="username" name="username" type="username" class="form-control" value="{{ old('username') }}" placeholder="Username yang terdaftar" aria-label="username" aria-describedby="username-addon">
                                            @error('username')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label for="password">Password Baru</label><span class="text-danger">*</span>
                                        <div>
                                            <input id="password" name="password" type="password" class="form-control" placeholder="Password Baru" aria-label="password" aria-describedby="password-addon">
                                            @error('password')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label for="cpassword">Konfirmasi Password Baru</label><span class="text-danger">*</span>
                                        <div>
                                            {{-- password_confirmation --}}
                                            <input id="cpassword" name="cpassword" type="password" class="form-control" placeholder="Konfirmasi Password Baru" aria-label="cpassword" aria-describedby="cpassword-addon">
                                            @error('cpassword')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-dark w-100 mt-4 mb-0">Simpan Password</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Anda bisa kembali
                                    <a href="login" class="text-info text-gradient font-weight-bold">Login</a>
                                    lebih lanjut.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../assets/img/curved-images/white-curved.jpeg')"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
