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
                <h5 class="font-weight-bolder mb-0">
                    Deposito Koin
                    <span class="text-secondary text-sm font-weight-bolder align-bottom ps-4">({{$user['username']}}) - {{$user['nama']}}</span>
                    @if(count($deposito)>0) <span class="text-success text-sm font-weight-bolder align-bottom ps-4"> <i class="fa fa-check-circle text-success text-gradient p-1" aria-hidden="true"></i> Deposito {{count($deposito)}} Data</span> @endif
                    {{-- @if ($tidak > 0) <span class="text-danger text-sm font-weight-bolder align-bottom ps-4"> {{$tidak}} non-aktif</span> @endif --}}
                </h5>
            </div>
            <a href="{{ url('/deposito/'.($user['role'] == 2 ? 'penggemar' : 'penjual'))}}"
                class="btn bg-gradient-secondary font-weight-bolder text-white btn-sm mb-0" type="button">
                Kembali ke Deposito {{$user['role'] == 2 ? 'Penggemar' : 'Penjual'}}
                <i class="fas fa-wallet text-white mx-1 text-sm" aria-hidden="true"></i>
            </a>
          </div>
        </div>
{{-- dari user-management --}}
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    no.
                                </th>
                                {{-- <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    deposito ID
                                </th> --}}
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    jenis
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    total koin
                                </th>
                                {{-- <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    harga awal
                                </th> --}}
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    tanggal transaksi
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    status
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    detail
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($deposito); $i++)
                            <tr>
                                <td class="ps-4 m-0 p-0">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$i+1}}.</p>
                                </td>
                                <td class="text-center p-1 text-capitalize">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$deposito[$i]['jenisdepo'] == 'lelang' || $deposito[$i]['jenisdepo'] == 'lelang-penjual' ? ( $deposito[$i]['jenisdepo'] == 'lelang' ? 'Pemenang Lelang' : 'Penghasilan Lelang') : $deposito[$i]['jenisdepo']}}</p>
                                </td>
                                <td class="text-center p-1">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$deposito[$i]['koindepo'] < 0 ? $deposito[$i]['koindepo']*$deposito[$i]['jumlahdepo']*-1 : $deposito[$i]['koindepo']*$deposito[$i]['jumlahdepo']}}</p>
                                </td>
                                {{-- <td class="text-center p-1">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$deposito[$i]['harga']}}</p>
                                </td> --}}
                                <td class="text-center p-1">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$deposito[$i]['tanggaldepo']}}</p>
                                </td>
                                <td class="text-center p-1">
                                    {{-- <i class="px-2 fa {{ $deposito[$i]['statusdepo'] == 0 ? 'fa-ban text-danger' : 'fa-check-circle text-success'}}" aria-hidden="true"></i> --}}
                                    <p class="font-weight-bolder text-sm mb-0 text-gradient font-weight-bolder
                                        {{$deposito[$i]['statusdepo'] == 'Admin' ? 'text-warning' :
                                        ($deposito[$i]['statusdepo'] == 'Berhasil' ? 'text-success' :
                                        ($deposito[$i]['statusdepo'] == 'Gagal' ? 'text-danger' : 'text-info')) }}">
                                            {{$deposito[$i]['statusdepo'] != 'Berhasil' && $deposito[$i]['statusdepo'] != 'Gagal' ? (
                                                $deposito[$i]['statusdepo'] == 'Belum' || $deposito[$i]['statusdepo'] == 'Nota' ? 'Dalam Proses' : 'Konfirmasi') : $deposito[$i]['statusdepo'] }}
                                    </p>
                                </td>
                                <td class="text-center p-1">
                                    <button type="button" class="btn-link text-lg btn m-0 p-0" data-bs-toggle="modal" data-bs-target="#exampleModalMessage{{$i}}"><!---->
                                        <a href="#" class="{{ Request::is('detail-deposito/'.$deposito[$i]['kodedepo']) ? 'active' : '' }}"
                                            title="User ID {{$deposito[$i]['deposito']}}">
                                            <i class="fas fa-file-contract text-dark me-2" aria-hidden="true"></i>
                                        </a>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalMessage{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Nota Deposito</h5>
                                              {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                              </button> --}}
                                            </div>
                                            <div class="modal-body">
                                              {{-- <form>
                                                <div class="form-group">
                                                  <label for="recipient-name" class="col-form-label">Recipient:</label>
                                                  <input type="text" class="form-control" value="Creative Tim" id="recipient-name">
                                                </div>
                                                <div class="form-group">
                                                  <label for="message-text" class="col-form-label">Message:</label>
                                                  <textarea class="form-control" id="message-text"></textarea>
                                                </div>
                                              </form> --}}

                                              {{-- dari nota --}}
                                              <div class="card-body pt-4 p-3">
                                                {{-- <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Newest</h6> --}}
                                                <ul class="list-group">
                                                <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                    <span class="mb-1 text-dark text-sm">Tanggal</span>
                                                    <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                                        {{ $deposito[$i]['tanggaldepo'] == null ? $deposito[$i]['tanggaldepo'] : $deposito[$i]['tanggaldepo'] }}
                                                    </span>
                                                </li>
                                                @if($deposito[$i]['jenisdepo'] != 'registrasi')
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                                                        <span class="mb-1 text-dark text-sm">Deposito ID</span>
                                                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                                            {{ $deposito[$i]['deposito'] }}
                                                        </span>
                                                    </li>
                                                    <hr>
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                        <span class="mb-1 text-dark text-sm">Transaksi ID</span>
                                                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                                            {{ $deposito[$i]['kodedepo'] == null ? $deposito[$i]['jenisdepo'] : $deposito[$i]['kodedepo'] }}
                                                        </span>
                                                    </li>
                                                    @if($deposito[$i]['statusdepo'] == 'Berhasil'){{-- statusmid --}}
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 ps-0 mb-2 border-radius-lg">
                                                        <span class="mb-1 text-dark text-sm">Tipe Pembayaran</span>
                                                        <div class="d-flex align-items-center badge-dark text-sm font-weight-bolder">
                                                            {{ $deposito[$i]['tipedepo'] == null ? '-' : $deposito[$i]['tipedepo'] }}
                                                        </div>
                                                    </li>
                                                    @endif
                                                    @if($deposito[$i]['statusdepo'] != 'Nota')<!--statusmid == 'settlement'-->
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                                                        <span class="mb-1 text-dark text-sm">Status Pembayaran</span>
                                                        <div class="d-flex align-items-center text-gradient font-weight-bolder
                                                            {{
                                                            //$statusmid == 'settlement' ||
                                                            $deposito[$i]['statusdepo'] == 'Berhasil' ? 'text-success' :
                                                            //($statusmid == 'pending' ||
                                                            ($deposito[$i]['statusdepo'] == 'Admin' ? 'text-warning' :
                                                            //($statusmid == 'failure' || $statusmid == 'expire' ||
                                                            ($deposito[$i]['statusdepo'] == 'Gagal' ? 'text-danger' : 'text-dark' ) )
                                                            }} text-sm">
                                                            {{
                                                            //$statusmid == 'settlement'||
                                                            $deposito[$i]['statusdepo'] == 'Berhasil' ? 'Berhasil' :
                                                            //($statusmid == 'pending' ? 'Menunggu Pembayaran' :
                                                            //($statusmid == 'failure' ||$statusmid == 'expire' ||
                                                            ( $deposito[$i]['statusdepo'] == 'Gagal' ? 'Gagal Membayar' :
                                                            ( $deposito[$i]['statusdepo'] == 'Admin' ? 'Menunggu Konfirmasi' : $deposito[$i]['statusdepo']))
                                                            }}<!-- $snap -->{{-- ) --}}
                                                        </div>
                                                    </li>
                                                    @endif
                                                @else
                                                <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                                                    <span class="mb-1 text-dark text-sm">Status Transaksi</span>
                                                    <div class="d-flex align-items-center text-gradient font-weight-bolder
                                                        {{$deposito[$i]['statusdepo'] == 'Berhasil' ? 'text-success' :
                                                        ($deposito[$i]['statusdepo'] == 'Admin' ? 'text-warning' : '')}} text-sm">
                                                            {{$deposito[$i]['statusdepo'] == 'Berhasil' ? $deposito[$i]['statusdepo'] :
                                                            ($deposito[$i]['statusdepo'] == 'Admin' ? 'Menunggu Konfirmasi' :
                                                            ($deposito[$i]['statusdepo'] == 'Gagal' ? 'Gagal Registrasi' : '' ))}}<!-- $snap -->
                                                    </div>
                                                </li>
                                                @endif
                                                <hr>
                                                {{-- <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                    <h6 class="mb-0"><u>Perincian</u></h6>
                                                </li> --}}
                                                <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                    <span class="mb-1 text-dark text-sm">Jenis Nota</span>
                                                    <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                                        {{$deposito[$i]['jenisdepo'] == 'beli' ? 'Isi Koin' :
                                                        ($deposito[$i]['jenisdepo'] == 'tukar' ? 'Tarik Koin' :
                                                        ($deposito[$i]['jenisdepo'] == 'registrasi' ? 'Registrasi Penjual' : ''))}}
                                                    </span>
                                                </li>
                                                <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                    <span class="mb-1 text-dark text-sm">
                                                        {{$deposito[$i]['jenisdepo'] == 'beli' || $deposito[$i]['jenisdepo'] == 'tukar' ? 'Menu Koin' :
                                                        ($deposito[$i]['jenisdepo'] == 'registrasi' ? 'Biaya Registrasi' : '')}}</span>
                                                    <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                                        {{ $deposito[$i]['jenisdepo'] == 'beli' ? $deposito[$i]['koindepo'] : ($deposito[$i]['jenisdepo'] == 'tukar' ? $deposito[$i]['koindepo']*-1 : $deposito[$i]['koindepo']*$deposito[$i]['jumlahdepo']*-1) }} Koin
                                                    </span>
                                                </li>
                                                @if($deposito[$i]['jenisdepo'] != 'registrasi')
                                                <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                    <span class="mb-1 text-dark text-sm">Jumlah Menu</span>
                                                    <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                                    {{ $deposito[$i]['jumlahdepo'] }}
                                                    </span>
                                                </li>
                                                <hr>
                                                <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                                                    <span class="mb-1 text-dark text-sm">Sub Total</span>
                                                    <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                                    Rp {{ $deposito[$i]['jenisdepo'] == 'beli' ? $deposito[$i]['koindepo']*$deposito[$i]['jumlahdepo'] : $deposito[$i]['koindepo']*$deposito[$i]['jumlahdepo']*-1}}.000,-
                                                    </span>
                                                </li>
                                                <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                                                    <span class="mb-1 text-dark text-sm">Biaya Admin</span>
                                                    <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                                    {{$deposito[$i]['jenisdepo'] == 'beli' ? 'Rp 2.000,-' : 'Rp 3.000,-'}}
                                                    </span>
                                                </li>
                                                <hr>
                                                <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                                                    <span class="mb-1 text-dark text-sm">Total {{$deposito[$i]['jenisdepo'] == 'beli' ? 'yang Dibayar' : ($deposito[$i]['jenisdepo'] == 'tukar' ? 'Uang yang didapat' : '')}}</span>
                                                    <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                                    {{  'Rp '.($deposito[$i]['totaldepo']/1000) }}.000,-
                                                    </span>
                                                </li>
                                                <li class="list-group-item border-0 d-flex justify-content-between p-0 ps-0 mb-2 border-radius-lg">
                                                    <span class="mb-1 text-dark text-sm">Jumlah {{$deposito[$i]['jenisdepo'] == 'beli' ? 'Beli' : ($deposito[$i]['jenisdepo'] == 'tukar' ? 'Tukar' : '')}} Koin</span>
                                                    <div class="d-flex align-items-center text-sm {{$deposito[$i]['jenisdepo'] == 'beli' ? 'text-success' : 'text-danger'}} font-weight-bolder">
                                                        {{$deposito[$i]['jenisdepo'] == 'beli' ? '+ '.$deposito[$i]['koindepo']*$deposito[$i]['jumlahdepo'] :
                                                            '- '.($deposito[$i]['jenisdepo'] == 'tukar' ? $deposito[$i]['koindepo']*$deposito[$i]['jumlahdepo']*-1 :
                                                            ($deposito[$i]['jenisdepo'] == 'registrasi' ? $deposito[$i]['koindepo']*$deposito[$i]['jumlahdepo']*-1 : '')) }} Koin
                                                    </div>
                                                </li>
                                                @else
                                                <hr>
                                                <li class="list-group-item border-0 d-flex justify-content-between p-0 ps-0 mb-2 border-radius-lg">
                                                    <span class="mb-1 text-dark text-sm">Jumlah Koin {{$deposito[$i]['jenisdepo'] == 'beli' ? 'yang dibeli' : ($deposito[$i]['jenisdepo'] == 'tukar' ? 'yang ditukar' : 'yang dibayar')}}</span>
                                                    <div class="d-flex align-items-center text-sm {{$deposito[$i]['jenisdepo'] == 'beli' ? 'text-success' : 'text-danger'}} font-weight-bolder">
                                                        {{$deposito[$i]['jenisdepo'] == 'beli' ? '+ '.$deposito[$i]['koindepo']*$deposito[$i]['koindepo'] :
                                                        '- '.($deposito[$i]['jenisdepo'] == 'tukar' ? $deposito[$i]['koindepo']*-1 :
                                                        ($deposito[$i]['jenisdepo'] == 'registrasi' ? $deposito[$i]['koindepo']*-1 : '')) }} Koin
                                                    </div>
                                                </li>
                                                @endif
                                                <hr>
                                                <li class="list-group-item border-0 d-flex justify-content-between p-0 ps-0 mb-2 border-radius-lg">
                                                    <span class="mb-1 text-dark text-sm">Admin ID</span>
                                                    <div class="d-flex align-items-center text-sm text-dark font-weight-bolder">
                                                        {{$deposito[$i]['admindepo'] == null ? '-' : ($deposito[$i]['admindepo'] == auth()->user()->id ? 'Anda' : "ID ".$deposito[$i]['admindepo'])}}
                                                    </div>
                                                </li>
                                                </ul>
                                              </div>
                                              {{-- end nota --}}

                                            </div>
                                            <div class="modal-footer">
                                              {{-- dari nota --}}
                                                @if($deposito[$i]['jenisdepo'] == 'tukar' && $deposito[$i]['statusdepo'] != 'Berhasil' && $deposito[$i]['statusdepo'] != 'Gagal')
                                                {{-- tukar-koin/>> MasterTransaksiKoin::class,'userDeposito'] --}}
                                                <form action="{{'/transfer-koin'}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="transkode" id="transkode" value="{{$deposito[$i]['kodedepo']}}">
                                                    <input type="hidden" name="userid" id="userid" value="{{$user['id']}}">
                                                    <button type="submit" class="btn bg-gradient-secondary m-0 mx-2">Transfer</button>
                                                </form>
                                                @endif
                                              {{-- end nota --}}
                                              <button type="button" class="btn btn-outline-secondary m-0 mx-2" data-bs-dismiss="modal">Kembali</button>
                                              {{-- <button type="button" class="btn bg-gradient-primary">Send message</button> --}}

                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                    {{-- contoh modal notifikasi --}}
                                    {{-- <button type="button" class="btn btn-block bg-gradient-warning mb-3" data-bs-toggle="modal" data-bs-target="#modal-notification">Notification</button> --}}
                                    {{-- <div class="col-md-4">
                                        <div class="modal fade" id="exampleModalMessage{{$deposito[$i]['i']}}" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
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
                            </tr>
                            @endfor
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
