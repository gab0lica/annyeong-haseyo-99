
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
                        <h4 class="text-dark font-weight-bolder m-0">Daftar Pengikut</h4>
                        <h6 class="mb-1">
                            {{ auth()->user()->nama }} {{--  __('Alec Thompson') --}}
                        </h6>
                    </div>
                </div>
                <div class="col-auto text-end my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 px-5"><!--col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3-->
                    {{-- <h6 class="mb-1">
                        {{ __('Penjual') }}
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
        <div class="row">
            <div class="card h-100">
                <div class="card-body p-3">
                    <ul class="list-group">
                        @if (count($pengikut) > 0)
                        @for ($i = 0; $i < count($pengikut); $i+=1)
                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                            <div class="avatar me-3 w-5">
                                @php
                                    $random = rand(1,4);
                                    // ../pic/uni-user-{{ $random == 3 ? '3.jpg' : $random.'.png' }}
                                @endphp
                            <img src="../assets/img/team-{{ rand(1,8) }}.jpg" alt="{{$pengikut[$i]['nama']}}" class="border-radius-lg shadow">
                            </div>
                            <div class="d-flex align-items-start flex-column justify-content-center">
                                <h5 class="mb-0">{{$pengikut[$i]['nama']}}<i class="fas fa-user-check text-info text-gradient opacity-10 px-2"></i></h5>
                                <span class="mb-0 text-sm text-secondary">{{ auth()->user()->id != $pengikut[$i]['id'] ? $pengikut[$i]['username'] : 'Anda'}}</span>
                            </div>
                            {{-- <h6 class="text-dark font-weight-bold pe-3 ps-0 mb-0 text-end ms-auto"><i class="fas fa-users text-info text-gradient opacity-10 px-2"></i>{{ $pengikut[$i]['user'] }} user</h6>
                            @if(auth()->user()->id != $pengikut[$i]['id'])
                            <a class="btn {{$pengikut[$i]['ikut'] == 1 ? 'btn-outline-dark' : 'bg-gradient-info'}} mb-0" href="{{ url('/ikuti-penjual/'.$pengikut[$i]['id']) }}">
                                {{$pengikut[$i]['ikut'] == 1 ? 'Tidak Ikuti' : 'Ikuti'}}
                            </a>
                            @endif --}}
                        </li>
                        <hr>
                        @endfor
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

