@extends('layouts.user_type.auth')

@section('content')

{{-- kode asli di konten.blade.php --}}

{{-- JANGAN HILANG dari link --}}
<div class="row">
    <div class="col-md-4">
        <div class="mb-4 pb-0">
            <img src="../logo/{{$web}}.png" class="navbar-brand-img ms-3
            {{ ( Request::is('konten/dsp') || Request::is('konten-dsp/0') || Request::is('konten-dsp/1') ? 'w-65' :
               (Request::is('konten/ktm') || Request::is('konten-ktm/0') || Request::is('konten-ktm/1') || Request::is('konten-ktm/2') ? 'w-80' : '')) }}
               " alt="{{$web}}">
            {{-- <a href="{{ url('getting/'.$web) }}" class="ms-5 btn bg-gradient-secondary btn-sm mb-0" type="button">
              Ambil Konten dengan Terjemahkan / 100 Link <i class="fas fa-code text-sm opacity-10 ps-2"></i>
            </a> --}}
        </div>
    </div>

    @if ($web == 'ktm')
    <div class="col-md-4 text-end pb-0">
      {{-- <a href="{{ url('select/ktm') }}" class="btn bg-gradient-secondary btn-sm" type="button">
      Seleksi KPOP / 100 Link <i class="fas fa-language text-lg opacity-10 ps-2"></i>
      </a> --}}
      @if ($ubah < count($berita))
      <button type="button" class="btn bg-gradient-secondary btn-sm my-2 py-2" data-bs-toggle="modal" data-bs-target="#bukaModalSeleksi">
          Seleksi KPOP <i class="fas fa-language text-lg opacity-10 ps-2"></i>
      </button>
      <!-- Modal -->
      <div class="modal fade" id="bukaModalSeleksi" tabindex="-1" role="dialog" aria-labelledby="bukaModalSeleksiMessageTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h6 class="modal-title" id="bukaModalSeleksiLabel">Jumlah Link Seleksi</h6>
              </div>
              <div class="modal-body">
                <form action={{"/select/ktm"}} method="POST" role="form" class="my-2">
                    @csrf
                    <div class="row">
                      <div class="input-group">
                          <input type="number" class="form-control text-center" id="jumlah" name="jumlah" min="1" max="200" value='1'>
                          <span class="input-group-text font-weight-bold">Link</span>
                      </div>
                    </div>
                </form>
              </div>
              {{-- <div class="modal-footer">
                <button type="submit" id='seleksi' name='seleksi' class="btn bg-gradient-secondary">Mulai Seleksi KPOP</button>
              </div> --}}
            </div>
          </div>
      </div>
      @endif
    </div>
    @endif
    <div class="text-end pb-0 {{(Request::is('konten/ktm') || Request::is('konten-ktm/0') || Request::is('konten-ktm/1') || Request::is('konten-ktm/2') ? 'col-md-4 px-4' : 'col-md-8 px-4' )}}">
        {{-- <a href="{{ url('getting/'.$web) }}" class="ms-5 btn bg-gradient-secondary btn-sm mb-0" type="button">
          Ambil Konten dengan Terjemahkan / 100 Link <i class="fas fa-code text-sm opacity-10 ps-2"></i>
        </a> --}}
        <button type="button" class="btn bg-gradient-secondary btn-sm my-2" data-bs-toggle="modal" data-bs-target="#bukaModalKonten">
            Ambil Konten dan Terjemahkan <i class="fas fa-code text-sm opacity-10 ps-2"></i>
        </button>
        <!-- Modal -->
        <div class="modal fade" id="bukaModalKonten" tabindex="-1" role="dialog" aria-labelledby="bukaModalKontenMessageTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="bukaModalKontenLabel">Jumlah Link Ambil Konten dan Terjemahkan</h6>
                </div>
                <div class="modal-body">
                  <form action={{"/getting/".$web}} method="POST" role="form" class="my-2">
                      @csrf
                      <div class="row">
                        {{-- @if($web == 'dsp') Khusus Dispatch, --}}
                        <strong class="m-0 text-danger text-sm font-weight-bolder text-center">Perhatikan: Maksimal {{$web == 'dsp' ? 100 : 200}} Link</strong>
                        {{-- <strong class="m-0 text-danger text-sm font-weight-bolder text-center">Perubahan Inputan Tidak Mempengaruhi !</strong>
                        @endif --}}
                        <div class="input-group">
                            <input type="number" class="form-control text-center" id="jumlah" name="jumlah" min="1" max="{{$web == 'dsp' ? 100 : 200}}" value='1'>
                            <span class="input-group-text font-weight-bold">Link</span>
                        </div>
                      </div>
                  </form>
                </div>
                {{-- @if($web == 'dsp')
                <div class="modal-footer">
                  <button type="submit" id='konten' name='konten' class="btn bg-gradient-secondary">Mulai Ambil Konten dan Terjemahkan</button>
                </div>
                @endif --}}
              </div>
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
            <div>
                <h5 class="font-weight-bolder mb-0">
                    Daftar Link Hasil Crawler Konten Berita
                    <span class="text-dark text-sm font-weight-bolder align-bottom ps-4">
                        <i class="fa text-lg {{ $bhs == 'cek' ? 'fa-check text-dark' : 'fa-check-circle text-gradient text-primary'}}" aria-hidden="true"></i> {{$bhs == 'cek' ? 'Hasil Filter '.count($berita)." Link Aktif" : 'Aktif '.count($berita)." Link"}}
                    </span>{{-- link aktif --}}
                    @if ($ubah > 0 && $web == 'ktm' && $ubah < count($berita) && $bhs == 'kor')
                    <span class="text-dark font-weight-bold text-sm align-bottom ps-4">
                        <i class="fa text-lg fa-clipboard-check text-info text-gradient" aria-hidden="true"></i> K-POP {{$ubah}} Link
                    </span> {{-- link seleksi / kpop --}}
                    <span class="text-dark font-weight-bold text-sm align-bottom ps-4">
                        <i class="fa text-lg fa-check-circle text-success text-gradient" aria-hidden="true"></i> Ambil Konten {{$idn}} Link
                    </span>{{-- berhasil ambil konten --}}
                    @elseif ($idn > 0 && $bhs == 'kor')
                    <span class="text-dark font-weight-bold text-sm align-bottom ps-4">
                        <i class="fa text-lg fa-check-circle text-success text-gradient" aria-hidden="true"></i> Ambil Konten {{$idn}} Link
                    </span>{{-- berhasil ambil konten --}}
                    @endif
                    {{-- @if ($total > 0)<!-- text-success, text-info, text-secondary, text-warning -->
                    <span class="text-dark text-sm font-weight-bolder align-bottom ps-4">Total {{$total}} link berhasil ambil konten</span>
                    @endif --}}
                </h5>
            </div>
            <div class="text-end">
                <a href="#" class="m-0 btn bg-gradient-secondary dropdown-toggle" data-bs-toggle="dropdown" id="navbarDropdownMenuLink">
                    {{  Request::is('konten/dsp') || Request::is('konten-dsp/0') || Request::is('konten-dsp/1') ? (
                        Request::is('konten/dsp') ? 'Dispatch' : (Request::is('konten-dsp/0') ? 'Non-Aktif' : 'Aktif' )
                        ) :
                    ( Request::is('konten/ktm') || Request::is('konten-ktm/0') || Request::is('konten-ktm/1') || Request::is('konten-ktm/2') ? (
                        Request::is('konten/ktm') ? 'The Korea Times' : (Request::is('konten-ktm/0') ? 'Non-Aktif' : (Request::is('konten-ktm/1') ? 'Aktif / Belum Seleksi' : 'K-POP') )
                        ) :
                    ( Request::is('konten/khd') || Request::is('konten-khd/0') || Request::is('konten-khd/1') ? (
                        Request::is('konten/khd') ? 'Korea Herald' : (Request::is('konten-khd/0') ? 'Non-Aktif' : 'Aktif' )
                        ) : 'Semua' ))}}
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @if(Request::is('konten-dsp/0') || Request::is('konten-dsp/1') || Request::is('konten-ktm/0') || Request::is('konten-ktm/1') ||  Request::is('konten-ktm/2') || Request::is('konten-khd/0') || Request::is('konten-khd/1'))
                    <li> <a class="dropdown-item {{ Request::is('konten/dsp') || Request::is('konten/ktm') || Request::is('konten/khd') ? 'font-weight-bolder': '' }}" href="{{ url('/konten/'.$web) }}">
                         Kembali</a>
                    </li>
                    @endif
                    <li> <a class="dropdown-item {{ Request::is('konten-dsp/0') || Request::is('konten-ktm/0') || Request::is('konten-khd/0') ? 'font-weight-bolder' : '' }}" href="{{ url('/konten-'.$web.'/0')}}"> Non-Aktif </a> </li>
                    <li> <a class="dropdown-item {{ Request::is('konten-dsp/1') || Request::is('konten-ktm/1') || Request::is('konten-khd/1') ? 'font-weight-bolder' : '' }}" href="{{ url('/konten-'.$web.'/1')}}"> Aktif {{ $web == 'ktm' ? '/ Belum Seleksi' : '' }} </a> </li>
                    @if($web == 'ktm') <li> <a class="dropdown-item {{ Request::is('konten-ktm/2') ? 'font-weight-bolder' : '' }}" href="{{ url('/konten-'.$web.'/2')}}"> K-POP </a> </li>@endif
                </ul>
            </div>
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
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    ID
                                </th>
                                <th class="text-center col-md-5 text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    Link
                                </th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    Admin ID
                                </th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    tanggal crawler (TERBARU)
                                </th>
                                @if ( $web == 'ktm')
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    Status
                                </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($berita) == 0)
                            <td>
                              <div class="d-flex px-2 ps-3">
                                <div class="my-auto">
                                  <h6 class="mb-0 text-sm text-center">Tidak ada Data Terbaru</h6>
                                </div>
                              </div>
                            </td>
                            @else
                            <!--10 ganti count($berita)-->
                            @for ($i = 0; $i < count($berita); $i++)
                            <tr>
                                <td class="ps-4">
                                    <p class="{{ $berita[$i]['status'] == 2 && $ubah < count($berita) ? 'text-dark font-weight-bolder' : 'text-dark font-weight-bold' }} text-sm mb-0">{{$i+1}}.</p>
                                </td>
                                <td class="text-center">
                                    <p class="{{ $berita[$i]['status'] == 2 && $ubah < count($berita) ? 'text-dark font-weight-bolder' : 'text-dark font-weight-bold' }} text-sm mb-0">{{$berita[$i]['id']}} - Level {{$berita[$i]['level']}}</p>
                                </td>
                                <td class="text-center text-sm m-0 px-3 active {{ $berita[$i]['status'] == 2 && $ubah < count($berita) ? 'text-dark font-weight-bolder' : 'text-dark font-weight-bold' }}">
                                    <a href="{{$berita[$i]['link']}}" target="_blank" title="Link ID {{$berita[$i]['id']}}">
                                      {{$berita[$i]['link']}} <i class="fas fa-link opacity-10 ps-2"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <p class="m-0 p-0 {{ $berita[$i]['status'] == 2 && $ubah < count($berita) ? 'text-dark font-weight-bolder' : 'text-dark font-weight-bold' }} text-sm">{{$berita[$i]['admin_id'] == auth()->user()->id ? 'Anda' : 'ID '.$berita[$i]['admin_id']}}</p>
                                </td>
                                <td class="text-center">
                                    <p class="m-0 p-0 {{ $berita[$i]['status'] == 2 && $ubah < count($berita) ? 'text-dark font-weight-bolder' : 'text-dark font-weight-bold' }} text-sm">{{$berita[$i]['tgl']}}</p>
                                </td>
                                @if ( $web == 'ktm')
                                <td class="text-center px-4">
                                    <p class="{{ $berita[$i]['status'] == 2 ? 'text-info font-weight-bolder' : ($berita[$i]['status'] == 1 ? 'font-weight-bolder' : 'text-danger font-weight-bolder') }} text-sm mb-0">
                                        {{ $berita[$i]['status'] == 2 ? 'KPOP' : ($berita[$i]['status'] == 1 ? 'BELUM SELEKSI' : 'NON-AKTIF') }}
                                    </p>
                                </td>
                                @endif
                            </tr>
                            @endfor
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
{{-- end dari user-management --}}
        </div>
    </div>
</div>
</div>
{{-- dari link(JANGAN HILANG) --}}

@endsection
