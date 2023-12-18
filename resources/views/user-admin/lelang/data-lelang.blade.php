@extends('layouts.user_type.auth')

@section('content')

{{-- kode asli di konten.blade.php --}}

{{-- untuk tabel user pada admin --}}
{{-- JANGAN HILANG dari link --}}
<div class="row">
    <div class="col-12">
      <div class="mb-4">
        <div class="pb-0">
          {{-- <a href="{{ url('lelang/'.$web) }}" class="ms-5 btn bg-gradient-dark btn-sm mb-0" type="button">{{ $bhs == 'kor' ? 'Ambil Konten dengan Terjemahkan' : 'Terjemah Konten' }} / 25 Link</a>
          @if ($web == 'ktm' && $bhs == 'kor' && $ubah < count($berita))
          <a href="{{ url('select/ktm') }}" class="ms-5 btn bg-gradient-dark btn-sm mb-0" type="button">Seleksi KPOP / 100 Link </a>
          @endif --}}
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
<div class="row">
    <div class="col-12">
      <div class="card mb-2">
        <div class="card-header pb-0">
          <div class="d-flex flex-row justify-content-between">
            <div class="col-md-9">
                <h5 class="font-weight-bolder mb-0">
                    Daftar Lelang
                    <span class="text-secondary text-sm font-weight-bolder align-bottom ps-4 text-capitalize"><u>berdasarkan waktu lelang dimulai terbaru</u></span>
                    @if(count($lelang)>0)
                    <span class="text-dark text-gradient text-sm font-weight-bolder align-bottom ps-4">
                        <i class="fa fa-check-circle text-dark text-gradient p-1" aria-hidden="true"></i> {{count($lelang)}} Aktif Berjalan
                    </span>
                    @endif
                    @if($selesai>0)
                    <span class="text-success text-gradient text-sm font-weight-bolder align-bottom ps-4">
                        <i class="fa fa-check-circle text-success text-gradient p-1" aria-hidden="true"></i> {{$selesai}} Selesai
                    </span>
                    @endif
                    @if ($tidak > 0) <span class="text-danger text-sm font-weight-bolder align-bottom ps-4"> <i class="fa fa-ban text-danger text-gradient p-1" aria-hidden="true"></i>{{$tidak}} non-aktif</span> @endif
                </h5>
            </div>
            <a href="{{ url('/lelang/transaksi') }}"
                class="btn bg-gradient-secondary font-weight-bolder text-white btn-sm mb-0" type="button">
                Transaksi Lelang Anda<i class="fas fa-file-invoice text-white mx-1 text-sm" aria-hidden="true"></i>
            </a>
          </div>
        </div>
{{-- dari user-management --}}
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    No.
                                </th>
                                <th class="col-md-2 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    username penjual
                                </th>
                                <th class="col-md-4 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    jangka waktu berlangsung
                                </th>
                                <th class="col-md-2 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    jumlah penawar
                                </th>
                                <th class="col-md-2 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    Admin
                                </th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    status
                                </th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    detail
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($lelang) == 0)
                            <tr>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                <td class="ps-4 mb-0 text-sm text-center font-weight-bolder">Belum Terdaftar Lelang</td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                            </tr>
                            @else
                            @for ($i = 0; $i < count($lelang); $i++)
                            <tr class="text-dark"><!-- {{$lelang[$i]['status'] == 3 ? 'text-success' : 'text-dark'}}-->
                                <td class="ps-4">
                                    <p class="font-weight-bold text-sm mb-0">{{$i+1}}.</p>
                                </td>
                                <td class="text-center">
                                    <p class="font-weight-bold text-sm mb-0">{{$lelang[$i]['username']}}</p>
                                </td>
                                <td class="text-center">
                                    <p class="font-weight-bold text-sm mb-0">{{$lelang[$i]['mulai'].' - '}}
                                        <span class="font-weight-bolder text-sm">{{$lelang[$i]['selesai']}}</span>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <span class="font-weight-bolder text-sm mb-0">{{$lelang[$i]['ikut']}}</span>
                                    {{-- <i class="px-1 fas {{ $lelang[$i]['status'] == 0 ? 'fa-ban text-danger' : 'fa-check-circle text-success'}}" aria-hidden="true"></i> --}}
                                </td>
                                <td class="text-center">
                                    {{-- <p class="font-weight-bold text-sm mb-0">{{$lelang[$i]['produk']}}</p> --}}
                                    <p class="font-weight-{{$lelang[$i]['admin'] == auth()->user()->id ? 'bolder' : 'bold'}} text-sm mb-0">
                                        {{$lelang[$i]['admin'] == auth()->user()->id ? 'Anda' : "ID ".$lelang[$i]['admin']}}
                                    </p>
                                </td>
                                <td class="text-center">
                                    <a href="{{$lelang[$i]['admin'] == auth()->user()->id ? ($lelang[$i]['status'] < 2 ? url('non-aktif/'.$lelang[$i]['lelang']) : '#') : '#' }}"
                                        class="{{ Request::is('non-aktif/'.$lelang[$i]['lelang']) ? 'active' : '' }}"
                                        type="button" title="{{$lelang[$i]['admin'] == auth()->user()->id ? ($lelang[$i]['status'] == 1 ? 'Non-Aktifkan' : ($lelang[$i]['status'] == 0 ? 'Aktifkan' : 'Selesai')) : ''}} Lelang ID {{$lelang[$i]['lelang']}}">
                                        <i class="fas fa-{{ $lelang[$i]['status'] < 3 ? ( $lelang[$i]['status'] == 1 ? 'ban text-danger' : 'check-circle text-success') : 'check text-success'}} text-lg me-2" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('detail-lelang/'.$lelang[$i]['lelang']) }}"
                                        class="{{ Request::is('detail-lelang/'.$lelang[$i]['lelang']) ? 'active' : '' }}"
                                        type="button" title="Lelang ID {{$lelang[$i]['lelang']}}">
                                        {{-- target="_blank" --}}
                                        <i class="fas fa-file-invoice text-lg text-dark me-2" aria-hidden="true"></i>
                                    </a>
                                </td>
                                {{-- @if ($user == 'penjual')
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$lelang[$i]['ktp']}}</p>
                                </td>
                                @endif --}}
                            </tr>
                            @endfor
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
{{-- end dari user-management --}}
            {{-- pagination dari http://localhost:8000/documentation/components/pagination.html --}}
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end me-4">
                  {{-- <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                      <p class="text-xs font-weight-bolder mb-0" aria-hidden="true">&laquo;</p>
                    </a>
                  </li> --}}
                  {{-- <a href="{{ url('crawler/'.$web) }}" class="ms-5 btn bg-gradient-secondary btn-sm mb-0 {{ (Request::is('crawler/'.$web) ? 'active' : '') }}" type="button">Repeat Crawler</a> --}}
                  {{-- <li class="page-item">
                    <button class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light" onclick='halo(this,10)'>
                        <p class="text-xs font-weight-bolder mb-0">1</p>
                    </button>
                  </li> --}}
                  <!--100,200,300,dst-->
                  {{-- <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('user/'.$user) ? 'active' : '') }}" href="{{ url('user/'.$user) }}"><p class="text-xs font-weight-bolder mb-0">1</p></a></li><!--100,200,300,dst-->
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('user/'.$user) ? 'active' : '') }}" href="{{ url('user/'.$user) }}"><p class="text-xs font-weight-bolder mb-0">2</p></a></li>
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('user/'.$user) ? 'active' : '') }}" href="{{ url('user/'.$user) }}"><p class="text-xs font-weight-bolder mb-0">3</p></a></li>
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('user/'.$user) ? 'active' : '') }}" href="{{ url('user/'.$user) }}"><p class="text-xs font-weight-bolder mb-0">4</p></a></li>
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('user/'.$user) ? 'active' : '') }}" href="{{ url('user/'.$user) }}"><p class="text-xs font-weight-bolder mb-0">5</p></a></li> --}}
                  {{-- <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('konten/'.$web) ? 'active' : '') }}" href="{{ url('konten/'.$web.'/-') }}"><p class="text-xs font-weight-bolder mb-0">6</p></a></li>
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('konten/'.$web) ? 'active' : '') }}" href="{{ url('konten/'.$web.'/-') }}"><p class="text-xs font-weight-bolder mb-0">7</p></a></li>
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('konten/'.$web) ? 'active' : '') }}" href="{{ url('konten/'.$web.'/-') }}"><p class="text-xs font-weight-bolder mb-0">8</p></a></li>
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('konten/'.$web) ? 'active' : '') }}" href="{{ url('konten/'.$web.'/-') }}"><p class="text-xs font-weight-bolder mb-0">9</p></a></li>
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('konten/'.$web) ? 'active' : '') }}" href="{{ url('konten/'.$web.'/-') }}"><p class="text-xs font-weight-bolder mb-0">10</p></a></li> --}}
                  {{-- <li class="page-item">
                    <a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('user/'.$user) ? 'active' : '') }}" href="{{ url('user/'.$user) }}" aria-label="Next">
                        <p class="text-xs font-weight-bolder mb-0" aria-hidden="true">&raquo;</p>
                    </a>
                  </li> --}}
                </ul>
            </nav>
            {{-- end pagination --}}
        </div>
    </div>
</div>
</div>
{{-- dari link(JANGAN HILANG) --}}

@endsection
