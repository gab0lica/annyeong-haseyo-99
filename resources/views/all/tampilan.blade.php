{{-- belum tau ttg apa tapi kayak dashboard/berita.blade --}}
@extends('layouts.user_type.auth')

@section('content')

{{-- dari dashboard, dimodifikasi --}}
  <!-- content ke-1 -->
  {{-- tambah berita, class tambah mt-4 --}}
  <div class="row mt-4">
    <div class="col-lg-7 mb-lg-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-lg-6">
              <div class="d-flex flex-column h-100">
                <p class="mb-1 pt-2 text-bold">{{$berita[0]['tgl']}}</p>
                <h5 class="font-weight-bolder">{{$berita[0]['judul']}}</h5>
                <p class="mb-5">{{$berita[0]['desk']}}</p>
                <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[0]['link']}}">
                  Read More
                  <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
              </div>
            </div>
            <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0">
                <div class="position-relative d-flex align-items-center justify-content-center h-100">
                    {{-- tambar gambar dalam img > src, class hapus pt-4 dan h-100 dan tambah border-radius-lg --}}
                  <img class="w-100 position-relative z-index-2 border-radius-lg" src="{{$berita[0]['gambar']}}" alt="rocket">
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card h-100 p-3">
        <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url({{$berita[1]['gambar']}});">
          <span class="mask bg-gradient-dark"></span>
          <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
            {{-- tambah p buat tgl --}}
            <p class="mb-1 pt-2 text-white">{{$berita[1]['tgl']}}</p>
            <h5 class="text-white font-weight-bolder mb-4 pt-2">{{$berita[1]['judul']}}</h5>
            <p class="text-white">{{$berita[1]['desk']}}</p>
            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[1]['link']}}">
              Read More
              <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- end tambah berita --}}
  {{-- tambah berita (1 kolum kiri) --}}
  <div class="row mt-4">
    <div class="col-lg-12">
      <div class="card h-100 p-3">
        {{-- tambah gambar dalam div > style:background --}}
        <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url({{$berita[2]['gambar']}});">
          <span class="mask bg-gradient-dark"></span>
          <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
            <p class="mb-1 pt-2 text-white">{{$berita[2]['tgl']}}</p>
            <h5 class="text-white font-weight-bolder mb-4 pt-2">{{$berita[2]['judul']}}</h5>
            <p class="text-white">{{$berita[2]['desk']}}</p>
            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[2]['link']}}">
              Read More
              <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- end tambah berita (1 kolum kiri) --}}
  {{-- tambah berita (1 kolum kanan) --}}
  <div class="row mt-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-lg-6">
              <div class="d-flex flex-column h-100">
                <p class="mb-1 pt-2 text-bold">{{$berita[3]['tgl']}}</p>
                <h5 class="font-weight-bolder">{{$berita[3]['judul']}}</h5>
                <p class="mb-5">{{$berita[3]['desk']}}</p>
                <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[3]['link']}}">
                  Read More
                  <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
              </div>
            </div>
            <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0">
                <div class="position-relative d-flex align-items-center justify-content-center h-100">
                    {{-- tambar gambar dalam img > src, class hapus pt-4 dan tambah border-radius-lg h-100 --}}
                  <img class="w-100 position-relative z-index-2 border-radius-lg h-100" src="{{$berita[3]['gambar']}}" alt="rocket">
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- end tambah berita (1 kolum kanan) --}}
  {{-- tambah berita (tukar kolum) --}}
  <div class="row mt-4">
    {{-- class tambah mb-lg-0 dan mb-4 --}}
    <div class="col-lg-5 mb-lg-0 mb-4">
      <div class="card h-100 p-3">
        <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url({{$berita[4]['gambar']}});">
          <span class="mask bg-gradient-dark"></span>
          <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
            <p class="mb-1 pt-2 text-white">{{$berita[4]['tgl']}}</p>
            <h5 class="text-white font-weight-bolder mb-4 pt-2">{{$berita[4]['judul']}}</h5>
            <p class="text-white">{{$berita[4]['desk']}}</p>
            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[4]['link']}}">
              Read More
              <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    {{-- class hapus mb-4 --}}
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            {{-- class hapus ms-auto dan mt-lg-0 dan mt-5 --}}
            <div class="col-lg-5 text-center">
                {{-- <div class="bg-gradient-primary border-radius-lg h-100"> --}}
                    <div class="position-relative d-flex align-items-center justify-content-center h-100">
                        {{-- tambar gambar dalam img > src, class hapus pt-4 dan h-100 dan tambah border-radius-lg --}}
                        <img class="w-100 position-relative z-index-2 border-radius-lg" src="{{$berita[5]['gambar']}}" alt="rocket">
                    </div>
              {{-- </div> --}}
            </div>
            {{-- class tambah ms-auto dan mt-lg-0 dan mt-5 --}}
            <div class="col-lg-6 ms-auto mt-lg-0 mt-5">
              <div class="d-flex flex-column h-100">
                <p class="mb-1 pt-2 text-bold">{{$berita[5]['tgl']}}</p>
                <h5 class="font-weight-bolder">{{$berita[5]['judul']}}</h5>
                <p class="mb-5">{{$berita[5]['desk']}}</p>
                <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[5]['link']}}">
                  Read More
                  <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- end tambah berita (tukar kolum) --}}
  {{-- tambah berita (1 kolum kanan tukar posisi) --}}
  <div class="row mt-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            {{-- tuker posisi gambar dan tulisan, class hapus  mt-lg-0 dan ms-auto dan mt-5 --}}
            <div class="col-lg-5 text-center">
                <div class="position-relative d-flex align-items-center justify-content-center h-100">
                    {{-- tambar gambar dalam img > src, class hapus pt-4 dan tambah border-radius-lg h-100 --}}
                  <img class="w-100 position-relative z-index-2 border-radius-lg h-100" src="{{$berita[6]['gambar']}}" alt="rocket">
                </div>
            </div>
            {{-- class tambah ms-auto dan mt-lg-0 dan mt-5 --}}
            <div class="col-lg-6 ms-auto mt-lg-0 mt-5">
              <div class="d-flex flex-column h-100">
                <p class="mb-1 pt-2 text-bold">{{$berita[6]['tgl']}}</p>
                <h5 class="font-weight-bolder">{{$berita[6]['judul']}}</h5>
                <p class="mb-5">{{$berita[6]['desk']}}</p>
                <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[6]['link']}}">
                  Read More
                  <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- end tambah berita (1 kolum kanan tukar posisi) --}}
  {{-- tambah berita (1 kolum kiri sama) --}}
  <div class="row mt-4">
    <div class="col-lg-12">
      <div class="card h-100 p-3">
        <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('../assets/img/ivancik.jpg');">
          <span class="mask bg-gradient-dark"></span>
          <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
            <p class="mb-1 pt-2 text-white">{{$berita[7]['tgl']}}</p>
            <h5 class="text-white font-weight-bolder mb-4 pt-2">{{$berita[7]['judul']}}</h5>
            <p class="text-white">{{$berita[7]['desk']}}</p>
            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[7]['link']}}">
              Read More
              <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- end tambah berita (1 kolum kiri sama) --}}

  <!-- content ke-2 -->
  {{-- tambah berita, class tambah mt-4 --}}
  <div class="row mt-4">
    <div class="col-lg-7 mb-lg-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-lg-6">
              <div class="d-flex flex-column h-100">
                <p class="mb-1 pt-2 text-bold">{{$berita[8]['tgl']}}</p>
                <h5 class="font-weight-bolder">{{$berita[8]['judul']}}</h5>
                <p class="mb-5">{{$berita[8]['desk']}}</p>
                <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[8]['link']}}">
                  Read More
                  <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
              </div>
            </div>
            <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0">
                <div class="position-relative d-flex align-items-center justify-content-center h-100">
                    {{-- tambar gambar dalam img > src, class hapus pt-4 dan h-100 dan tambah border-radius-lg --}}
                  <img class="w-100 position-relative z-index-2 border-radius-lg" src="{{$berita[8]['gambar']}}" alt="rocket">
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card h-100 p-3">
        <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url({{$berita[9]['gambar']}});">
          <span class="mask bg-gradient-dark"></span>
          <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
            {{-- tambah p buat tgl --}}
            <p class="mb-1 pt-2 text-white">{{$berita[9]['tgl']}}</p>
            <h5 class="text-white font-weight-bolder mb-4 pt-2">{{$berita[9]['judul']}}</h5>
            <p class="text-white">{{$berita[9]['desk']}}</p>
            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[9]['link']}}">
              Read More
              <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- end tambah berita --}}
  {{-- tambah berita (1 kolum kiri) --}}
  <div class="row mt-4">
    <div class="col-lg-12">
      <div class="card h-100 p-3">
        {{-- tambah gambar dalam div > style:background --}}
        <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url({{$berita[10]['gambar']}});">
          <span class="mask bg-gradient-dark"></span>
          <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
            <p class="mb-1 pt-2 text-white">{{$berita[10]['tgl']}}</p>
            <h5 class="text-white font-weight-bolder mb-4 pt-2">{{$berita[10]['judul']}}</h5>
            <p class="text-white">{{$berita[10]['desk']}}</p>
            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[10]['link']}}">
              Read More
              <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- end tambah berita (1 kolum kiri) --}}
  {{-- tambah berita (1 kolum kanan) --}}
  <div class="row mt-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-lg-6">
              <div class="d-flex flex-column h-100">
                <p class="mb-1 pt-2 text-bold">{{$berita[11]['tgl']}}</p>
                <h5 class="font-weight-bolder">{{$berita[11]['judul']}}</h5>
                <p class="mb-5">{{$berita[11]['desk']}}</p>
                <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[11]['link']}}">
                  Read More
                  <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
              </div>
            </div>
            <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0">
                <div class="position-relative d-flex align-items-center justify-content-center h-100">
                    {{-- tambar gambar dalam img > src, class hapus pt-4 dan tambah border-radius-lg h-100 --}}
                  <img class="w-100 position-relative z-index-2 border-radius-lg h-100" src="{{$berita[11]['gambar']}}" alt="rocket">
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- end tambah berita (1 kolum kanan) --}}
  {{-- tambah berita (tukar kolum) --}}
  <div class="row mt-4">
    {{-- class tambah mb-lg-0 dan mb-4 --}}
    <div class="col-lg-5 mb-lg-0 mb-4">
      <div class="card h-100 p-3">
        <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url({{$berita[12]['gambar']}});">
          <span class="mask bg-gradient-dark"></span>
          <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
            <p class="mb-1 pt-2 text-white">{{$berita[12]['tgl']}}</p>
            <h5 class="text-white font-weight-bolder mb-4 pt-2">{{$berita[12]['judul']}}</h5>
            <p class="text-white">{{$berita[12]['desk']}}</p>
            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[12]['link']}}">
              Read More
              <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    {{-- class hapus mb-4 --}}
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            {{-- class hapus ms-auto dan mt-lg-0 dan mt-5 --}}
            <div class="col-lg-5 text-center">
                {{-- <div class="bg-gradient-primary border-radius-lg h-100"> --}}
                    <div class="position-relative d-flex align-items-center justify-content-center h-100">
                        {{-- tambar gambar dalam img > src, class hapus pt-4 dan h-100 dan tambah border-radius-lg --}}
                        <img class="w-100 position-relative z-index-2 border-radius-lg" src="{{$berita[13]['gambar']}}" alt="rocket">
                    </div>
              {{-- </div> --}}
            </div>
            {{-- class tambah ms-auto dan mt-lg-0 dan mt-5 --}}
            <div class="col-lg-6 ms-auto mt-lg-0 mt-5">
              <div class="d-flex flex-column h-100">
                <p class="mb-1 pt-2 text-bold">{{$berita[13]['tgl']}}</p>
                <h5 class="font-weight-bolder">{{$berita[13]['judul']}}</h5>
                <p class="mb-5">{{$berita[13]['desk']}}</p>
                <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[13]['link']}}">
                  Read More
                  <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- end tambah berita (tukar kolum) --}}
  {{-- tambah berita (1 kolum kanan tukar posisi) --}}
  <div class="row mt-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            {{-- tuker posisi gambar dan tulisan, class hapus  mt-lg-0 dan ms-auto dan mt-5 --}}
            <div class="col-lg-5 text-center">
                <div class="position-relative d-flex align-items-center justify-content-center h-100">
                    {{-- tambar gambar dalam img > src, class hapus pt-4 dan tambah border-radius-lg h-100 --}}
                  <img class="w-100 position-relative z-index-2 border-radius-lg h-100" src="{{$berita[14]['gambar']}}" alt="rocket">
                </div>
            </div>
            {{-- class tambah ms-auto dan mt-lg-0 dan mt-5 --}}
            <div class="col-lg-6 ms-auto mt-lg-0 mt-5">
              <div class="d-flex flex-column h-100">
                <p class="mb-1 pt-2 text-bold">{{$berita[14]['tgl']}}</p>
                <h5 class="font-weight-bolder">{{$berita[14]['judul']}}</h5>
                <p class="mb-5">{{$berita[14]['desk']}}</p>
                <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{$berita[14]['link']}}">
                  Read More
                  <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- end tambah berita (1 kolum kanan tukar posisi) --}}
  {{-- tidak ada tambah berita (1 kolum kiri sama) --}}
{{-- end dari dashboard, dimodifikasi --}}


