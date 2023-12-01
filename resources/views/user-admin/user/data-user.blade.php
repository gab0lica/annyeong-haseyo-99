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
                    Daftar {{$user == 'penjual' ? 'Penjual' : 'Penggemar'}}
                    <span class="text-secondary text-sm font-weight-bolder align-bottom ps-4 text-capitalize">berdasarkan terakhir aktif</span>
                    <span class="text-success text-sm font-weight-bolder align-bottom ps-4"> <i class="fa fa-check-circle text-success text-gradient p-1" aria-hidden="true"></i> Aktif {{count($datauser)}} Akun </span>
                    @if ($tidak > 0) <span class="text-danger text-sm font-weight-bolder align-bottom ps-4"><i class="fa fa-ban text-danger text-gradient p-1" aria-hidden="true"></i> Non-Aktif {{$tidak}} Akun</span> @endif
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
                                    email
                                </th> --}}
                                @if ($user == 'penjual')
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    kota
                                </th>
                                @endif
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    masa aktif terakhir
                                </th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    status{{-- nomor telepon --}}
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
                                <td class="ps-4 mb-0 text-sm text-center font-weight-bolder">{{$user == 'penjual' ? 'Penjual' : 'Penggemar'}} Belum Terdaftar</td>
                                <td class="ps-4"></td>
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

                                @if ($user == 'penjual')
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-sm mb-0">{{$datauser[$i]['kota'] == null ? '-' : $datauser[$i]['kota']}}</p>
                                </td>
                                @endif
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-sm mb-0">
                                        {{$datauser[$i]['created_at'].' - '}}
                                        <span class="text-success font-weight-bolder text-sm">{{$datauser[$i]['updated_at']}}</span>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <i class="px-1 fas {{ $datauser[$i]['status'] == 0 ? 'fa-ban text-danger' : 'fa-check-circle text-success'}}" aria-hidden="true"></i>
                                    <a href="{{ url('/status/'.$user.'/'.$datauser[$i]['id']) }}"
                                        class="btn btn-sm {{$datauser[$i]['status'] == 1 ? 'btn-outline-danger' : 'btn-outline-success'}} m-0 mx-1 px-3">
                                        {{ $datauser[$i]['status'] == 1 ? 'Non-Aktif' : 'Aktif'}}
                                        {{-- <i class="fab fa-readme opacity-10 ps-2"></i> --}}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn-link text-lg btn m-0 p-0" data-bs-toggle="modal" data-bs-target="#exampleModalMessage{{$i}}">
                                        <a href="#"
                                            class="{{ Request::is('user/'.$user.'/'.$datauser[$i]['id']) ? 'active' : '' }}"
                                            title="User ID {{$datauser[$i]['id']}}">
                                            <i class="fas fa-user-edit text-dark me-2" aria-hidden="true"></i>
                                        </a>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalMessage{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h6 class="modal-title" id="exampleModalLabel">Data Diri User</h6>
                                              {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                              </button> --}}
                                            </div>
                                            <div class="modal-body">
                                              {{-- <form>
                                                <div class="form-group">
                                                  <label for="recipient-name" class="col-form-label">Name</label>
                                                  <input type="text" class="form-control" value="Creative Tim" id="recipient-name">
                                                </div>
                                                <div class="form-group">
                                                  <label for="recipient-name" class="col-form-label">Alamat</label>
                                                  <textarea class="form-control" id="message-text"></textarea>
                                                </div>
                                              </form> --}}
                                              <div class="card-header py-2">
                                                <img src="{{ $datauser[$i]['gambar_profile'] != null || $datauser[$i]['gambar_profile'] != '' ? $datauser[$i]['gambar_profile'] : '../pic/uni-user-4.png' }}"
                                                  alt="Gambar Profile Anda" class="w-20 h-20 m-2 border-radius-lg shadow-sm bg-gradient-dark">
                                                <p class="font-weight-bold {{$datauser[$i]['status'] == 0 ? 'text-danger' : 'text-success'}} text-left m-0">Masa Aktif: {{$datauser[$i]['created_at'].' - '.$datauser[$i]['updated_at']}}</p>
                                              </div>
                                              <hr class="my-0">
                                              <div class="card-body">
                                                <ul class="list-group">
                                                    <h6 class="font-weight-bolder text-dark text-left"><u>Penggemar</u></h6>
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
                                                    @if ($datauser[$i]['foto_ktp'] != 'tidak')
                                                    <hr>
                                                    <h6 class="font-weight-bolder text-dark text-left my-2"><u>Penjual</u></h6>
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                        <span class="mb-1 text-dark text-sm">Jumlah Pengikut</span>
                                                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                            {{ $datauser[$i]['pengikut'] }} User
                                                        </span>
                                                    </li>
                                                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                                        <span class="mb-1 text-dark text-sm">Nomor KTP</span>
                                                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                                                            {{ $datauser[$i]['ktp'] }}
                                                        </span>
                                                    </li>
                                                    <span class="mb-0">Foto KTP</span>
                                                    <img src="{{ $datauser[$i]['foto_ktp'] }}" alt="Foto KTP Anda" class="my-2 w-100 border-radius-lg shadow-sm bg-outline-dark">
                                                    @endif
                                                </ul>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                                              {{-- <button type="button" class="btn bg-gradient-primary">Send message</button> --}}
                                            </div>
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
            {{-- pagination dari http://localhost:8000/documentation/components/pagination.html --}}
            {{-- <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end me-4">
                  <!-- <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                      <p class="text-xs font-weight-bolder mb-0" aria-hidden="true">&laquo;</p>
                    </a>
                  </li>
                  <a href="{{ url('crawler/'.$web) }}" class="ms-5 btn bg-gradient-secondary btn-sm mb-0 {{ (Request::is('crawler/'.$web) ? 'active' : '') }}" type="button">Repeat Crawler</a>
                  <li class="page-item">
                    <button class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light" onclick='halo(this,10)'>
                        <p class="text-xs font-weight-bolder mb-0">1</p>
                    </button>
                  </li> -->
                  <!--100,200,300,dst-->
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('user/'.$user) ? 'active' : '') }}" href="{{ url('user/'.$user) }}"><p class="text-xs font-weight-bolder mb-0">1</p></a></li><!--100,200,300,dst-->
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('user/'.$user) ? 'active' : '') }}" href="{{ url('user/'.$user) }}"><p class="text-xs font-weight-bolder mb-0">2</p></a></li>
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('user/'.$user) ? 'active' : '') }}" href="{{ url('user/'.$user) }}"><p class="text-xs font-weight-bolder mb-0">3</p></a></li>
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('user/'.$user) ? 'active' : '') }}" href="{{ url('user/'.$user) }}"><p class="text-xs font-weight-bolder mb-0">4</p></a></li>
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('user/'.$user) ? 'active' : '') }}" href="{{ url('user/'.$user) }}"><p class="text-xs font-weight-bolder mb-0">5</p></a></li>
                  <!-- <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('konten/'.$web) ? 'active' : '') }}" href="{{ url('konten/'.$web.'/-') }}"><p class="text-xs font-weight-bolder mb-0">6</p></a></li>
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('konten/'.$web) ? 'active' : '') }}" href="{{ url('konten/'.$web.'/-') }}"><p class="text-xs font-weight-bolder mb-0">7</p></a></li>
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('konten/'.$web) ? 'active' : '') }}" href="{{ url('konten/'.$web.'/-') }}"><p class="text-xs font-weight-bolder mb-0">8</p></a></li>
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('konten/'.$web) ? 'active' : '') }}" href="{{ url('konten/'.$web.'/-') }}"><p class="text-xs font-weight-bolder mb-0">9</p></a></li>
                  <li class="page-item"><a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('konten/'.$web) ? 'active' : '') }}" href="{{ url('konten/'.$web.'/-') }}"><p class="text-xs font-weight-bolder mb-0">10</p></a></li> -->
                  <li class="page-item">
                    <a class="page-link btn bg-gradient-secondary btn-sm mb-0 text-light {{ (Request::is('user/'.$user) ? 'active' : '') }}" href="{{ url('user/'.$user) }}" aria-label="Next">
                        <p class="text-xs font-weight-bolder mb-0" aria-hidden="true">&raquo;</p>
                    </a>
                  </li>
                </ul>
            </nav> --}}
            {{-- end pagination --}}
        </div>
    </div>
</div>
</div>
{{-- dari link(JANGAN HILANG) --}}

@endsection
