@extends('layouts.user_type.auth')

@section('content')

{{-- kode asli di konten.blade.php --}}

{{-- JANGAN HILANG dari link --}}
<div class="row">
    <div class="col-12">
      <div class="mb-4">
        <div class="pb-0">
          {{-- <img src="../logo/{{$web}}.png" class="navbar-brand-img ms-3 {{ (Request::is('konten/dsp') ? 'w-20' : (Request::is('konten/ktm') ? 'w-25' : 'w-30')) }}" alt="{{$web}}"> --}}
          {{-- <a href="{{ url('crawler/'.$web) }}" class="ms-5 btn bg-gradient-secondary btn-sm mb-0 {{ (Request::is('crawler/'.$web) ? 'active' : '') }}" type="button">Ulangi Crawler</a> --}}
        </div>
      </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
      <div class="card mb-2">
        <div class="card-header pb-0">
          <div class="d-flex flex-row justify-content-between">
            {{-- <div> --}}
                <h5 class="font-weight-bolder mb-0">
                    Laporan Aggregator Konten Berita
                @if (count($berita) > 0)
                @if ($web != 'ktm' && $web != 'khd')
                <span class="text-dark text-sm font-weight-bolder align-bottom ps-4">
                    <i class="fa text-lg fa-check-circle text-info text-gradient me-1 py-1" aria-hidden="true"></i> {{$dsp}} Link
                </span>
                @endif
                @if ($web != 'dsp' && $web != 'khd')
                <span class="text-dark text-sm font-weight-bolder align-bottom ps-4">
                    <i class="fa text-lg fa-check-circle text-success text-gradient me-1 py-1" aria-hidden="true"></i> {{$ktm}} Link
                </span>
                @endif
                @if ($web != 'dsp' && $web != 'ktm')
                <span class="text-dark text-sm font-weight-bolder align-bottom ps-4">
                    <i class="fa text-lg fa-check-circle text-secondary me-1 py-1" aria-hidden="true"></i> {{$khd}} Link
                </span>
                @endif
                @endif
                </h5>
            {{-- </div> --}}
            <div class="my-auto text-end">
                <a href="#" class="btn bg-gradient-secondary dropdown-toggle " data-bs-toggle="dropdown" id="navbarDropdownMenuLink">
                    {{Request::is('berita-aggregator/semua') ? 'Semua Website Korea' :  (Request::is('berita-aggregator/dsp') ? 'Dispatch' :
                    (Request::is('berita-aggregator/ktm') ? 'The Korea Times' : (Request::is('berita-aggregator/khd') ? 'Korea Herald' :
                    (Request::is('berita-aggregator/grafik') ? 'Dalam Grafik': '') )))}}
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li> <a class="dropdown-item {{ Request::is('berita-aggregator/semua') ? 'font-weight-bolder' : '' }}" href="{{ url('/berita-aggregator/semua')}}"> Semua Website Korea </a> </li>
                    <li> <a class="dropdown-item {{ Request::is('berita-aggregator/dsp') ? 'font-weight-bolder' : '' }}" href="{{ url('/berita-aggregator/dsp')}}"> Dispatch </a> </li>
                    <li> <a class="dropdown-item {{ Request::is('berita-aggregator/ktm') ? 'font-weight-bolder' : '' }}" href="{{ url('/berita-aggregator/ktm')}}"> The Korea Times </a> </li>
                    <li> <a class="dropdown-item {{ Request::is('berita-aggregator/khd') ? 'font-weight-bolder' : '' }}" href="{{ url('/berita-aggregator/khd')}}"> Korea Herald </a> </li>
                    <li> <a class="dropdown-item {{ Request::is('berita-aggregator/grafik') ? 'font-weight-bolder' : '' }}" href="{{ url('/berita-aggregator/grafik')}}"> Dalam Grafik </a> </li>
                </ul>
            </div>
            {{-- <a href="{{ url('konten/'.$web) }}" class="btn bg-gradient-secondary btn-sm mb-0" type="button">Ulangi Ambil Database</a>--}}
          </div>
        </div>
{{-- dari user-management --}}
            <div class="card-body px-0 pt-0 pb-2">
                @if($pesan[0] == 'salah' && $web != 'grafik')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white font-weight-bold">
                        Terdapat Kesalahan Jumlah Data dari Hasil Crawler dan Seleksi Ambil Data Konten. {{$pesan[1].' link'}}
                    </span>
                </div>
                @endif
                @if($web != 'grafik')
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    No.
                                </th>
                                <th class="col-md-3 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    Website
                                </th>
                                <th class="col-md-3 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    Level
                                </th>
                                <th class="col-md-3 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    Tanggal Crawler (Terbaru)
                                </th>
                                {{-- <th class="text-center col-md-5 text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    Link
                                </th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    Jumlah Konten
                                </th>--}}
                                <th class="col-md-3 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                    Detail
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--10 ganti count($berita)-->
                            @for ($i = 0; $i < count($berita); $i++)
                            <tr>
                                <td class="text-dark ps-4">
                                    <p class="text-sm font-weight-bold m-0 p-0">
                                        {{-- {{ ($i+1) < 10 ? '000'.($i+1) : (($i+1) < 100 ? '00'.($i+1) : (($i+1) < 1000 ? '0'.($i+1) : ($i+1)) ) }} --}}
                                        {{ ($i+1) }}.
                                    </p>
                                </td>
                                <td class="{{ $berita[$i]['web'] == 1 ? 'text-info text-gradient' : ($berita[$i]['web'] == 2 ? 'text-success text-gradient' : 'text-secondary') }} text-center">
                                    <p class="text-sm font-weight-bold m-0 p-0">
                                        {{ $berita[$i]['web'] == 1 ? 'Dispatch' : ($berita[$i]['web'] == 2 ? 'The Korea Times' : 'Korea Herald') }}
                                    </p>
                                </td>
                                <td class="text-dark text-center">
                                    <p class="text-sm font-weight-bold m-0 p-0">
                                        Level {{$berita[$i]['level']}}
                                    </p>
                                </td>
                                <td class="text-dark text-center">
                                    <p class="text-sm font-weight-bold m-0 p-0">
                                        {{$berita[$i]['tanggal']}}
                                    </p>
                                </td>
                                {{-- <td class="{{ $berita[$i]['web'] == 1 ? 'text-info text-gradient' : ($berita[$i]['web'] == 2 ? 'text-success text-gradient' : 'text-secondary') }} text-center">
                                    <a href="{{$berita[$i]['link']}}" target="_blank" class="text-sm font-weight-bold m-0 p-0"
                                        title="Link ID {{$berita[$i]['id']}}">
                                        {{$berita[$i]['link']}} <i class="fas fa-link opacity-10 ps-2"></i>
                                    </a>
                                </td>
                                <td class="{{ $berita[$i]['web'] == 1 ? 'text-info text-gradient' : ($berita[$i]['web'] == 2 ? 'text-success text-gradient' : 'text-secondary') }} text-center">
                                    <p class="text-sm font-weight-bold m-0 p-0">
                                        {{$berita[$i]['jumlah']}}
                                    </p>
                                </td>--}}
                                <td class="text-center">
                                    <form action="/detail-aggregator" method="POST" role="form" class="m-0 p-0">
                                        {{-- 'my-auto' target="_blank"--}}
                                        @csrf
                                        <input type="hidden" id="web" name="web" value="{{$berita[$i]['web']}}">
                                        <input type="hidden" id="level" name="level" value="{{$berita[$i]['level']}}">
                                        <input type="hidden" id="tanggal" name="tanggal" value="{{$berita[$i]['tanggal']}}">
                                        <input type="hidden" id="jumlah" name="jumlah" value="{{$berita[$i]['jumlah']}}">
                                        <button type="submit" title="Buka Hasil Aggregator" class="btn-link text-lg btn m-0 p-0"> <!-- data-bs-toggle="modal" data-bs-target="#exampleModalMessage{{$i}}"-->
                                            <span class="text-sm text-dark text-capitalize font-weight-bold m-0 p-0"><strong>{{$berita[$i]['jumlah']}}</strong> Link </span> <i class="fas fa-folder-open text-dark ps-2" aria-hidden="true"></i>
                                        </button>
                                        {{-- <div class="input-group">
                                            <input type="text text-right" class="form-control" name="cari" placeholder="Artis Korea, Event, dan lainnya..." value="{{ $cari == null ? '' : $cari }}">
                                            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                        </div> --}}
                                    </form>
                                    <!-- Modal -->
                                    {{-- <div class="modal fade" id="exampleModalMessage{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h6 class="modal-title" id="exampleModalLabel">Daftar Link</h6>
                                            </div>
                                            <div class="modal-body">
                                                <span class="text-lg font-weight-bolder" id="exampleModalLabel">Jumlah Konten: {{$berita[$i]['jumlah'] == count($berita[$i]['links']) ? count($berita[$i]['links']) : '-'}}</span>
                                                <hr class="bg-dark">
                                                <table class="table">
                                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                                        No.
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                                        Admin
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                                        Link
                                                    </th>
                                                    @foreach ($berita[$i]['links'] as $idx => $item)
                                                    <tr>
                                                        <td class="text-center py-1 m-0">
                                                            <p class="text-sm font-weight-bold mb-0 {{ $berita[$i]['web'] == 1 ? 'text-info' : ($berita[$i]['web'] == 2 ? 'text-success' : 'text-secondary') }}">
                                                                {{$idx+1}}.
                                                            </p>
                                                        </td>
                                                        <td class="text-center py-1 m-0">
                                                            <p class="text-sm font-weight-bold mb-0 {{ $berita[$i]['web'] == 1 ? 'text-info' : ($berita[$i]['web'] == 2 ? 'text-success' : 'text-secondary') }}">
                                                                Crawler ({{$item['berita_admin'] == auth()->user()->id ? 'Anda' : 'ID '.$item['berita_admin']}}) - Konten ({{$item['konten_admin'] == auth()->user()->id ? 'Anda' : 'ID '.$item['konten_admin']}})
                                                            </p>
                                                        </td>
                                                        <td class="text-center py-1 m-0">
                                                            <a href="{{$item['link']}}" target="_blank" class="text-sm font-weight-bold mb-0
                                                            {{ $berita[$i]['web'] == 1 ? 'text-info' : ($berita[$i]['web'] == 2 ? 'text-success' : 'text-secondary') }}"
                                                                title="{{$item['link']}}">
                                                                <i class="fas fa-link opacity-10 ps-2"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" id="berita" name="berita" value="{{$item['berita']}}">
                                                <input type="hidden" id="konten" name="konten" value="{{$item['konten']}}">
                                              <button type="button" class="btn btn-outline-{{ $berita[$i]['web'] == 1 ? 'info' : ($berita[$i]['web'] == 2 ? 'success' : 'secondary') }}" data-bs-dismiss="modal">Kembali</button>
                                              <button type="button" class="btn bg-gradient-{{ $berita[$i]['web'] == 1 ? 'info' : ($berita[$i]['web'] == 2 ? 'success' : 'secondary') }}">Print</button>
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
                @else
                <div class="col-lg-12">
                  <div class="card-body p-3">
                    <div class="chart">
                      <canvas id="line-chart" class="chart chart-canvas" height="300"></canvas>
                    </div>
                  </div>
                </div>
                @endif
            </div>
{{-- end dari user-management --}}
        </div>
    </div>
</div>
</div>
{{-- dari link(JANGAN HILANG) --}}

@endsection
<script type="text/javascript">
    window.onload = function() {
    var ctx2 = document.getElementById("line-chart").getContext("2d");
    // var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
    // gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
    // gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    // gradientStroke1.addColorStop(0, 'rgba(203,0,159,0)'); //purple colors

    // var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
    // gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
    // gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    // gradientStroke2.addColorStop(0, 'rgba(0,23,39,0)'); //purple colors

    // var gradientStroke3 = ctx2.createLinearGradient(0, 230, 0, 50);
    // gradientStroke3.addColorStop(1, 'rgba(93,12,100,0.2)');
    // gradientStroke3.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    // gradientStroke3.addColorStop(0, 'rgba(203,12,0,0)'); //purple colors

    let dataY = [];
    // let berita = @json($berita);//document.getElementById("berita").value();
    let totalBulan = @json($totalBulan);//document.getElementById("berita").value();

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: [
          // "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
          'Juli','Agustus', 'September', 'Oktober', 'November', 'Desember', '2024'
          ],
        datasets: [{
            label: 'Dispatch',
            // tension: 0.4,
            // borderWidth: 0,
            // pointRadius: 2,
            // pointBackgroundColor: "#e3316e",
            // borderColor: "#e3316e",
            // borderWidth: 3,
            // backgroundColor: 'transparent',

            tension: 0.4,
            borderWidth: 0,
            pointRadius: 2,
            pointBackgroundColor: "#03a9f4",
            borderColor: "#03a9f4",
            borderWidth: 3,
            backgroundColor: 'transparent',//gradientStroke1,
            fill: true,
            data: [
                // 50, 40, 300, 220, 500, 250, 400, 230, 500
                totalBulan[7]['Dispatch'],
                // 0,
                totalBulan[8]['Dispatch'],
                totalBulan[9]['Dispatch'],
                totalBulan[10]['Dispatch'],
                totalBulan[11]['Dispatch'],
                totalBulan[12]['Dispatch'],
                0
            ],
            maxBarThickness: 6
          },
          {
            label: "The Korea Times",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 2,//0,
            pointBackgroundColor: "#4caf50",
            borderColor: "#4caf50",
            borderWidth: 3,
            backgroundColor: 'transparent',//gradientStroke2,
            fill: true,
            data: [
                // 30, 90, 40, 140, 290, 290, 340, 230, 400
                totalBulan[7]['The Korea Times'],
                // 0,
                totalBulan[8]['The Korea Times'],
                totalBulan[9]['The Korea Times'],
                totalBulan[10]['The Korea Times'],
                totalBulan[11]['The Korea Times'],
                totalBulan[12]['The Korea Times'],
                0
            ],
            maxBarThickness: 6
          },
          {
            label: "Korea Herald",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 2,//0,
            pointBackgroundColor: "#7b809a",
            borderColor: "#7b809a",
            borderWidth: 3,
            backgroundColor: 'transparent',//gradientStroke3,
            fill: true,
            data: [
                // 30, 90, 40, 140, 290, 290, 340, 230, 400
                totalBulan[7]['Korea Herald'],
                // 0,
                totalBulan[8]['Korea Herald'],
                totalBulan[9]['Korea Herald'],
                totalBulan[10]['Korea Herald'],
                totalBulan[11]['Korea Herald'],
                totalBulan[12]['Korea Herald'],
                0
            ],
            maxBarThickness: 6
          },
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
