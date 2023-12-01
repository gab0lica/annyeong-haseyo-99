@extends('layouts.user_type.auth')

@section('content')
{{-- dari profile.blade.php --}}
<div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 p-3">
      <div class="row">
        <div class="col-lg-9 col-9">
            <h4 class="mb-1 font-weight-bolder">Sejarah Membaca Berita</h4>
            <h6 class="font-weight-bold">Berdasarkan Terakhir Membaca Berita</h6>
            {{-- <p class="text-sm mb-0"> --}}
              @if (($dsp > 0 || $ktm > 0 || $khd > 0) && $cari == -1)
                <span class="ms-1 {{$web == 'dsp' ? 'font-weight-bolder badge badge-pill badge-md bg-gradient-dark' : ''}}"> Dispatch </span> <p class="text-ms badge badge-pill badge-md bg-gradient-info ms-1 my-0"> {{$dsp}} </p>
                <span class="ms-1 {{$web == 'ktm' ? 'font-weight-bolder badge badge-pill badge-md bg-gradient-dark' : ''}}"> The Korea Times </span> <p class="text-ms badge badge-pill badge-md bg-gradient-success ms-1 my-0"> {{$ktm}} </p>
                <span class="ms-1 {{$web == 'khd' ? 'font-weight-bolder badge badge-pill badge-md bg-gradient-dark' : ''}}"> Korea Herald </span> <p class="text-ms badge badge-pill badge-md bg-gradient-secondary ms-1 my-0"> {{$khd}} </p>
                <i class="fas fa-check-circle text-gradient text-primary ms-2 py-1" aria-hidden="true"></i> <span class="font-weight-bold">{{count($history) < 100 ? count($history) : '100 berita'}} dimunculkan</span>
              @elseif($cari != null && $cari != -1)
              <i class="fas fa-check-circle text-gradient text-primary ms-2 py-1" aria-hidden="true"></i> <span class="font-weight-bolder">{{count($history) < 100 ? count($history).' berita dimunculkan' : '100 berita dimunculkan, sisa '.(count($berita)-100).' berita lainnya' }} </span> <span class=""> yang berkaitan dengan {{ "'".$cari."' " }}</span>
              @if (count($artis) > 0)
              <span class="">dan Artis {{auth()->user()->artis == strtolower($cari) ? 'Favorit' : ''}}</span>
              @foreach($artis as $key)<span class="font-weight-bolder me-2"><i class="fas fa-user text-gradient text-primary ms-2 py-1" aria-hidden="true"></i> {{ $key->nama.' ' }}</span>@endforeach
              @endif
              @else
              <span class="ms-1 font-weight-bold">Belum Membaca Berita</span>
              @endif
              {{-- @else
              <span class="ms-1"> Berkaitan dengan {{ " '".$cari."' " }}</span>  <i class="fa fa-check-circle text-dark" aria-hidden="true"></i><span class="ms-1 font-weight-bolder">{{count($berita)}} berita</span>
              @endif --}}
            {{-- </p> --}}
          </div>
          <div class="col-lg-3 col-3 my-auto text-end">
            <a href="#" class="btn bg-gradient-dark dropdown-toggle " data-bs-toggle="dropdown" id="navbarDropdownMenuLink">
                {{Request::is('sejarah-berita/semua') || Request::is('cari-sejarah') ? 'Semua Berita' :  (Request::is('sejarah-berita/dsp') ? 'Dispatch' :
                (Request::is('sejarah-berita/ktm') ? 'The Korea Times' : (Request::is('sejarah-berita/khd') ? 'Korea Herald' : '' )))}}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li> <a class="dropdown-item {{ Request::is('sejarah-berita/semua') ? 'font-weight-bolder' : '' }}" href="{{ url('/sejarah-berita/semua')}}"> Semua Berita </a> </li>
                <li> <a class="dropdown-item {{ Request::is('sejarah-berita/dsp') ? 'font-weight-bolder' : '' }}" href="{{ url('/sejarah-berita/dsp')}}"> Dispatch </a> </li>
                <li> <a class="dropdown-item {{ Request::is('sejarah-berita/ktm') ? 'font-weight-bolder' : '' }}" href="{{ url('/sejarah-berita/ktm')}}"> The Korea Times </a> </li>
                <li> <a class="dropdown-item {{ Request::is('sejarah-berita/khd') ? 'font-weight-bolder' : '' }}" href="{{ url('/sejarah-berita/khd')}}"> Korea Herald </a> </li>
            </ul>
          </div>
            <form action="/cari-sejarah" method="POST" role="form text-left" class="mt-4" >
                @csrf
                <div class="input-group">
                    <input type="text text-right" class="form-control" name="cari" placeholder="Artis Korea, Event, dan lainnya..." value="{{ $cari == -1 ? '' : $cari }}">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                </div>
            </form>
        </div>
      </div>
      <div class="card-body p-3">
        <div class="row">
            @if (count($history) == 0)
                  <div class="col-12">
                      <div class="alert alert-dark mx-4" role="alert">
                            <h6 class="mb-0 text-l text-center text-white">Tidak ada Data Terbaru</h6>
                      </div>
                  </div>
            @else

            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                @for ($i = 0; $i < (count($history) < 200 ? count($history) : 200); $i+=4)
                <div class="column"><!--grid-item-->
                <div class="col-xl-12 col-md-6 mb-xl-0 mb-4 mt-4">
                    <div class="card card-blog card-plain">
                    <div class="position-relative">
                        <a class="d-block shadow-xl border-radius-xl" href="{{ url('/lihat-berita/'.$history[$i]['id']) }}" target="_blank">
                            <img src="{{ $history[$i]['gambar'] == 'nope' ? ( $history[$i]['web'] == 1 ? '../logo/dsp.png' : ( $history[$i]['web'] == 2 ? '../logo/ktm.png' : '../logo/khd.png') ) : $history[$i]['gambar'] }}"
                                title="{{$history[$i]['judul']}}..." alt="{{  $history[$i]['web'] == 1 ? 'Dispatch Korea' : ( $history[$i]['web'] == 2 ? 'The Korea Times' : 'The Korea Herald') }}"
                                class="img-fluid shadow border-radius-xl {{ $history[$i]['gambar'] == 'nope' ? 'w-100' : '' }}">
                        </a>
                    </div>
                    {{-- <span class="badge badge-pill badge-md bg-gradient-info"></span> --}}
                    <div class="card-body px-1 pb-0">
                        <p class="badge badge-pill badge-md {{$history[$i]['web'] == 1 ? "bg-gradient-info" : ($history[$i]['web'] == 2 ? "bg-gradient-success" : "bg-gradient-secondary") }}
                            font-weight-bolder mb-2 text-sm">{{$history[$i]['web'] == 1 ? "Dispatch Korea" : ($history[$i]['web'] == 2 ? "The Korea Times" : "The Korea Herald") }}</p>
                        <a href="{{ url('/lihat-berita/'.$history[$i]['id']) }}" target="_blank">
                        <h5>{{$history[$i]['judul']}}...</h5>
                        </a>
                        <div class="text-end">
                            <span class="text-sm ms-1 pe-4">Terakhir Baca:  {{$history[$i]['baca']}}</span>
                            @if ($history[$i]['suka'] > -1)
                            <a href="{{ url('/suka-berita/2/'.$history[$i]['id']) }}" class="btn p-2">
                                <i class="fas text-sm {{ $history[$i]['suka'] == 1 ? 'text-danger fa-thumbs-up': 'text-black fa-thumbs-down' }} text-s" aria-hidden="true"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                @endfor
            </div>

            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                @for ($i = 1; $i < (count($history) < 200 ? count($history) : 200); $i+=4)
                <div class="column"><!--grid-item-->
                <div class="col-xl-12 col-md-6 mb-xl-0 mb-4 mt-4">
                    <div class="card card-blog card-plain">
                      <div class="position-relative">
                        <a class="d-block shadow-xl border-radius-xl" href="{{ url('/lihat-berita/'.$history[$i]['id']) }}" target="_blank">
                            <img src="{{ $history[$i]['gambar'] == 'nope' ? ( $history[$i]['web'] == 1 ? '../logo/dsp.png' : ( $history[$i]['web'] == 2 ? '../logo/ktm.png' : '../logo/khd.png') ) : $history[$i]['gambar'] }}"
                                title="{{$history[$i]['judul']}}..." alt="{{  $history[$i]['web'] == 1 ? 'Dispatch Korea' : ( $history[$i]['web'] == 2 ? 'The Korea Times' : 'The Korea Herald') }}"
                                class="img-fluid shadow border-radius-xl {{ $history[$i]['gambar'] == 'nope' ? 'w-100' : '' }}">
                        </a>
                      </div>
                      {{-- <span class="badge badge-pill badge-md bg-gradient-info"></span> --}}
                      <div class="card-body px-1 pb-0">
                        <p class="badge badge-pill badge-md {{$history[$i]['web'] == 1 ? "bg-gradient-info" : ($history[$i]['web'] == 2 ? "bg-gradient-success" : "bg-gradient-secondary") }}
                            font-weight-bolder mb-2 text-sm">{{$history[$i]['web'] == 1 ? "Dispatch Korea" : ($history[$i]['web'] == 2 ? "The Korea Times" : "The Korea Herald") }}</p>
                        <a href="{{ url('/lihat-berita/'.$history[$i]['id']) }}" target="_blank">
                          <h5>{{$history[$i]['judul']}}...</h5>
                        </a>
                        <div class="text-end">
                            <span class="text-sm ms-1 pe-4">Terakhir Baca: {{$history[$i]['baca']}}</span>
                            @if ($history[$i]['suka'] > -1)
                            <a href="{{ url('/suka-berita/2/'.$history[$i]['id']) }}" class="btn p-2">
                                <i class="fas text-sm {{ $history[$i]['suka'] == 1 ? 'text-danger fa-thumbs-up': 'text-black fa-thumbs-down' }} text-s" aria-hidden="true"></i>
                            </a>
                            @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endfor
            </div>

            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                @for ($i = 2; $i < (count($history) < 200 ? count($history) : 200); $i+=4)
                <div class="column"><!--grid-item-->
                <div class="col-xl-12 col-md-6 mb-xl-0 mb-4 mt-4">
                    <div class="card card-blog card-plain">
                      <div class="position-relative">
                        <a class="d-block shadow-xl border-radius-xl" href="{{ url('/lihat-berita/'.$history[$i]['id']) }}" target="_blank">
                            <img src="{{ $history[$i]['gambar'] == 'nope' ? ( $history[$i]['web'] == 1 ? '../logo/dsp.png' : ( $history[$i]['web'] == 2 ? '../logo/ktm.png' : '../logo/khd.png') ) : $history[$i]['gambar'] }}"
                                title="{{$history[$i]['judul']}}..." alt="{{  $history[$i]['web'] == 1 ? 'Dispatch Korea' : ( $history[$i]['web'] == 2 ? 'The Korea Times' : 'The Korea Herald') }}"
                                class="img-fluid shadow border-radius-xl {{ $history[$i]['gambar'] == 'nope' ? 'w-100' : '' }}">
                        </a>
                      </div>
                      {{-- <span class="badge badge-pill badge-md bg-gradient-info"></span> --}}
                      <div class="card-body px-1 pb-0">
                        <p class="badge badge-pill badge-md {{$history[$i]['web'] == 1 ? "bg-gradient-info" : ($history[$i]['web'] == 2 ? "bg-gradient-success" : "bg-gradient-secondary") }}
                            font-weight-bolder mb-2 text-sm">{{$history[$i]['web'] == 1 ? "Dispatch Korea" : ($history[$i]['web'] == 2 ? "The Korea Times" : "The Korea Herald") }}</p>
                        <a href="{{ url('/lihat-berita/'.$history[$i]['id']) }}" target="_blank">
                          <h5>{{$history[$i]['judul']}}...</h5>
                        </a>
                        <div class="text-end">
                            <span class="text-sm ms-1 pe-4">Terakhir Baca: {{$history[$i]['baca']}}</span>
                            @if ($history[$i]['suka'] > -1)
                            <a href="{{ url('/suka-berita/2/'.$history[$i]['id']) }}" class="btn p-2">
                                <i class="fas text-sm {{ $history[$i]['suka'] == 1 ? 'text-danger fa-thumbs-up': 'text-black fa-thumbs-down' }} text-s" aria-hidden="true"></i>
                            </a>
                            @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endfor
            </div>

            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                @for ($i = 3; $i < (count($history) < 200 ? count($history) : 200); $i+=4)
                <div class="column"><!--grid-item-->
                <div class="col-xl-12 col-md-6 mb-xl-0 mb-4 mt-4">
                    <div class="card card-blog card-plain">
                      <div class="position-relative">
                        <a class="d-block shadow-xl border-radius-xl" href="{{ url('/lihat-berita/'.$history[$i]['id']) }}" target="_blank">
                            <img src="{{ $history[$i]['gambar'] == 'nope' ? ( $history[$i]['web'] == 1 ? '../logo/dsp.png' : ( $history[$i]['web'] == 2 ? '../logo/ktm.png' : '../logo/khd.png') ) : $history[$i]['gambar'] }}"
                                title="{{$history[$i]['judul']}}..." alt="{{  $history[$i]['web'] == 1 ? 'Dispatch Korea' : ( $history[$i]['web'] == 2 ? 'The Korea Times' : 'The Korea Herald') }}"
                                class="img-fluid shadow border-radius-xl {{ $history[$i]['gambar'] == 'nope' ? 'w-100' : '' }}">
                        </a>
                      </div>
                      {{-- <span class="badge badge-pill badge-md bg-gradient-info"></span> --}}
                      <div class="card-body px-1 pb-0">
                        <p class="badge badge-pill badge-md {{$history[$i]['web'] == 1 ? "bg-gradient-info" : ($history[$i]['web'] == 2 ? "bg-gradient-success" : "bg-gradient-secondary") }}
                            font-weight-bolder mb-2 text-sm">{{$history[$i]['web'] == 1 ? "Dispatch Korea" : ($history[$i]['web'] == 2 ? "The Korea Times" : "The Korea Herald") }}</p>
                        <a href="{{ url('/lihat-berita/'.$history[$i]['id']) }}" target="_blank">
                          <h5>{{$history[$i]['judul']}}...</h5>
                        </a>
                        <div class="text-end">
                            <span class="text-sm ms-1 pe-4">Terakhir Baca: {{$history[$i]['baca']}}</span>
                            @if ($history[$i]['suka'] > -1)
                            <a href="{{ url('/suka-berita/2/'.$history[$i]['id']) }}" class="btn p-2">
                                <i class="fas text-sm {{ $history[$i]['suka'] == 1 ? 'text-danger fa-thumbs-up': 'text-black fa-thumbs-down' }} text-s" aria-hidden="true"></i>
                            </a>
                            @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endfor
            </div>

            @endif
        </div>
      </div>
    </div>
  </div>

{{-- end dari profile.blade.php --}}
@endsection
