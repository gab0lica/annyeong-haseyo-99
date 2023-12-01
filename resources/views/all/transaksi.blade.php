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
<div class="row">
    <div class="col-12">
      <div class="card mb-2">
        <div class="card-header pb-0">
          <div class="d-flex flex-row justify-content-between">
            <div>
                <h5 class="font-weight-bolder mb-0 text-capitalize">
                    Transaksi Koin
                    {{-- <span class="text-secondary text-sm font-weight-bolder align-bottom ps-4">Total </span>
                    @if(count($deposito)>0) <span class="text-success text-sm font-weight-bolder align-bottom ps-4"> {{count($deposito)}} <i class="fa fa-check-circle text-success" aria-hidden="true"></i> aktif</span> @endif --}}
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
                                    ID deposito
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
                            <tr>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                <td class="ps-4 mb-0 text-sm text-center font-weight-bolder">Belum Terdaftar Transaksi</td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                            </tr>
                            {{-- @if (count($deposito) == 0)
                            <tr>
                                <td class="ps-4"></td>
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
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$deposito[$i]['id']}}.</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$deposito[$i]['username']}}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$deposito[$i]['produk']}}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$deposito[$i]['harga']}}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$deposito[$i]['mulai'].' - '}}
                                        <span class="text-success font-weight-bolder text-xs">{{$deposito[$i]['selesai']}}</span>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$deposito[$i]['status']}}</p>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn-link btn m-0 p-0" data-bs-toggle="modal" data-bs-target="#exampleModalMessage{{$i}}">
                                        <a href="#"
                                        <!-- {{ url('user/'.$user.'/'.$deposito[$i]['id']) }} -->
                                            class="{{ Request::is('user/'.$user.'/'.$deposito[$i]['id']) ? 'active' : '' }}"
                                            <!-- type="button"  -->
                                            title="User ID {{$deposito[$i]['id']}}"
                                             <!-- target="_blank"  -->
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
                                <!-- @if ($user == 'penjual')
                                <td class="text-center">
                                    <p class="text-dark font-weight-bold text-xs mb-0">{{$deposito[$i]['ktp']}}</p>
                                </td>
                                @endif -->
                            </tr>
                            @endfor
                            @endif--}}
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
