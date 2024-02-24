@extends('layouts.user_type.auth')

@section('content')
{{-- dari profile.blade.php --}}
<div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 p-3">
      <div class="row">
        {{-- <h4 class="mb-1 font-weight-bolder col-md-8">Berita Terbaru</h4> --}}
            <div class="col-8">
            <h4>{{ $konten['idn']['judul'] }}</h4>
            <p class="text-sm mb-0">
              {{-- @if ($dsp > 0 && $ktm > 0 && $khd > 0)
              <span class="{{$web == 'dsp' ? 'font-weight-bolder' : ''}} ms-1"> {{$dsp}} berita</span>  <i class="fa {{$web == 'dsp' ?'fa-check-circle' : 'fa-check'}} text-info" aria-hidden="true"></i>
              <span class="{{$web == 'ktm' ? 'font-weight-bolder' : ''}} ms-1"> {{$ktm}} berita</span>  <i class="fa {{$web == 'ktm' ?'fa-check-circle' : 'fa-check'}} text-success" aria-hidden="true"></i>
              <span class="{{$web == 'khd' ? 'font-weight-bolder' : ''}} ms-1"> {{$khd}} berita</span>  <i class="fa {{$web == 'khd' ?'fa-check-circle' : 'fa-check'}} text-secondary" aria-hidden="true"></i>
              @endif --}}
              {{ $konten['idn']['sub'] }}
            </p>
            <p class="text-sm mb-0">{{ $konten['idn']['tanggal'] }}</p>
            </div>
            <div class="col-4 my-auto text-end"><!--col-lg-6-->
                <a href="{{ $konten['link'] }}"
                class="btn {{$konten['web'] == 1 ? 'btn-outline-info' : ($konten['web'] == 2 ? 'btn-outline-success' : 'btn-outline-secondary')}}" target="_blank">
                Kunjungi {{ $konten['web'] == 1 ? 'Dispatch' : ( $konten['web'] == 2 ? 'The Korea Times' :
                    ( $konten['web'] == 3 ? 'Korea Herald' : 'Berita' ))}} <i class="fab fa-readme opacity-10 ps-2"></i>
                </a>

                <a href="#" class="btn {{ $suka == 1 ? 'btn-outline-danger' : ($suka == 0 ? 'btn-outline-dark' : 'bg-gradient-dark')}}">
                    <i class="fas {{ $suka == 1 ? 'text-danger fa-thumbs-up': ($suka == 0 ? 'text-black fa-thumbs-down' : 'text-white fa-thumbs-up') }} text-sm"></i>
                </a>
                {{-- <a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('berita/') ? 'active' : '') }}"
                 href="{{ url('like/') }}">
                    <p class="text-xs font-weight-bolder mb-0">1</p>
                </a> --}}
            </div>
        </div>
      </div>
      <div class="card-body p-3">
        <div class="row">
            {{  print($konten['idn']['deskripsi']) }}
        </div>
      </div>
    </div>
  </div>
{{-- end dari profile.blade.php --}}
@endsection
