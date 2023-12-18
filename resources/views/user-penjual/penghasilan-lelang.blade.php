@extends('layouts.user_type.auth')

@section('content')

  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Semua Lelang</p>
                <h5 class="font-weight-bolder mb-0">
                  {{count($master)}}
                  <span class="text-secondary text-sm font-weight-bolder">Lelang</span>
                  {{-- <span class="text-success text-sm font-weight-bolder">+55%</span> --}}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fas fa-store text-lg opacity-10" aria-hidden="true"></i>
                {{-- <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Lelang yang Berjalan</p>
                <h5 class="font-weight-bolder mb-0">
                    {{$berjalan}}
                    {{-- 2,300 --}}
                  <span class="text-secondary text-sm font-weight-bolder">Lelang</span>
                  {{-- <span class="text-success text-sm font-weight-bolder">+3%</span> --}}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md">
                <i class="fas fa-hourglass-half text-lg opacity-10" aria-hidden="true"></i>
                {{-- <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Penawaran Awal</p>
                <h5 class="font-weight-bolder mb-0">
                  {{$awal}}
                  {{-- +3,462 --}}
                  <span class="text-secondary text-sm font-weight-bolder">Koin</span>
                  {{-- <span class="text-danger text-sm font-weight-bolder">-2%</span> --}}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                <i class="fas fa-coins text-lg opacity-10" aria-hidden="true"></i>
                {{-- <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Keuntungan</p>
                @php
                    $persen = ($akhir - $ongkir - $awal)/100;
                @endphp
                <h5 class="font-weight-bolder {{$persen < 0 ? 'text-danger' : 'text-dark'}} mb-0">
                    <i class="fas fa-arrow-{{$persen < 0 ? 'down text-danger' : 'up text-success'}} text-gradient text-md opacity-10" aria-hidden="true"></i>
                    {{$persen < 0 ? '(-)'.($persen)*-1 : $persen}}
                    {{-- {{$akhir.",".$awal.';'.$ongkir}} --}}
                    {{-- $103,430 --}}
                    <span class="text-secondary text-sm font-weight-bolder">%</span>
                  {{-- <span class="text-success text-sm font-weight-bolder">+5%</span> --}}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-{{($akhir-$awal)/100 < 0 ? 'danger' : 'success'}} shadow text-center border-radius-md">
                <i class="fas fa-percent text-lg opacity-10" aria-hidden="true"></i>
                {{-- <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- <div class="row mt-4">
    <div class="col-lg-7 mb-lg-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-lg-6">
              <div class="d-flex flex-column h-100">
                <p class="mb-1 pt-2 text-bold">Built by developers</p>
                <h5 class="font-weight-bolder">Soft UI Dashboard</h5>
                <p class="mb-5">From colors, cards, typography to complex elements, you will find the full documentation.</p>
                <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                  Read More
                  <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
              </div>
            </div>
            <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0">
              <div class="bg-gradient-primary border-radius-lg h-100">
                <img src="../assets/img/shapes/waves-white.svg" class="position-absolute h-100 w-50 top-0 d-lg-block d-none" alt="waves">
                <div class="position-relative d-flex align-items-center justify-content-center h-100">
                  <img class="w-100 position-relative z-index-2 pt-4" src="../assets/img/illustrations/rocket-white.png" alt="rocket">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card h-100 p-3">
        <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('../assets/img/ivancik.jpg');">
          <span class="mask bg-gradient-dark"></span>
          <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
            <h5 class="text-white font-weight-bolder mb-4 pt-2">Work with the rockets</h5>
            <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p>
            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
              Read More
              <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div> --}}
  <div class="row mt-4">
    {{-- <h3 id="mixed-chart-example">Mixed chart example</h3> --}}
    <div class="col-lg-12 mb-lg-0 mb-4">
      <div class="card mb-3">
        <div class="card-body p-3">
          <div class="chart">
            <canvas id="mixed-chart" class="chart-canvas" height="375" width="683" style="display: block; box-sizing: border-box; height: 300px; width: 547.1px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row my-4">
    <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-7">
              <h5>Transaksi Penghasilan Lelang</h5>
              <p class="text-sm mb-0 me-2">
                <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                <span class="font-weight-bold ms-1">{{$selesai}}</span> Lelang telah Selesai
              </p>
              {{-- <p class="text-sm mb-0">
                <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                <span class="font-weight-bold ms-1">{{$selesai}}</span> Lelang telah Selesai
              </p> --}}
            </div>
            <div class="col-5 text-end">
                <a href="{{ url('/master-lelang/semua') }}" class="btn bg-gradient-primary btn-md m-1">
                    Kembali ke Master Lelang <i class="fas fa-store text-lg text-white mx-1" aria-hidden="true"></i>
                </a>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-capitalize text-secondary text-xs font-weight-bolder opacity-7">
                            No.
                        </th>
                        <th class="col-md-2 text-center text-capitalize text-secondary text-xs font-weight-bolder opacity-7">
                            Nama Produk
                        </th>
                        <th class="col-md-2 text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                            Koin Penawaran Awal
                        </th>
                        {{-- <th class="col-md-2 text-center text-capitalize text-secondary text-xs font-weight-bolder opacity-7">
                            Jumlah Penawaran Akhir
                        </th> --}}
                        <th class="col-md-2 text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                            Penghasilan Akhir
                        </th>
                        <th class="col-md-2 text-center text-capitalize text-secondary text-xs font-weight-bolder opacity-7">
                            Jumlah Penawar
                        </th>
                        <th class="text-center text-capitalize text-secondary text-xs font-weight-bolder opacity-7">
                            Detail Lelang
                        </th>
                        <th class="col-md-2 text-center text-capitalize text-secondary text-xs font-weight-bolder opacity-7">
                            Status Transaksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($master) == 0)
                    <tr>
                        <td class="ps-4"></td>
                        <td class="ps-4"></td>
                        <td class="ps-4"></td>
                        <td class="ps-4 mb-0 text-sm text-center font-weight-bolder">Belum ada Penghasilan Lelang</td>
                        <td class="ps-4"></td>
                        <td class="ps-4"></td>
                        <td class="ps-4"></td>
                    </tr>
                    @else
                    @for ($i = 0; $i < count($master); $i++)
                    <tr class="text-dark">
                        <td class="ps-4">
                            <p class="font-weight-bold text-sm mb-0">{{$i+1}}.</p>
                        </td>
                        <td class="text-center">
                            <p class="font-weight-bold text-sm mb-0">{{$master[$i]['judul']}}</p>
                        </td>
                        <td class="text-center">
                            <span class="font-weight-bolder text-md mb-0">{{$master[$i]['koin']}} <i class="p-1 fas fa-coins text-gradient text-warning" aria-hidden="true"></i></span>
                        </td>
                        {{-- <td class="text-center">
                            <p class="font-weight-bold text-sm mb-0">{{($master[$i]['pemenang'])*-1}} <i class="p-1 fas fa-coins text-gradient text-warning" aria-hidden="true"></i></p>
                        </td> --}}
                        <td class="text-center">
                            <span class="font-weight-bolder text-md mb-0">{{$master[$i]['penjual']}} </span>
                            <span class="font-weight-bold text-sm mb-0">dari {{($master[$i]['pemenang'])*-1}} <i class="p-1 fas fa-coins text-gradient text-success" aria-hidden="true"></i></span>
                            {{-- <i class="px-1 fas {{ $master[$i]['status'] == 0 ? 'fa-ban text-danger' : 'fa-check-circle text-success'}}" aria-hidden="true"></i> --}}
                        </td>
                        <td class="text-center">
                            <p class="font-weight-bold text-sm mb-0">
                                {{$master[$i]['jumlahpenawar']}} <i class="px-1 fas fa-user-check" aria-hidden="true"></i>
                            </p>
                            {{-- <p class="font-weight-bold text-sm mb-0">{{$master[$i]['produk']}}</p> --}}
                            {{-- <p class="font-weight-{{$master[$i]['admin'] == auth()->user()->id ? 'bolder' : 'bold'}} text-sm mb-0">
                                {{$master[$i]['admin'] == auth()->user()->id ? 'Anda' : "ID ".$master[$i]['admin']}}
                            </p> --}}
                        </td>
                        <td class="text-center">
                            <a href="{{ url('form-lelang/'.$master[$i]['id']) }}"
                                class="{{ Request::is('form-lelang/'.$master[$i]['id']) ? 'active' : '' }}"
                                target="_blank" type="button" title="Lihat Lelang {{$master[$i]['id']}}">
                                <i class="fas fa-file-invoice text-lg text-dark me-2" aria-hidden="true"></i>
                            </a>
                            <i class="fa fa-{{$master[$i]['status'] == 3 ? 'check-circle text-success' : 'hourglass-half text-dark'}} text-gradient" aria-hidden="true"></i>
                        </td>
                        <td class="text-center">
                            <i class="fa fa-{{$master[$i]['penjualstatus'] == "Berhasil" ? 'check-circle text-success' : 'hourglass-half text-dark'}} text-gradient" aria-hidden="true"></i>
                        </td>
                    </tr>
                    @endfor
                    @endif
                </tbody>
            </table>
        </div>
        </div>
    </div>
  </div>


@endsection

@push('dashboard')
  <script>
    window.onload = function() {
      //untuk penawaran
    let label = @json($label);
    let koinawal = @json($koinawal);
    let koinakhir = @json($koinakhir);

      // Mixed chart
      var ctx7 = document.getElementById("mixed-chart").getContext("2d");
      new Chart(ctx7, {
        data: {
          labels: label
        //   ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
          ,
          datasets: [{
              type: "bar",
              label: "Koin Penawaran Awal",
              weight: 5,
              tension: 0.4,
              borderWidth: 0,
              pointBackgroundColor: "#fb8c00",
              borderColor: "#fb8c00",
              backgroundColor: '#fb8c00',
              borderRadius: 4,
              borderSkipped: false,
              data: koinawal
            //   [50, 40, 300, 220, 500, 250, 400, 230, 500]
              ,
            //   maxBarThickness: 10,
              fill: true,
            },
            {
              type: "bar",//line
              label: "Penghasilan Akhir",
              weight: 5,
              tension: 0.4,
              borderWidth: 0,
              pointBackgroundColor: "#4caf50",
              borderColor: "#4caf50",
              backgroundColor: '#4caf50',
              borderRadius: 4,
              borderSkipped: false,

            //   tension: 0.4,
            //   borderWidth: 0,
            //   pointRadius: 0,
            //   pointBackgroundColor: "#4caf50",
            //   borderColor: "#4caf50",
            //   borderWidth: 3,
            //   backgroundColor: 'transparent',
              data: koinakhir
            //   [30, 90, 40, 140, 290, 290, 340, 230, 400]
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


      // //chart contoh
      // var ctx = document.getElementById("chart-bars").getContext("2d");
      // new Chart(ctx, {
      //   type: "bar",
      //   data: {
      //     labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      //     datasets: [{
      //       label: "Sales",
      //       tension: 0.4,
      //       borderWidth: 0,
      //       borderRadius: 4,
      //       borderSkipped: false,
      //       backgroundColor: "#fff",
      //       data: [450, 200, 800, 220, 500, 100, 400, 230, 500],
      //       maxBarThickness: 6
      //     },
      //     {
      //       label: "Sales",
      //       tension: 0.4,
      //       borderWidth: 0,
      //       borderRadius: 4,
      //       borderSkipped: false,
      //       backgroundColor: "#fff",
      //       data: [450, 100, 400, 230, 500, 200, 800, 220, 500],
      //       maxBarThickness: 6
      //     },
      //     {
      //       label: "Sales",
      //       tension: 0.4,
      //       borderWidth: 0,
      //       borderRadius: 4,
      //       borderSkipped: false,
      //       backgroundColor: "#fff",
      //       data: [450, 500, 100, 200, 800, 220, 400, 230, 500],
      //       maxBarThickness: 6
      //     },],
      //   },
      //   options: {
      //     responsive: true,
      //     maintainAspectRatio: false,
      //     plugins: {
      //       legend: {
      //         display: false,
      //       }
      //     },
      //     interaction: {
      //       intersect: false,
      //       mode: 'index',
      //     },
      //     scales: {
      //       y: {
      //         grid: {
      //           drawBorder: false,
      //           display: false,
      //           drawOnChartArea: false,
      //           drawTicks: false,
      //         },
      //         ticks: {
      //           suggestedMin: 0,
      //           suggestedMax: 500,
      //           beginAtZero: true,
      //           padding: 15,
      //           font: {
      //             size: 14,
      //             family: "Open Sans",
      //             style: 'normal',
      //             lineHeight: 2
      //           },
      //           color: "#fff"
      //         },
      //       },
      //       x: {
      //         grid: {
      //           drawBorder: false,
      //           display: false,
      //           drawOnChartArea: false,
      //           drawTicks: false
      //         },
      //         ticks: {
      //           display: false
      //         },
      //       },
      //     },
      //   },
      // });

      // var ctx2 = document.getElementById("chart-line").getContext("2d");
      // var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
      // gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      // gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      // gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

      // var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
      // gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      // gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      // gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

      // new Chart(ctx2, {
      //   type: "line",
      //   data: {
      //     labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      //     datasets: [{
      //         label: "Mobile apps",
      //         tension: 0.4,
      //         borderWidth: 0,
      //         pointRadius: 0,
      //         borderColor: "#cb0c9f",
      //         borderWidth: 3,
      //         backgroundColor: gradientStroke1,
      //         fill: true,
      //         data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
      //         maxBarThickness: 6

      //       },
      //       {
      //         label: "Websites",
      //         tension: 0.4,
      //         borderWidth: 0,
      //         pointRadius: 0,
      //         borderColor: "#3A416F",
      //         borderWidth: 3,
      //         backgroundColor: gradientStroke2,
      //         fill: true,
      //         data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
      //         maxBarThickness: 6
      //       },
      //     ],
      //   },
      //   options: {
      //     responsive: true,
      //     maintainAspectRatio: false,
      //     plugins: {
      //       legend: {
      //         display: false,
      //       }
      //     },
      //     interaction: {
      //       intersect: false,
      //       mode: 'index',
      //     },
      //     scales: {
      //       y: {
      //         grid: {
      //           drawBorder: false,
      //           display: true,
      //           drawOnChartArea: true,
      //           drawTicks: false,
      //           borderDash: [5, 5]
      //         },
      //         ticks: {
      //           display: true,
      //           padding: 10,
      //           color: '#b2b9bf',
      //           font: {
      //             size: 11,
      //             family: "Open Sans",
      //             style: 'normal',
      //             lineHeight: 2
      //           },
      //         }
      //       },
      //       x: {
      //         grid: {
      //           drawBorder: false,
      //           display: false,
      //           drawOnChartArea: false,
      //           drawTicks: false,
      //           borderDash: [5, 5]
      //         },
      //         ticks: {
      //           display: true,
      //           color: '#b2b9bf',
      //           padding: 20,
      //           font: {
      //             size: 11,
      //             family: "Open Sans",
      //             style: 'normal',
      //             lineHeight: 2
      //           },
      //         }
      //       },
      //     },
      //   },
      // });
    }
  </script>
@endpush

