@extends('layouts.user_type.auth')

@section('content')
<div class="row">
    <div class="container-fluid">
        <div class="page-header min-height-200 border-radius-xl mt-2" style="background-image: url('../assets/img/home-decor-3.jpg'); background-position-y: 50%;">
            <span class="mask bg-gradient-dark opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6 my-4">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ auth()->user()->gambar_profile != null || auth()->user()->gambar_profile != '' ? auth()->user()->gambar_profile : '../pic/uni-user-4.png' }}" alt="..."
                          class="w-100 border-radius-lg shadow-sm bg-gradient-dark">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h4 class="text-dark font-weight-bolder m-0">Beli Koin</h4>
                        <h6 class="mb-1">
                            {{ auth()->user()->nama }}
                        </h6>
                        {{-- <p class="mb-0 font-weight-bold text-sm">
                            {{ (auth()->user()->role == 2 ? 'Penggemar' : 'Penjual') }}
                        </p> --}}
                    </div>
                </div>
                <div class="col-auto text-end my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 px-5"><!--col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3-->
                    <h6 class="mb-0 text-lg font-weight-bold">
                        <i class="fas fa-coins text-warning text-gradient text-lg p-1"></i> {{ $koin }} Koin
                    </h6>
                    <span class="text-sm">1 Koin = Rp 1.000,00 </span>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="container-fluid text-center">
        <hr class="horizontal dark my-2">
        <h4 class="text-dark px-2 font-weight-bolder m-0">Beli Koin</h4>
        <span class="text-sm font-weight-bold">1 Koin = Rp 1.000,00</span>
        <hr class="horizontal dark my-2">
    </div> --}}

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header mx-2 my-2 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
                        <i class="fas fa-coins opacity-10"></i>
                    </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="mb-0 font-weight-bolder">15 Koin</h6>
                        <span class="text-sm font-weight-bold">Rp. 15.000,-</span>
                        <hr class="horizontal dark my-2">
                        <button type="submit" class="btn-link btn text-info m-1" data-bs-toggle="modal" data-bs-target="#beli15"> Beli <i class="fas fa-money-bill text-info opacity-10 ps-2"></i></button><!---->
                        <!-- Modal Beli -->
                        <div class="modal fade" id="beli15" tabindex="-1" role="dialog" aria-labelledby="beli15Title" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{'/beli-koin'}}" method="POST" role="form">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="beli15Label">Beli Koin</h5>
                                        </div>
                                        <div class="modal-body">
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" value="15" id="koin" name="koin">
                                                <div class="input-group">
                                                    <span class="input-group-text font-weight-bolder">Jumlah :</span>
                                                    <input id="jumlah" name="jumlah" type="number" class="form-control text-center text-md" value="1" min="1" max="15">
                                                    <span class="input-group-text font-weight-bolder">* 15 Koin</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Kembali</button>
                                            <button type="submit" id='pay-button' class="btn bg-gradient-info">Buat Nota</button><!--data-bs-toggle="modal" data-bs-target="#checkout"-->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header mx-2 my-2 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
                        <i class="fas fa-coins opacity-10"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="mb-0 font-weight-bolder">25 Koin</h6>
                        <span class="text-sm font-weight-bold">Rp. 25.000,-</span>
                        <hr class="horizontal dark my-2">
                        <button class="btn-link btn text-info m-1" data-bs-toggle="modal" data-bs-target="#beli25"> Beli <i class="fas fa-money-bill text-info opacity-10 ps-2"></i></button>
                        <!-- Modal Beli -->
                        <div class="modal fade" id="beli25" tabindex="-1" role="dialog" aria-labelledby="beli25Title" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{'/beli-koin'}}" method="POST" role="form">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="beli25Label">Beli Koin</h5>
                                        </div>
                                        <div class="modal-body">
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" value="25" id="koin" name="koin">
                                                <div class="input-group">
                                                    <span class="input-group-text font-weight-bolder">Jumlah :</span>
                                                    <input id="jumlah" name="jumlah" type="number" class="form-control text-center text-md" value="1" min="1" max="8">
                                                    <span class="input-group-text font-weight-bolder">* 25 Koin</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Kembali</button>
                                            <button type="submit" id='pay-button' class="btn bg-gradient-info">Buat Nota</button><!--data-bs-toggle="modal" data-bs-target="#checkout"-->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header mx-2 my-2 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
                        <i class="fas fa-coins opacity-10"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="mb-0 font-weight-bolder">40 Koin</h6>
                        <span class="text-sm font-weight-bold">Rp. 40.000,-</span>
                        <hr class="horizontal dark my-2">
                        <button class="btn-link btn text-info m-1" data-bs-toggle="modal" data-bs-target="#beli40"> Beli <i class="fas fa-money-bill text-info opacity-10 ps-2"></i></button>
                        <!-- Modal Beli -->
                        <div class="modal fade" id="beli40" tabindex="-1" role="dialog" aria-labelledby="beli40Title" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{'/beli-koin'}}" method="POST" role="form">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="beli40Label">Beli Koin</h5>
                                        </div>
                                        <div class="modal-body">
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" value="40" id="koin" name="koin">
                                                <div class="input-group">
                                                    <span class="input-group-text font-weight-bolder">Jumlah :</span>
                                                    <input id="jumlah" name="jumlah" type="number" class="form-control text-center text-md" value="1" min="1" max="5">
                                                    <span class="input-group-text font-weight-bolder">* 40 Koin</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Kembali</button>
                                            <button type="submit" id='pay-button' class="btn bg-gradient-info">Buat Nota</button><!--data-bs-toggle="modal" data-bs-target="#checkout"-->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header mx-2 my-2 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
                        <i class="fas fa-coins opacity-10"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="mb-0 font-weight-bolder">70 Koin</h6>
                        <span class="text-sm font-weight-bold">Rp. 70.000,-</span>
                        <hr class="horizontal dark my-2">
                        <button class="btn-link btn text-info m-1" data-bs-toggle="modal" data-bs-target="#beli70"> Beli <i class="fas fa-money-bill text-info opacity-10 ps-2"></i></button>
                        <!-- Modal Beli -->
                        <div class="modal fade" id="beli70" tabindex="-1" role="dialog" aria-labelledby="beli70Title" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{'/beli-koin'}}" method="POST" role="form">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="beli70Label">Beli Koin</h5>
                                        </div>
                                        <div class="modal-body">
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" value="70" id="koin" name="koin">
                                                <div class="input-group">
                                                    <span class="input-group-text font-weight-bolder">Jumlah :</span>
                                                    <input id="jumlah" name="jumlah" type="number" class="form-control text-center text-md" value="1"  min="1" max="3">
                                                    <span class="input-group-text font-weight-bolder">* 70 Koin</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Kembali</button>
                                            <button type="submit" id='pay-button' class="btn bg-gradient-info">Buat Nota</button><!--data-bs-toggle="modal" data-bs-target="#checkout"-->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
