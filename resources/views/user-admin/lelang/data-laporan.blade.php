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
                    Laporan Lelang
                    @if(count($lelang)>0) <span class="text-secondary text-sm font-weight-bolder align-bottom ps-4">Total</span>
                    <span class="text-success text-sm font-weight-bolder align-bottom ps-4"> {{count($lelang)}} <i class="fa fa-check-circle text-success" aria-hidden="true"></i> aktif</span> @endif
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
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    ID Lelang
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    username penjual
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Nama produk
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    harga awal
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    masa aktif
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
                            @if (count($lelang) == 0)
                            <tr>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                <td class="ps-4 mb-0 text-sm text-center font-weight-bolder">Belum Terdaftar Laporan Lelang</td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                            </tr>
                            @else
                            @for ($i = 0; $i < count($lelang); $i++)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$lelang[$i]['id']}}.</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$lelang[$i]['username']}}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$lelang[$i]['produk']}}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$lelang[$i]['harga']}}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$lelang[$i]['mulai'].' - '}}
                                        <span class="text-success font-weight-bolder text-xs">{{$lelang[$i]['selesai']}}</span>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$lelang[$i]['status']}}</p>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn-link btn m-0 p-0" data-bs-toggle="modal" data-bs-target="#exampleModalMessage{{$i}}">
                                        <a href="#"
                                        {{-- {{ url('user/'.$user.'/'.$lelang[$i]['id']) }} --}}
                                            class="{{ Request::is('user/'.$user.'/'.$lelang[$i]['id']) ? 'active' : '' }}"
                                            {{-- type="button"  --}}
                                            title="User ID {{$lelang[$i]['id']}}"
                                             {{-- target="_blank"  --}}
                                            ><!--  -->
                                            <i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>
                                        </a>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalMessage{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">New message to</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <form>
                                                <div class="form-group">
                                                  <label for="recipient-name" class="col-form-label">Recipient:</label>
                                                  <input type="text" class="form-control" value="Creative Tim" id="recipient-name">
                                                </div>
                                                <div class="form-group">
                                                  <label for="message-text" class="col-form-label">Message:</label>
                                                  <textarea class="form-control" id="message-text"></textarea>
                                                </div>
                                              </form>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                              <button type="button" class="btn bg-gradient-primary">Send message</button>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </td>
                                {{-- @if ($user == 'penjual')
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$lelang[$i]['ktp']}}</p>
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
