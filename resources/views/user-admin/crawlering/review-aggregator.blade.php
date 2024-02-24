@extends('layouts.user_type.auth')

@section('content')
{{-- dari berita-aggregator.blade.php --}}
<div class="row">
    <div class="col-12">
      <div class="mb-4">
        <div class="pb-0">
          {{-- <img src="../logo/{{$web}}.png" class="navbar-brand-img ms-3 {{ (Request::is('konten/dsp') ? 'w-20' : (Request::is('konten/ktm') ? 'w-25' : 'w-30')) }}" alt="{{$web}}"> --}}
          {{-- <a href="{{ url('crawler/'.$web) }}" class="ms-5 btn bg-gradient-secondary btn-sm mb-0 {{ (Request::is('crawler/'.$web) ? 'active' : '') }}" type="button">Ulangi Crawler</a> --}}
        </div>
      </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card mb-2">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <h5 class="font-weight-bolder mb-0">
                        Laporan Review Aggregator Berita
                        @if (count($berita) > 0)
                        @if ($web != 'ktm' && $web != 'khd')
                        <span class="text-dark text-sm font-weight-bolder align-bottom ps-4">
                            <i class="fa text-lg fa-check-circle text-info text-gradient me-1 py-1" aria-hidden="true"></i> {{$dsp}} Link
                        </span>
                        @endif
                        @if ($web != 'dsp' && $web != 'khd')
                        <span class="text-dark text-sm font-weight-bolder align-bottom ps-4">
                            <i class="fa text-lg fa-check-circle text-success text-gradient me-1 py-1" aria-hidden="true"></i> {{$ktm}} Link
                        </span>
                        @endif
                        @if ($web != 'dsp' && $web != 'ktm')
                        <span class="text-dark text-sm font-weight-bolder align-bottom ps-4">
                            <i class="fa text-lg fa-check-circle text-secondary me-1 py-1" aria-hidden="true"></i> {{$khd}} Link
                        </span>
                        @endif
                        @endif
                        {{-- <span class="text-dark text-sm font-weight-bolder align-bottom ps-4">
                            <strong><u>Urutan Tanggal Crawler Terbaru</u></strong>
                        </span> --}}
                    </h5>
                    <div class="text-end">
                        <a href="#" class="btn bg-gradient-dark dropdown-toggle mb-0" data-bs-toggle="dropdown" id="navbarDropdownMenuLink">
                            {{Request::is('review-aggregator/semua') ? 'Semua Website Korea' :  (Request::is('review-aggregator/dsp') ? 'Dispatch' :
                            (Request::is('review-aggregator/ktm') ? 'The Korea Times' : (Request::is('review-aggregator/khd') ? 'Korea Herald' :
                            (Request::is('review-aggregator/nonaktif') ? 'Non-Aktif': (Request::is('review-aggregator/admin') ? 'Anda sebagai Admin Berita': 'Pilih Website')))))}}
                        </a>
                        <ul class="dropdown-menu mb-0" aria-labelledby="navbarDropdownMenuLink">
                            <li> <a class="dropdown-item {{ Request::is('review-aggregator/semua') ? 'font-weight-bolder' : '' }}" href="{{ url('/review-aggregator/semua')}}"> Semua Website Korea </a> </li>
                            <li> <a class="dropdown-item {{ Request::is('review-aggregator/dsp') ? 'font-weight-bolder' : '' }}" href="{{ url('/review-aggregator/dsp')}}"> Dispatch </a> </li>
                            <li> <a class="dropdown-item {{ Request::is('review-aggregator/ktm') ? 'font-weight-bolder' : '' }}" href="{{ url('/review-aggregator/ktm')}}"> The Korea Times </a> </li>
                            <li> <a class="dropdown-item {{ Request::is('review-aggregator/khd') ? 'font-weight-bolder' : '' }}" href="{{ url('/review-aggregator/khd')}}"> Korea Herald </a> </li>
                            <li> <a class="dropdown-item {{ Request::is('review-aggregator/nonaktif') ? 'font-weight-bolder' : '' }}" href="{{ url('/review-aggregator/nonaktif')}}"> Non-Aktif </a> </li>
                            <li> <a class="dropdown-item {{ Request::is('review-aggregator/admin') ? 'font-weight-bolder' : '' }}" href="{{ url('/review-aggregator/admin')}}"> Admin sebagai Admin Berita </a> </li>
                        </ul>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <a href="{{ url('preview-berita/dsp') }}" target="_blank" class="btn bg-gradient-info btn-md mb-0 mx-2">
                        <i class="fab fa-readme text-lg p-1" aria-hidden="true"></i> Preview Tayangkan Berita Dispatch
                    </a>
                    <a href="{{ url('preview-berita/ktm') }}" target="_blank" class="btn bg-gradient-success btn-md mb-0 mx-2">
                        <i class="fab fa-readme text-lg p-1" aria-hidden="true"></i> Preview Tayangkan Berita The Korea Times
                    </a>
                    <a href="{{ url('preview-berita/khd') }}" target="_blank" class="btn bg-gradient-secondary btn-md mb-0 mx-2">
                        <i class="fab fa-readme text-lg p-1" aria-hidden="true"></i> Preview Tayangkan Berita Korea Herald
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @if($pesan[0] == 'salah')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white font-weight-bold">
                        Terdapat Kesalahan Jumlah Data dari Hasil Crawler dan Seleksi Ambil Data Konten. {{$pesan[1].' link'}}
                    </span>
                </div>
                @endif
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    No.
                                </th>
                                <th class="col-md-4 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    Website - Level - Tanggal Crawler (Terbaru)
                                </th>
                                <th class="col-md-3 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    Pembaca dengan Suka
                                </th>
                                <th class="col-md-3 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    Admin (Web Crawler - Catcher Konten)
                                </th>
                                <th class="col-md-2 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    Kontrol
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--10 ganti count($berita)-->
                            @if (count($berita) == 0)
                            <tr>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                <td class="ps-4 mb-0 text-sm text-center font-weight-bolder">Berita Tidak Tersedia Sesuai Filter</td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                            </tr>
                            @else
                            @for ($i = 0; $i < count($berita); $i++)
                            <tr>
                                <td class="text-dark ps-4">
                                    <p class="text-sm font-weight-bold m-0 p-0">
                                        {{-- {{ ($i+1) < 10 ? '000'.($i+1) : (($i+1) < 100 ? '00'.($i+1) : (($i+1) < 1000 ? '0'.($i+1) : ($i+1)) ) }} --}}
                                        {{ ($i+1) }}.
                                    </p>
                                </td>
                                <td class="{{ $berita[$i]['web'] == 1 ? 'text-info' : ($berita[$i]['web'] == 2 ? 'text-success' : 'text-secondary') }} text-center">
                                    <p class="text-sm font-weight-bold m-0 p-0">
                                        {{ $berita[$i]['web'] == 1 ? 'Dispatch' : ($berita[$i]['web'] == 2 ? 'The Korea Times' : 'Korea Herald') }} - Level {{$berita[$i]['level']}} - {{$berita[$i]['tanggal']}}
                                    </p>
                                </td>
                                <td class="text-center m-0 p-0">
                                    <span class="text-sm font-weight-bolder mb-0">
                                        <i class="text-lg fa fa-eye text-dark text-gradient py-2 pe-1 ps-3"></i> {{$berita[$i]['baca']}}
                                    </span>
                                    <span class="text-sm font-weight-bolder mb-0">
                                        <i class="text-lg fas fa-thumbs-up text-danger text-gradient py-2 pe-1 ps-3"></i> {{$berita[$i]['suka']}}
                                    </span>
                                    <span class="text-sm font-weight-bolder mb-0">
                                        <i class="text-lg fas fa-thumbs-down text-dark text-gradient py-2 pe-1 ps-3"></i> {{$berita[$i]['tidaksuka']}}
                                    </span>
                                    <span class="text-sm font-weight-bolder mb-0">
                                        <i class="text-lg fas fa-thumbs-up text-secondary py-2 pe-1 ps-3"></i> {{$berita[$i]['belum']}}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <p class="text-sm font-weight-bolder m-0 p-0">
                                        ({{$berita[$i]['berita_admin'] == auth()->user()->id ? 'Anda' : 'ID '.$berita[$i]['berita_admin']}}) - ({{$berita[$i]['konten_admin'] == auth()->user()->id ? 'Anda' : 'ID '.$berita[$i]['konten_admin']}})
                                    </p>
                                </td>
                                <td class="text-center m-0 p-0">
                                    {{-- linknya --}}
                                    <a href="{{$berita[$i]['link']}}" target="_blank" class="text-sm font-weight-bolder m-0 p-0"
                                        title="Buka Link {{ $berita[$i]['web'] == 1 ? 'Dispatch' : ($berita[$i]['web'] == 2 ? 'The Korea Times' : 'Korea Herald') }}">
                                        {{-- {{$berita[$i]['link']}} --}}
                                        <i class="fas fa-link text-gradient text-lg text-dark p-1"></i>
                                    </a>
                                    {{-- lihat berita --}}
                                    <a href="{{ url('halaman-berita/'.$berita[$i]['id']) }}"
                                        class="{{ Request::is('halaman-berita/'.$berita[$i]['id']) ? 'active' : '' }}"
                                        type="button" target="_blank" title="Buka Berita ID {{$berita[$i]['id']}}">
                                        <i class="fas fa-newspaper text-gradient text-lg text-dark p-1" aria-hidden="true"></i>
                                    </a>
                                    {{-- yang bisa mengubah status, hanya admin yg bertanggung jawab --}}
                                    @if(($berita[$i]['status'] > 0 || Request::is('review-aggregator/nonaktif')) && ($berita[$i]['berita_admin'] == auth()->user()->id || $berita[$i]['konten_admin'] == auth()->user()->id))
                                    <a href="{{ url('/tayangkan/'.$berita[$i]['id']) }}" target="_blank" class="text-sm font-weight-bolder m-0 p-0"
                                        title="Tayangkan Berita Link ID {{$berita[$i]['id']}}">
                                        {{-- {{$berita[$i]['link']}} --}}
                                        <i class="fas fa-check text-gradient text-lg text-success p-1"></i>
                                    </a>
                                    @endif
                                    {{-- status-link/{id} nonaktifkan --}}
                                    @if(!Request::is('review-aggregator/nonaktif') && ($berita[$i]['berita_admin'] == auth()->user()->id || $berita[$i]['konten_admin'] == auth()->user()->id))
                                    <a href="{{ url('status-link/'.$berita[$i]['id']) }}"
                                        class="{{ Request::is('status-link/'.$berita[$i]['id']) ? 'active' : '' }}"
                                        type="button" target="_blank" title="Nonaktifkan Link ID {{$berita[$i]['id']}}">
                                        <i class="fas fa-ban text-gradient text-lg text-danger p-1" aria-hidden="true"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endfor
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