{{-- dari tables, original --}}
  {{-- from tables.blade.php, class tambah mt-4 --}}
      <div class="row mt-4">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Authors table</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Author</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Function</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employed</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">John Michael</h6>
                            <p class="text-xs text-secondary mb-0">john@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Manager</p>
                        <p class="text-xs text-secondary mb-0">Organization</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-success">Online</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">23/04/18</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-3.jpg" class="avatar avatar-sm me-3" alt="user2">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Alexa Liras</h6>
                            <p class="text-xs text-secondary mb-0">alexa@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Programator</p>
                        <p class="text-xs text-secondary mb-0">Developer</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-secondary">Offline</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">11/01/19</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user3">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Laurent Perrier</h6>
                            <p class="text-xs text-secondary mb-0">laurent@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Executive</p>
                        <p class="text-xs text-secondary mb-0">Projects</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-success">Online</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">19/09/17</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-3.jpg" class="avatar avatar-sm me-3" alt="user4">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Michael Levi</h6>
                            <p class="text-xs text-secondary mb-0">michael@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Programator</p>
                        <p class="text-xs text-secondary mb-0">Developer</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-success">Online</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">24/12/08</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user5">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Richard Gran</h6>
                            <p class="text-xs text-secondary mb-0">richard@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Manager</p>
                        <p class="text-xs text-secondary mb-0">Executive</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-secondary">Offline</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">04/10/21</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user6">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Miriam Eric</h6>
                            <p class="text-xs text-secondary mb-0">miriam@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Programtor</p>
                        <p class="text-xs text-secondary mb-0">Developer</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-secondary">Offline</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">14/09/20</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Projects table</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Budget</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Completion</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex px-2">
                          <div>
                            <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm rounded-circle me-2" alt="spotify">
                          </div>
                          <div class="my-auto">
                            <h6 class="mb-0 text-sm">Spotify</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">$2,500</p>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold">working</span>
                      </td>
                      <td class="align-middle text-center">
                        <div class="d-flex align-items-center justify-content-center">
                          <span class="me-2 text-xs font-weight-bold">60%</span>
                          <div>
                            <div class="progress">
                              <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle">
                        <button class="btn btn-link text-secondary mb-0">
                          <i class="fa fa-ellipsis-v text-xs"></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2">
                          <div>
                            <img src="../assets/img/small-logos/logo-invision.svg" class="avatar avatar-sm rounded-circle me-2" alt="invision">
                          </div>
                          <div class="my-auto">
                            <h6 class="mb-0 text-sm">Invision</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">$5,000</p>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold">done</span>
                      </td>
                      <td class="align-middle text-center">
                        <div class="d-flex align-items-center justify-content-center">
                          <span class="me-2 text-xs font-weight-bold">100%</span>
                          <div>
                            <div class="progress">
                              <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle">
                        <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-ellipsis-v text-xs"></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2">
                          <div>
                            <img src="../assets/img/small-logos/logo-jira.svg" class="avatar avatar-sm rounded-circle me-2" alt="jira">
                          </div>
                          <div class="my-auto">
                            <h6 class="mb-0 text-sm">Jira</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">$3,400</p>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold">canceled</span>
                      </td>
                      <td class="align-middle text-center">
                        <div class="d-flex align-items-center justify-content-center">
                          <span class="me-2 text-xs font-weight-bold">30%</span>
                          <div>
                            <div class="progress">
                              <div class="progress-bar bg-gradient-danger" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="30" style="width: 30%;"></div>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle">
                        <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-ellipsis-v text-xs"></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2">
                          <div>
                            <img src="../assets/img/small-logos/logo-slack.svg" class="avatar avatar-sm rounded-circle me-2" alt="slack">
                          </div>
                          <div class="my-auto">
                            <h6 class="mb-0 text-sm">Slack</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">$1,000</p>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold">canceled</span>
                      </td>
                      <td class="align-middle text-center">
                        <div class="d-flex align-items-center justify-content-center">
                          <span class="me-2 text-xs font-weight-bold">0%</span>
                          <div>
                            <div class="progress">
                              <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="0" style="width: 0%;"></div>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle">
                        <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-ellipsis-v text-xs"></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2">
                          <div>
                            <img src="../assets/img/small-logos/logo-webdev.svg" class="avatar avatar-sm rounded-circle me-2" alt="webdev">
                          </div>
                          <div class="my-auto">
                            <h6 class="mb-0 text-sm">Webdev</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">$14,000</p>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold">working</span>
                      </td>
                      <td class="align-middle text-center">
                        <div class="d-flex align-items-center justify-content-center">
                          <span class="me-2 text-xs font-weight-bold">80%</span>
                          <div>
                            <div class="progress">
                              <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="80" style="width: 80%;"></div>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle">
                        <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-ellipsis-v text-xs"></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2">
                          <div>
                            <img src="../assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm rounded-circle me-2" alt="xd">
                          </div>
                          <div class="my-auto">
                            <h6 class="mb-0 text-sm">Adobe XD</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">$2,300</p>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold">done</span>
                      </td>
                      <td class="align-middle text-center">
                        <div class="d-flex align-items-center justify-content-center">
                          <span class="me-2 text-xs font-weight-bold">100%</span>
                          <div>
                            <div class="progress">
                              <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle">
                        <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-ellipsis-v text-xs"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
{{-- end of tables.blade.php --}}


{{-- dari content from tables.blade.php --}}
    <!-- web content crawler -->
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <img src="../logo/khd.png" class="navbar-brand-img h-100" alt="Dispatch">
            </div>
            <h6>Level 1</h6>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Link</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($lv1 as $item)
                    <tr>
                      <td>
                        <div class="d-flex px-2">
                          <div class="my-auto">
                            <h6 class="mb-0 text-sm">{{$item}}</h6>
                          </div>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
    <!-- content aggregator -->
    <div class="row">
    <div class="col-12">
        <div class="pb-0">
            <img src="../logo/{{$web}}.png" class="navbar-brand-img w-30" alt="Korea Herald">
            <span class="text-sm font-weight-bold align-bottom ps-3">{{count($berita)}} datas</span>
        </div>
    </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
          <div class="card mb-4">
            <div class="pb-0">
                <span class="text-sm font-weight-bold align-bottom">{{count($berita)}} datas</span>
              <h6>Content Aggregator Korea Herald</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <img src="../logo/khd.png" class="navbar-brand-img h-100 ps-3" alt="Korea Herald">
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Judul</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Deskripsi</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Berita</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Link</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($berita as $item)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="{{$item['gambar']}}" class="avatar avatar-sm me-3" alt="user1">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{$item['judul']}}</h6>
                            <p class="text-xs text-secondary mb-0">Korea Herald</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{substr($item['desk'], 0, 20)}}...</p>
                        <p class="text-xs text-secondary mb-0">Korea Herald</p>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$item['tgl']}}</span>
                      </td>
                      <td class="align-middle">
                        <a href="{{$item['link']}}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    @endforeach
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-3.jpg" class="avatar avatar-sm me-3" alt="user2">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Alexa Liras</h6>
                            <p class="text-xs text-secondary mb-0">alexa@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Programator</p>
                        <p class="text-xs text-secondary mb-0">Developer</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-secondary">Offline</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">11/01/19</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user3">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Laurent Perrier</h6>
                            <p class="text-xs text-secondary mb-0">laurent@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Executive</p>
                        <p class="text-xs text-secondary mb-0">Projects</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-success">Online</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">19/09/17</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-3.jpg" class="avatar avatar-sm me-3" alt="user4">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Michael Levi</h6>
                            <p class="text-xs text-secondary mb-0">michael@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Programator</p>
                        <p class="text-xs text-secondary mb-0">Developer</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-success">Online</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">24/12/08</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user5">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Richard Gran</h6>
                            <p class="text-xs text-secondary mb-0">richard@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Manager</p>
                        <p class="text-xs text-secondary mb-0">Executive</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-secondary">Offline</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">04/10/21</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user6">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Miriam Eric</h6>
                            <p class="text-xs text-secondary mb-0">miriam@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Programtor</p>
                        <p class="text-xs text-secondary mb-0">Developer</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-secondary">Offline</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">14/09/20</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
{{-- end of content from tables.blade.php --}}


{{-- dari link.blade.php buat button edit --}}

                                {{-- dari web bootstrap: https://getbootstrap.com/docs/5.3/components/modal/#how-it-works --}}
                                    <!-- Button trigger example modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        Check
                                    </button>
                                    <!-- example Modal -->
                                    <div class="modal fade" id="staticBackdrop{{$i}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Checking</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ID {{$berita[$i]['id']}} adalah kPOP
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Understood</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                    <!-- Button trigger static modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Launch demo modal
                                    </button>
                                    <!-- static Modal -->
                                    <div class="modal fade" id="exampleModal{{$i}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Cek Konten</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @if($web=='ktm' && $berita[$i]['status']==2)
                                                ID {{$berita[$i]['id']}} adalah kPOP
                                                @elseif($web=='ktm')
                                                Konten untuk ID {{$berita[$i]['id']}} belum dicek
                                                @elseif($web != 'ktm')
                                                Konten untuk ID {{$berita[$i]['id']}} dari web {{$web}}
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                {{-- end dari web bootstrap --}}

                                {{-- dari documentation --}}
                                <div class="col-md-4">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">
                                      Message Modal
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
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
                                </div>
                                {{-- end dari documentation


{{-- from user-management.blade.php --}}
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Link Korea Herald</h5>
                    </div>
                    <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New User</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Nomor
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Gambar
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Judul
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Deskripsi
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Tanggal
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Link
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($berita as $item)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-xs font-weight-bold mb-0">1</p>
                                </td>
                                <td>
                                    <div>
                                        <img src="{{$item['gambar']}}" class="avatar avatar-sm me-3">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{$item['judul']}}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{$item['desk']}}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{$item['tgl']}}</p>
                                </td>
                                <td class="text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{$item['link']}}</span>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit user">
                                        <i class="fas fa-user-edit text-secondary"></i>
                                    </a>
                                    <span>
                                        <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- end of user-management.blade.php --}}


