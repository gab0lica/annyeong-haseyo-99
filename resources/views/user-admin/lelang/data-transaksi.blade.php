@extends('layouts.user_type.auth')

@section('content')

{{-- kode asli di konten.blade.php --}}

<div class="row">
    <div class="col-12">
      <div class="mb-4">
        <div class="pb-0">
        </div>
      </div>
    </div>
</div>
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
            <div class="col-md-9">
                <h5 class="font-weight-bolder mb-0">
                    Transaksi Lelang
                    <span class="text-dark text-gradient text-sm font-weight-bolder align-bottom ps-4">
                        <i class="fa fa-check-circle text-dark text-gradient p-1" aria-hidden="true"></i> {{$admin[0]}} Lelang yang Ditugaskan
                    </span>
                    <span class="text-success text-gradient text-sm font-weight-bolder align-bottom ps-4">
                        <i class="fa fa-check-circle text-success text-gradient p-1" aria-hidden="true"></i> {{$selesai}} Lelang Selesai
                    </span>
                </h5>
            </div>
            <a href="{{ url('/lelang/daftar') }}"
                class="btn bg-gradient-secondary font-weight-bolder text-white btn-sm mb-0" type="button">
                Semua Daftar Lelang<i class="fas fa-file-invoice text-white mx-1 text-sm" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                No.
                            </th>
                            <th class="text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                username penjual
                            </th>
                            <th class="col-md-2 text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                Judul / Nama Produk
                            </th>
                            {{-- <th class="col-md-4 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                Koin Penawaran Awal
                            </th> --}}
                            <th class="col-md-2 text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                Jumlah Penawaran Akhir
                            </th>
                            <th class="col-md-2 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                Persentase Penghasilan
                            </th>
                            {{-- <th class="col-md-2 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                Jumlah Penawar
                            </th> --}}
                            <th class="text-center text-capitalize text-secondary text-sm font-weight-bolder opacity-7">
                                Detail Lelang
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($lelang) == 0)
                        <tr>
                            <td class="ps-4"></td>
                            <td class="ps-4"></td>
                            {{-- <td class="ps-4"></td> --}}
                            <td class="ps-4 mb-0 text-sm text-center font-weight-bolder">Belum Terdaftar Transaksi Lelang</td>
                            <td class="ps-4"></td>
                            <td class="ps-4"></td>
                            <td class="ps-4"></td>
                        </tr>
                        @else
                        @php
                            $index = 1;
                        @endphp
                        @for ($i = 0; $i < count($lelang); $i++)
                        @if ($lelang[$i]['admin'] == auth()->user()->id)
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
                            {{-- <td class="text-center">
                                <p class="text-dark font-weight-bold text-sm mb-0">{{$lelang[$i]['harga']}}</p>
                            </td> --}}
                            <td class="text-center">
                                <p class="text-dark font-weight-bold text-sm mb-0">{{($lelang[$i]['pemenang'])*-1}} <i class="px-1 fas fa-coins text-gradient text-warning" aria-hidden="true"></i></p>
                                {{-- <p class="text-dark font-weight-bold text-sm mb-0">{{$lelang[$i]['mulai'].' - '}}
                                    <span class="text-success font-weight-bolder text-sm">{{$lelang[$i]['selesai']}}</span>
                                </p> --}}
                            </td>
                            <td class="text-center">
                                <p class="text-dark font-weight-bold text-sm mb-0">{{$lelang[$i]['persenadmin']}} <i class="px-1 fas fa-coins text-gradient text-success" aria-hidden="true"></i></p>
                            </td>
                            <td class="text-center">
                                <a href="{{ url('detail-lelang/'.$lelang[$i]['lelang']) }}"
                                    class="{{ Request::is('detail-lelang/'.$lelang[$i]['lelang']) ? 'active' : '' }}"
                                    target="_blank" type="button" title="Lihat Lelang {{$lelang[$i]['lelang']}}">
                                    <i class="fas fa-file-invoice text-lg text-dark me-2" aria-hidden="true"></i>
                                </a>
                                <i class="fa fa-{{$lelang[$i]['status'] == 3 ? 'check text-success' : 'hourglass-half text-dark'}}" aria-hidden="true"></i>
                                {{-- <button type="button" class="btn-link btn m-0 p-0" data-bs-toggle="modal" data-bs-target="#exampleModalMessage{{$i}}">
                                    <a href="#"
                                    {{ url('user/'.$user.'/'.$lelang[$i]['id']) }}
                                        class="{{ Request::is('user/'.$user.'/'.$lelang[$i]['id']) ? 'active' : '' }}"
                                        type="button"
                                        title="User ID {{$lelang[$i]['id']}}"
                                         target="_blank"
                                        ><!--  -->
                                        <i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>
                                    </a>
                                </button> --}}
                                <!-- Modal -->
                                {{-- <div class="modal fade" id="exampleModalMessage{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
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
                                </div> --}}
                            </td>
                        </tr>
                        @php
                            $index += 1;
                        @endphp
                        @endif
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
