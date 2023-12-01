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
                        {{-- <a href="javascript:;" class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                            <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Image"></i>
                        </a> --}}
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->nama }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ (auth()->user()->role == 2 ? 'Penggemar (Fans)' : 'Penjual') }}
                        </p>
                    </div>
                </div>
                <div class="col-auto text-end my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 px-5"><!--col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3-->
                    <h6 class="mb-0 text-lg font-weight-bold">
                       <i class="fas fa-coins text-warning text-gradient text-lg me-1 py-1"></i> {{ $depositoku }} Koin
                    </h6>
                    {{-- @if($status == 'Belum')
                    <span class="font-weight-bold text-danger text-sm">
                        (Koin Anda belum {{ $jenis == 'lelang' ? 'dipotong dengan Jumlah Penawaran Anda' :
                        ($jenis == 'lelang-penjual' ? 'ditambah dengan Hasil Lelang Anda' : '')}})
                    </span>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <hr class="horizontal dark my-2">
        <h4 class="text-dark p-2 pb-1 text-center font-weight-bolder m-0">Cek Harga Ongkos Pengiriman</h4>
        <hr class="horizontal dark">
        <div class="row mt-1">
            <div class="col-md-10 mx-auto">
                <div class="card">
                    <div class="card-header pb-0">
                        <ul class="list-group text-capitalize">
                            {{-- <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                <span class="mb-1 text-dark text-sm">Transaksi ID</span>
                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    {{ $lelang['transPemenang'] }}
                                </span>
                            </li> --}}
                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                <span class="mb-1 text-dark text-sm">Nama Produk Pengiriman</span>
                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    {{ $lelang['produkLelang'] }}
                                </span>
                            </li>
                            <hr class="my-2 horizontal-dark">
                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                <span class="mb-1 text-dark text-sm">Nama Penerima</span>
                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    {{ $lelang['userNama'] }}
                                </span>
                            </li>
                            {{-- <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                <span class="mb-1 text-dark text-sm">Kota</span>
                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    {{ $lelang['userKota'] == null ? '-' :  $lelang['userKota'] }}
                                </span>
                            </li> --}}
                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                <span class="mb-1 text-dark text-sm">Nomor Telepon</span>
                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    {{ $lelang['userTelepon'] }}
                                </span>
                            </li>
                            <hr class="my-2 horizontal-dark">
                            @if($req['asal'] != null)
                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                <h5 class="mb-1 text-dark text-center mx-auto">Data Permintaan Cek Ongkos</h5>
                                {{-- <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    {{ $lelang['transPemenang'] }}
                                </span> --}}
                            </li>
                            @else
                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                <span class="mb-1 text-dark text-sm">Kota Asal (Anda)</span>
                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    {{ auth()->user()->kota == null ? '-' : auth()->user()->kota }}
                                </span>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                <span class="mb-1 text-dark text-sm">Alamat Destinasi</span>
                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    {{ $lelang['alamatKirim'] }}
                                </span>
                            </li>
                            <hr class="my-2 horizontal-dark">
                            @endif
                            @if($req['asal'] != null)
                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                <span class="mb-1 text-dark text-sm">Lokasi Asal (Anda)</span>
                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    {{ $req['asal'] == null ? '-' : ($req['asal'].', '.$req['pro-asal']) }} <strong class="ms-2 font-weight-bolder text-danger">({{ auth()->user()->kota == null ? '-' : auth()->user()->kota }})</strong>
                                </span>
                            </li>
                            @endif
                            @if($req['tujuan'] != null)
                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                <span class="mb-1 text-dark text-sm">Lokasi Destinasi (Alamat dari Penggemar)</span>
                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    {{ $req['tujuan'] == null ? '-' : ($req['tujuan'].', '.$req['pro-tujuan']) }} <strong class="ms-2 font-weight-bolder text-danger">({{ $lelang['alamatKirim'] }})</strong>
                                </span>
                            </li>
                            @endif
                            @if($req['kurir'] != null)
                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                <span class="mb-1 text-dark text-sm">Kurir</span>
                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    {{ strtoupper($req['kurir']) == null ? '-' : strtoupper($req['kurir']) }}
                                </span>
                            </li>
                            @endif
                            @if($req['berat'] != null)
                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                <span class="mb-1 text-dark text-sm">Berat Paket</span>
                                <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    {{ $req['berat'] == null ? '-' : $req['berat'] }} Gram
                                </span>
                            </li>
                            <hr class="my-2 horizontal-dark">
                            @endif
                            {{-- <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                <h4 class="mb-1 text-dark text-sm"></h4>
                                <h6 class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                </h6>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                                <h4 class="mb-1 text-dark text-sm">Destinasi</h4>
                                <h6 class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    {{ $req['tujuan'].' dari '.$req['pro-tujuan'] }}
                                </h6>
                            </li>--}}
                        </ul>
                    </div>
                    @if($biaya == [])
                    <form action="{{'/ongkir'}}" method="post"> @csrf
                        <input type="hidden" id="idKirim" name="idKirim" value="{{$lelang['idKirim']}}">
                        <input type="hidden" id="alamatKirim" name="alamatKirim" value="{{$lelang['alamatKirim']}}">
                        <input type="hidden" id="userNama" name="userNama" value="{{$lelang['userNama']}}">
                        {{-- <input type="hidden" id="userKota" name="userKota" value="{{$lelang['userKota']}}"> --}}
                        <input type="hidden" id="userTelepon" name="userTelepon" value="{{$lelang['userTelepon']}}">
                        <input type="hidden" id="idLelang" name="idLelang" value="{{$lelang['idLelang']}}">
                        <input type="hidden" id="produkLelang" name="produkLelang" value="{{$lelang['produkLelang']}}">
                        {{-- <input type="hidden" id="transPemenang" name="transPemenang" value="{{$lelang['transPemenang']}}"> --}}
                        <input type="hidden" id="transID" name="transID" value="{{$lelang['transID']}}">
                        <div class="row text-center">
                            <div class="column col-md-4 shadow-radius-sm">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="">Lokasi Asal</h4>
                                            <hr>
                                            <div class="form-group">
                                                <label class="font-weight-bold text-capitalize">PROVINSI ASAL</label>
                                                <select class="form-control provinsi-asal" name="province_origin">
                                                    <option value="0">Pilih Provinsi</option>
                                                    @foreach ($provinces as $province => $value)
                                                        <option value="{{ $province  }}" >{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold text-capitalize">KOTA / KABUPATEN ASAL</label>
                                                <select class="form-control kota-asal" name="city_origin">
                                                    <option value="">Pilih Kota</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column col-md-4 shadow-radius-sm">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="text-capitalize">Lokasi Destinasi</h4>
                                            <hr>
                                            <div class="form-group">
                                                <label class="font-weight-bold text-capitalize">PROVINSI TUJUAN</label>
                                                <select class="form-control provinsi-tujuan" name="province_destination">
                                                    <option value="0">Pilih Provinsi</option>
                                                    @foreach ($provinces as $province => $value)
                                                        <option value="{{ $province }}" >{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold text-capitalize">KOTA / KABUPATEN TUJUAN</label>
                                                <select class="form-control kota-tujuan" name="city_destination">
                                                    <option value="">Pilih Kota</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column col-md-4 shadow-radius-sm">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="text-capitalize">Kurir Ekspedisi</h4>
                                            <hr>
                                            <div class="form-group">
                                                <label class="font-weight-bold text-capitalize">PROVINSI TUJUAN</label>
                                                <select class="form-control kurir" name="courier">
                                                    <option value="0">Pilih Kurir</option>
                                                    <option value="jne" {{count($req) > 0 ? ($req['kurir'] == 'jne' ? 'selected' : '') : ''}}>JNE</option>
                                                    <option value="pos" {{count($req) > 0 ? ($req['kurir'] == 'pos' ? 'selected' : '') : ''}}>POS</option>
                                                    <option value="tiki" {{count($req) > 0 ? ($req['kurir'] == 'tiki' ? 'selected' : '') : ''}}>TIKI</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold text-capitalize">BERAT (GRAM)</label>
                                                <input type="number" class="form-control" name="weight" id="weight" placeholder="Masukkan Berat (GRAM)" value="{{count($req) > 0 ? $req['berat'] : ''}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center mt-3">
                            {{-- <div class="column col-md-3 me-1"> --}}
                                <div class="col-md-12">
                                    {{-- <div class="card">
                                        <div class="card-body"> --}}
                                        <button type="submit" class="col-md-4 btn bg-gradient-dark m-0 mx-2">Kirim Data</button>
                                        {{-- </div>
                                    </div> --}}
                                </div>
                            {{-- </div> --}}
                        </div>
                    </form>
                    @else
                    <div class="card-body pt-0">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white font-weight-bold">
                                Pastikan Anda Telah Membayar Ongkos Kirim untuk Pilihan Pengiriman Anda
                                @if($errors->any()){{$errors->first()}}@endif
                            </span>
                        </div>
                        <div class="row text-center mt-3">
                            <div class="col-md-12">
                                <a href="{{ url('/ongkir/'.$lelang['idLelang']) }}" class="col-md-4 btn bg-gradient-dark mx-auto">
                                    Ulangi Kirim Data
                                     {{-- <i class="fas fa-money-bill ps-0 text-sm ps-2"></i> --}}
                                </a>
                                {{-- <button type="submit" class="btn bg-gradient-dark m-0 mx-2">Kirim Data</button> --}}
                            </div>
                        </div>
                        {{-- <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                            <h5 class="mb-1 text-dark text-center mx-auto">Data Permintaan Cek Ongkos</h5>
                            <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                            {{ $lelang['transPemenang'] }}
                            </span>
                        </li> --}}
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        {{-- <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                            No
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                            username penjual
                                        </th>--}}
                                        {{-- <th class="text-center text-uppercase text-secondary text-sm font-weight-bold opacity-7">
                                            Kode Kurir Ekspedisi
                                        </th> --}}
                                        <th class="text-center text-uppercase text-secondary text-sm font-weight-bold opacity-7">
                                            Layanan Servis
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-sm font-weight-bold opacity-7">
                                            Biaya Ongkos
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-sm font-weight-bold opacity-7">
                                            Perkiraan Waktu Pengiriman (dalam Hari)
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-sm font-weight-bold opacity-7">
                                            Pengiriman
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($biaya) > 0)
                                    {{-- <tr>
                                        <td class="ps-4"></td>
                                        <td class="ps-4"></td>
                                        <td class="ps-4 mb-0 text-sm text-center font-weight-bolder">Tidak Tersedia dalam Ekspedisi {{$biaya[0]['code']}}</td>
                                        <td class="ps-4"></td>
                                        <td class="ps-4"></td>
                                    </tr>
                                    @else --}}
                                    @for ($i = 0; $i < count($biaya); $i++)
                                    <tr>
                                        {{-- <td class="text-dark text-sm text-center font-weight-bolder">
                                            {{$biaya[$i]['code']}}
                                        </td> --}}
                                        <td class="text-dark text-sm text-center font-weight-bolder">
                                            {{$biaya[$i]['servis']}}
                                        </td>
                                        <td class="text-dark text-sm text-center font-weight-bolder">
                                            Rp {{($biaya[$i]['biaya'])}},-
                                        </td>
                                        <td class="text-dark text-sm text-center font-weight-bolder">
                                            {{$biaya[$i]['hari']}}
                                        </td>
                                        <td class="text-sm text-center font-weight-bolder">
                                            <form action="{{'/set-ongkir'}}" method="post" class="m-0 p-0">
                                                @csrf
                                                <input type="hidden" id="idKirim" name="idKirim" value="{{$lelang['idKirim']}}">
                                                <input type="hidden" id="alamatKirim" name="alamatKirim" value="{{$lelang['alamatKirim']}}">
                                                <input type="hidden" id="userNama" name="userNama" value="{{$lelang['userNama']}}">
                                                {{-- <input type="hidden" id="userKota" name="userKota" value="{{$lelang['userKota']}}"> --}}
                                                <input type="hidden" id="userTelepon" name="userTelepon" value="{{$lelang['userTelepon']}}">
                                                <input type="hidden" id="idLelang" name="idLelang" value="{{$lelang['idLelang']}}">
                                                <input type="hidden" id="produkLelang" name="produkLelang" value="{{$lelang['produkLelang']}}">
                                                {{-- <input type="hidden" id="transPemenang" name="transPemenang" value="{{$lelang['transPemenang']}}"> --}}
                                                <input type="hidden" id="transID" name="transID" value="{{$lelang['transID']}}">
                                                <input type="hidden" id="asal" name="asal" value="{{$req['asal'].', '.$req['pro-asal']}}">
                                                <input type="hidden" id="tujuan" name="tujuan" value="{{$req['tujuan'].', '.$req['pro-tujuan']}}">
                                                <input type="hidden" id="berat" name="berat" value="{{$req['berat']}}">
                                                <input type="hidden" id="kurir" name="kurir" value="{{$req['kurir']}}">
                                                <input type="hidden" id="servis" name="servis" value="{{$biaya[$i]['servis']}}">
                                                <input type="hidden" id="biaya" name="biaya" value="{{$biaya[$i]['biaya']}}">
                                                <input type="hidden" id="hari" name="hari" value="{{$biaya[$i]['hari']}}">
                                                <button type="submit" class="btn bg-gradient-info text-white m-0">
                                                    Kirim Produk <i class="fas fa-truck text-white text-md ms-1" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endfor
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        let req = @json($req);

        //ajax select kota asal
        $('select[name="province_origin"]').on('change', function () {
            let provindeId = $(this).val();
            if (provindeId) {
                jQuery.ajax({
                    url: '/kota/'+provindeId,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        $('select[name="city_origin"]').empty();
                        $.each(response, function (key, value) {
                            let pilih = '';
                            $('select[name="city_origin"]').append('<option value="' + key + '" >' + value + '</option>');
                        });
                    },
                });
            } else {
                $('select[name="city_origin"]').append('<option value="">-- pilih kota asal --</option>');
            }
        });
        //ajax select kota tujuan
        $('select[name="province_destination"]').on('change', function () {
            let provindeId = $(this).val();
            if (provindeId) {
                jQuery.ajax({
                    url: '/kota/'+provindeId,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        $('select[name="city_destination"]').empty();
                        $.each(response, function (key, value) {
                            let pilih = '';
                            $('select[name="city_destination"]').append('<option value="' + key + '" >' + value + '</option>');
                        });
                    },
                });
            } else {
                $('select[name="city_destination"]').append('<option value="">-- pilih kota tujuan --</option>');
            }
        });

        //ajax check ongkir
        // let isProcessing = false;
        // $('#btn-check').click(function (e) {
        //     e.preventDefault();

        //     let token            = $("meta[name='csrf-token']").attr("content");
        //     let city_origin      = $('select[name=city_origin]').val();
        //     let city_destination = $('select[name=city_destination]').val();
        //     let courier          = $('select[name=courier]').val();
        //     let weight           = $('#weight').val();

        //     if(isProcessing){
        //         return;
        //     }

        //     isProcessing = true;
        //     jQuery.ajax({
        //         url: "/set-ongkir",
        //         data: {
        //             _token:              token,
        //             city_origin:         city_origin,
        //             city_destination:    city_destination,
        //             courier:             courier,
        //             weight:              weight,
        //         },
        //         dataType: "JSON",
        //         type: "POST",
        //         success: function (response) {
        //             isProcessing = false;
        //             if (response) {
        //                 $('#ongkir').empty();
        //                 $('.ongkir').addClass('d-block');
        //                 $.each(response[0]['costs'], function (key, value) {
        //                     $('#ongkir').append('<li class="list-group-item">'+response[0].code.toUpperCase()+' : <strong>'+value.service+'</strong> - Rp. '+value.cost[0].value+' ('+value.cost[0].etd+' hari)</li>')
        //                 });

        //             }
        //         }
        //     });

        // });

    });

    // function check() {
    //     let isProcessing = false;
    //     // $('#btn-check').click(function (e) {
    //     //     e.preventDefault();

    //         let token            = $("meta[name='csrf-token']").attr("content");
    //         let city_origin      = $('select[name=city_origin]').val();
    //         let city_destination = $('select[name=city_destination]').val();
    //         let courier          = $('select[name=courier]').val();
    //         let weight           = $('#weight').val();

    //         if(isProcessing){// || city_origin == '' || city_destination == '' || courier == '' || weight == ''){
    //             return;
    //         }
    //         alert([isProcessing,city_origin,city_destination,courier,weight]);

    //         isProcessing = true;
    //         jQuery.ajax({
    //             url: "/set-ongkir/"+city_origin+"/"+city_destination+"/"+courier+"/"+weight,
    //             // data: {
    //             //     _token:              token,
    //             //     city_origin:         city_origin,
    //             //     city_destination:    city_destination,
    //             //     courier:             courier,
    //             //     weight:              weight,
    //             // },
    //             dataType: "JSON",
    //             type: "GET",//"POST",
    //             success: function (response) {
    //                 isProcessing = false;
    //                 if (response) {
    //                     // $('#ongkir').empty();
    //                     alert(response[0]);
    //                     $('.ongkir').addClass('d-block');
    //                     $.each(response[0]['costs'], function (key, value) {
    //                         // alert(response[0]['costs']);
    //                         $('#ongkir').append('<li class="list-group-item">'+response[0].code.toUpperCase()+' : <strong>'+value.service+'</strong> - Rp. '+value.cost[0].value+' ('+value.cost[0].etd+' hari)</li>')
    //                     });
    //                 }
    //             }
    //         });

    //     // });
    // }
</script>
