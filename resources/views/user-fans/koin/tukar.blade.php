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
                        <h4 class="text-dark font-weight-bolder m-0">Tukar Koin</h4>
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
                        {{-- @php
                            $tgl = date('d').'-';
                            $tanggal = ( (int) date('d') );
                            $jam = ( (int) date('H') )+7;
                            if($jam >= 24) {$tanggal += 1; $jam = "0".($jam - 24);}
                            elseif($jam < 10) {$jam = "0".$jam;}
                            if($tanggal < 10) $tgl = date("Y-m")."-0".$tanggal.' '.$jam.date(':i:s');
                            else if ($tanggal < 32) $tgl = date("Y-m-").$tanggal.' '.$jam.date(':i:s');
                            $jumlahkoin = DB::table('transaksi_koin')
                                ->select(DB::raw('SUM(koin * jumlah) as total_koin'))
                                ->where('user_id','=',auth()->user()->id)
                                ->where('status', 'Berhasil')
                                ->first();
                            $total = 0;
                            if($jumlahkoin->total_koin != null) $total = $jumlahkoin->total_koin;
                            $deposito = DB::table('deposito_koin')
                                ->where('user_id','=',auth()->user()->id)
                                ->update([
                                    'koin' => $total,
                                    'tanggal_update' => $tgl
                                ]);
                            $koin = $total;
                        @endphp --}}
                        <i class="fas fa-coins text-warning text-gradient text-lg p-1"></i> {{ $koin }} Koin
                    </h6>
                    <span class="text-sm">1 Koin = Rp 1.000,00 </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid text-center">
        {{-- <hr class="horizontal dark my-2">
        <h4 class="text-dark px-2 font-weight-bolder m-0">Tukar Koin</h4>
        <span class="text-sm font-weight-bold">1 Koin = Rp 1.000,00</span><!-- 1 Koin = KRW 1.000 (Kurs Korean Won) = Rp 1.250,-  -->
        <hr class="horizontal dark my-2"> --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show text-sm" role="alert">
                <span class="text-sm alert-text text-white font-weight-bold">
                {{ $errors->first() }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
        @endif
        @if(session('success'))
            <div class="m-3 alert alert-success alert-dismissible fade show text-sm" id="alert-success" role="alert">
                <span class="text-sm alert-text text-white">
                {{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
        @endif
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
                        <i class="fas fa-money-bill opacity-10"></i>
                    </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="mb-0 font-weight-bolder">Rp. 15.000,-</h6><!--18.750-->
                        <span class="text-sm font-weight-bold">15 Koin</span>
                        <hr class="horizontal dark my-3">
                        <form action="{{'/tukar-koin'}}" method='post' role="form">
                            @csrf
                            {{-- penggemar: Penarikan koin ini bisa dilakukan setiap 7 (tujuh) hari sekali dengan menarik maksimal 100 (seratus) koin. --}}
                            {{-- penjual: Penarikan koin ini bisa dilakukan setiap 3 (tiga) hari sekali dengan menarik maksimal 200 (dua seratus) koin --}}
                            <div class="form-group">
                                <input type="hidden" value="15" id="koin" name="koin">
                                <div class="input-group">
                                    <span class="input-group-text font-weight-bold">Jumlah Paket:</span><!--100 @ 7hari fans/penjual 200 @ 3hari-->
                                    <input id="jumlah" name="jumlah" type="number" class="form-control text-center text-md" value="1" min="1" max="{{auth()->user()->role == 2 ? 6 : 13}}">
                                    {{-- <span class="input-group-text font-weight-bold">* 15</span> --}}
                                </div>
                            </div>
                            {{-- <div class="form-group"> --}}
                                {{-- <label for="jumlah" class="form-control-label">{{ __('Jumlah') }} <span class="text-danger">*</span></label> --}}
                                {{-- <div class="@error('jumlah') border border-danger rounded-3 @enderror"> --}}
                                    {{-- <input class="form-control" type="text" id="jumlah" name="jumlah" value=""> --}}
                                    {{-- @error('jumlah') --}}
                                        {{-- <p class="text-danger text-xs mt-2">{{ $message }}</p> --}}
                                    {{-- @enderror --}}
                                {{-- </div> --}}
                            {{-- </div> --}}
                            <button type="submit" class="btn btn-outline-info btn-md mb-0">
                                kirim permintaan  <i class="fas fa-envelope opacity-10 ps-2"></i>
                            </button><!--onclick='tukar(15)'-->
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
                        <i class="fas fa-money-bill opacity-10"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="mb-0 font-weight-bolder">Rp. 25.000,-</h6><!--31.250-->
                        <span class="text-sm font-weight-bold">25 Koin</span>
                        <hr class="horizontal dark my-3">
                        <form action="{{'/tukar-koin'}}" method='post' role="form">
                            @csrf
                            {{-- @if(session('success25'))
                                <div class="m-3 alert alert-success alert-dismissible fade show text-sm" id="alert-success" role="alert">
                                    <span class="alert-text text-white">
                                    {{ session('success25') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <i class="fa fa-close" aria-hidden="true"></i>
                                    </button>
                                </div>
                            @endif --}}
                            <div class="form-group">
                                <input type="hidden" value="25" id="koin" name="koin">
                                <div class="input-group">
                                    <span class="input-group-text font-weight-bold">Jumlah Paket:</span><!--100 @ 7hari fans/penjual 200 @ 3hari-->
                                    <input id="jumlah" name="jumlah" type="number" class="form-control text-center text-md" value="1" min="1" max="{{auth()->user()->role ? 4 : 8}}">
                                    {{-- <span class="input-group-text font-weight-bold">* 25</span> --}}
                                </div>
                            </div>
                            {{-- <div class="form-group"> --}}
                                {{-- <label for="jumlah" class="form-control-label">{{ __('Jumlah') }} <span class="text-danger">*</span></label> --}}
                                {{-- <div class="@error('jumlah') border border-danger rounded-3 @enderror"> --}}
                                    {{-- <input class="form-control" type="text" id="jumlah" name="jumlah" value=""> --}}
                                    {{-- @error('jumlah') --}}
                                        {{-- <p class="text-danger text-xs mt-2">{{ $message }}</p> --}}
                                    {{-- @enderror --}}
                                {{-- </div> --}}
                            {{-- </div> --}}
                            <button type="submit" class="btn btn-outline-info btn-md mb-0">
                                kirim permintaan  <i class="fas fa-envelope opacity-10 ps-2"></i>
                            </button><!--onclick='tukar(25)'-->
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
                        <i class="fas fa-money-bill opacity-10"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="mb-0 font-weight-bolder">Rp. 40.000,-</h6><!--50.000-->
                        <span class="text-sm font-weight-bold">40 Koin</span>
                        <hr class="horizontal dark my-3">
                        <form action="{{'/tukar-koin'}}" method='post' role="form">
                            @csrf
                            {{-- @if(session('success40'))
                                <div class="m-3 alert alert-success alert-dismissible fade show text-sm" id="alert-success" role="alert">
                                    <span class="alert-text text-white">
                                    {{ session('success40') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <i class="fa fa-close" aria-hidden="true"></i>
                                    </button>
                                </div>
                            @endif --}}
                            <div class="form-group">
                                <input type="hidden" value="40" id="koin" name="koin">
                                <div class="input-group">
                                    <span class="input-group-text font-weight-bold">Jumlah Paket:</span><!--100 @ 7hari fans/penjual 200 @ 3hari-->
                                    <input id="jumlah" name="jumlah" type="number" class="form-control text-center text-md" value="1" min="1" max="{{auth()->user()->role ? 2 : 5}}">
                                    {{-- <span class="input-group-text font-weight-bold">* 40</span> --}}
                                </div>
                            </div>
                            {{-- <div class="form-group"> --}}
                                {{-- <label for="jumlah" class="form-control-label">{{ __('Jumlah') }} <span class="text-danger">*</span></label> --}}
                                {{-- <div class="@error('jumlah') border border-danger rounded-3 @enderror"> --}}
                                    {{-- <input class="form-control" type="text" id="jumlah" name="jumlah" value=""> --}}
                                    {{-- @error('jumlah') --}}
                                        {{-- <p class="text-danger text-xs mt-2">{{ $message }}</p> --}}
                                    {{-- @enderror --}}
                                {{-- </div> --}}
                            {{-- </div> --}}
                            <button type="submit" class="btn btn-outline-info btn-md mb-0">
                                kirim permintaan  <i class="fas fa-envelope opacity-10 ps-2"></i>
                            </button><!--onclick='tukar(40)'-->
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
                        <i class="fas fa-money-bill opacity-10"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="mb-0 font-weight-bolder">Rp. 70.000,-</h6><!--87.500-->
                        <span class="text-sm font-weight-bold">70 Koin</span>
                        <hr class="horizontal dark my-3">
                        <form action="{{'/tukar-koin'}}" method='post' role="form">
                            @csrf
                            {{-- @if(session('success70'))
                                <div class="m-3 alert alert-success alert-dismissible fade show text-sm" id="alert-success" role="alert">
                                    <span class="alert-text text-white">
                                    {{ session('success70') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <i class="fa fa-close" aria-hidden="true"></i>
                                    </button>
                                </div>
                            @endif --}}
                            <div class="form-group">
                                <input type="hidden" value="70" id="koin" name="koin">
                                <div class="input-group">
                                    <span class="input-group-text font-weight-bold">Jumlah Paket:</span><!--100 @ 7hari fans/penjual 200 @ 3hari-->
                                    <input id="jumlah" name="jumlah" type="number" class="form-control text-center text-md" value="1" min="1" max="{{auth()->user()->role ? 1 : 2}}">
                                    {{-- <span class="input-group-text font-weight-bold">* 70</span> --}}
                                </div>
                            </div>
                            {{-- <div class="form-group"> --}}
                                {{-- <label for="jumlah" class="form-control-label">{{ __('Jumlah') }} <span class="text-danger">*</span></label> --}}
                                {{-- <div class="@error('jumlah') border border-danger rounded-3 @enderror"> --}}
                                    {{-- <input class="form-control" type="text" id="jumlah" name="jumlah" value=""> --}}
                                    {{-- @error('jumlah') --}}
                                        {{-- <p class="text-danger text-xs mt-2">{{ $message }}</p> --}}
                                    {{-- @enderror --}}
                                {{-- </div> --}}
                            {{-- </div> --}}
                            <button type="submit" class="btn btn-outline-info btn-md mb-0">
                                kirim permintaan  <i class="fas fa-envelope opacity-10 ps-2"></i>
                            </button><!--onclick='tukar(70)'-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">
    function tukar(koin) {
        // let jumlah = document.getElementById('jumlah').value;
        // let uang = document.getElementById('uang').value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'POST',
            url:'/tukar-koin',
            data:{
                koin: koin,
                jumlah: jumlah,
                // uang: uang,
                },
            success:function(data){
                alert($data['pesan']);
            }
        });
        // alert('Anda Sukses Melakukan Pembayaran');
        // window.location.href = url('/nota-koin');
    };
</script>
