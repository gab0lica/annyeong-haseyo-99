@extends('layouts.user_type.auth')

@section('content')

{{-- dari tables, web content crawler --}}
    {{-- header dan ulang crawler --}}
    <div class="row">
        <div class="col-12">
          <div class="mb-2">
            <div class="pb-0">
                <img src="../logo/{{$web}}.png" class="navbar-brand-img ms-3 {{ (Request::is('crawler/dsp') || Request::is('crawlering/dsp') ? 'w-20' : (Request::is('crawler/ktm') || Request::is('crawlering/ktm') ? 'w-25' : 'w-30')) }}" alt="{{$web}}">
                <a href="{{ url('crawlering/'.$web) }}" class="ms-5 btn bg-gradient-secondary btn-sm mb-0 {{ (Request::is('crawlering/'.$web) ? 'active' : '') }}" type="button">
                    {{ $pesan == "Crawler Mulai" ? 'Jalankan Web Crawler' : 'Ulangi Web Crawler'}} <i class="fas fa-file-import text-lg opacity-10 ps-2"></i>
                </a>
            </div>
          </div>
        </div>
    </div>
    @if ($error)
    <div class="row">
        <div class="col-12">
            <div class="alert alert-dark mx-4" role="alert">
                <span class="text-white">
                    <strong>{{$pesan}}</strong>
                </span>
            </div>
        </div>
    </div>
    @endif
    {{-- link baru crawler --}}
    <div class="row py-2">
        <div class="col-12">
          <div class="card mb-2">
            <div class="card-header pb-0">
              <div class="d-flex flex-row justify-content-between">
                <div>
                    <h5 class="font-weight-bolder mb-0">
                        Link Baru Hasil Crawler
                        @if ($web != 'dsp')
                        <span class="text-danger text-sm font-weight-bolder align-bottom ps-3"> <u>hanya Level 1</u> </span>
                        @endif
                        @if (count($lv1)+count($lv2) > 0)
                        <span class="text-success text-sm font-weight-bolder align-bottom ps-3"> Hasil Crawler {{count($lv1)+count($lv2)}} Link dan Sukses Tersimpan</span>
                        @endif
                    </h5>
                </div>
            </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Link</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Level</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($lv1)+count($lv2) == 0 && $pesan == "Crawler Mulai")
                    <td>
                        <div class="d-flex px-2 ps-3">
                        <div class="my-auto">
                            <h6 class="mb-0 text-center">Web Crawler Belum Dijalankan</h6>
                        </div>
                        </div>
                    </td>
                    @elseif  (count($lv1)+count($lv2) == 0)
                    <td>
                        <div class="d-flex px-2 ps-3">
                        <div class="my-auto">
                            <h6 class="mb-0 text-center">Tidak ada Data Terbaru</h6>
                        </div>
                        </div>
                    </td>
                    @else
                    @foreach ($lv1 as $item)
                    <tr>
                      <td>
                        <div class="d-flex px-2 ps-3">
                          <div class="my-auto">
                            <h6 class="mb-0">{{$item}}</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="text-sm font-weight-bolder ps-3">Level 1</span>
                      </td>
                    </tr>
                    @endforeach
                    @foreach ($lv2 as $item)
                    <tr>
                      <td>
                        <div class="d-flex px-2 ps-3">
                          <div class="my-auto">
                            <h6 class="mb-0">{{$item}}</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="text-sm font-weight-bolder ps-3">Level 2</span>
                      </td>
                    </tr>
                    @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
    {{-- link lama crawler --}}
    {{-- <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                  <div>
                      <h5 class="font-weight-bolder mb-0">
                        Link Lama Hasil Crawler
                        @if ($web == 'ktm')
                        <span class="text-dark text-sm font-weight-bolder align-bottom ps-3"> only Level 1 </span>
                        @endif
                        @if (count($saved1)+count($saved2) > 0)
                        <span class="text-success text-sm font-weight-bolder align-bottom ps-3"> {{count($saved1)+count($saved2)}} link dalam Database</span>
                        @endif
                    </h5>
                  </div>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                     <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Link</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Level</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($saved1)+count($saved2) == 0)
                    <td>
                        <div class="d-flex px-2 ps-3">
                        <div class="my-auto">
                            <h6 class="mb-0 text-sm text-center">Tidak ada Data Terbaru</h6>
                        </div>
                        </div>
                    </td>
                    @else
                    @foreach ($saved1 as $item)
                    <tr>
                      <td>
                        <div class="d-flex px-2 ps-3">
                          <div class="my-auto">
                            <h6 class="mb-0 text-sm">{{$item}}</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold ps-3">Level 1</span>
                      </td>
                    </tr>
                    @endforeach
                    @foreach ($saved2 as $item)
                    <tr>
                      <td>
                        <div class="d-flex px-2 ps-3">
                          <div class="my-auto">
                            <h6 class="mb-0 text-sm">{{$item}}</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold ps-3">Level 2</span>
                      </td>
                    </tr>
                    @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>--}}
{{-- end of web content crawler --}}

@endsection