{{-- dari user-profile.blade.php --}}
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 px-3">
                <h5 class="font-weight-bolder mb-0">
                    Konten Link ID
                    <span class="text-sm font-weight-bold align-bottom ps-3"> {{$id}}</span>
                </h5>
                <h6 class="mb-0">{{ __('Profile Information') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="/user-profile" method="POST" role="form text-left">
                    @csrf
                    @if($errors->any())
                        <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                            {{$errors->first()}}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-name" class="form-control-label">{{ __('Full Name') }}</label>
                                <div class="@error('user.name')border border-danger rounded-3 @enderror">
                                    <input class="form-control" value="{{ auth()->user()->name }}" type="text" placeholder="Name" id="user-name" name="name">
                                        @error('name')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-email" class="form-control-label">{{ __('Email') }}</label>
                                <div class="@error('email')border border-danger rounded-3 @enderror">
                                    <input class="form-control" value="{{ auth()->user()->email }}" type="email" placeholder="@example.com" id="user-email" name="email">
                                        @error('email')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.phone" class="form-control-label">{{ __('Phone') }}</label>
                                <div class="@error('user.phone')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="tel" placeholder="40770888444" id="number" name="phone" value="{{ auth()->user()->phone }}">
                                        @error('phone')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.location" class="form-control-label">{{ __('Location') }}</label>
                                <div class="@error('user.location') border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text" placeholder="Location" id="name" name="location" value="{{ auth()->user()->location }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="about">{{ 'About Me' }}</label>
                        <div class="@error('user.about')border border-danger rounded-3 @enderror">
                            <textarea class="form-control" id="about" rows="3" placeholder="Say something about yourself" name="about_me">{{ auth()->user()->about_me }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save Changes' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- dari user-profile.blade.php --}}


{{-- dari KP --}}
{{-- <x-base-layout> --}}
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        {{-- <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search">
                        </div> --}}
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Filter-->
                            {{-- <a href="#" class="btn btn-light-success me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                {!! theme()->getSvgIcon("icons/duotone/Text/Filter.svg", "svg-icon-5 svg-icon-gray-500 me-1") !!}
                                Filter
                            </a>
                            {{ theme()->getView('partials/menus/_menu-1') }} --}}
                            <!--end::Filter-->

                            <!--begin::Add user-->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#kt_modal_add_shipping">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black"></rect>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                Add New Shipping Schedule
                            </button>
                            <!--end::Add user-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_table_users">
                            <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                        <th>No</th>
                                        <th>Supplier</th>
                                        <th>Driver</th>
                                        <th>Transportation</th>
                                        <th>Raw Material</th>
                                        <th>Status Shipping</th>
                                        <th>Action</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-bold" id="bodyShippingTable">

                                </tbody>
                                <!--end::Table body-->
                            </table>
                        </div>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--begin::MODAL ADD -->
        <div class="modal fade" tabindex="-1" id="kt_modal_add_shipping">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Shipping Form</h5>
                    </div>

                    <form id="form-create-shipping">
                        <div class="modal-body">
                            <h1>Supplier Data </h1>
                            <br>

                            <input type="hidden" name="createdBy" value="{{auth()->user()->id}}">
                            @csrf

                            Supplier's Email
                            <select id="supplierEmail" name="supplierEmail" class="form-control select2">
                            </select>

                            <br>

                            Supplier's Name
                            <input type="hidden" name="supplierID">
                            <input type="text" name="supplierName" id="supplierName" class="form-control" readonly>

                            <br>

                            Supplier's Phone
                            <input type="text" name="supplierPhone" id="supplierPhone" class="form-control" readonly>

                            <br>

                            Supplier's Address
                            <input type="text" name="supplierAddress" id="supplierAddress" class="form-control" readonly>

                            <br> <hr> <br>

                            <h1>Shipping's Date</h1>
                            <br>

                            Shipping's Date
                            <input type="date" name="shippingDate" id="shippingDate" class="form-control" required min="{{date('Y-m-d')}}" max="{{date('Y-m-d',strtotime("+1 month"))}}"/>

                            <br> <hr> <br>

                            <h1>Transportation and Raw Material Detail</h1>
                            <br>

                            Driver's Name
                            <input type="text" name="driverName" id="driverName" class="form-control">

                            <br>

                            Driver's Phone
                            <input type="text" name="driverPhone" id="driverPhone" class="form-control">

                            <br>

                            Transportation's Type
                            <select id="transportationType" name="transportationType" class="form-control select2">
                            </select>

                            <br>

                            License Plate
                            <input type="text" name="licensePlate" id="licensePlate" class="form-control">

                            <br>

                            Material Raw's Type
                            <select id="afvalType" name="afvalType" class="form-control select2">
                            </select>

                            <br>

                            Material Raw's Weight (Kg)
                            <input type="text" name="afvalWeight" id="afvalWeight" class="form-control">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal" id='btn-cancel-create'>Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!--end::MODAL ADD -->
    <!--begin::MODAL Detail -->
    <div class="modal fade" tabindex="-1" id="kt_modal_detail_shipping">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form-detail-shipping">
                    <div class="modal-body">
                        {{-- Judul --}}
                        <div>
                            <h1 class="text-center">SHIPPING DETAIL</h1>
                            <hr> <br>
                        </div>

                        <input type="hidden" name="checkerID" id="checkerID" value="{{auth()->user()->id}}">
                        {{-- Information --}}
                        <div>
                            <table>
                                <tr>
                                    <td style="width: 25vh">Created by</td>
                                    <td> : </td>
                                    <td id="detail-createdBy"></td>
                                </tr>
                                <tr>
                                    <td style="width: 25vh">Created at</td>
                                    <td> : </td>
                                    <td id="detail-createdAt"></td>
                                </tr>
                                <tr>
                                    <td style="width: 25vh">Shipping Type</td>
                                    <td> : </td>
                                    <td id="detail-shippingType"></td>
                                </tr>
                                <tr>
                                  <td style="width: 25vh">Status</td>
                                  <td> : </td>
                                  <td id="detail-shippingStatus"></td>

                                </tr>
                            </table>

                            <br><hr><br>
                        </div>

                        {{-- Supplier Data --}}
                        <div>
                            <h2>SUPPLIER DATA</h2>
                            <br>
                            <table>
                                <tr>
                                    <td style="width: 25vh">Name</td>
                                    <td> : </td>
                                    <td id="detail-supplierName"></td>
                                </tr>
                                <tr>
                                    <td style="width: 25vh">Email</td>
                                    <td> : </td>
                                    <td id="detail-supplierEmail"></td>
                                </tr>
                                <tr>
                                    <td style="width: 25vh">Phone</td>
                                    <td> : </td>
                                    <td id="detail-supplierPhone"></td>
                                </tr>
                                <tr>
                                  <td style="width: 25vh">Address</td>
                                  <td> : </td>
                                  <td id="detail-supplierAddress"></td>
                                </tr>
                            </table>
                            <br><hr><br>
                        </div>

                        {{-- Registration Data --}}
                        <div>
                            <h2>REGISTRATION DATA</h2>
                            <br>
                            <table>
                                <tr>
                                    <td style="width: 25vh">Shipping Date</td>
                                    <td> : </td>
                                    <td id="detail-shippingDate"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td id="changeShippingDate">
                                        <input type="hidden" name="changeShippingDateMin" id="changeShippingDateMin" value="{{date('Y-m-d')}}">
                                        <input type="hidden" name="changeShippingDateMax" id="changeShippingDateMax" value="{{date('Y-m-d',strtotime("+1 month"))}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><br></td>
                                </tr>
                                <tr>
                                    <td style="width: 25vh">Driver's Name</td>
                                    <td> : </td>
                                    <td id="detail-driverName"></td>
                                </tr>
                                <tr>
                                    <td style="width: 25vh">Driver's Phone</td>
                                    <td> : </td>
                                    <td id="detail-driverPhone"></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><br></td>
                                </tr>
                                <tr>
                                  <td style="width: 25vh">Transportation</td>
                                  <td> : </td>
                                  <td id="detail-transportationType"></td>
                                </tr>
                                <tr>
                                    <td style="width: 25vh">License Plate</td>
                                    <td> : </td>
                                    <td id="detail-licensePlate"></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><br></td>
                                </tr>
                                <tr>
                                    <td style="width: 25vh">Raw Material's Type</td>
                                    <td> : </td>
                                    <td id="detail-afvalType"></td>
                                </tr>
                                <tr>
                                    <td style="width: 25vh">Raw Material's Weight</td>
                                    <td> : </td>
                                    <td id="detail-afvalWeight"></td>
                                </tr>
                            </table>

                            <br><hr><br>
                        </div>

                        {{-- Re Registration--}}
                        <div id="detail-reRegistration">
                        </div>

                        {{-- Shipping Document--}}
                        <div id="detail-shippingDocument">
                        </div>

                        {{-- Check Result --}}
                        <div id="detail-checkResult">

                        </div>

                        {{-- Cancel Booking Shipping --}}
                        <div id="cancelShipping">
                        </div>

                        <button type="button" class="btn btn-light w-100" data-bs-dismiss="modal" id='btn-close-modal'>Close</button>
                </form>
            </div>
        </div>
    </div>
    <!--end::MODAL Detail -->
{{-- </x-base-layout> --}}
{{-- <script src="/js/custom/shipping.js"></script> --}}


@endsection

@push('dashboard')
  <script>
    window.onload = function() {
      var ctx = document.getElementById("chart-bars").getContext("2d");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "Sales",
            tension: 0.4,
            borderWidth: 0,
            borderRadius: 4,
            borderSkipped: false,
            backgroundColor: "#fff",
            data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
            maxBarThickness: 6
          }, ],
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
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
              },
              ticks: {
                suggestedMin: 0,
                suggestedMax: 500,
                beginAtZero: true,
                padding: 15,
                font: {
                  size: 14,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
                color: "#fff"
              },
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false
              },
              ticks: {
                display: false
              },
            },
          },
        },
      });


      var ctx2 = document.getElementById("chart-line").getContext("2d");

      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

      new Chart(ctx2, {
        type: "line",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
              label: "Mobile apps",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#cb0c9f",
              borderWidth: 3,
              backgroundColor: gradientStroke1,
              fill: true,
              data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
              maxBarThickness: 6

            },
            {
              label: "Websites",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#3A416F",
              borderWidth: 3,
              backgroundColor: gradientStroke2,
              fill: true,
              data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
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
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                color: '#b2b9bf',
                padding: 20,
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

{{-- dari kp report --}}
@push('report')
<script>
const { default: axios } = require("axios");
const { default: Swal } = require("sweetalert2");
// Datatable
require('../../../core/plugins/datatable/jquery.dataTables.min.js');
require('../../../core/plugins/datatable/dataTables.bootstrap5.min.js');

// require('../../../core/plugins/datatable/buttons.dataTables.min.css');
// require('../../../core/plugins/datatable/jquery.dataTables.min.css');
// require('../../../core/plugins/datatable/dataTables.buttons.min.js');
require('../../../core/plugins/datatable/pdfmake.min.js');
require('../../../core/plugins/datatable/vfs_fonts.js');

var Report = (function () {
var dataTableAfvalClaimedRejected;
var txtTotalShipping;
var txtTotalShippingRejected;
var txtTotalShippingClaimed;
var listAfval;
var listShippingToday;
var inputDateFrom, inputDateTo;
let formatFrom, formatTo;
let formatInput = formatDate(new Date(), 'dd\-mm\-yyyy');
let dateFrom, dateTo;
let dateSelected = formatDate(new Date(), 'day, dd month yyyy');

function formatDate (date, format) {
    let monthNames = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'Juny',
        'July',
        'August',
        'September',
        'October',
        'November',
        'Desember',
    ];
    let dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    let formatted = format.replace(/dd/g, date.getDate().toString().padStart(2, '0'));
    formatted = formatted.replace(/day/g, dayNames[date.getDay()]);
    formatted = formatted.replace(/mm/g, (date.getMonth() + 1).toString().padStart(2, '0'));
    formatted = formatted.replace(/month/g, monthNames[date.getMonth()]);
    formatted = formatted.replace(/yyyy/g, date.getFullYear());
    formatted = formatted.replace(/hh/g, date.getHours().toString().padStart(2, '0'));
    formatted = formatted.replace(/mi/g, date.getMinutes().toString().padStart(2, '0'));
    formatted = formatted.replace(/ss/g, date.getSeconds().toString().padStart(2, '0'));
    return formatted;
}
    return {
        initDatabase: function () {
            axios.get("api/report").then(function (response) {
                dataTableAfvalClaimedRejected = response.data.dataTableAfvalClaimedRejected;
                txtTotalShipping         = response.data.totalShipping;
                txtTotalShippingRejected = response.data.totalShippingRejected;
                txtTotalShippingClaimed  = response.data.totalShippingClaimed;
                listAfval                = response.data.listAfval;
                listShippingToday        = response.data.listShippingToday;

                // Set Today's Date in Title
                let datetoday = formatDate(new Date(), 'day, dd month yyyy');
                document.getElementById("selectdate").innerHTML = datetoday;
                dateSelected = datetoday;
            }).then(function () {
                Report.fillPage();
            });
        },
        clearPage: function () {
            document.getElementById('totalShipping').innerHTML = '';
            document.getElementById('totalShippingRejected').innerHTML = '';
            document.getElementById('totalShippingClaimed').innerHTML = '';
            document.getElementById('tbodyAfvalClaimedAndRejected').innerHTML = '';
            document.getElementById('detailShippingAfval').innerHTML = '';
        },
        fillPage: function () {
            Report.clearPage();

            document.getElementById('totalShipping').innerHTML          = txtTotalShipping;
            document.getElementById('totalShippingRejected').innerHTML  = txtTotalShippingRejected;
            document.getElementById('totalShippingClaimed').innerHTML   = txtTotalShippingClaimed;

            let ctr = 0;
            for (const dataRow of dataTableAfvalClaimedRejected) {
                ctr = ctr + 1;
                let tr = document.createElement('tr');

                let td_1 = document.createElement('td');
                let td_2 = document.createElement('td');
                let td_3 = document.createElement('td');
                let td_4 = document.createElement('td');

                td_1.setAttribute('scope', 'row');
                td_1.setAttribute('class', 'px-5');
                td_2.setAttribute('class', 'px-5');
                td_3.setAttribute('class', 'px-5');
                td_4.setAttribute('class', 'px-5');

                td_1.innerHTML = ctr;
                td_2.innerHTML = dataRow.name;
                td_3.innerHTML = dataRow.claimed;
                td_4.innerHTML = dataRow.rejected;

                tr.appendChild(td_1);
                tr.appendChild(td_2);
                tr.appendChild(td_3);
                tr.appendChild(td_4);

                document.getElementById('tbodyAfvalClaimedAndRejected').appendChild(tr);
            }

            for (const afval of listAfval){
                let div_card_1 = document.createElement('div');
                let div_card_2 = document.createElement('div');

                div_card_1.setAttribute('class', 'card card-xxl-stretch-50 mb-5 mb-xl-8');
                div_card_2.setAttribute('class', 'card-body p-0 d-flex justify-content-between flex-column overflow-hidden p-5');

                let H2_title = document.createElement('H2');
                H2_title.innerHTML = "Detail " + afval.name;

                let table = document.createElement('table');
                table.setAttribute('class', 'table table-striped');

                let thead = document.createElement('thead');
                let tr_head = document.createElement('tr');
                tr_head.setAttribute('class', 'bg-success text-light');
                let th_1 = document.createElement('th');
                let th_2 = document.createElement('th');
                let th_3 = document.createElement('th');
                let th_4 = document.createElement('th');

                th_1.setAttribute('class', 'px-5');
                th_2.setAttribute('class', 'px-5');
                th_3.setAttribute('class', 'px-5');
                th_4.setAttribute('class', 'px-5');

                th_1.setAttribute('style', 'width: 5vw');
                th_2.setAttribute('style', 'width: 65vw');
                th_3.setAttribute('style', 'width: 15vw');
                th_4.setAttribute('style', 'width: 15vw');

                th_1.setAttribute('scope', 'col');
                th_2.setAttribute('scope', 'col');
                th_3.setAttribute('scope', 'col');
                th_4.setAttribute('scope', 'col');

                th_1.innerHTML = "No";
                th_2.innerHTML = "Shipping Code / Supplier's Data";
                th_3.innerHTML = "Weight (Kg)";
                th_4.innerHTML = "Status";

                tr_head.appendChild(th_1);
                tr_head.appendChild(th_2);
                tr_head.appendChild(th_3);
                tr_head.appendChild(th_4);

                thead.appendChild(tr_head);


                let tbody = document.createElement('tbody');
                let ctrX = 0;
                for (const shipping of listShippingToday){
                    if (shipping.afval_id == afval.id) {
                        ctrX = ctrX+1;
                        let tr = document.createElement('tr');

                        let td_1 = document.createElement('td');
                        let td_2 = document.createElement('td');
                        let td_3 = document.createElement('td');
                        let td_4 = document.createElement('td');

                        td_1.setAttribute('scope', 'row');
                        td_1.setAttribute('class', 'px-5');
                        td_2.setAttribute('class', 'px-5');
                        td_3.setAttribute('class', 'px-5');
                        td_4.setAttribute('class', 'px-5');

                        td_1.innerHTML = ctrX;
                        td_2.innerHTML = shipping.shipping_code == null ? shipping.supplier.name + " (" + shipping.supplier.phone + ")" : shipping.shipping_code;
                        td_3.innerHTML = shipping.net_afval_weight == null ? shipping.afval_weight : shipping.afval_weight + " (" + shipping.net_afval_weight + ")";
                        td_4.innerHTML = shipping.shipping_status.name;

                        tr.appendChild(td_1);
                        tr.appendChild(td_2);
                        tr.appendChild(td_3);
                        tr.appendChild(td_4);

                        tbody.appendChild(tr);
                    }
                }

                table.appendChild(thead);
                table.appendChild(tbody);

                div_card_2.appendChild(H2_title);
                div_card_2.appendChild(document.createElement('br'));
                div_card_2.appendChild(table);

                div_card_1.appendChild(div_card_2);
                document.getElementById('detailShippingAfval').appendChild(div_card_1);
            }
        },
        selectDate:function(){
            inputDateFrom = document.querySelector("#selectfrom");
            formatFrom    = formatDate(new Date(inputDateFrom.value), 'dd\-mm\-yyyy');
            dateFrom      = formatDate(new Date(inputDateFrom.value), 'day, dd month yyyy');
            inputDateTo   = document.querySelector("#selectto");
            formatTo      = formatDate(new Date(inputDateTo.value), 'dd\-mm\-yyyy');
            dateTo        = formatDate(new Date(inputDateTo.value), 'day, dd month yyyy');

            if(inputDateTo.value >= inputDateFrom.value){
                //Today
                formatInput = '';

                if(inputDateFrom.value == inputDateTo.value && inputDateFrom.value != formatDate(new Date(), 'dd\-mm\-yyyy')) {
                    //Same Date
                    formatInput = formatFrom;
                    dateSelected  = dateFrom;
                }
                else {
                    //Different Date
                    formatInput = formatFrom+"/"+formatTo;
                    dateSelected = dateFrom + " - " + dateTo;
                }
            }
            else{
                Swal.fire({
                    text: "Value date in 'to' field has to be after "+dateFrom,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        },
        selecting:function(){
            //Select Date

            document.getElementById('selectForm').addEventListener("submit", function (e) {
                e.preventDefault();
                inputDateFrom = document.querySelector("#selectfrom");
                formatFrom    = formatDate(new Date(inputDateFrom.value), 'dd\-mm\-yyyy');
                dateFrom      = formatDate(new Date(inputDateFrom.value), 'day, dd month yyyy');
                inputDateTo   = document.querySelector("#selectto");
                formatTo      = formatDate(new Date(inputDateTo.value), 'dd\-mm\-yyyy');
                dateTo        = formatDate(new Date(inputDateTo.value), 'day, dd month yyyy');

                if(inputDateTo.value >= inputDateFrom.value){
                    //Today
                    formatInput = '';

                    if(inputDateFrom.value == inputDateTo.value && inputDateFrom.value != formatDate(new Date(), 'dd\-mm\-yyyy')) {
                        //Same Date
                        formatInput = formatFrom;
                        dateSelected  = dateFrom;
                    }
                    else {
                        //Different Date
                        formatInput = formatFrom+"/"+formatTo;
                        dateSelected = dateFrom + " - " + dateTo;
                    }
                }
                else{
                    Swal.fire({
                        text: "This date have to be after "+dateFrom,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }

                axios.get(`api/report/${formatInput}`)
                .then(function (response) {
                    dataTableAfvalClaimedRejected   = response.data.dataTableAfvalClaimedRejected;
                    txtTotalShipping                = response.data.totalShipping;
                    txtTotalShippingRejected        = response.data.totalShippingRejected;
                    txtTotalShippingClaimed         = response.data.totalShippingClaimed;
                    listAfval                       = response.data.listAfval;
                    listShippingToday               = response.data.listShippingToday;
                    document.getElementById("selectdate").innerHTML = dateSelected;
                    Report.fillPage();
                });
            });
        },
        exporting:function(){
            //Export

            document.getElementById('exportForm').addEventListener("submit", function (e) {
                e.preventDefault();
                var listContent = [];
                listContent.push({text: 'PT. Buana Megah Paper Mills',  color: '#339600', fontSize: 20, bold: true});
                listContent.push({
                    table: {
                        headerRows: 1,
                        body: [
                            ["", "", ""],
                            ["Report Date", ":", dateSelected],
                            ["Total Shipping", ":", txtTotalShipping+" shipping(s)"],
                            ["Total Rejected", ":", txtTotalShippingRejected+" shipping(s)"],
                            ["Total Claimed", ":", txtTotalShippingClaimed+" shipping(s)"],
                        ]
                    },
                    layout: 'noBorders'
                });

                var ship_code = '';
                var ship_afval_weight = '';
                var ship_status = '';
                for (const afval of listAfval){

                    let ctr = 0;
                    listContent.push({text: 'Raw Material: '+afval.name, fontSize: 15, bold: true , margin: [0, 15, 0, 0]});

                    var listTabel = [];
                    listTabel.push([
                        { text: 'No', style: 'judul' },
                        { text: 'Shipping Code / Supplier\'s Data', style: 'judul' },
                        { text: 'Weight (Kg)', style: 'judul'  },
                        { text: 'Status' , style: 'judul'}
                    ]);
                    for (const shipping of listShippingToday){
                        if (shipping.afval_id == afval.id) {
                            ship_code = shipping.shipping_code == null ? shipping.supplier.name + " (" + shipping.supplier.phone + ")" : shipping.shipping_code;
                            ship_afval_weight = shipping.net_afval_weight == null ? shipping.afval_weight : shipping.afval_weight + " (" + shipping.net_afval_weight + ")";
                            ship_status = shipping.shipping_status.name;
                            ctr = ctr + 1;
                            listTabel.push([
                                { text: ctr },
                                { text: ship_code },
                                { text: ship_afval_weight },
                                { text: ship_status }
                            ]);
                        }
                    }
                    if(ctr==0){
                        listTabel.push([{ text: "Shipping on selected date hasn\'t registered yet.", colSpan: 4, margin: [0, 5, 0, 5], alignment: 'center' }]);
                    }
                    listContent.push({
                        table: {
                            headerRows: 1,
                            widths: [ 'auto','*', 75, 100 ],
                            body: listTabel
                        },
                        margin: [0, 5, 0, 15],
                        layout: {
                            hLineColor : 'gray',
                            vLineColor: 'gray',
                            fillColor: function (rowIndex, node, columnIndex) {
                                return (rowIndex % 2 === 0) ? '#CCCCCC' : null;
                            }
                        }
                    });
                }

                var docDefinition = {
                    margin: [40,40,40,40],
                    watermark: { text: 'PT. Buana Megah Paper Mills', angle: 45, opacity: 0.3, color: '#012645', bold: true},
                    footer: function(currentPage, pageCount)
                        { return {text: currentPage.toString() + ' of ' + pageCount, alignment: 'center'} },
                    content: listContent,
                    styles:{
                        judul:{
                            bold:true,
                            fontSize: 11,
                            fillColor: "#339600",
                            color: "white",
                            margin: [0, 5, 0, 5]
                        }
                    },
                    defaultStyle: {
                        fontSize: 10
                    }
                };
                console.log(formatInput);
                let formatExport = "_"+formatInput;
                let pdfName = 'reportRawMaterial'+formatExport+'.pdf';
                pdfMake.createPdf(docDefinition).download(pdfName);
                console.log(listContent);
            });
        }
    };
})();

// Webpack support
if (typeof module !== "undefined") {
    module.exports = Report;
}

// On document ready
KTUtil.onDOMContentLoaded(function () {
    Report.initDatabase();
    Report.selecting();
    Report.exporting();
});
</script>
@endpush
{{-- kp report end --}}

{{-- dari KP --}}
@push('link')

<!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{config('midtrans.client_key')}}"> </script><!--SET_YOUR_CLIENT_KEY_HERE-->

<script type="text/javascript">
    // var payButton = document.getElementById('pay-button');
    // payButton.addEventListener('click', function () {
    function check() {
        alert('halooo');
        // window.snap.pay({{$snap}});//'TRANSACTION_TOKEN_HERE'
        // customer will be redirected after completing payment pop-up
    // });

    //dari midtrans
    // document.getElementById('pay-button').onclick = function(){
    //     alert('halooo');
        // SnapToken acquired from previous step
        snap.pay('<?=$snap?>', {
          // Optional
          onSuccess: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          },
          // Optional
          onPending: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          },
          // Optional
          onError: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          }
        });
      };

    //dari fai/fpw dan sdp
    // function check() {
    //     koin = document.getElementById('koin').value;
    //     checkout = document.getElementById('checkout');
    //     alert('ini ada '.koin.' dan jumlahnya '.jumlah.' = '.parseInt(koin.value)*parseInt(jumlah.value));
    //     if (jumlah > 0 && jumlah <= 10) {
    //         alert("Jumlah antara 1 - 10.");
    //     } else {
    //         // if (new Date(tgl) >= new Date() ){
    //             $.ajaxSetup({
    //                 headers: {
    //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                 }
    //             });
    //             $.ajax({
    //                 type:'POST',
    //                 url:'/bayar-koin',
    //                 data:{
    //                     jumlah : jumlah,
    //                     koin : koin,
    //                     },
    //                 success:function(data){
    //                     alert(data['snap']);
    //                     //<!--class=' + show' style='display:block;' aria-modal='true' (hidden hilang)-->
    //                     checkout.setAttribute('class','modal fade show');
    //                     checkout.setAttribute('style','display:block;');
    //                     checkout.setAttribute('aria-hidden','false');
    //                     checkout.setAttribute('aria-modal','true');

    //                     snap.pay(data['token'], {
    //                         // Optional
    //                         onSuccess: function(result){
    //                             // /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
    //                             window.location.href='/cartkosong/'+ data['id'];
    //                         },
    //                         // Optional
    //                         onPending: function(result){
    //                             // /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
    //                             window.location.href='/cartkosong/'+ data['id'];
    //                         },
    //                         // Optional
    //                         onError: function(result){
    //                             // /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
    //                             alert("ERROR PAYMENT PROCESS PLEASE CONTACT OUR CUSTOMER SERVICE")
    //                         }
    //                     });
    //                 }
    //             });
    //         // }else{
    //         //     alert("INVALID DATE");
    //         // }
    //     }
    // }

    //note saja
    // jumlah = document.getElementById('jumlah').value;
    // jumlah.addEventListener("input", function () {
    //     value = parseInt(jumlah);
    //     if (jumlah > 0) jumlah.value=1;
    //     else if(jumlah < 10) jumlah.value = 10;
    // });
</script>

<script>
    // namanya ini: src="/js/custom/shipping.js"
const { default: axios } = require("axios");
const { default: Swal } = require("sweetalert2");
// Datatable
// require('../../../core/plugins/datatable/jquery.dataTables.min.js');
// require('../../../core/plugins/datatable/dataTables.bootstrap5.min.js');
var Shipping = (function () {
    var formCreate;
    var supplierID;
    var shippingDate;
    var driverName;
    var driverPhone;
    var licensePlate;
    var transportationType;
    var afvalType;
    var afvalWeight;
    var createdBy;

    return {
        initDatabase: function () {
            axios.get("api/shipping").then(function (response) {
                let listShipping = response.data;
                var bodyTable = document.querySelector("#bodyShippingTable");
                let ctrNo = 0;
                bodyTable.innerHTML = "";

                function formatDate (date, format) {
                    let monthNames = [
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'Juny',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'Desember',
                    ];
                    let dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    let formatted = format.replace(/dd/g, date.getDate().toString().padStart(2, '0'));
                    formatted = formatted.replace(/day/g, dayNames[date.getDay()]);
                    formatted = formatted.replace(/mm/g, (date.getMonth() + 1).toString().padStart(2, '0'));
                    formatted = formatted.replace(/month/g, monthNames[date.getMonth()]);
                    formatted = formatted.replace(/yyyy/g, date.getFullYear());
                    formatted = formatted.replace(/hh/g, date.getHours().toString().padStart(2, '0'));
                    formatted = formatted.replace(/mi/g, date.getMinutes().toString().padStart(2, '0'));
                    formatted = formatted.replace(/ss/g, date.getSeconds().toString().padStart(2, '0'));
                    return formatted;
                }

                for (const shipping of listShipping) {
                    ctrNo = ctrNo + 1;

                    let tr = document.createElement("tr");

                    let td_1 = document.createElement("td");
                    let td_2 = document.createElement("td");
                    let td_3 = document.createElement("td");
                    let td_4 = document.createElement("td");
                    let td_5 = document.createElement("td");
                    let td_6 = document.createElement("td");
                    let td_7 = document.createElement("td");

                    // begin :: make btn View Detail
                        let icon_detail = document.createElement("span");
                        icon_detail.setAttribute("class", "svg-icon svg-icon-3");
                        let i_detail = document.createElement("i");
                        i_detail.setAttribute("class", "bi bi-eye");
                        icon_detail.appendChild(i_detail);

                        let btn_detail = document.createElement("button");
                        btn_detail.setAttribute("id", `btn_detail_${shipping.id}`);
                        btn_detail.setAttribute("class", "btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1");
                        btn_detail.setAttribute("data-bs-toggle", "modal");
                        btn_detail.setAttribute("title", "detail");
                        btn_detail.setAttribute(
                            "data-bs-target",
                            "#kt_modal_detail_shipping"
                        );

                        btn_detail.onclick = function () {
                            // Mengosongkan Element (agar tidak tertumpuk dengan data lain)
                                document.getElementById("detail-reRegistration").innerHTML = '';
                                document.getElementById("detail-shippingDocument").innerHTML = '';
                                document.getElementById("detail-checkResult").innerHTML = '';
                                document.getElementById("cancelShipping").innerHTML = '';
                            // --

                            // Menyiapkan text untuk isi detail form (yang pasti muncul di semua status shipping)
                                let txtCreatedBy         = shipping.created_by.name + (shipping.created_by.role_id == '0' ? ' (Admin)' :
                                                                                        shipping.created_by.role_id == '1' ? ' (Employee)' :
                                                                                        ' (Supplier)');
                                let txtCreatedAt         = formatDate(new Date(shipping.created_at), 'day, dd month yyyy');
                                let txtShippingType      = shipping.is_booking == '0' ? 'Regular' : 'Booking';
                                let txtShippingStatus    = shipping.shipping_status.name;

                                let txtSupplierName      = shipping.supplier.name;
                                let txtSupplierEmail     = shipping.supplier.email;
                                let txtSupplierPhone     = shipping.supplier.phone;
                                let txtSupplierAddress   = shipping.supplier.address;

                                let txtShippingDate      = formatDate(new Date(shipping.booking_shipping_date), 'day, dd month yyyy');
                                let txtDriverName        = shipping.driver_name;
                                let txtDriverPhone       = shipping.driver_phone;
                                let txtTransportationType= shipping.transportation.name;
                                let txtLicensePlate      = shipping.license_plate;
                                let txtAfvalType         = shipping.afval.name;
                                let txtAfvalWeight       = shipping.afval_weight;
                            // --

                            // Memasukkan text ke detail form (yang pasti muncul di semua status shipping)
                                document.getElementById("detail-createdBy").innerHTML = txtCreatedBy;
                                document.getElementById("detail-createdAt").innerHTML = txtCreatedAt;
                                document.getElementById("detail-shippingType").innerHTML = txtShippingType;
                                document.getElementById("detail-shippingStatus").innerHTML = txtShippingStatus;

                                document.getElementById("detail-supplierName").innerHTML = txtSupplierName;
                                document.getElementById("detail-supplierEmail").innerHTML = txtSupplierEmail;
                                document.getElementById("detail-supplierPhone").innerHTML = txtSupplierPhone;
                                document.getElementById("detail-supplierAddress").innerHTML = txtSupplierAddress;

                                document.getElementById("detail-shippingDate").innerHTML = txtShippingDate;
                                document.getElementById("detail-driverName").innerHTML = txtDriverName;
                                document.getElementById("detail-driverPhone").innerHTML = txtDriverPhone;
                                document.getElementById("detail-transportationType").innerHTML = txtTransportationType;
                                document.getElementById("detail-licensePlate").innerHTML = txtLicensePlate;
                                document.getElementById("detail-afvalType").innerHTML = txtAfvalType;
                                document.getElementById("detail-afvalWeight").innerHTML = txtAfvalWeight;
                            // --

                            let statusShippingID = shipping.shipping_status.id;
                            // Change Shipping Date
                            if (statusShippingID == 0 || statusShippingID == 1) {
                                document.getElementById('changeShippingDate').innerHTML = ` <table>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <input type="date" name="changeShippingDatePicker" id="changeShippingDatePicker" class="form-control" min="`+ document.getElementById('changeShippingDateMin').value +`" max="`+ document.getElementById('changeShippingDateMax').value +`" style="width: 25vw"/>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <button type="button" class="btn btn-success" style="width: 5vw" id="changeShippingDateSaveBtn">
                                                                                                            Save
                                                                                                        </button>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>`;
                                document.getElementById('changeShippingDateSaveBtn').onclick = function () {
                                    if (document.getElementById('changeShippingDatePicker').value != '') {
                                        Swal.fire({
                                            title: "Are you sure to change the shipping date?",
                                            text: ``,
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#28a745',
                                            cancelButtonColor: '#f8f9fa',
                                            confirmButtonText: 'Yes sure!'
                                        }).then(function (result) {
                                            if (result.isConfirmed) {
                                                axios.put(`/api/shipping/updateShippingDate/${shipping.id}`, {
                                                    shipping_date : document.getElementById('changeShippingDatePicker').value,
                                                })
                                                .then(function(result) {
                                                    document.querySelector('#btn-close-modal').click();
                                                    Shipping.initDatabase();
                                                    Swal.fire(
                                                        'Success to change the Shipping Date',
                                                        ``,
                                                        'success'
                                                    );
                                                })
                                            }
                                        })
                                    }else{
                                        Swal.fire(
                                            'Error!',
                                            'Make sure you pick the date!',
                                            'error'
                                        );
                                    }
                                }
                            }
                            // --


                            // Detail re-register
                                /*
                                    Detail re-register hanya akan tampil untuk shipping yang selain berstatus -1 (Canceled)
                                    * Cancel Shipping hanya bisa dilakukan saat status shipping = 0 (Scheuled) atau 1 (Waiting Re-Register)
                                    Detail isi detail re-register menurut statusnya :
                                    -   Menampilkan detail re-register lengkap
                                        [ -5 : Rejected Raw Material Quality ]      -> (karena status ini hanya bisa didapatkan ketika re-register sudah di accept dan sebelumnya berada di status 5:Quality Check)
                                        [ -4 : Rejected Shipping Document    ]      -> (karena status ini hanya bisa didapatkan ketika re-register sudah di accept dan sebelumnya berada di status 3:Shipping Document Check)
                                        [ -3 : Rejected Re-Register          ]      -> (karena status ini hanya bisa didapatkan ketika re-register ditolak dan sebelumnya berada di status 1:Waiting Re-Registration)
                                        [  2 : Waiting In Line               ]
                                        [  3 : Shipping Document Check       ]
                                        [  4 : Weight Check                  ]
                                        [  5 : Quality Check                 ]
                                        [  6 : Waiting Claim                 ]
                                        [  7 : Claimed                       ]

                                    -   Menampilkan alert merah berisikan tulisan "terlambat"
                                        [ -2 : Not Come                      ]      -> (karena status ini hanya bisa didapatkan ketika sebelumnya berstatus 1:Waiting Re Registration dan tidak melakukan re-registrasi pada pos satpam)

                                    -   Menampilkan alert biru berisikan tulisan tanggal untuk melakukan re-registrasi
                                        [  0 : Scheduled                     ]

                                    -   Menampilkan alert kuning berisikan tulisan pemberitahuan kepada employee untuk memastikan semua data registrasi sudah sama dengan kenyataan dan terdapat field notes serta button decline dan accept
                                        [  1 : Waiting Re Register           ]
                                */

                                if (statusShippingID != -1) {
                                    // Menampilkan header Detail Re Register
                                        let H2_ReRegisterTitle = document.createElement('H2');
                                        H2_ReRegisterTitle.innerHTML = "RE - REGISTRATION <br>";
                                        document.getElementById("detail-reRegistration").appendChild(H2_ReRegisterTitle);
                                    // --

                                    // Menampilkan re-register lengkap
                                        if (statusShippingID <= -3 || statusShippingID >= 2) {
                                            // Menyiapkan data detail re-register
                                                let txtReRegistrationChecker   = shipping.reregistration_checker.name;
                                                let txtReRegistrationDate      = formatDate(new Date(shipping.re_registration_date), 'day, dd month yyyy');
                                                let txtReRegistrationStatus    = shipping.is_re_registration_accepted == 0 ? 'Declined' : 'Accepted';
                                                let txtReRegistrationNotes     = shipping.re_registration_notes;
                                            // --

                                            // Menyiapkan element tabel agar tampilan lebih rapi
                                                let tableReRegistration = document.createElement("table");

                                                let trReRegistration1 = document.createElement("tr");
                                                let trReRegistration2 = document.createElement("tr");
                                                let trReRegistration3 = document.createElement("tr");
                                                let trReRegistration4 = document.createElement("tr");
                                                let trReRegistration5 = document.createElement("tr");

                                                let tdReRegistration1_1 = document.createElement("td");
                                                let tdReRegistration1_2 = document.createElement("td");
                                                let tdReRegistration1_3 = document.createElement("td");

                                                let tdReRegistration2_1 = document.createElement("td");

                                                let tdReRegistration3_1 = document.createElement("td");
                                                let tdReRegistration3_2 = document.createElement("td");
                                                let tdReRegistration3_3 = document.createElement("td");

                                                let tdReRegistration4_1 = document.createElement("td");
                                                let tdReRegistration4_2 = document.createElement("td");
                                                let tdReRegistration4_3 = document.createElement("td");

                                                let tdReRegistration5_1 = document.createElement("td");
                                                let tdReRegistration5_2 = document.createElement("td");
                                                let tdReRegistration5_3 = document.createElement("td");

                                                tdReRegistration1_1.setAttribute("style", "width: 25vh;");
                                                tdReRegistration2_1.setAttribute("colspan", "3");
                                                tdReRegistration3_1.setAttribute("style", "width: 25vh;");
                                                tdReRegistration4_1.setAttribute("style", "width: 25vh;");
                                                tdReRegistration5_1.setAttribute("style", "width: 25vh;");
                                            // --

                                            // Mengisi detail re-register dalam tabel
                                                tdReRegistration1_1.innerHTML = "Checker";
                                                tdReRegistration1_2.innerHTML = ":";
                                                tdReRegistration1_3.innerHTML = txtReRegistrationChecker;

                                                tdReRegistration2_1.innerHTML = "<br>";

                                                tdReRegistration3_1.innerHTML = "Datetime";
                                                tdReRegistration3_2.innerHTML = ":";
                                                tdReRegistration3_3.innerHTML = txtReRegistrationDate;

                                                tdReRegistration4_1.innerHTML = "Status";
                                                tdReRegistration4_2.innerHTML = ":";
                                                tdReRegistration4_3.innerHTML = txtReRegistrationStatus;

                                                tdReRegistration5_1.innerHTML = "Notes";
                                                tdReRegistration5_2.innerHTML = ":";
                                                tdReRegistration5_3.innerHTML = txtReRegistrationNotes;
                                            // --

                                            // Menggabungkan hingga ke div#detail-reRegistration
                                                trReRegistration1.appendChild(tdReRegistration1_1);
                                                trReRegistration1.appendChild(tdReRegistration1_2);
                                                trReRegistration1.appendChild(tdReRegistration1_3);

                                                trReRegistration2.appendChild(tdReRegistration2_1);

                                                trReRegistration3.appendChild(tdReRegistration3_1);
                                                trReRegistration3.appendChild(tdReRegistration3_2);
                                                trReRegistration3.appendChild(tdReRegistration3_3);

                                                trReRegistration4.appendChild(tdReRegistration4_1);
                                                trReRegistration4.appendChild(tdReRegistration4_2);
                                                trReRegistration4.appendChild(tdReRegistration4_3);

                                                trReRegistration5.appendChild(tdReRegistration5_1);
                                                trReRegistration5.appendChild(tdReRegistration5_2);
                                                trReRegistration5.appendChild(tdReRegistration5_3);

                                                tableReRegistration.appendChild(trReRegistration1);
                                                tableReRegistration.appendChild(trReRegistration2);
                                                tableReRegistration.appendChild(trReRegistration3);
                                                tableReRegistration.appendChild(trReRegistration4);
                                                tableReRegistration.appendChild(trReRegistration5);

                                                document.getElementById("detail-reRegistration").appendChild(tableReRegistration);
                                            //
                                        }
                                    // --

                                    // Menampilkan alert merah (telat/tidak datang)
                                        else if (statusShippingID == -2) {
                                            let divAlertDanger = document.createElement("div");
                                            divAlertDanger.setAttribute("class", "alert alert-danger");
                                            divAlertDanger.innerHTML =  "<b>" +
                                                                        "Haven't re-registered yet! Too late to re-register! Last register on " + txtShippingDate +
                                                                        "</b>";
                                            document.getElementById("detail-reRegistration").appendChild(divAlertDanger);
                                        }
                                    // --

                                    // Menampilkan alert biru (informasi tanggal re-register)
                                        else if (statusShippingID == 0) {
                                            let divAlertInfo = document.createElement("div");
                                            divAlertInfo.setAttribute("class", "alert alert-info");
                                            divAlertInfo.innerHTML =  "<b>" +
                                                                        "Haven't re-registered yet! Please do re-register at Security Post on " + txtShippingDate +
                                                                        "</b>";
                                            document.getElementById("detail-reRegistration").appendChild(divAlertInfo);
                                        }
                                    // --

                                    // Menampilkan alert kuning (pengecekan kesamaan) dan form penerimaan atau penolakan re-register
                                        else if (statusShippingID == 1) {
                                            // Alert
                                                let divAlertWarning = document.createElement("div");
                                                divAlertWarning.setAttribute("class", "alert alert-warning");
                                                divAlertWarning.innerHTML = "<b>Haven't re-registered yet! <br>" +
                                                                            "Please re-check whether the registered data with the reality is the same! </b> <br>" +
                                                                            "If same, you can accepted and the supplier will get the queue number. <br>" +
                                                                            "Else (if not same), you can rejected and give the reason!";
                                                document.getElementById("detail-reRegistration").appendChild(divAlertWarning);
                                            // --

                                            document.getElementById("detail-reRegistration").appendChild(document.createElement("br"));

                                            // Form Re-Register Check
                                                // Notes
                                                    let spanNotes = document.createElement("span");
                                                    spanNotes.innerHTML = "Notes";
                                                    document.getElementById("detail-reRegistration").appendChild(spanNotes);

                                                    let inputTextAreaNotes = document.createElement("textarea");
                                                    inputTextAreaNotes.setAttribute("class", "form-control");
                                                    inputTextAreaNotes.setAttribute("cols", "30");
                                                    inputTextAreaNotes.setAttribute("rows", "10");
                                                    inputTextAreaNotes.setAttribute("id", "notesReRegister");
                                                    inputTextAreaNotes.setAttribute("name", "notesReRegister");
                                                    document.getElementById("detail-reRegistration").appendChild(inputTextAreaNotes);
                                                // --

                                                document.getElementById("detail-reRegistration").appendChild(document.createElement("br"));
                                                document.getElementById("detail-reRegistration").appendChild(document.createElement("br"));

                                                //  Button Decline
                                                    let btnReRegistrationDecline = document.createElement("button");
                                                    btnReRegistrationDecline.innerHTML = "Decline";
                                                    btnReRegistrationDecline.setAttribute("type", "button");
                                                    btnReRegistrationDecline.setAttribute("class", "btn btn-active-color-light btn-outline-danger border border-danger w-100");
                                                    btnReRegistrationDecline.onclick = function () {
                                                        if (document.getElementById('notesReRegister').value != '') {
                                                            Swal.fire({
                                                                title: "Are you sure to Declined Re-Register of the Shipping? You won't be able to revert this!",
                                                                text: `Reason : ${document.getElementById('notesReRegister').value}`,
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#dc3545',
                                                                cancelButtonColor: '#f8f9fa',
                                                                confirmButtonText: 'Yes, Decline it!'
                                                            }).then(function (result) {
                                                                if (result.isConfirmed) {
                                                                    axios.put(`/api/shipping/declineReRegister/${shipping.id}`, {
                                                                        re_registration_notes : document.getElementById('notesReRegister').value,
                                                                        re_registration_checker : document.getElementById('checkerID').value,
                                                                    })
                                                                    .then(function(result) {
                                                                        document.querySelector('#btn-close-modal').click();
                                                                        Shipping.initDatabase();
                                                                        Swal.fire(
                                                                            'Success to Declined the Re-Register of Shipping',
                                                                            `Your re-register has been declined because ${document.getElementById('notesReRegister').value}`,
                                                                            'success'
                                                                        );
                                                                    })
                                                                }
                                                            })
                                                        }else{
                                                            Swal.fire(
                                                                'Error!',
                                                                'Please give your reason on the notes!',
                                                                'error'
                                                            );
                                                        }
                                                    }
                                                    document.getElementById("detail-reRegistration").appendChild(btnReRegistrationDecline);
                                                // --

                                                document.getElementById("detail-reRegistration").appendChild(document.createElement("br"));
                                                document.getElementById("detail-reRegistration").appendChild(document.createElement("br"));

                                                // Button Accept
                                                    let btnReRegistrationAccept = document.createElement("button");
                                                    btnReRegistrationAccept.innerHTML = "Acccept";
                                                    btnReRegistrationAccept.setAttribute("type", "button");
                                                    btnReRegistrationAccept.setAttribute("class", "btn btn-active-color-light btn-outline-success border border-success w-100");
                                                    btnReRegistrationAccept.onclick = function () {
                                                        Swal.fire({
                                                            title: "Are you sure to Accept the Re-Register of the Shipping? You won't be able to revert this!",
                                                            text: `Please makesure if the registration data and reality is same`,
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#28a745',
                                                            cancelButtonColor: '#f8f9fa',
                                                            confirmButtonText: 'Yes, Accept it!'
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                axios.put(`/api/shipping/acceptReRegister/${shipping.id}`, {
                                                                    re_registration_notes : document.getElementById('notesReRegister').value,
                                                                    re_registration_checker : document.getElementById('checkerID').value,
                                                                    supplier_name : txtSupplierName,
                                                                    supplier_phone : txtSupplierPhone,
                                                                    license_plate : txtLicensePlate,
                                                                    created_at : formatDate(new Date(shipping.created_at), 'dd-mm-yyyy'),
                                                                    shipping_type : txtShippingType,
                                                                })
                                                                .then(function(result) {
                                                                    document.querySelector('#btn-close-modal').click();
                                                                    Shipping.initDatabase();
                                                                    Swal.fire(
                                                                        'Success to Accept the Re-Register of Shipping',
                                                                        `Your re-register has been accepted`,
                                                                        'success'
                                                                    );
                                                                })
                                                            }
                                                        })
                                                    }
                                                    document.getElementById("detail-reRegistration").appendChild(btnReRegistrationAccept);
                                                // --

                                        }
                                    // --

                                    document.getElementById("detail-reRegistration").appendChild(document.createElement("br"));
                                    document.getElementById("detail-reRegistration").appendChild(document.createElement("hr"));
                                    document.getElementById("detail-reRegistration").appendChild(document.createElement("br"));
                                }
                            // --

                            // Shipping Document
                                /*
                                    Shipping Document hanya akan tampil untuk shipping status <= -4 atau >= 0
                                    Penjelasan Isi  :
                                    -   Status 0~2              -> Alert mengingatkan membawa document
                                    -   Status 3                -> Form notes, accept, decline
                                    -   Status <= -4 atau >= 4  -> Semua detail
                                */
                                if (statusShippingID <= -4 || statusShippingID >= 0) {
                                    // Menampilkan header Detail Re Register
                                        let H2_ShippingDocument = document.createElement('H2');
                                        H2_ShippingDocument.innerHTML = "SHIPPING DOCUMENT <br>";
                                        document.getElementById("detail-shippingDocument").appendChild(H2_ShippingDocument);
                                    // --

                                    // Menampilkan alert
                                        if (statusShippingID >= 0 && statusShippingID <=2) {
                                            let divAlertInfo = document.createElement("div");
                                            divAlertInfo.setAttribute("class", "alert alert-info");
                                            divAlertInfo.innerHTML =  "<b>" +
                                                                        "Don't forget to bring the Shipping Document at " + txtShippingDate +
                                                                        "</b>";
                                            document.getElementById("detail-shippingDocument").appendChild(divAlertInfo);
                                        }
                                    // --

                                    // Menampilkan form
                                        if (statusShippingID == 3) {
                                            // Alert
                                                let divAlertWarning = document.createElement("div");
                                                divAlertWarning.setAttribute("class", "alert alert-warning");
                                                divAlertWarning.innerHTML = "<b>Please check the shipping document!</b>";
                                                document.getElementById("detail-shippingDocument").appendChild(divAlertWarning);
                                            // --

                                            document.getElementById("detail-shippingDocument").appendChild(document.createElement("br"));

                                            // Form Re-Register Check
                                                // Notes
                                                    let spanNotes = document.createElement("span");
                                                    spanNotes.innerHTML = "Notes";
                                                    document.getElementById("detail-shippingDocument").appendChild(spanNotes);

                                                    let inputTextAreaNotes = document.createElement("textarea");
                                                    inputTextAreaNotes.setAttribute("class", "form-control");
                                                    inputTextAreaNotes.setAttribute("cols", "30");
                                                    inputTextAreaNotes.setAttribute("rows", "10");
                                                    inputTextAreaNotes.setAttribute("id", "notesShippingDocument");
                                                    inputTextAreaNotes.setAttribute("name", "notesShippingDocument");
                                                    document.getElementById("detail-shippingDocument").appendChild(inputTextAreaNotes);
                                                // --

                                                document.getElementById("detail-shippingDocument").appendChild(document.createElement("br"));
                                                document.getElementById("detail-shippingDocument").appendChild(document.createElement("br"));

                                                //  Button Decline
                                                    let btnShippingDocumentDecline = document.createElement("button");
                                                    btnShippingDocumentDecline.innerHTML = "Decline";
                                                    btnShippingDocumentDecline.setAttribute("type", "button");
                                                    btnShippingDocumentDecline.setAttribute("class", "btn btn-active-color-light btn-outline-danger border border-danger w-100");
                                                    btnShippingDocumentDecline.onclick = function () {
                                                        if (document.getElementById('notesShippingDocument').value != '') {
                                                            Swal.fire({
                                                                title: "Are you sure to Decline the Shipping Document? You won't be able to revert this!",
                                                                text: `Reason : ${document.getElementById('notesShippingDocument').value}`,
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#dc3545',
                                                                cancelButtonColor: '#f8f9fa',
                                                                confirmButtonText: 'Yes, Decline it!'
                                                            }).then(function (result) {
                                                                if (result.isConfirmed) {
                                                                    axios.put(`/api/shipping/declineShippingDocument/${shipping.id}`, {
                                                                        shipping_document_notes : document.getElementById('notesShippingDocument').value,
                                                                        shipping_document_checker : document.getElementById('checkerID').value,
                                                                    })
                                                                    .then(function(result) {
                                                                        document.querySelector('#btn-close-modal').click();
                                                                        Shipping.initDatabase();
                                                                        Swal.fire(
                                                                            'Success to Declined the Shipping Document',
                                                                            `Your shipping document has been declined because ${document.getElementById('notesShippingDocument').value}`,
                                                                            'success'
                                                                        );
                                                                    })
                                                                }
                                                            })
                                                        }else{
                                                            Swal.fire(
                                                                'Error!',
                                                                'Please give your reason on the notes!',
                                                                'error'
                                                            );
                                                        }
                                                    }
                                                    document.getElementById("detail-shippingDocument").appendChild(btnShippingDocumentDecline);
                                                // --

                                                document.getElementById("detail-shippingDocument").appendChild(document.createElement("br"));
                                                document.getElementById("detail-shippingDocument").appendChild(document.createElement("br"));

                                                // Button Accept
                                                    let btnShippingDocumentAccept = document.createElement("button");
                                                    btnShippingDocumentAccept.innerHTML = "Acccept";
                                                    btnShippingDocumentAccept.setAttribute("type", "button");
                                                    btnShippingDocumentAccept.setAttribute("class", "btn btn-active-color-light btn-outline-success border border-success w-100");
                                                    btnShippingDocumentAccept.onclick = function () {
                                                        Swal.fire({
                                                            title: "Are you sure to Accept the Shipping Document? You won't be able to revert this!",
                                                            text: `Please makesure it`,
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#28a745',
                                                            cancelButtonColor: '#f8f9fa',
                                                            confirmButtonText: 'Yes, Accept it!'
                                                        }).then(function (result) {
                                                            if (result.isConfirmed) {
                                                                axios.put(`/api/shipping/acceptShippingDocument/${shipping.id}`, {
                                                                    shipping_document_notes : document.getElementById('notesShippingDocument').value,
                                                                    shipping_document_checker : document.getElementById('checkerID').value,
                                                                })
                                                                .then(function(result) {
                                                                    document.querySelector('#btn-close-modal').click();
                                                                    Shipping.initDatabase();
                                                                    Swal.fire(
                                                                        'Success to Accept the Shipping Document',
                                                                        `Your shipping document has been accepted`,
                                                                        'success'
                                                                    );
                                                                })
                                                            }
                                                        })
                                                    }
                                                    document.getElementById("detail-shippingDocument").appendChild(btnShippingDocumentAccept);
                                                // --
                                        }
                                    // --

                                    // Menampilkan semua detail
                                        if (statusShippingID <= -4 || statusShippingID >= 4) {
                                            // Menyiapkan data detail re-register
                                                let txtShippingDocumentChecker   = shipping.shipping_document_checker.name;
                                                let txtShippingDocumentDate      = formatDate(new Date(shipping.travel_document_check_date), 'day, dd month yyyy');
                                                let txtShippingDocumentStatus    = shipping.is_travel_document_accepted == 0 ? 'Declined' : 'Accepted';
                                                let txtShippingDocumentNotes     = shipping.travel_document_notes;
                                            // --

                                            // Menyiapkan element tabel agar tampilan lebih rapi
                                                let tableShippingDocument = document.createElement("table");

                                                let trShippingDocument1 = document.createElement("tr");
                                                let trShippingDocument2 = document.createElement("tr");
                                                let trShippingDocument3 = document.createElement("tr");
                                                let trShippingDocument4 = document.createElement("tr");
                                                let trShippingDocument5 = document.createElement("tr");

                                                let tdShippingDocument1_1 = document.createElement("td");
                                                let tdShippingDocument1_2 = document.createElement("td");
                                                let tdShippingDocument1_3 = document.createElement("td");

                                                let tdShippingDocument2_1 = document.createElement("td");

                                                let tdShippingDocument3_1 = document.createElement("td");
                                                let tdShippingDocument3_2 = document.createElement("td");
                                                let tdShippingDocument3_3 = document.createElement("td");

                                                let tdShippingDocument4_1 = document.createElement("td");
                                                let tdShippingDocument4_2 = document.createElement("td");
                                                let tdShippingDocument4_3 = document.createElement("td");

                                                let tdShippingDocument5_1 = document.createElement("td");
                                                let tdShippingDocument5_2 = document.createElement("td");
                                                let tdShippingDocument5_3 = document.createElement("td");

                                                tdShippingDocument1_1.setAttribute("style", "width: 25vh;");
                                                tdShippingDocument2_1.setAttribute("colspan", "3");
                                                tdShippingDocument3_1.setAttribute("style", "width: 25vh;");
                                                tdShippingDocument4_1.setAttribute("style", "width: 25vh;");
                                                tdShippingDocument5_1.setAttribute("style", "width: 25vh;");
                                            // --

                                            // Mengisi detail re-register dalam tabel
                                                tdShippingDocument1_1.innerHTML = "Checker";
                                                tdShippingDocument1_2.innerHTML = ":";
                                                tdShippingDocument1_3.innerHTML = txtShippingDocumentChecker;

                                                tdShippingDocument2_1.innerHTML = "<br>";

                                                tdShippingDocument3_1.innerHTML = "Datetime";
                                                tdShippingDocument3_2.innerHTML = ":";
                                                tdShippingDocument3_3.innerHTML = txtShippingDocumentDate;

                                                tdShippingDocument4_1.innerHTML = "Status";
                                                tdShippingDocument4_2.innerHTML = ":";
                                                tdShippingDocument4_3.innerHTML = txtShippingDocumentStatus;

                                                tdShippingDocument5_1.innerHTML = "Notes";
                                                tdShippingDocument5_2.innerHTML = ":";
                                                tdShippingDocument5_3.innerHTML = txtShippingDocumentNotes;
                                            // --

                                            // Menggabungkan hingga ke div#detail-ShippingDocument
                                                trShippingDocument1.appendChild(tdShippingDocument1_1);
                                                trShippingDocument1.appendChild(tdShippingDocument1_2);
                                                trShippingDocument1.appendChild(tdShippingDocument1_3);

                                                trShippingDocument2.appendChild(tdShippingDocument2_1);

                                                trShippingDocument3.appendChild(tdShippingDocument3_1);
                                                trShippingDocument3.appendChild(tdShippingDocument3_2);
                                                trShippingDocument3.appendChild(tdShippingDocument3_3);

                                                trShippingDocument4.appendChild(tdShippingDocument4_1);
                                                trShippingDocument4.appendChild(tdShippingDocument4_2);
                                                trShippingDocument4.appendChild(tdShippingDocument4_3);

                                                trShippingDocument5.appendChild(tdShippingDocument5_1);
                                                trShippingDocument5.appendChild(tdShippingDocument5_2);
                                                trShippingDocument5.appendChild(tdShippingDocument5_3);

                                                tableShippingDocument.appendChild(trShippingDocument1);
                                                tableShippingDocument.appendChild(trShippingDocument2);
                                                tableShippingDocument.appendChild(trShippingDocument3);
                                                tableShippingDocument.appendChild(trShippingDocument4);
                                                tableShippingDocument.appendChild(trShippingDocument5);

                                                document.getElementById("detail-shippingDocument").appendChild(tableShippingDocument);
                                            //
                                        }
                                    // --

                                    document.getElementById("detail-shippingDocument").appendChild(document.createElement("br"));
                                    document.getElementById("detail-shippingDocument").appendChild(document.createElement("hr"));
                                    document.getElementById("detail-shippingDocument").appendChild(document.createElement("br"));
                                }
                            // --

                            // Check Result
                                /*
                                    Check Result hanya akan tampil untuk shipping status -5 atau >= 4
                                    Penjelasan Isi  :
                                    -   Status 4                -> Menampilkan form Transportation Weight
                                    -   Status 5                -> Menampilkan form Raw Material's Quality dan menampilkan result trans weight
                                    -   Status 6                -> Menampilkan result trans weight and raw material's quality
                                    -   Status -5 atau 7        -> Menampilkan semua detail
                                */
                                if (statusShippingID == -5 || statusShippingID >= 4) {
                                    // Menampilkan header Detail Re Register
                                        let H2_CheckResult = document.createElement('H2');
                                        H2_CheckResult.innerHTML = "CHECK RESULT <br> <br>";
                                        document.getElementById("detail-checkResult").appendChild(H2_CheckResult);
                                    // --

                                    // Menampilkan Form Weight Check
                                        let H4_TitleBruTransWeight = document.createElement('H4');
                                        H4_TitleBruTransWeight.innerHTML = "Transportation Weight (With Raw Material) <br>";
                                        document.getElementById("detail-checkResult").appendChild(H4_TitleBruTransWeight);

                                        if (shipping.bru_transportation_weight == null) {
                                            let span_txtFormBruTransWeight = document.createElement('span');
                                            span_txtFormBruTransWeight.innerHTML = "<br>Weight (Kg) :<br>";
                                            document.getElementById("detail-checkResult").appendChild(span_txtFormBruTransWeight);

                                            let input_txtFormBruTransWeight = document.createElement('input');
                                            input_txtFormBruTransWeight.setAttribute('type', 'text');
                                            input_txtFormBruTransWeight.setAttribute('name', 'inputTxtFormBruTransWeight');
                                            input_txtFormBruTransWeight.setAttribute('id', 'inputTxtFormBruTransWeight');
                                            input_txtFormBruTransWeight.setAttribute('class', 'form-control w-100');
                                            document.getElementById("detail-checkResult").appendChild(input_txtFormBruTransWeight);

                                            document.getElementById("detail-checkResult").appendChild(document.createElement("br"));

                                            let btn_submitFormBruTransWeight = document.createElement('button');
                                            btn_submitFormBruTransWeight.setAttribute("class", "btn btn-active-color-light btn-outline-success border border-success w-100");
                                            btn_submitFormBruTransWeight.setAttribute("type", "button");
                                            btn_submitFormBruTransWeight.innerText= "Submit Transportation Weight (With Raw Material)";
                                            btn_submitFormBruTransWeight.onclick = function () {
                                                let txtBruTransWeight = document.getElementById('inputTxtFormBruTransWeight').value;
                                                Swal.fire({
                                                    title: 'Are you sure to Submit the Transportation Weight with Raw Material is ?' + txtBruTransWeight,
                                                    text: "You won't be able to revert this!",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#28a745',
                                                        cancelButtonColor: '#f8f9fa',
                                                    confirmButtonText: "Yes, I'm sure"
                                                    }).then(function (result) {
                                                    if (result.isConfirmed) {
                                                        axios.put(`/api/shipping/updateBruttoWeightTrans/${shipping.id}`, {
                                                            bru_transportation_weight : txtBruTransWeight,
                                                            bru_transportation_weight_checker : document.getElementById('checkerID').value,
                                                        })
                                                        .then(function(result) {
                                                            document.querySelector('#btn-close-modal').click();
                                                            Shipping.initDatabase();
                                                            Swal.fire(
                                                            'Success to update the Transportation Weight with Raw Material',
                                                            'Your update has been success',
                                                            'success'
                                                            );
                                                        })
                                                    }
                                                })
                                            };
                                            document.getElementById("detail-checkResult").appendChild(btn_submitFormBruTransWeight);

                                        }else{
                                            let txtBruTransWeightChecker    = shipping.bru_trans_weight_checker.name;
                                            let txtBruTransWeightCheckDate  = formatDate(new Date(shipping.bru_transportation_weight_check_date), 'day, dd month yyyy');
                                            let txtBruTransWeight           = shipping.bru_transportation_weight;

                                            let table_bruTransWeight = document.createElement('table');

                                            let tr_bruTransWeight_1    = document.createElement('tr');
                                            let tr_bruTransWeight_2    = document.createElement('tr');
                                            let tr_bruTransWeight_3    = document.createElement('tr');

                                            let td_bruTransWeight_1_1  = document.createElement('td');
                                            let td_bruTransWeight_1_2  = document.createElement('td');
                                            let td_bruTransWeight_1_3  = document.createElement('td');

                                            let td_bruTransWeight_2_1  = document.createElement('td');
                                            let td_bruTransWeight_2_2  = document.createElement('td');
                                            let td_bruTransWeight_2_3  = document.createElement('td');

                                            let td_bruTransWeight_3_1  = document.createElement('td');
                                            let td_bruTransWeight_3_2  = document.createElement('td');
                                            let td_bruTransWeight_3_3  = document.createElement('td');

                                            td_bruTransWeight_1_1.setAttribute('style', 'width: 25vh');
                                            td_bruTransWeight_2_1.setAttribute('style', 'width: 25vh');
                                            td_bruTransWeight_3_1.setAttribute('style', 'width: 25vh');

                                            td_bruTransWeight_1_1.innerHTML = "Checker";
                                            td_bruTransWeight_1_2.innerHTML = " : ";
                                            td_bruTransWeight_1_3.innerHTML = txtBruTransWeightChecker;

                                            td_bruTransWeight_2_1.innerHTML = "Datetime";
                                            td_bruTransWeight_2_2.innerHTML = " : ";
                                            td_bruTransWeight_2_3.innerHTML = txtBruTransWeightCheckDate;

                                            td_bruTransWeight_3_1.innerHTML = "Weight";
                                            td_bruTransWeight_3_2.innerHTML = " : ";
                                            td_bruTransWeight_3_3.innerHTML = txtBruTransWeight + " Kg";

                                            tr_bruTransWeight_1.appendChild(td_bruTransWeight_1_1);
                                            tr_bruTransWeight_1.appendChild(td_bruTransWeight_1_2);
                                            tr_bruTransWeight_1.appendChild(td_bruTransWeight_1_3);

                                            tr_bruTransWeight_2.appendChild(td_bruTransWeight_2_1);
                                            tr_bruTransWeight_2.appendChild(td_bruTransWeight_2_2);
                                            tr_bruTransWeight_2.appendChild(td_bruTransWeight_2_3);

                                            tr_bruTransWeight_3.appendChild(td_bruTransWeight_3_1);
                                            tr_bruTransWeight_3.appendChild(td_bruTransWeight_3_2);
                                            tr_bruTransWeight_3.appendChild(td_bruTransWeight_3_3);

                                            table_bruTransWeight.appendChild(tr_bruTransWeight_1);
                                            table_bruTransWeight.appendChild(tr_bruTransWeight_2);
                                            table_bruTransWeight.appendChild(tr_bruTransWeight_3);

                                            document.getElementById("detail-checkResult").appendChild(table_bruTransWeight);

                                            document.getElementById("detail-checkResult").appendChild(document.createElement("br"));

                                            let H4_TitleNetTransWeight = document.createElement('H4');
                                            H4_TitleNetTransWeight.innerHTML = "Transportation Weight (Without Raw Material) <br>";
                                            document.getElementById("detail-checkResult").appendChild(H4_TitleNetTransWeight);

                                            if (shipping.net_transportation_weight == null) {
                                                let span_txtFormNetTransWeight = document.createElement('span');
                                                span_txtFormNetTransWeight.innerHTML = "<br>Weight (Kg) :<br>";
                                                document.getElementById("detail-checkResult").appendChild(span_txtFormNetTransWeight);

                                                let input_txtFormNetTransWeight = document.createElement('input');
                                                input_txtFormNetTransWeight.setAttribute('type', 'text');
                                                input_txtFormNetTransWeight.setAttribute('name', 'inputTxtFormNetTransWeight');
                                                input_txtFormNetTransWeight.setAttribute('id', 'inputTxtFormNetTransWeight');
                                                input_txtFormNetTransWeight.setAttribute('class', 'form-control w-100');
                                                document.getElementById("detail-checkResult").appendChild(input_txtFormNetTransWeight);

                                                document.getElementById("detail-checkResult").appendChild(document.createElement("br"));

                                                let btn_submitFormNetTransWeight = document.createElement('button');
                                                btn_submitFormNetTransWeight.setAttribute("class", "btn btn-active-color-light btn-outline-success border border-success w-100");
                                                btn_submitFormNetTransWeight.setAttribute("type", "button");
                                                btn_submitFormNetTransWeight.innerText= "Submit Transportation Weight (Without Raw Material)";
                                                btn_submitFormNetTransWeight.onclick = function () {
                                                    let txtNetTransWeight = document.getElementById('inputTxtFormNetTransWeight').value;
                                                    Swal.fire({
                                                        title: 'Are you sure to Submit the Transportation Weight without Raw Material is ?' + txtNetTransWeight,
                                                        text: "You won't be able to revert this!",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#28a745',
                                                            cancelButtonColor: '#f8f9fa',
                                                        confirmButtonText: "Yes, I'm sure"
                                                        }).then(function (result) {
                                                        if (result.isConfirmed) {
                                                            axios.put(`/api/shipping/updateNettoWeightTrans/${shipping.id}`, {
                                                                net_transportation_weight : txtNetTransWeight,
                                                                net_transportation_weight_checker : document.getElementById('checkerID').value,
                                                            })
                                                            .then(function(result) {
                                                                document.querySelector('#btn-close-modal').click();
                                                                Shipping.initDatabase();
                                                                Swal.fire(
                                                                'Success to update the Transportation Weight without Raw Material',
                                                                'Your update has been success.',
                                                                'success'
                                                                );
                                                            })
                                                        }
                                                    })
                                                };
                                                document.getElementById("detail-checkResult").appendChild(btn_submitFormNetTransWeight);
                                            }else{
                                                let txtNetTransWeightChecker    = shipping.net_trans_weight_checker.name;
                                                let txtNetTransWeightCheckDate  = formatDate(new Date(shipping.net_transportation_weight_check_date), 'day, dd month yyyy');
                                                let txtNetTransWeight           = shipping.net_transportation_weight;

                                                let table_netTransWeight = document.createElement('table');

                                                let tr_netTransWeight_1    = document.createElement('tr');
                                                let tr_netTransWeight_2    = document.createElement('tr');
                                                let tr_netTransWeight_3    = document.createElement('tr');

                                                let td_netTransWeight_1_1  = document.createElement('td');
                                                let td_netTransWeight_1_2  = document.createElement('td');
                                                let td_netTransWeight_1_3  = document.createElement('td');

                                                let td_netTransWeight_2_1  = document.createElement('td');
                                                let td_netTransWeight_2_2  = document.createElement('td');
                                                let td_netTransWeight_2_3  = document.createElement('td');

                                                let td_netTransWeight_3_1  = document.createElement('td');
                                                let td_netTransWeight_3_2  = document.createElement('td');
                                                let td_netTransWeight_3_3  = document.createElement('td');

                                                td_netTransWeight_1_1.setAttribute('style', 'width: 25vh');
                                                td_netTransWeight_2_1.setAttribute('style', 'width: 25vh');
                                                td_netTransWeight_3_1.setAttribute('style', 'width: 25vh');

                                                td_netTransWeight_1_1.innerHTML = "Checker";
                                                td_netTransWeight_1_2.innerHTML = " : ";
                                                td_netTransWeight_1_3.innerHTML = txtNetTransWeightChecker;

                                                td_netTransWeight_2_1.innerHTML = "Datetime";
                                                td_netTransWeight_2_2.innerHTML = " : ";
                                                td_netTransWeight_2_3.innerHTML = txtNetTransWeightCheckDate;

                                                td_netTransWeight_3_1.innerHTML = "Weight";
                                                td_netTransWeight_3_2.innerHTML = " : ";
                                                td_netTransWeight_3_3.innerHTML = txtNetTransWeight + " Kg";

                                                tr_netTransWeight_1.appendChild(td_netTransWeight_1_1);
                                                tr_netTransWeight_1.appendChild(td_netTransWeight_1_2);
                                                tr_netTransWeight_1.appendChild(td_netTransWeight_1_3);

                                                tr_netTransWeight_2.appendChild(td_netTransWeight_2_1);
                                                tr_netTransWeight_2.appendChild(td_netTransWeight_2_2);
                                                tr_netTransWeight_2.appendChild(td_netTransWeight_2_3);

                                                tr_netTransWeight_3.appendChild(td_netTransWeight_3_1);
                                                tr_netTransWeight_3.appendChild(td_netTransWeight_3_2);
                                                tr_netTransWeight_3.appendChild(td_netTransWeight_3_3);

                                                table_netTransWeight.appendChild(tr_netTransWeight_1);
                                                table_netTransWeight.appendChild(tr_netTransWeight_2);
                                                table_netTransWeight.appendChild(tr_netTransWeight_3);

                                                document.getElementById("detail-checkResult").appendChild(table_netTransWeight);

                                                document.getElementById("detail-checkResult").appendChild(document.createElement("br"));

                                                let H4_RawMaterialQuality = document.createElement('H4');
                                                H4_RawMaterialQuality.innerHTML = "Raw Material's Quality <br>";
                                                document.getElementById("detail-checkResult").appendChild(H4_RawMaterialQuality);

                                                if (shipping.afval_quality_notes == null) {
                                                    // Notes
                                                        let spanNotes = document.createElement("span");
                                                        spanNotes.innerHTML = "Quality's Notes";
                                                        document.getElementById("detail-checkResult").appendChild(spanNotes);

                                                        let inputTextAreaNotes = document.createElement("textarea");
                                                        inputTextAreaNotes.setAttribute("class", "form-control");
                                                        inputTextAreaNotes.setAttribute("cols", "30");
                                                        inputTextAreaNotes.setAttribute("rows", "10");
                                                        inputTextAreaNotes.setAttribute("id", "notesAfvalQuality");
                                                        inputTextAreaNotes.setAttribute("name", "notesAfvalQuality");
                                                        document.getElementById("detail-checkResult").appendChild(inputTextAreaNotes);
                                                    // --

                                                    document.getElementById("detail-checkResult").appendChild(document.createElement("br"));
                                                    document.getElementById("detail-checkResult").appendChild(document.createElement("br"));

                                                    let btn_submitFormAfvalQuality = document.createElement('button');
                                                    btn_submitFormAfvalQuality.setAttribute("class", "btn btn-active-color-light btn-outline-success border border-success w-100");
                                                    btn_submitFormAfvalQuality.setAttribute("type", "button");
                                                    btn_submitFormAfvalQuality.innerText= "Submit Quality's Notes";
                                                    btn_submitFormAfvalQuality.onclick = function () {
                                                        let txtAfvalQuality = document.getElementById('notesAfvalQuality').value;

                                                        if (txtAfvalQuality != '') {
                                                            Swal.fire({
                                                                title: "Are you sure to Submit the Raw Material's Quality Notes?",
                                                                text: "Make sure the notes contains descripe the Raw Material's Quality",
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#28a745',
                                                                    cancelButtonColor: '#f8f9fa',
                                                                confirmButtonText: "Yes, I'm sure"
                                                                }).then(function (result) {
                                                                if (result.isConfirmed) {
                                                                    axios.put(`/api/shipping/updateAfvalQuality/${shipping.id}`, {
                                                                        afval_quality_notes : txtAfvalQuality,
                                                                        afval_quality_checker : document.getElementById('checkerID').value,
                                                                    })
                                                                    .then(function(result) {
                                                                        document.querySelector('#btn-close-modal').click();
                                                                        Shipping.initDatabase();
                                                                        Swal.fire(
                                                                        'Success to give notes for descripe quality of the raw material',
                                                                        'Your update has been success.',
                                                                        'success'
                                                                        );
                                                                    })
                                                                }
                                                            })
                                                        }else{
                                                            Swal.fire(
                                                                'Error!',
                                                                "You must descripe the Raw Material's Quality on the Notes",
                                                                'error'
                                                            );
                                                        }

                                                    };
                                                    document.getElementById("detail-checkResult").appendChild(btn_submitFormAfvalQuality);
                                                }else{
                                                    let txtAfvalQualityChecker      = shipping.afval_quality_checker.name;
                                                    let txtAfvalQualityCheckDate    = formatDate(new Date(shipping.afval_quality_check_date), 'day, dd month yyyy');
                                                    let txtAfvalQualityNotes        = shipping.afval_quality_notes;

                                                    let table_afvalQuality = document.createElement('table');

                                                    let tr_afvalQuality_1    = document.createElement('tr');
                                                    let tr_afvalQuality_2    = document.createElement('tr');
                                                    let tr_afvalQuality_3    = document.createElement('tr');

                                                    let td_afvalQuality_1_1  = document.createElement('td');
                                                    let td_afvalQuality_1_2  = document.createElement('td');
                                                    let td_afvalQuality_1_3  = document.createElement('td');

                                                    let td_afvalQuality_2_1  = document.createElement('td');
                                                    let td_afvalQuality_2_2  = document.createElement('td');
                                                    let td_afvalQuality_2_3  = document.createElement('td');

                                                    let td_afvalQuality_3_1  = document.createElement('td');
                                                    let td_afvalQuality_3_2  = document.createElement('td');
                                                    let td_afvalQuality_3_3  = document.createElement('td');

                                                    td_afvalQuality_1_1.setAttribute('style', 'width: 25vh');
                                                    td_afvalQuality_2_1.setAttribute('style', 'width: 25vh');
                                                    td_afvalQuality_3_1.setAttribute('style', 'width: 25vh');

                                                    td_afvalQuality_1_1.innerHTML = "Checker";
                                                    td_afvalQuality_1_2.innerHTML = " : ";
                                                    td_afvalQuality_1_3.innerHTML = txtAfvalQualityChecker;

                                                    td_afvalQuality_2_1.innerHTML = "Datetime";
                                                    td_afvalQuality_2_2.innerHTML = " : ";
                                                    td_afvalQuality_2_3.innerHTML = txtAfvalQualityCheckDate;

                                                    td_afvalQuality_3_1.innerHTML = "Weight";
                                                    td_afvalQuality_3_2.innerHTML = " : ";
                                                    td_afvalQuality_3_3.innerHTML = txtAfvalQualityNotes;

                                                    tr_afvalQuality_1.appendChild(td_afvalQuality_1_1);
                                                    tr_afvalQuality_1.appendChild(td_afvalQuality_1_2);
                                                    tr_afvalQuality_1.appendChild(td_afvalQuality_1_3);

                                                    tr_afvalQuality_2.appendChild(td_afvalQuality_2_1);
                                                    tr_afvalQuality_2.appendChild(td_afvalQuality_2_2);
                                                    tr_afvalQuality_2.appendChild(td_afvalQuality_2_3);

                                                    tr_afvalQuality_3.appendChild(td_afvalQuality_3_1);
                                                    tr_afvalQuality_3.appendChild(td_afvalQuality_3_2);
                                                    tr_afvalQuality_3.appendChild(td_afvalQuality_3_3);

                                                    table_afvalQuality.appendChild(tr_afvalQuality_1);
                                                    table_afvalQuality.appendChild(tr_afvalQuality_2);
                                                    table_afvalQuality.appendChild(tr_afvalQuality_3);

                                                    document.getElementById("detail-checkResult").appendChild(table_afvalQuality);

                                                    document.getElementById("detail-checkResult").appendChild(document.createElement("br"));

                                                    let H4_FinalResult = document.createElement('H4');
                                                    H4_FinalResult.innerHTML = "Final Result";
                                                    document.getElementById("detail-checkResult").appendChild(H4_FinalResult);

                                                    if (shipping.is_accepted == null) {
                                                        // Notes
                                                            let spanNotes = document.createElement("span");
                                                            spanNotes.innerHTML = "Notes";
                                                            document.getElementById("detail-checkResult").appendChild(spanNotes);

                                                            let inputTextAreaNotes = document.createElement("textarea");
                                                            inputTextAreaNotes.setAttribute("class", "form-control");
                                                            inputTextAreaNotes.setAttribute("cols", "30");
                                                            inputTextAreaNotes.setAttribute("rows", "10");
                                                            inputTextAreaNotes.setAttribute("id", "notesFinalResult");
                                                            inputTextAreaNotes.setAttribute("name", "notesFinalResult");
                                                            document.getElementById("detail-checkResult").appendChild(inputTextAreaNotes);
                                                        // --

                                                        document.getElementById("detail-checkResult").appendChild(document.createElement("br"));
                                                        document.getElementById("detail-checkResult").appendChild(document.createElement("br"));

                                                        //  Button Decline
                                                            let btnFinalResultDecline = document.createElement("button");
                                                            btnFinalResultDecline.innerHTML = "Rejected Raw Material";
                                                            btnFinalResultDecline.setAttribute("type", "button");
                                                            btnFinalResultDecline.setAttribute("class", "btn btn-active-color-light btn-outline-danger border border-danger w-100");
                                                            btnFinalResultDecline.onclick = function () {
                                                                if (document.getElementById('notesFinalResult').value != '') {
                                                                    Swal.fire({
                                                                        title: "Are you sure to Decline the Shipping? You won't be able to revert this!",
                                                                        text: `Reason : ${document.getElementById('notesFinalResult').value}`,
                                                                        icon: 'warning',
                                                                        showCancelButton: true,
                                                                        confirmButtonColor: '#dc3545',
                                                                        cancelButtonColor: '#f8f9fa',
                                                                        confirmButtonText: 'Yes, Decline it!'
                                                                    }).then(function (result) {
                                                                        if (result.isConfirmed) {
                                                                            axios.put(`/api/shipping/declineShipping/${shipping.id}`, {
                                                                                is_accepted_notes : document.getElementById('notesFinalResult').value,
                                                                                is_accepted_checker : document.getElementById('checkerID').value,
                                                                                net_afval_weight : parseInt(shipping.bru_transportation_weight) - parseInt(shipping.net_transportation_weight)
                                                                            })
                                                                            .then(function(result) {
                                                                                document.querySelector('#btn-close-modal').click();
                                                                                Shipping.initDatabase();
                                                                                Swal.fire(
                                                                                    'Success to Declined the Raw Material',
                                                                                    `Your Raw Material has been declined because ${document.getElementById('notesShippingDocument').value}`,
                                                                                    'success'
                                                                                );
                                                                            })
                                                                        }
                                                                    })
                                                                }else{
                                                                    Swal.fire(
                                                                        'Error!',
                                                                        'Please give your reason on the notes!',
                                                                        'error'
                                                                    );
                                                                }
                                                            }
                                                            document.getElementById("detail-checkResult").appendChild(btnFinalResultDecline);
                                                        // --

                                                        document.getElementById("detail-checkResult").appendChild(document.createElement("br"));
                                                        document.getElementById("detail-checkResult").appendChild(document.createElement("br"));

                                                        // Button Accept
                                                            let btnFinalResultAccept = document.createElement("button");
                                                            btnFinalResultAccept.innerHTML = "Claim the Raw Materia";
                                                            btnFinalResultAccept.setAttribute("type", "button");
                                                            btnFinalResultAccept.setAttribute("class", "btn btn-active-color-light btn-outline-success border border-success w-100");
                                                            btnFinalResultAccept.onclick = function () {
                                                                Swal.fire({
                                                                    title: "Are you sure to Claim the Raw Material? You won't be able to revert this!",
                                                                    text: `Please makesure it`,
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#28a745',
                                                                    cancelButtonColor: '#f8f9fa',
                                                                    confirmButtonText: 'Yes, Accept it!'
                                                                }).then(function (result) {
                                                                    if (result.isConfirmed) {
                                                                        axios.put(`/api/shipping/acceptShipping/${shipping.id}`, {
                                                                            is_accepted_notes : document.getElementById('notesFinalResult').value,
                                                                            is_accepted_checker : document.getElementById('checkerID').value,
                                                                            net_afval_weight : parseInt(shipping.bru_transportation_weight) - parseInt(shipping.net_transportation_weight)
                                                                        })
                                                                        .then(function(result) {
                                                                            document.querySelector('#btn-close-modal').click();
                                                                            Shipping.initDatabase();
                                                                            Swal.fire(
                                                                                'Success',
                                                                                `The raw materia has been claimed`,
                                                                                'success'
                                                                            );
                                                                        })
                                                                    }
                                                                })
                                                            }
                                                            document.getElementById("detail-checkResult").appendChild(btnFinalResultAccept);
                                                        // --
                                                    }else{
                                                        let txtFinalResultChecker      = shipping.final_checker.name;
                                                        let txtFinalResultCheckDate    = formatDate(new Date(shipping.is_accepted_date), 'day, dd month yyyy');
                                                        let txtFinalResultNotes        = shipping.notes;
                                                        let txtFinalResultStatus       = shipping.is_accepted == 0 ? 'Rejected' : 'Claimed';
                                                        let txtFinalResultNetAfval     = shipping.net_afval_weight;

                                                        let table_FinalResult = document.createElement('table');

                                                        let tr_FinalResult_1    = document.createElement('tr');
                                                        let tr_FinalResult_2    = document.createElement('tr');
                                                        let tr_FinalResult_3    = document.createElement('tr');
                                                        let tr_FinalResult_4    = document.createElement('tr');
                                                        let tr_FinalResult_5    = document.createElement('tr');
                                                        let tr_FinalResult_6    = document.createElement('tr');

                                                        let td_FinalResult_1_1  = document.createElement('td');
                                                        let td_FinalResult_1_2  = document.createElement('td');
                                                        let td_FinalResult_1_3  = document.createElement('td');

                                                        let td_FinalResult_2_1  = document.createElement('td');
                                                        let td_FinalResult_2_2  = document.createElement('td');
                                                        let td_FinalResult_2_3  = document.createElement('td');

                                                        let td_FinalResult_3_1  = document.createElement('td');

                                                        let td_FinalResult_4_1  = document.createElement('td');
                                                        let td_FinalResult_4_2  = document.createElement('td');
                                                        let td_FinalResult_4_3  = document.createElement('td');

                                                        let td_FinalResult_5_1  = document.createElement('td');
                                                        let td_FinalResult_5_2  = document.createElement('td');
                                                        let td_FinalResult_5_3  = document.createElement('td');

                                                        let td_FinalResult_6_1  = document.createElement('td');
                                                        let td_FinalResult_6_2  = document.createElement('td');
                                                        let td_FinalResult_6_3  = document.createElement('td');

                                                        td_FinalResult_1_1.setAttribute('style', 'width: 25vh');
                                                        td_FinalResult_2_1.setAttribute('style', 'width: 25vh');
                                                        td_FinalResult_3_1.setAttribute('colspan', '3');
                                                        td_FinalResult_4_1.setAttribute('style', 'width: 25vh');
                                                        td_FinalResult_5_1.setAttribute('style', 'width: 25vh');
                                                        td_FinalResult_6_1.setAttribute('style', 'width: 25vh');

                                                        td_FinalResult_1_1.innerHTML = "Checker";
                                                        td_FinalResult_1_2.innerHTML = " : ";
                                                        td_FinalResult_1_3.innerHTML = txtFinalResultChecker;

                                                        td_FinalResult_2_1.innerHTML = "Datetime";
                                                        td_FinalResult_2_2.innerHTML = " : ";
                                                        td_FinalResult_2_3.innerHTML = txtFinalResultCheckDate;

                                                        td_FinalResult_3_1.innerHTML = "<br>";

                                                        td_FinalResult_4_1.innerHTML = "Net Raw Material's Weight";
                                                        td_FinalResult_4_2.innerHTML = " : ";
                                                        td_FinalResult_4_3.innerHTML = txtFinalResultNetAfval + " Kg - " + shipping.afval.name;

                                                        td_FinalResult_5_1.innerHTML = "Status";
                                                        td_FinalResult_5_2.innerHTML = " : ";
                                                        td_FinalResult_5_3.innerHTML = txtFinalResultStatus;

                                                        td_FinalResult_6_1.innerHTML = "Notes";
                                                        td_FinalResult_6_2.innerHTML = " : ";
                                                        td_FinalResult_6_3.innerHTML = txtFinalResultNotes;

                                                        tr_FinalResult_1.appendChild(td_FinalResult_1_1);
                                                        tr_FinalResult_1.appendChild(td_FinalResult_1_2);
                                                        tr_FinalResult_1.appendChild(td_FinalResult_1_3);

                                                        tr_FinalResult_2.appendChild(td_FinalResult_2_1);
                                                        tr_FinalResult_2.appendChild(td_FinalResult_2_2);
                                                        tr_FinalResult_2.appendChild(td_FinalResult_2_3);

                                                        tr_FinalResult_3.appendChild(td_FinalResult_3_1);

                                                        tr_FinalResult_4.appendChild(td_FinalResult_4_1);
                                                        tr_FinalResult_4.appendChild(td_FinalResult_4_2);
                                                        tr_FinalResult_4.appendChild(td_FinalResult_4_3);

                                                        tr_FinalResult_5.appendChild(td_FinalResult_5_1);
                                                        tr_FinalResult_5.appendChild(td_FinalResult_5_2);
                                                        tr_FinalResult_5.appendChild(td_FinalResult_5_3);

                                                        tr_FinalResult_6.appendChild(td_FinalResult_6_1);
                                                        tr_FinalResult_6.appendChild(td_FinalResult_6_2);
                                                        tr_FinalResult_6.appendChild(td_FinalResult_6_3);

                                                        table_FinalResult.appendChild(tr_FinalResult_1);
                                                        table_FinalResult.appendChild(tr_FinalResult_2);
                                                        table_FinalResult.appendChild(tr_FinalResult_3);
                                                        table_FinalResult.appendChild(tr_FinalResult_4);
                                                        table_FinalResult.appendChild(tr_FinalResult_5);
                                                        table_FinalResult.appendChild(tr_FinalResult_6);

                                                        document.getElementById("detail-checkResult").appendChild(table_FinalResult);

                                                        document.getElementById("detail-checkResult").appendChild(document.createElement("br"));
                                                    }
                                                }
                                            }
                                        }
                                    // --


                                    document.getElementById("detail-checkResult").appendChild(document.createElement("br"));
                                    document.getElementById("detail-checkResult").appendChild(document.createElement("hr"));
                                    document.getElementById("detail-checkResult").appendChild(document.createElement("br"));
                                }
                            // --

                            // Button Cancel Shipping
                                /*
                                    Cancel Shipping hanya dapat dilakukan jika status shipping 0:Scheduled atau 1:Waiting Re Register
                                */
                                if (statusShippingID == 0 || statusShippingID == 1) {
                                    let btnCancelShipping = document.createElement("button");
                                    btnCancelShipping.setAttribute("class", "btn btn-active-color-light btn-outline-danger border border-danger w-100");
                                    btnCancelShipping.setAttribute("type", "button");
                                    btnCancelShipping.innerText= "Cancel Shipping";

                                    btnCancelShipping.onclick = function() {
                                        Swal.fire({
                                            title: 'Are you sure to Cancel this Shipping?',
                                            text: "You won't be able to revert this!",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#dc3545',
                                            cancelButtonColor: '#f8f9fa',
                                            confirmButtonText: 'Yes, cancel it!'
                                            }).then(function (result) {
                                            if (result.isConfirmed) {
                                                axios.put(`/api/shipping/cancelShipping/${shipping.id}`)
                                                .then(function(result) {
                                                    document.querySelector('#btn-close-modal').click();
                                                    Shipping.initDatabase();
                                                    Swal.fire(
                                                    'Success to Cancel the Shipping',
                                                    'Your shipping has been cancel it.',
                                                    'success'
                                                    );
                                                })
                                            }
                                            })
                                    }

                                    document.getElementById("cancelShipping").appendChild(btnCancelShipping);
                                    document.getElementById("cancelShipping").appendChild(document.createElement("br"));
                                    document.getElementById("cancelShipping").appendChild(document.createElement("br"));
                                }
                            // --
                        };
                        btn_detail.appendChild(icon_detail);
                    // end :: make btn View Detail


                    let div = document.createElement("div");
                    div.setAttribute("class", "d-flex justify-content-start flex-shrink-0");
                    div.appendChild(btn_detail);
                    // div.appendChild(btn_toogle);

                    td_1.innerHTML = ctrNo;
                    td_2.innerHTML =
                        shipping.supplier.name +
                        "<br>" +
                        shipping.supplier.phone;
                    td_3.innerHTML =
                        shipping.driver_name + "<br>" + shipping.driver_phone;
                    td_4.innerHTML =
                        shipping.transportation.name +
                        "<br>" +
                        shipping.license_plate;
                    td_5.innerHTML =
                        shipping.afval.name +
                        "<br>" +
                        shipping.afval_weight +
                        " Kg";
                    td_6.innerHTML = shipping.shipping_status.name + "<br> Type : " + (shipping.is_booking == '0' ? 'Regular' : 'Booking');
                    td_7.appendChild(div);

                    tr.appendChild(td_1);
                    tr.appendChild(td_2);
                    tr.appendChild(td_3);
                    tr.appendChild(td_4);
                    tr.appendChild(td_5);
                    tr.appendChild(td_6);
                    tr.appendChild(td_7);

                    // append li ke ul
                    bodyTable.appendChild(tr);
                }
                $("#kt_table_users").DataTable();
            });

            // Ambil data email
            axios.get("api/user/supplier").then(function (response) {
                document.querySelector("#supplierEmail").innerHTML = '';
                let suppliers = response.data;
                var selectSupplier = document.querySelector("#supplierEmail");
                selectSupplier.onchange = function (event) {
                    let supplier;
                    for (const supp of suppliers) {
                        if (supp.id == event.target.value) {
                            supplierID.value = supp.id;
                            supplierName.value = supp.name;
                            supplierPhone.value = supp.phone;
                            supplierAddress.value = supp.address;
                        }
                    }
                };
                // foreach bikin <option> lalu masukin di dalam select
                for (const supplier of suppliers) {
                    let optionSupplier = document.createElement("option");
                    optionSupplier.innerText = supplier.email;
                    optionSupplier.value = supplier.id;
                    selectSupplier.appendChild(optionSupplier);
                }
            });

            // Ambil data afval
            axios.get("api/afval").then(function (response) {

                document.querySelector("#afvalType").innerHTML = '';
                let afvals = response.data;
                var selectAfval = document.querySelector("#afvalType");
                // foreach bikin <option> lalu masukin di dalam select
                for (const afval of afvals) {
                    let optionAfval = document.createElement("option");
                    optionAfval.innerText = afval.name;
                    optionAfval.value = afval.id;
                    selectAfval.appendChild(optionAfval);
                }
            });

            // Ambil data transportation
            axios.get("api/transportation").then(function (response) {
                document.querySelector("#transportationType").innerHTML = '';
                let transportations = response.data;
                var selectTransportation = document.querySelector(
                    "#transportationType"
                );
                // foreach bikin <option> lalu masukin di dalam select
                for (const transportation of transportations) {
                    let optionTransportation = document.createElement("option");
                    optionTransportation.innerText = transportation.name;
                    optionTransportation.value = transportation.id;
                    selectTransportation.appendChild(optionTransportation);
                }
            });
        },
        initModalCreate: function () {
            formCreate = document.querySelector("#form-create-shipping");

            supplierID = document.querySelector("[name='supplierID']");
            shippingDate = document.querySelector("[id='shippingDate']");
            driverName = document.querySelector("[id='driverName']");
            driverPhone = document.querySelector("[id='driverPhone']");
            transportationType = document.querySelector("[id='transportationType']");
            licensePlate = document.querySelector("[id='licensePlate']");
            afvalType = document.querySelector("[id='afvalType']");
            afvalWeight = document.querySelector("[id='afvalWeight']");
            createdBy = document.querySelector("[name='createdBy']");

            formCreate.addEventListener("submit", function (e) {
                e.preventDefault();
                axios
                    .post(
                        `api/shipping`,
                        {
                            supplierID: supplierID.value,
                            supplierName: supplierName.value,
                            supplierPhone: supplierPhone.value,
                            shippingDate: shippingDate.value,
                            driverName: driverName.value,
                            driverPhone: driverPhone.value,
                            licensePlate: licensePlate.value,
                            transportationType: transportationType.value,
                            afvalType: afvalType.value,
                            afvalWeight: afvalWeight.value,
                            createdBy: createdBy.value
                        }
                    )
                    //Update Success
                    .then(function (response) {
                        document.querySelector("#btn-cancel-create").click();
                        window.location.reload();
                        Shipping.initDatabase();
                        Swal.fire({
                            text: "Berhasil Update",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                    })
                    //Update Failed
                    .catch(function (error) {
                        console.log(error.response.data);
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                    });
            });
        },
    };
})();
// Webpack support
if (typeof module !== "undefined") {
    module.exports = Shipping;
}
// On document ready
KTUtil.onDOMContentLoaded(function () {
    Shipping.initDatabase();
    Shipping.initModalCreate();
});
</script>
@endpush
