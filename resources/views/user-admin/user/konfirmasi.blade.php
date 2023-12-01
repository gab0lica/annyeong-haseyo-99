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
            <div>
                <h5 class="font-weight-bolder mb-0">
                    Daftar Konfirmasi Penjual
                    {{-- <span class="text-secondary text-sm font-weight-bolder align-bottom ps-4">Total Akun</span> --}}
                    @if(count($datauser) > 0)<span class="text-success text-sm font-weight-bolder align-bottom ps-4"> <i class="fas fa-check-circle opacity-10 ps-2 text-gradient"></i> Konfirmasi {{count($datauser)}} Akun</span>@endif
                    @if(count($datauser) > 0 && $tidak > 0)<span class="text-warning text-gradient text-sm font-weight-bolder align-bottom ps-4"> <i class="fas fa-check-circle opacity-10 ps-2 text-gradient"></i> Menunggu {{$tidak}} Akun </span>@endif
                    @if(count($datauser) > 0 && $revisi > 0)<span class="text-danger text-sm font-weight-bolder align-bottom ps-4"> <i class="fas fa-check-circle opacity-10 ps-2 text-gradient"></i> Perbaikan {{$revisi}} Akun</span>@endif
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
                                    No.
                                </th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    username
                                </th>
                                {{-- <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    nomor ktp
                                </th> --}}
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    masa aktif
                                </th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    status konfirmasi
                                </th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    detail
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($datauser) == 0)
                            <tr>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                {{-- <td class="ps-4"></td> --}}
                                <td class="ps-4 mb-0 text-sm text-center font-weight-bolder">Belum Terdaftar Konfirmasi Penjual</td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                            </tr>
                            @else
                            @for ($i = 0; $i < count($datauser); $i++)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$i+1}}.</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$datauser[$i]['username']}}</p>
                                </td>
                                {{-- <td class="text-center">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$datauser[$i]['ktp']}}</p>
                                </td> --}}
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$datauser[$i]['created_at'].' - '}}
                                        <span class="text-success font-weight-bolder text-sm">{{$datauser[$i]['updated_at']}}</span>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <i class="px-2 text-lg fa {{ $datauser[$i]['status'] == 1 && $datauser[$i]['konfirmasi'] == 2 ? 'fa-file-signature text-danger' :
                                    ($datauser[$i]['status'] == 1 && $datauser[$i]['konfirmasi'] == 1 ? 'fa-check-circle text-success' :
                                    ($datauser[$i]['status'] == 0 || $datauser[$i]['konfirmasi'] == -1 ? 'fa-ban text-danger' : 'fa-hourglass-half text-gradient text-warning'))}}"></i>
                                    {{-- {{($datauser[$i]['status'])." - ".($datauser[$i]['konfirmasi'])."-".(auth()->user()->id == $datauser[$i]['admin'])}} --}}
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn-link btn m-0 p-0" data-bs-toggle="modal" data-bs-target="#exampleModalMessage{{$i}}">
                                        <a href="#" title="User ID {{$datauser[$i]['id']}}"
                                             {{-- target="_blank"  --}}
                                            ><!--  -->
                                            <i class="fas fa-user-edit text-dark text-lg me-2" aria-hidden="true"></i>
                                        </a>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalMessage{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                            <form method="POST" action="{{ '/konfirmasi' }}" role="form">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Registrasi Penjual</h5>
                                                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button> --}}
                                                </div>
                                                <div class="modal-body">
                                                    @if($errors->any())
                                                        <div class="alert alert-danger alert-dismissible fade show text-sm" role="alert">
                                                            <span class="alert-text text-white font-weight-bold">
                                                            {{ $errors->first() }}</span>
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                                <i class="fa fa-close" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                    <div class="card-body pt-2 p-3">
                                                        <ul class="list-group">
                                                            <h6 class="font-weight-bolder text-dark text-left"><u>Data sebagai Penggemar</u></h6>
                                                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                                <span class="mb-1 text-dark text-sm">Username</span>
                                                                <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                                    {{ $datauser[$i]['username'] }}
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                                <span class="mb-1 text-dark text-sm">Email</span>
                                                                <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                                    {{ $datauser[$i]['email'] }}
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                                <span class="mb-1 text-dark text-sm">Nama Lengkap</span>
                                                                <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                                    {{ $datauser[$i]['nama'] }}
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                                <span class="mb-1 text-dark text-sm">Nomor Telepon</span>
                                                                <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                                    {{ $datauser[$i]['nomor_telepon'] }}
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                                <span class="mb-1 text-dark text-sm">Kota</span>
                                                                <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                                    {{ $datauser[$i]['kota'] != null ? $datauser[$i]['kota'] : '-'}}
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                                <span class="mb-1 text-dark text-sm">Tentang Anda</span>
                                                                <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                                    {{ $datauser[$i]['tentang_user'] != null ? $datauser[$i]['tentang_user'] : '-'}}
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                                <span class="mb-1 text-dark text-sm">Artis Favorit</span>
                                                                <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                                    {{ $datauser[$i]['artis'] != null ? $datauser[$i]['artis'] : '-'}}
                                                                </span>
                                                            </li>
                                                            <hr>
                                                            <h6 class="font-weight-bolder text-dark text-left"><u>Data Registrasi</u></h6>
                                                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                                <span class="mb-1 text-dark text-sm">Pembayaran</span>
                                                                <span class="d-flex align-items-center {{ $datauser[$i]['transaksi'] != null ? 'text-success' : 'text-dark'}} text-sm font-weight-bold">
                                                                    {{ $datauser[$i]['transaksi'] != null ? 'Lunas' : '-' }}
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                                <span class="mb-1 text-dark text-sm">Tanggal</span>
                                                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                                                    {{ $datauser[$i]['tanggaldepo'] == null ? $datauser[$i]['tanggaldepo'] : $datauser[$i]['tanggaldepo'] }}
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                                                                <span class="mb-1 text-dark text-sm">Status Transaksi</span>
                                                                <span class="d-flex align-items-center text-gradient font-weight-bolder
                                                                    {{$datauser[$i]['statusdepo'] == 'Berhasil' ? 'text-success' :
                                                                    ($datauser[$i]['statusdepo'] == 'Admin' ? 'text-warning' : '')}} text-sm">
                                                                        {{$datauser[$i]['statusdepo'] == 'Berhasil' ? $datauser[$i]['statusdepo'] :
                                                                        ($datauser[$i]['statusdepo'] == 'Admin' ? (
                                                                            $datauser[$i]['konfirmasi'] == 0 ? 'Menunggu Konfirmasi' : (
                                                                            $datauser[$i]['konfirmasi'] == -2 ? 'Konfirmasi Perbaikan' : 'Menunggu Perbaikan')) :
                                                                        ($datauser[$i]['statusdepo'] == 'Gagal' ? 'Gagal Registrasi' : '' ))}}<!-- $snap -->
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                                <span class="mb-1 text-dark text-sm">Jenis Nota</span>
                                                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                                                    Registrasi Penjual
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                                <span class="mb-1 text-dark text-sm">Biaya Registrasi</span>
                                                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                                                    {{ $datauser[$i]['koindepo']*$datauser[$i]['jumlahdepo']*-1 }} Koin
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                                <span class="mb-1 text-dark text-sm">Admin ID</span>
                                                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                                                    {{ $datauser[$i]['adminid'] != null ? ($datauser[$i]['adminid'] == auth()->user()->id ? 'Anda' : "ID ".$datauser[$i]['adminid']) : '-'}}
                                                                </span>
                                                            </li>
                                                            <hr>
                                                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                                <span class="mb-1 text-dark text-sm">Nomor KTP</span>
                                                                <span class="d-flex align-items-center font-weight-bolder text-danger text-sm">
                                                                    {{ $datauser[$i]['ktp'] }}
                                                                </span>
                                                            </li>
                                                        </ul>
                                                        <span for="catatan" class="text-dark font-weight-bold">Foto KTP</span>
                                                        <div class="form-group">
                                                            {{-- <span class="mb-1 text-dark text-sm">Foto KTP</span> --}}
                                                            <img src="{{ $datauser[$i]['foto'] }}" alt="Foto KTP" class="my-2 w-100 border-radius-lg shadow-sm bg-outline-dark">
                                                        </div>
                                                        {{-- <div class="form-group">
                                                            <label for="message-text" class="col-form-label">Pembayaran</label>
                                                            <h6 class="mx-2 font-weight-bolder text-info">
                                                                @if($datauser[$i]['transaksi'] != null)
                                                                <i class="px-2 text-lg fa fa-check-circle text-success"></i>
                                                                @endif
                                                            </h6>
                                                        </div> --}}
                                                        <hr>
                                                        <h6 class="font-weight-bolder text-dark text-left"><u>Keterangan</u></h6>
                                                        <span for="catatan" class="text-dark font-weight-bold">Catatan</span><span class="text-danger">*</span>
                                                        <div class="form-group">
                                                            <textarea class="form-control" id="catatan" name="catatan" {{$datauser[$i]['konfirmasi'] == 0 ||
                                                                ($datauser[$i]['adminid'] == auth()->user()->id && $datauser[$i]['konfirmasi'] == -2) ? '' :
                                                                'disabled' }}>{{$datauser[$i]['catatan']}}</textarea>
                                                        </div>
                                                        <span for="konfirmasi" class="text-dark font-weight-bold">Konfirmasi Registrasi</span><span class="text-danger">*</span>
                                                        <div class="form-group col-md-2">
                                                            <div class="form-check">
                                                            <input class="form-check-input px-2" type="radio" id="pilihan" name="pilihan" value='terima' {{($datauser[$i]['konfirmasi'] == 1 ? 'checked' : '').' '.($datauser[$i]['adminid'] == auth()->user()->id || $datauser[$i]['adminid'] == null ? '' : 'disabled')}}>
                                                            <span class="mb-1 text-dark text-sm text-left px-1" for="konfirmasi">Terima</span>
                                                            </div>
                                                            <div class="form-check">
                                                            <input class="form-check-input px-2" type="radio" id="pilihan" name="pilihan" value='perbaiki' {{($datauser[$i]['konfirmasi'] == -2 || $datauser[$i]['konfirmasi'] == 2 ? 'checked' : '').' '.($datauser[$i]['adminid'] == auth()->user()->id || $datauser[$i]['adminid'] == null ? '' : 'disabled')}}>
                                                            <span class="mb-1 text-dark text-sm text-left px-1" for="konfirmasi">Perbaiki</span>
                                                            </div>
                                                            {{-- <div class="form-check">
                                                            <input class="form-check-input px-2" type="radio" id="pilihan" name="pilihan" value='tolak' @selected($datauser[$i]['konfirmasi'] == 0 && $datauser[$i]['statusdepo'] == 'Gagal')>
                                                            <span class="mb-1 text-dark text-sm text-left px-1" for="konfirmasi">Tolak</span>
                                                            </div> --}}
                                                        </div>
                                                        <span class="text-danger">*</span><span class="font-weight-bold text-dark text-sm mb-0">Harap Mengisi Seluruh Data yang Tersedia</span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="user" value="{{ $datauser[$i]['id']}}">
                                                    <input type="hidden" name="konfirmasi" value="{{ $datauser[$i]['idkon']}}">
                                                    <input type="hidden" name="transaksi" value="{{ $datauser[$i]['transaksi']}}">
                                                    <input type="hidden" name="statusKon" value="{{ $datauser[$i]['konfirmasi']}}">

                                                    <button type="submit" class="btn bg-gradient-secondary" {{($datauser[$i]['adminid'] == auth()->user()->id && $datauser[$i]['konfirmasi'] == -2) || $datauser[$i]['konfirmasi'] == 0 ? '' : 'disabled' }}><!--disabled-->
                                                        Kirim Konfirmasi
                                                    </button>
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Kembali</button>
                                                </div>
                                            </form>
                                          </div>
                                        </div>
                                    </div>
                                </td>
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
