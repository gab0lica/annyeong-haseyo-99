@extends('layouts.user_type.auth')

@section('content')
{{-- dari profile.blade.php --}}
<div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 p-3">
        <div class="row">
        {{-- <h4 class="mb-1 font-weight-bolder col-md-8">Berita Terbaru</h4> --}}
        <div class="col-lg-9 col-9">
            <h4 class="mb-1 font-weight-bolder">Berita Terbaru</h4>
            @if (($dsp > 0 || $ktm > 0 || $khd > 0) && $cari == null)
              <span class="ms-1 {{$web == 'dsp' ? 'font-weight-bolder badge badge-pill badge-md bg-gradient-dark' : ''}}"> Dispatch </span> <p class="text-ms badge badge-pill badge-md bg-gradient-info ms-1 my-0"> {{$dsp}} </p>
              <span class="ms-1 {{$web == 'ktm' ? 'font-weight-bolder badge badge-pill badge-md bg-gradient-dark' : ''}}"> The Korea Times </span> <p class="text-ms badge badge-pill badge-md bg-gradient-success ms-1 my-0"> {{$ktm}} </p>
              <span class="ms-1 {{$web == 'khd' ? 'font-weight-bolder badge badge-pill badge-md bg-gradient-dark' : ''}}"> Korea Herald </span> <p class="text-ms badge badge-pill badge-md bg-gradient-secondary ms-1 my-0"> {{$khd}} </p>
              <i class="fas fa-check-circle text-gradient text-primary ms-2 py-1" aria-hidden="true"></i> <span class="font-weight-bold">{{count($berita) < 100 ? count($berita) : '100 berita dimunculkan'}}</span>
            @else
            <i class="fas fa-check-circle text-gradient text-primary ms-2 py-1" aria-hidden="true"></i> <span class="font-weight-bolder">{{count($berita) < 100 ? count($berita).' berita dimunculkan' : '100 berita dimunculkan, sisa '.(count($berita)-100).' berita lainnya' }} </span> <span class=""> yang berkaitan dengan {{ "'".$cari."' " }}</span>
            @if (count($artis) > 0)
            <span class="">dan Artis {{auth()->user()->artis == strtolower($cari) ? 'Favorit' : ''}}</span>
            @foreach($artis as $key)<span class="font-weight-bolder me-2"><i class="fas fa-users text-gradient text-primary ms-2 py-1" aria-hidden="true"></i> {{ $key->nama.' ' }}</span>@endforeach
            @endif
            @endif
        </div>
        <div class="col-lg-3 col-3 my-auto text-end">
            <a href="#" class="btn bg-gradient-dark dropdown-toggle" data-bs-toggle="dropdown" id="navbarDropdownMenuLink">
                {{-- <img src="https://demos.creative-tim.com/argon-dashboard-pro/assets/img/icons/flags/US.png" />  --}}
                {{Request::is('berita/semua') || Request::is('cari-berita') ? 'Semua Website Korea' :  (Request::is('berita/dsp') ? 'Dispatch' :
                (Request::is('berita/ktm') ? 'The Korea Times' : (Request::is('berita/khd') ? 'Korea Herald' : '' )))}}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li> <a class="dropdown-item {{ Request::is('berita/semua') ? 'font-weight-bolder' : '' }}" href="{{ url('/berita/semua')}}"> Semua Website Korea </a> </li>
                <li> <a class="dropdown-item {{ Request::is('berita/dsp') ? 'font-weight-bolder' : '' }}" href="{{ url('/berita/dsp')}}"> Dispatch </a> </li>
                <li> <a class="dropdown-item {{ Request::is('berita/ktm') ? 'font-weight-bolder' : '' }}" href="{{ url('/berita/ktm')}}"> The Korea Times </a> </li>
                <li> <a class="dropdown-item {{ Request::is('berita/khd') ? 'font-weight-bolder' : '' }}" href="{{ url('/berita/khd')}}"> Korea Herald </a> </li>
            </ul>
        </div>
            <form action="/cari-berita" method="POST" role="form text-left" class="mt-4" >
                {{-- 'my-auto' target="_blank"--}}
                @csrf
                <div class="input-group">
                    <input type="text text-right" class="form-control" name="cari" placeholder="Artis Korea, Event, dan lainnya..." value="{{ $cari == null ? '' : $cari }}">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                </div>
            </form>
        </div>
      </div>
      <div class="card-body p-3">
        <div class="row">
              {{-- <div class="grid-container" style="display: grid; grid-auto-flow: column; grid-gap: 50px; grid-template-columns: repeat(3, 250px); grid-template-rows: repeat(21, 500px);"> --}}
              {{--  grid-auto-rows: auto; --}}
            @if (count($berita) == 0)
              {{-- <div class="row"> --}}
                  <div class="col-12">
                      <div class="alert alert-dark mx-4" role="alert">
                          {{-- <span class="text-white"> --}}
                            <h6 class="mb-0 text-l text-center text-white">Tidak ditemukan Berita Terbaru {{$cari == null ? '' : 'dengan kata '.$cari}}</h6>
                              {{-- <strong>{{$pesan}}</strong> --}}
                          {{-- </span> --}}
                      </div>
                  </div>
              {{-- </div> --}}
            @else
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
            @for ($i = 0; $i < (count($berita) < 100 ? count($berita) : 100); $i+=4)
            <div class="column"><!--grid-item-->
            <div class="col-xl-12 col-md-6 mb-xl-0 mb-4 mt-4">
                <div class="card card-blog card-plain">
                  <div class="position-relative">
                    <a class="d-block shadow-xl border-radius-xl" href="{{ url('/lihat-berita/'.$berita[$i]['id']) }}" target="_blank">
                        <img src="{{ $berita[$i]['gambar'] == 'nope' ? ( $berita[$i]['web'] == 1 ? '../logo/dsp.png' : ( $berita[$i]['web'] == 2 ? '../logo/ktm.png' : '../logo/khd.png') ) : $berita[$i]['gambar'] }}"
                            title="Buka Berita" alt="{{  $berita[$i]['web'] == 1 ? 'Dispatch Korea' : ( $berita[$i]['web'] == 2 ? 'The Korea Times' : 'The Korea Herald') }}"
                            class="img-fluid shadow border-radius-xl {{ $berita[$i]['gambar'] == 'nope' ? 'w-100' : '' }}">
                    </a>
                  </div>
                  <div class="card-body px-1 pb-0">
                    <p class="badge badge-pill badge-md {{$berita[$i]['web'] == 1 ? "bg-gradient-info" : ($berita[$i]['web'] == 2 ? "bg-gradient-success" : "bg-gradient-secondary") }}
                        font-weight-bolder mb-2 text-sm">{{$berita[$i]['web'] == 1 ? "Dispatch Korea" : ($berita[$i]['web'] == 2 ? "The Korea Times" : "The Korea Herald") }}</p>
                    <a href="{{ url('/lihat-berita/'.$berita[$i]['id']) }}" target="_blank" title="Buka Berita"> <!--title="{{$berita[$i]['idnjudul']}}"-->
                      <h5>{{$berita[$i]['judul']}}</h5>
                    </a>
                    <div class="text-end">
                        <span class="text-sm ms-1">{{$berita[$i]['tanggal']}}</span>
                    </div>
                  </div>
                </div>
            </div>
            </div>
            @endfor
            </div>

            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
            @for ($i = 1; $i < (count($berita) < 100 ? count($berita) : 100); $i+=4)
            <div class="column"><!--grid-item-->
            <div class="col-xl-12 col-md-6 mb-xl-0 mb-4 mt-4">
                <div class="card card-blog card-plain">
                  <div class="position-relative">
                    <a class="d-block shadow-xl border-radius-xl" href="{{ url('/lihat-berita/'.$berita[$i]['id']) }}" target="_blank">
                        <img src="{{ $berita[$i]['gambar'] == 'nope' ? ( $berita[$i]['web'] == 1 ? '../logo/dsp.png' : ( $berita[$i]['web'] == 2 ? '../logo/ktm.png' : '../logo/khd.png') ) : $berita[$i]['gambar'] }}"
                            title="{{$berita[$i]['judul']}}" alt="{{  $berita[$i]['web'] == 1 ? 'Dispatch Korea' : ( $berita[$i]['web'] == 2 ? 'The Korea Times' : 'The Korea Herald') }}"
                            class="img-fluid shadow border-radius-xl {{ $berita[$i]['gambar'] == 'nope' ? 'w-100' : '' }}">
                    </a>
                  </div>
                  <div class="card-body px-1 pb-0">
                    <p class="badge badge-pill badge-md {{$berita[$i]['web'] == 1 ? "bg-gradient-info" : ($berita[$i]['web'] == 2 ? "bg-gradient-success" : "bg-gradient-secondary") }}
                        font-weight-bolder mb-2 text-sm">{{$berita[$i]['web'] == 1 ? "Dispatch Korea" : ($berita[$i]['web'] == 2 ? "The Korea Times" : "The Korea Herald") }}</p>
                    <a href="{{ url('/lihat-berita/'.$berita[$i]['id']) }}" target="_blank">
                      <h5>{{$berita[$i]['judul']}}</h5>
                    </a>
                    <div class="text-end">
                        <span class="text-sm ms-1">{{$berita[$i]['tanggal']}}</span>
                    </div>
                  </div>
                </div>
            </div>
            </div>
            @endfor
            </div>

            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
            @for ($i = 2; $i < (count($berita) < 100 ? count($berita) : 100); $i+=4)
            <div class="column"><!--grid-item-->
            <div class="col-xl-12 col-md-6 mb-xl-0 mb-4 mt-4">
                <div class="card card-blog card-plain">
                  <div class="position-relative">
                    <a class="d-block shadow-xl border-radius-xl" href="{{ url('/lihat-berita/'.$berita[$i]['id']) }}" target="_blank">
                        <img src="{{ $berita[$i]['gambar'] == 'nope' ? ( $berita[$i]['web'] == 1 ? '../logo/dsp.png' : ( $berita[$i]['web'] == 2 ? '../logo/ktm.png' : '../logo/khd.png') ) : $berita[$i]['gambar'] }}"
                            title="{{$berita[$i]['judul']}}" alt="{{  $berita[$i]['web'] == 1 ? 'Dispatch Korea' : ( $berita[$i]['web'] == 2 ? 'The Korea Times' : 'The Korea Herald') }}"
                            class="img-fluid shadow border-radius-xl {{ $berita[$i]['gambar'] == 'nope' ? 'w-100' : '' }}">
                    </a>
                  </div>
                  <div class="card-body px-1 pb-0">
                    <p class="badge badge-pill badge-md {{$berita[$i]['web'] == 1 ? "bg-gradient-info" : ($berita[$i]['web'] == 2 ? "bg-gradient-success" : "bg-gradient-secondary") }}
                        font-weight-bolder mb-2 text-sm">{{$berita[$i]['web'] == 1 ? "Dispatch Korea" : ($berita[$i]['web'] == 2 ? "The Korea Times" : "The Korea Herald") }}</p>
                    <a href="{{ url('/lihat-berita/'.$berita[$i]['id']) }}" target="_blank">
                      <h5>{{$berita[$i]['judul']}}</h5>
                    </a>
                    <div class="text-end">
                        <span class="text-sm ms-1">{{$berita[$i]['tanggal']}}</span>
                    </div>
                  </div>
                </div>
            </div>
            </div>
            @endfor
            </div>

            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
            @for ($i = 3; $i < (count($berita) < 100 ? count($berita) : 100); $i+=4)
            <div class="column"><!--grid-item-->
            <div class="col-xl-12 col-md-6 mb-xl-0 mb-4 mt-4">
                <div class="card card-blog card-plain">
                  <div class="position-relative">
                    <a class="d-block shadow-xl border-radius-xl" href="{{ url('/lihat-berita/'.$berita[$i]['id']) }}" target="_blank">
                        <img src="{{ $berita[$i]['gambar'] == 'nope' ? ( $berita[$i]['web'] == 1 ? '../logo/dsp.png' : ( $berita[$i]['web'] == 2 ? '../logo/ktm.png' : '../logo/khd.png') ) : $berita[$i]['gambar'] }}"
                            title="{{$berita[$i]['judul']}}" alt="{{  $berita[$i]['web'] == 1 ? 'Dispatch Korea' : ( $berita[$i]['web'] == 2 ? 'The Korea Times' : 'The Korea Herald') }}"
                            class="img-fluid shadow border-radius-xl {{ $berita[$i]['gambar'] == 'nope' ? 'w-100' : '' }}">
                    </a>
                  </div>
                  <div class="card-body px-1 pb-0">
                    <p class="badge badge-pill badge-md {{$berita[$i]['web'] == 1 ? "bg-gradient-info" : ($berita[$i]['web'] == 2 ? "bg-gradient-success" : "bg-gradient-secondary") }}
                        font-weight-bolder mb-2 text-sm">{{$berita[$i]['web'] == 1 ? "Dispatch Korea" : ($berita[$i]['web'] == 2 ? "The Korea Times" : "The Korea Herald") }}</p>
                    <a href="{{ url('/lihat-berita/'.$berita[$i]['id']) }}" target="_blank">
                      <h5>{{$berita[$i]['judul']}}</h5>
                    </a>
                    <div class="text-end">
                        <span class="text-sm ms-1">{{$berita[$i]['tanggal']}}</span>
                    </div>
                  </div>
                </div>
            </div>
            </div>
            @endfor
            </div>
            @endif

        </div>
        {{-- @if (count($berita) > 200)
        <div class="col-xl-12 col-md-6 mb-xl-0 mb-4 mt-4">
            <div class="card card-blog card-plain">
              <div class="position-relative">
                <img src="../assets/img/vr-bg.jpg" title="{{count($berita)-200}} Berita Lainnya" class="img-fluid shadow border-radius-xl w-50">
              </div>
              <div class="card-body px-1 pb-0">
                  <h6>{{count($berita)-200}} Berita Lainnya</h6>
              </div>
            </div>
        </div>
        @endif --}}
        <div></div>
      </div>
    </div>
  </div>

{{-- end dari profile.blade.php --}}
@endsection
