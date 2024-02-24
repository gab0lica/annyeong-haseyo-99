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
              {{ $konten['idn']['sub'] }}
            </p>
            <p class="text-sm mb-0">{{ $konten['idn']['tanggal'] }}</p>
            </div>
            <div class="col-4 my-auto text-end"><!--col-lg-6-->
                <div class="column">
                    <div class="col-md-12">
                        <a href="{{ $konten['link'] }}"
                        class="btn {{$konten['web'] == 1 ? 'btn-outline-info' : ($konten['web'] == 2 ? 'btn-outline-success' : 'btn-outline-secondary')}}" target="_blank">
                        Kunjungi {{ $konten['web'] == 1 ? 'Dispatch' : ( $konten['web'] == 2 ? 'The Korea Times' :
                            ( $konten['web'] == 3 ? 'Korea Herald' : 'Berita' ))}} <i class="fab fa-readme opacity-10 ps-2"></i>
                        </a>
                        <a href="#" class="btn bg-gradient-dark">
                            <i class="fas text-white fa-thumbs-up text-sm"></i>
                        </a>
                    </div>
                    @if($konten['berita_admin'] == auth()->user()->id || $konten['konten_admin'] == auth()->user()->id)
                    <div class="col-md-12">
                        @if ($konten['status'] > 1)
                        <a href="{{ $konten['status'] == 4 ? '#' : url('/tayangkan/'.$konten['id']) }}"
                            {{-- class="text-sm font-weight-bolder m-0 p-0" --}}
                            class="btn {{$konten['status'] == 4 ? 'bg-gradient-success' : 'btn-outline-success bg-white'}} {{ Request::is('tayangkan/'.$konten['id']) ? 'active' : '' }}"
                            title="Tayangkan Berita Link ID {{$konten['id']}}">
                            {{-- {{$konten['status']}} --}}
                            <i class="fas fa-check text-lg text-{{ $konten['status'] == 4 ? 'white' : 'success text-gradient'}}"></i>
                        </a>
                        @endif
                        <a href="{{ ($konten['status'] < 1) ? '#' : url('/status-link/'.$konten['id']) }}"
                            class="btn {{($konten['status'] < 1) ? 'bg-gradient-danger' : 'btn-outline-danger bg-white'}} {{ Request::is('status-link/'.$konten['id']) ? 'active' : '' }}"
                            title="{{($konten['status'] < 1) ? 'Link Nonaktif' : 'Nonaktifkan Link ID '.$konten['id']}}">
                            <i class="fas text-{{($konten['status'] < 1) ? 'white' : 'danger'}} fa-ban text-lg"></i>
                        </a>
                    </div>
                    @endif
                </div>
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
