@extends('layouts.user_type.auth')

@section('content')

{{-- kode asli di konten.blade.php --}}

{{-- <div class="row">
    <div class="col-12">
      <div class="mb-4">
        <div class="pb-0">

        </div>
      </div>
    </div>
</div> --}}
{{-- <div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
      <div class="card mb-3">
        <div class="card-body p-3">
          <div class="chart">
            <canvas id="mixed-chart" class="chart-canvas" height="375" width="683" style="display: block; box-sizing: border-box; height: 300px; width: 547.1px;"></canvas>
          </div>
        </div>
      </div>
    </div>
</div> --}}
@if ($error)
<div class="row">
    <div class="col-12">
        <div class="alert alert-dark mx-4" role="alert">
            <span class="text-white">
                <strong>{{$errors->first()}}</strong>
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
            <div class="col-md-12">
                <h5 class="font-weight-bolder mb-0">
                    Transaksi Lelang @if($pesan[0] == 'sudah')<u>Sesuai Filter</u> @endif
                    <span class="text-dark text-gradient text-sm font-weight-bolder align-bottom ps-4">
                        <i class="fa fa-check-circle text-dark text-gradient p-1" aria-hidden="true"></i> {{count($lelang)}} Lelang Aktif
                    </span>
                    <span class="text-success text-gradient text-sm font-weight-bolder align-bottom ps-4">
                        <i class="fa fa-check-circle text-success text-gradient p-1" aria-hidden="true"></i> {{$selesai}} Lelang Selesai
                    </span>
                    <span class="text-danger text-sm font-weight-bolder align-bottom ps-4"> <u>Persentase Admin <strong class="text-lg">5%</strong> dari Jumlah Penawaran Akhir</u> </span>
                </h5>
            </div>
          </div>
          <div class="d-flex flex-row justify-content-between">
            <div class="row col-md-12 text-center">
                @if($pesan[0] == 'sudah')
                <form action="/laporan-pdf" method="POST" role="form text-left" class="col-md-6 text-end">
                    @csrf
                    <input type="hidden" name="admin" id="admin" value="{{$pesan[1]['admin']}}">
                    <input type="hidden" name="penjual" id="penjual" value="{{$pesan[1]['penjual']}}">
                    <input type="hidden" name="namapenjual" id="namapenjual" value="{{$pesan[1]['namapenjual']}}">
                    <input type="hidden" name="mulai" id="mulai" value="{{$pesan[1]['mulai']}}">
                    <input type="hidden" name="selesai" id="selesai" value="{{$pesan[1]['selesai']}}">
                    <button type="submit" class="btn bg-gradient-secondary btn-md font-weight-bolder text-white m-1 mb-0">
                        Print Transaksi <i class="fas fa-file-export text-white mx-1 text-sm" aria-hidden="true"></i>
                    </button>
                </form>
                @endif
                <div class="{{$pesan[0] == 'sudah' ? 'col-md-6 text-start' : 'col-md-12text-center'}}">
                <button type="button" class="btn bg-gradient-secondary btn-md font-weight-bolder text-white m-1 mb-0" data-bs-toggle="modal" data-bs-target="#exampleModalMessage" title="Filter Transaksi">
                    Filter <i class="fas fa-filter ps-2 text-sm" aria-hidden="true"></i>
                </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="/cari-transaksi" method="POST" role="form text-left" class="col-md-12">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLabel">Filter Transaksi Lelang</h6>
                            </div>
                            <div class="modal-body">
                                {{-- <span class="text-lg font-weight-bolder" id="exampleModalLabel">Jumlah Konten</span> --}}
                                {{-- <hr class="bg-dark"> --}}
                                @csrf
                                {{-- <div class="input-group">
                                    <input type="text text-right" class="form-control" name="cari" placeholder="Cari Laporan Lelang dengan Nama Produk..." value="{{ $pesan[0] == 'belum' ? '' : $pesan[1]['cari'] }}">
                                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                </div> --}}
                                <ul class="list-group">
                                    @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <span class="alert-text text-white font-weight-bold">
                                        {{$errors->first()}}
                                            {{-- Lelang Anda perlu diperbaiki. <br>Dimohon untuk mengisi dengan benar sesuai dengan catatan perbaikan. --}}
                                        </span>
                                    </div>
                                    @endif
                                    {{-- <li class="list-group-item border-0 ps-0 text-sm">
                                        <div class='row'>
                                            <div class='col-md-4 my-auto'><strong class="text-dark">Judul / Nama Produk Lelang</strong></div>
                                            <div class='col-md-8'>
                                                <div class="form-group my-0">
                                                <div class='row my-2'>
                                                    <input type="text text-right" class="form-control" name="cari" placeholder="Tulis Nama Produk..." value="{{ $pesan[0] == 'belum' ? '' : $pesan[1]['cari'] }}">
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li> --}}
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <div class='row'>
                                            <div class='col-md-4 my-auto'><strong class="text-dark">Penjual</strong></div>
                                            <div class='col-md-8 px-0'>
                                                <div class="form-group my-0">
                                                {{-- <span class="font-weight-bold text-danger">(Apabila Nama Artis ada)</span> --}}
                                                <div class='row my-2'>
                                                    @if (count($penjual) > 0)
                                                    <div class='col-md-12'>
                                                        {{-- <span class="font-weight-bold text-dark my-2"><u>Bagian Pilih Penjual yang Tersedia</u></span> --}}
                                                        <select class="form-control" id="penjual" name="penjual" value="{{ $pesan[1]['penjual'] == null ? old('penjual') : $pesan[1]['penjual'] }}">
                                                            <option>{{'Tidak Ada'}}</option>
                                                            @foreach ($penjual as $item)
                                                            <option class="text-capitalize" value="{{ $item->id }}" {{ $pesan[1]['penjual'] == $item->id ? 'selected' : '' }}>{{"@".$item->username." - ".$item->nama}}</option>
                                                            {{-- <option>{{$item->nama}}</option> --}}
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @endif
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <div class='row'>
                                            <div class='col-md-4 my-auto'><strong class="text-dark">Tanggal Mulai</strong> <span class="text-danger text-md">*</span></div>
                                            {{-- <span class="text-danger text-md">*</span> --}}
                                            <div class='col-md-8 px-0'>
                                                <div class="form-group my-0">
                                                    {{-- @if(count($detail) > 0)<span class="font-weight-bold text-danger">{{$detail['penawar'] > 0 ? '(Tanggal Dimulai Tidak Bisa Diubah karena Sudah Ada Penawar)' : ''}}</span>@endif --}}
                                                    <div class="row my-2">
                                                        <div class='col-md-6'>
                                                        <input id="mulai" name="mulai" type="date" class="form-control" value="{{ date('Y-m-d',strtotime( $pesan[1]['mulai'] == null ? $pesan[1]['hari_ini'] : $pesan[1]['mulai'] )) }}">
                                                        </div>
                                                        <div class='col-md-6'>
                                                        <input id="jamMulai" name="jamMulai" type="time" class="form-control" value="{{ date('H:i',strtotime( $pesan[1]['mulai'] == null ? $pesan[1]['hari_ini'] : $pesan[1]['mulai'])) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <div class='row'>
                                            <div class='col-md-4 my-auto'><strong class="text-dark">Tanggal Selesai</strong> <span class="text-danger text-md">*</span></div>
                                            {{-- <span class="text-danger text-md">*</span> --}}
                                            <div class='col-md-8 px-0'>
                                                <div class="form-group my-0">
                                                    <div class="row py-2">
                                                        <div class='col-md-6'>
                                                            <input id="selesai" name="selesai" type="date" class="form-control" value="{{ date('Y-m-d',strtotime( $pesan[1]['selesai'] == null ? $pesan[1]['hari_ini'] : $pesan[1]['selesai'] )) }}">
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <input id="jamSelesai" name="jamSelesai" type="time" class="form-control" value="{{ date('H:i',strtotime( $pesan[1]['selesai'] == null ? $pesan[1]['hari_ini'] : $pesan[1]['selesai'])) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <div class='row mx-3'>
                                            <div class="form-check text-start">
                                                {{-- <input class="form-check-input" type="checkbox" name="status" value="1" id="status"> --}}
                                                <input class="form-check-input" type="checkbox" value="anda" id="admin" name="admin" {{$pesan[1]['admin'] == 'anda' ? 'checked' : ''}}>
                                                <strong class="text-dark">Pendapatan Hasil Lelang <u>Anda</u></strong>
                                            </div>
                                            {{-- <div class="p-0 text-start">
                                                <span class="text-danger text-md font-weight-bolder">*</span>
                                                <span class="mb-1 text-dark text-sm text-left px-1" for="konfirmasi"></span>
                                            </div> --}}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                {{-- <input type="hidden" id="berita" name="berita" value="{{$item['berita']}}">
                                <input type="hidden" id="konten" name="konten" value="{{$item['konten']}}"> --}}
                                <a href="{{url('/lelang/transaksi')}}" class="btn bg-gradient-dark">Reset Filter</a>
                                {{-- <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Kembali</button> --}}
                                <button type="submit" class="btn bg-gradient-secondary">Kirim Filter</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
                {{-- <a href="{{ url('/lelang/daftar') }}"
                    class="btn bg-gradient-secondary font-weight-bolder text-white btn-sm mb-0" type="button">
                    Semua Daftar Lelang<i class="fas fa-file-invoice text-white mx-1 text-sm" aria-hidden="true"></i>
                </a> --}}
            </div>
          </div>
            @if ($pesan[0] == 'sudah')
            <div class="d-flex flex-row justify-content-between my-2">
                <h6 class="text-dark text-center font-weight-bolder mx-auto">
                    @php
                            $inggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                            $indonesia = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
                            // $indonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            $mulai = str_replace($inggris,$indonesia,date('d F Y H:i:s',strtotime($pesan[1]['mulai'])));
                            $selesai = str_replace($inggris,$indonesia,date('d F Y H:i:s',strtotime($pesan[1]['selesai'])));
                        @endphp
                        {{-- {{ str_replace($inggris,$indonesia,date('d F Y H:i:s',strtotime($hari_ini))) }} --}}
                        {{-- Urut Berdasarkan Waktu Dimulai Lelang Terbaru <i class="fas fa-hourglass-start text-primary text-gradient me-1 py-1" aria-hidden="true"></i> --}}
                        Filter: Lelang <u>{{$pesan[1]['admin'] == 'anda' ? 'Transaksi Pendapatan Anda ' : ''}}</u> @if($pesan[1]['namapenjual'] != null)dengan Penjual <u>{{$pesan[1]['namapenjual']}}</u>@endif @if($pesan[1]['mulai'] != null)dengan Tanggal dan Waktu dari <u>{{$mulai}} - {{$selesai}}</u>@endif
                </h6>
            </div>
            @endif
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                No.
                            </th>
                            <th class="col-md-1 text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                username penjual
                            </th>
                            <th class="col-md-3 text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                Judul / Nama Produk
                            </th>
                            <th class="col-md-3 text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                {{-- Jumlah Penawaran Akhir --}}
                                Durasi Lelang
                            </th>
                            <th class="col-md-2 text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                Persentase Admin
                            </th>
                            {{-- <th class="col-md-2 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                Admin
                            </th> --}}
                            <th class="col-md-2 text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                Detail Lelang
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($lelang) == 0)
                            <tr>
                                <td class="ps-4 mb-0 text-sm text-center font-weight-bolder">Belum Terdaftar Transaksi Lelang</td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                {{-- <td class="ps-4"></td> --}}
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                                <td class="ps-4"></td>
                            </tr>
                        @else
                            @php
                                $index = 1;
                            @endphp
                            @for ($i = 0; $i < count($lelang); $i++)
                                {{-- @if ($lelang[$i]['admin'] == auth()->user()->id) --}}
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-dark font-weight-bold text-sm mb-0">{{$index}}.</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-dark font-weight-bold text-sm mb-0">{{$lelang[$i]['username']}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-dark font-weight-bold text-sm mb-0">{{$lelang[$i]['produk']}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="font-weight-bold text-sm mb-0">{{$lelang[$i]['mulai'].' - '}}
                                            <span class="font-weight-bolder text-sm">{{$lelang[$i]['selesai']}}</span>
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-dark font-weight-bold text-sm mb-0">
                                            @if ($lelang[$i]['persenadmin'] < $lelang[$i]['pemenang'] && $lelang[$i]['persenadmin'] > 0 && $lelang[$i]['admin'] == auth()->user()->id)
                                            {{$lelang[$i]['persenadmin']}} <i class="p-1 text-lg fas fa-coins text-gradient text-success" aria-hidden="true"></i>
                                            dari {{($lelang[$i]['pemenang'])}} <i class="p-1 text-lg fas fa-coins text-gradient text-warning" aria-hidden="true"></i>
                                            @elseif($lelang[$i]['persenadmin'] < $lelang[$i]['pemenang'] && $lelang[$i]['persenadmin'] > 0)
                                            Lelang Selasai
                                            @else
                                            Lelang Sedang Berjalan
                                            @endif
                                        </p>
                                    </td>
                                    {{-- <td class="text-center">
                                        <p class="font-weight-{{$lelang[$i]['admin'] == auth()->user()->id ? 'bolder' : 'bold'}} text-sm mb-0">
                                            {{$lelang[$i]['admin'] == auth()->user()->id ? 'Anda' : "Admin ID ".$lelang[$i]['admin']}}
                                        </p>
                                    </td> --}}
                                    <td class="text-center">
                                        <i class=" text-lg me-2 fas fa-{{$lelang[$i]['status'] == 3 ? ($lelang[$i]['admin'] == auth()->user()->id ? 'check':'check-circle').' text-success' : 'hourglass-half text-dark'}}" aria-hidden="true"></i>
                                        <a href="{{ url('detail-lelang/'.$lelang[$i]['lelang']) }}"
                                            class="{{ Request::is('detail-lelang/'.$lelang[$i]['lelang']) ? 'active' : '' }}"
                                            target="_blank" type="button" title="Lihat Lelang {{$lelang[$i]['lelang']}}">
                                            <i class="fas fa-file-invoice text-lg text-dark me-2" aria-hidden="true"></i>
                                        </a>
                                        <span class="font-weight-{{$lelang[$i]['admin'] == auth()->user()->id ? 'bolder' : 'bold'}} text-sm mb-0">
                                            {{$lelang[$i]['admin'] == auth()->user()->id ? 'Anda' : "Admin ID ".$lelang[$i]['admin']}}
                                        </span>
                                        {{-- <a href="{{url('/laporan-pdf/'.$lelang[$i]['lelang'])}}" class="font-weight-bolder text-dark m-1 mb-0"
                                            title="Print Transaksi ID {{$lelang[$i]['lelang']}}" target="_blank">
                                            <i class="fas fa-file-export text-dark mx-1 text-lg" aria-hidden="true"></i>
                                        </button> --}}
                                    </td>
                                </tr>
                                @php
                                    $index += 1;
                                @endphp
                                {{-- @endif --}}
                            @endfor
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
</div>
</div>

@endsection

@push('dashboard')
  <script>
    window.onload = function() {
      //untuk penawaran
    let label = @json($admin[1]);
    let koinakhir = @json($admin[2]);
    let persenadmin = @json($admin[3]);

      // Mixed chart
      var ctx7 = document.getElementById("mixed-chart").getContext("2d");
      new Chart(ctx7, {
        data: {
          labels: label
          ,
          datasets: [{
              type: "bar",
              label: "Koin Penawaran Akhir",
              weight: 5,
              tension: 0.4,
              borderWidth: 0,
              pointBackgroundColor: "#fb8c00",
              borderColor: "#fb8c00",
              backgroundColor: '#fb8c00',
              borderRadius: 4,
              borderSkipped: false,
              data: koinakhir
              ,
              fill: true,
            },
            {
              type: "bar",//line
              label: "Persentase Penghasilan",
              weight: 5,
              tension: 0.4,
              borderWidth: 0,
              pointBackgroundColor: "#4caf50",
              borderColor: "#4caf50",
              backgroundColor: '#4caf50',
              borderRadius: 4,
              borderSkipped: false,
              data: persenadmin
              ,
              fill: true,
            }
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#b2b9bf',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: true,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                color: '#b2b9bf',
                padding: 10,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });

    }
  </script>
@endpush
