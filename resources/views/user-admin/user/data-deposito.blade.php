@extends('layouts.user_type.auth')

@section('content')

{{-- kode asli di konten.blade.php --}}

{{-- untuk tabel user pada admin --}}
{{-- JANGAN HILANG dari link --}}
<div class="row">
    <div class="col-12">
      <div class="mb-4">
        <div class="pb-0">
          {{-- <a href="{{ url('deposito/'.$web) }}" class="ms-5 btn bg-gradient-dark btn-sm mb-0" type="button">{{ $bhs == 'kor' ? 'Ambil Konten dengan Terjemahkan' : 'Terjemah Konten' }} / 25 Link</a>
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
            <div>
                <h5 class="font-weight-bolder mb-0 text-capitalize">
                    Deposito Koin ({{$user}})
                    {{-- <span class="text-secondary text-sm font-weight-bolder align-bottom ps-4">Total </span> --}}
                    @if(count($deposito)>0) <span class="text-success text-sm font-weight-bolder align-bottom ps-4"> <i class="fa fa-check-circle text-success text-gradient p-1" aria-hidden="true"></i>Aktif {{count($deposito)}} Akun</span> @endif
                    {{-- @if ($tidak > 0) <span class="text-danger text-sm font-weight-bolder align-bottom ps-4"> {{$tidak}} non-aktif</span> @endif --}}
                </h5>
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
                                    ID
                                </th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    username
                                </th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    masa aktif
                                </th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    jumlah transaksi Koin
                                </th>
                                {{-- <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    harga awal
                                </th> --}}
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    data user
                                </th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    detail
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($deposito) == 0)
                            <tr>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                <td class="ps-4 mb-0 text-sm text-center font-weight-bolder">Belum Terdaftar Deposito</td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                            </tr>
                            @else
                            @for ($i = 0; $i < count($deposito); $i++)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$i+1}}.</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$deposito[$i]['username']}}</p>
                                </td>
                                {{-- <td class="text-center">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$deposito[$i]['harga']}}</p>
                                </td> --}}
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$deposito[$i]['created_at'].' - '}}
                                        <span class="text-success font-weight-bolder text-sm">{{$deposito[$i]['updated_at']}}</span>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$deposito[$i]['trans']}}</p>
                                </td>
                                <td class="text-center">
                                    {{-- <i class="px-2 fa {{ $deposito[$i]['status'] == 0 ? 'fa-ban text-danger' : 'fa-check-circle text-success'}}" aria-hidden="true"></i>
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$deposito[$i]['status']}}</p> --}}
                                    <a href="{{url('user/'.$user)}}"
                                        class="{{ Request::is('deposito-user/'.$user) ? 'active' : '' }}"
                                        title="Buka Data User ID {{$deposito[$i]['id']}}">
                                        <i class="fas fa-user text-dark me-2" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="{{url('/deposito-'.$user.'/'.$deposito[$i]['id'])}}"
                                        class="{{ Request::is('deposito-user/'.$deposito[$i]['id']) ? 'active' : '' }}"
                                        {{-- type="button"  --}}
                                        title="User ID {{$deposito[$i]['id']}}"
                                         {{-- target="_blank"  --}}
                                        ><!--  -->
                                        <i class="fas fa-file-contract text-dark me-2" aria-hidden="true"></i>
                                    </a>
                                    {{-- contoh modal notifikasi --}}
                                    {{-- <div class="col-md-4">
                                        <button type="button" class="btn btn-block bg-gradient-warning mb-3" data-bs-toggle="modal" data-bs-target="#modal-notification">Notification</button>
                                        <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                        <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="py-3 text-center">
                                                <i class="ni ni-bell-55 ni-3x"></i>
                                                <h4 class="text-gradient text-danger mt-4">You should read this!</h4>
                                                <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white">Ok, Got it</button>
                                                <button type="button" class="btn btn-link text-white ml-auto" data-bs-dismiss="modal">Close</button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div> --}}
                                </td>
                                {{-- @if ($user == 'penjual')
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$deposito[$i]['ktp']}}</p>
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

        </div>
    </div>
</div>
</div>
{{-- dari link(JANGAN HILANG) --}}

@endsection
