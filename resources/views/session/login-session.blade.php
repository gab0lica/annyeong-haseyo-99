@extends('layouts.user_type.guest')

@section('content')

  <main class="main-content mt-0 mb-1"><!--tidak ada mb-1-->
    <section>
      <div class="page-header min-vh-80"><!--min-vh-75 = min-vh-80-->
        <div class="container">
          <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-6 d-flex flex-column mx-auto"> <!--col-xl-4 = col-xl-5-->
              <div class="card card-plain mt-5 mb-2"><!--mt-8 = mt-5-->
                <div class="card-header pb-0 text-left bg-transparent">
                    {{-- <h2 class="font-weight-bolder text-gradient text-info mt-0">Annyeong Haseyo</h2> --}}
                    <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="#">
                        <img src="../logo/logo-korea-10.jpg" class="navbar-brand-img w-80 h-100" alt="...">
                    </a>
                    <h6 class="font-weight-bolder text-dark mb-0">Silakan Login Terlebih Dahulu <br> dengan Akun yang Telah Terdaftar</h6>
                    {{-- <span class="text-danger">*</span><label class="font-weight-bold text-dark mb-0">Harap Menulis Akun Anda yang telah Terdaftar</label> --}}
                  {{-- <p class="mb-0">Create a new acount OR Sign in with these credentials:</p>
                  <p class="mb-0 text-secondary">Username <b>admin_softui</b>
                  <p class="mb-0 text-secondary">Password <b>secret</b></p> --}}
                </div>
                <div class="card-body mt-0">
                  <form role="form" method="POST" action="/session">
                    @csrf
                    <label for="email" class="text-s">Username</label><span class="text-danger">*</span>
                    <div class="mb-3">
                        {{-- placeholder="admin_softui" value="gabrielleakho"  --}}
                      <input class="form-control" name="username" id="username" value="{{old('username')}}" placeholder="Username Anda" aria-label="Username" aria-describedby="username-addon">
                      {{-- awalnya ada ini karena 'email' >> type="email" --}}
                      @error('username')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                    <label for="password" class="text-s">Password</label><span class="text-danger">*</span>
                    <div class="mb-3">
                        {{-- placeholder="secret" value="gab123321" --}}
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password Anda" aria-label="Password" aria-describedby="password-addon">
                      @error('password')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                    {{-- <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                      <label class="form-check-label" for="rememberMe">Ingat saya</label>
                    </div> --}}
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-dark w-100 mt-4 mb-0">Masuk</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                <small class="text-muted">Lupa Password? Buat ulang Password baru
                  <a href="/reset-password" class="text-info text-gradient font-weight-bold">disini.</a>
                  {{-- login/forgot-password --}}
                </small>
                  <p class="mb-4 text-sm mx-auto">
                    Akun belum didaftarkan?
                    <a href="register" class="text-info text-gradient font-weight-bold">Registrasi</a>
                     dahulu.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6"><!--col-md-6 = col-md-4-->
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n6"><!--me-n8-->
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../assets/img/curved-images/curved14.jpg')"></div><!--white-curved.jpeg-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection
