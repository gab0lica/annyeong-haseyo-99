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
                    <h5 class="mb-0 font-weight-bold">
                       <i class="fas fa-coins text-warning text-gradient text-lg me-1 py-1"></i> {{ $koinid }} Koin
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <hr class="horizontal dark my-2">
        <h4 class="text-dark px-2 text-center font-weight-bolder m-0">Nota Koin</h4>
        <hr class="horizontal dark">
    </div>

    <div class="container-fluid pt-0 py-4">
        <div class="row ">{{--"row mt-lg-n20 mt-md-n11 mt-n10">
        <div class="col-md-8 ">
          <div class="card z-index-0">
             --}}
            <div class="col-md-7 mx-auto">
                <div class="card h-100">
                {{-- <div class="card-header pb-0 px-3">
                    <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-0">Perincian</h6>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <i class="far fa-calendar-alt me-2"></i>
                    </div>
                    </div>
                </div> --}}
                <div class="card-body pt-4 p-3">
                    {{-- <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Newest</h6> --}}
                    <ul class="list-group">
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Transaksi ID</span>
                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                            {{ $id }}
                        </span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <span class="mb-1 text-dark text-sm">Tanggal Pembayaran</span>
                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                        @php
                            $inggris = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                            $indonesia = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        @endphp
                        {{ str_replace($inggris,$indonesia,date('d F Y H:i:s',strtotime($tanggal))) }}
                        </span>
                    </li>
                    @if($jenis != 'registrasi')
                        @if($status == 'Berhasil')
                        <li class="list-group-item border-0 d-flex justify-content-between p-0 ps-0 mb-2 border-radius-lg">
                            <span class="mb-1 text-dark text-sm">Tipe Pembayaran</span>
                            <div class="d-flex align-items-center badge-dark text-sm font-weight-bolder">
                                {{ $tipe }}
                            </div>
                        </li>
                        @endif
                        @if($status != 'Nota')<!--statusmid == 'settlement'-->
                        <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                            {{-- <div class="d-flex align-items-center">
                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></button>
                            <div class="d-flex flex-column"> --}}
                                <span class="mb-1 text-dark text-sm">Status Pembayaran</span>
                                {{-- <span class="text-xs">26 March 2020, at 08:30 AM</span>
                            </div>
                            </div>--}}
                            <div class="d-flex align-items-center font-weight-bolder text-gradient {{$statusmid == 'settlement' || $statusmid == 'Berhasil' ? 'text-success' : ($statusmid == 'pending' || $statusmid == 'Admin' ? 'text-warning' : ($statusmid == 'failure' || $statusmid == 'expire' || $statusmid == 'Gagal' ? 'text-danger' : 'text-dark' ) )}} text-sm">
                                {{$statusmid == 'settlement'|| $statusmid == 'Berhasil' ? 'Berhasil' : ($statusmid == 'pending' ? 'Menunggu Pembayaran' : ($statusmid == 'failure' || $statusmid == 'expire' || $statusmid == 'Gagal' ? 'Gagal Membayar' : ( $statusmid == 'Admin' ? 'Menunggu Konfirmasi' : $statusmid)))}}{{-- {{$snap}} --}}
                            </div>
                        </li>
                        @endif
                    @else
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                            <span class="mb-1 text-dark text-sm">Status Transaksi</span>
                        <div class="d-flex align-items-center font-weight-bolder text-gradient {{$status == 'Berhasil' ? 'text-success' : ($status == 'Admin' ? 'text-warning' : '')}} text-sm">
                            {{$status == 'Berhasil' ? $status : ($status == 'Admin' ? 'Menunggu Konfirmasi' : ($status == 'Gagal' ? 'Gagal Registrasi' : '' ))}}{{-- {{$snap}} --}}
                        </div>
                    </li>
                    @endif
                    <hr>
                    {{-- <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        <h6 class="mb-0"><u>Perincian</u></h6>
                    </li> --}}
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        {{-- <div class="d-flex align-items-center">
                        <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-down"></i></button>
                        <div class="d-flex flex-column"> --}}
                            <span class="mb-1 text-dark text-sm">Jenis Nota</span>
                            {{-- <span class="text-xs">27 March 2020, at 12:30 PM</span> --}}
                        {{-- </div>
                        </div> --}}
                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                            {{$jenis == 'beli' ? 'Isi Koin' : ($jenis == 'tukar' ? 'Tarik Koin' : ($jenis == 'registrasi' ? 'Registrasi Penjual' : ''))}}
                        </span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        {{-- <div class="d-flex align-items-center">
                        <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-down"></i></button>
                        <div class="d-flex flex-column"> --}}
                            <span class="mb-1 text-dark text-sm">{{$jenis == 'beli' || $jenis == 'tukar' ? 'Menu Koin' : ($jenis == 'registrasi' ? 'Biaya Registrasi Penjual' : '')}}</span>
                            {{-- <span class="text-xs">27 March 2020, at 12:30 PM</span> --}}
                        {{-- </div>
                        </div> --}}
                        <span class="d-flex align-items-center text-danger text-dark text-sm font-weight-bold">
                        {{ $jenis == 'beli' ? $koin : $koin*-1 }} Koin
                        </span>
                    </li>
                    @if($jenis != 'registrasi')
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-md">
                        {{-- <div class="d-flex align-items-center">
                        <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></button>
                        <div class="d-flex flex-column"> --}}
                            <span class="mb-1 text-dark text-sm">Jumlah Menu</span>
                            {{-- <span class="text-xs">27 March 2020, at 04:30 AM</span> --}}
                        {{-- </div>
                        </div> --}}
                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                        {{ $jumlah }}
                        </span>
                    </li>
                    <hr>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                        {{-- <div class="d-flex align-items-center">
                        <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></button>
                        <div class="d-flex flex-column"> --}}
                            <span class="mb-1 text-dark text-sm">Sub Total</span>
                            {{-- <span class="text-xs">26 March 2020, at 13:45 PM</span>
                        </div>
                        </div> --}}
                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                        Rp {{ $jenis == 'beli' ? $koin*$jumlah : $koin*$jumlah*-1}}.000,-
                        </span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                        {{-- <div class="d-flex align-items-center">
                        <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></button>
                        <div class="d-flex flex-column"> --}}
                            <span class="mb-1 text-dark text-sm">Biaya Admin</span>
                            {{-- <span class="text-xs">26 March 2020, at 12:30 PM</span>
                        </div>
                        </div> --}}
                        <span class="d-flex align-items-center text-dark text-dark text-sm font-weight-bold">
                        {{$jenis == 'beli' ? 'Rp 2.000,-' : 'Rp 3.000,-'}}
                        </span>
                    </li>
                    <hr>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 mb-2 border-radius-lg">
                        {{-- <div class="d-flex align-items-center">
                        <button class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-exclamation"></i></button>
                        <div class="d-flex flex-column"> --}}
                            <span class="mb-1 text-dark text-sm">Total {{$jenis == 'beli' ? 'yang dibayar' : ($jenis == 'tukar' ? 'uang yang didapat' : '')}}</span>
                            {{-- <span class="text-xs">26 March 2020, at 05:00 AM</span>
                        </div>
                        </div> --}}
                        <span class="d-flex align-items-center text-dark text-sm font-weight-bold">
                        {{ ($jenis != 'registrasi' ? 'Rp ' : '').($total/1000) }}.000,- <!--(($koin*$jumlah)+2)-->
                        </span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 ps-0 mb-2 border-radius-lg">
                        <span class="mb-1 text-dark text-sm">Jumlah {{$jenis == 'beli' ? 'Beli' : ($jenis == 'tukar' ? 'Tukar' : '')}} Koin</span>
                        <div class="d-flex align-items-center text-sm {{$jenis == 'beli' ? 'text-success' : 'text-danger'}} font-weight-bolder">
                            {{$jenis == 'beli' ? '+ '.$koin*$jumlah : '- '.($jenis == 'tukar' ? $koin*$jumlah*-1 : ($jenis == 'registrasi' ? $koin*-1 : '')) }} Koin
                        </div>
                    </li>
                    @else
                    <hr>
                    <li class="list-group-item border-0 d-flex justify-content-between p-0 ps-0 mb-2 border-radius-lg">
                        <span class="mb-1 text-dark text-sm">Jumlah Koin {{$jenis == 'beli' ? 'yang dibeli' : ($jenis == 'tukar' ? 'yang ditukar' : 'yang dibayar')}}</span>
                        <div class="d-flex align-items-center text-sm {{$jenis == 'beli' ? 'text-success' : 'text-danger'}} font-weight-bolder">
                            {{$jenis == 'beli' ? '+ '.$koin*$jumlah : '- '.($jenis == 'tukar' ? $koin*$jumlah*-1 : ($jenis == 'registrasi' ? $koin*-1 : '')) }} Koin
                        </div>
                    </li>
                    @endif
                    </ul>
                </div>
                @if($jenis != 'registrasi' && ($statusmid == 'Nota' || $statusmid == 'pending'))
                {{-- <form action="{{url('/bayar-koin')}}" method="post" class="mx-auto">
                    @csrf
                    <input type="hidden" name="idnota" id="idnota" value="{{$id}}"> --}}
                    <button id='pay-button' onclick='check()' class="btn bg-gradient-dark mx-auto">Bayar</button>
                {{-- </form> --}}
                @elseif($jenis == 'registrasi')
                <a href="{{ url(auth()->user()->role == 3 ? 'penjual/profile' : 'penjual/registrasi') }}" class="btn bg-gradient-dark mx-auto">Lihat Registrasi</a>
                @else
                <a href="{{ url('/deposito-koin') }}" class="btn bg-gradient-dark mx-auto">Kembali Ke Deposito</a>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{config('midtrans.client_key')}}"> </script><!--SET_YOUR_CLIENT_KEY_HERE-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
<script type="text/javascript">
    // function kembali() {
    //     alert('kembali');
    // }

    // var payButton = document.getElementById('pay-button');
    // payButton.addEventListener('click', function () {
    function check() {
        // let id = document.getElementById('idnota').value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // alert(id);
        // SnapToken acquired from previous step
        snap.pay('<?=$snap?>', {
          // Optional

          onSuccess: function(result){
            /* You may add your own js here, this is just example */
            // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            // send_response_to_form(result);
            // console.log(result);

            // $.ajax({
            //     type:'POST',
            //     url:'/bayar-koin',
            //     data:{
            //         id: '<?=$id?>',
            //         status: 'Berhasil'
            //         },
            //     success:function(data){
            //         alert('Anda Sukses Melakukan Pembayaran'.$data['success']);
            //     }
            // });
            // alert('Anda Sukses Melakukan Pembayaran');
            // window.location.href = url('/nota-koin');
          },
          // Optional
          onPending: function(result){
            /* You may add your own js here, this is just example */
            // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            // send_response_to_form(result);
            // console.log(result);

            // $.ajax({
            //     type:'POST',
            //     url:'/bayar-koin',
            //     data:{
            //         id: '<?=$id?>',
            //         status: 'Pending'
            //         },
            //     success:function(data){
            //         alert('Anda dalam mode Pending //'.$data['success']);
            //     }
            // });
            // alert('Anda dalam mode Pending');

          },
          // Optional
          onError: function(result){
            /* You may add your own js here, this is just example */
            // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            // send_response_to_form(result);
            // console.log(result);

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            // $.ajax({
            //     type:'POST',
            //     url:'/bayar-koin',
            //     data:{
            //         id: id,//'<?=$id?>',
            //         status: 'Error'
            //         },
            //     success:function(data){
            //         alert('Anda dalam mode Error'.data['snap']);
            //     }
            // });
            alert('Anda dalam mode Error');
          },
        // onClose: function(){
        //     /* You may add your own implementation here */
        //     alert('Anda Menutup Pembayaran tanpa Menyelesaikan.');
        // }
        });
      };
</script>
