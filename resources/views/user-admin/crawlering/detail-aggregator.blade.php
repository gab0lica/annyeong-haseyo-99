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
            {{-- <div class="row"> --}}
                {{-- <h5 class="font-weight-bolder mb-0">
                    Daftar Hasil Aggregator Konten Berita
                </h5> --}}
                <div class="alert col-md-12 {{ $req['web'] == 1 ? 'alert-info' : ($req['web'] == 2 ? 'alert-success' : 'alert-secondary') }} alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white text-lg font-weight-bolder">
                        {{ $req['web'] == 1 ? 'Dispatch' : ($req['web'] == 2 ? 'The Korea Times' : 'Korea Herald') }}
                    </span>
                    <span class="text-sm alert-text text-white">
                        dengan Level
                    </span>
                    <span class="alert-text text-white text-lg font-weight-bolder"> {{ $req['level'] }}</span>
                    <span class="text-sm alert-text text-white">
                        pada Tanggal Crawler
                    </span>
                    <span class="alert-text text-white text-lg font-weight-bolder"> {{ $req['tanggal'] }}</span>
                    <span class="text-sm alert-text text-white">
                        dengan Total
                    </span>
                    <span class="alert-text text-white text-lg font-weight-bolder"> {{ $req['jumlah'] != count($berita) ? count($berita) : $req['jumlah'] }}</span>
                    <span class="text-sm alert-text text-white">
                        Link
                    </span>
                    <a href="{{ url('berita-aggregator/grafik') }}" type="button"
                        class="btn ms-4 my-0 bg-white text-dark btn-outline-{{ $req['web'] == 1 ? 'info' : ($req['web'] == 2 ? 'success' : 'secondary') }} btn-md font-weight-bolder">
                        Laporan Aggregator Berita <i class="fas fa-folder-open text-lg opacity-10 ps-2"></i>
                    </a>
                </div>
            {{-- </div> --}}
          </div>
        </div>
{{-- dari user-management --}}
            <div class="card-body px-0 pt-0 pb-2">
                {{-- @if($pesan[0] == 'salah' && $web != 'grafik') --}}
                {{-- alert --}}
                {{-- @endif --}}
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <th class="ps-4 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                            No.
                        </th>
                        <th class="col-md-4 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                            Link
                        </th>
                        <th class="col-md-3 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                            Admin (Web Crawler - Catcher Konten)
                        </th>
                        <th class="col-md-3 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                            Pembaca dengan Suka
                        </th>
                        <th class="col-md-2 text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                            Kontrol
                        </th>
                        @for ($i = 0; $i < count($berita); $i++)
                        <tr>
                            <td class="ps-4">
                                <p class="text-sm font-weight-bolder m-0 p-0">
                                    {{$i+1}}.
                                </p>
                            </td>
                            <td class="text-center">
                                <a href="{{$berita[$i]['link']}}" target="_blank" class="text-sm font-weight-bolder m-0 p-0"
                                    title="Buka Link {{ $req['web'] == 1 ? 'Dispatch' : ($req['web'] == 2 ? 'The Korea Times' : 'Korea Herald') }}">
                                    {{$berita[$i]['link']}}
                                    <i class="fas fa-link opacity-10 ps-2"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <p class="text-sm font-weight-bolder m-0 p-0">
                                    ({{$berita[$i]['berita_admin'] == auth()->user()->id ? 'Anda' : 'ID '.$berita[$i]['berita_admin']}}) - ({{$berita[$i]['konten_admin'] == auth()->user()->id ? 'Anda' : 'ID '.$berita[$i]['konten_admin']}})
                                </p>
                            </td>
                            <td class="text-center m-0 p-0">
                                <span class="text-sm font-weight-bolder mb-0">
                                    <i class="text-lg fas fa-user text-dark text-gradient py-2 pe-1 ps-3"></i> {{$berita[$i]['baca']}}
                                </span>
                                <span class="text-sm font-weight-bolder mb-0">
                                    <i class="text-lg fas fa-thumbs-up text-danger text-gradient py-2 pe-1 ps-3"></i> {{$berita[$i]['suka']}}
                                </span>
                                <span class="text-sm font-weight-bolder mb-0">
                                    <i class="text-lg fas fa-thumbs-down text-dark text-gradient py-2 pe-1 ps-3"></i> {{$berita[$i]['tidaksuka']}}
                                </span>
                                <span class="text-sm font-weight-bolder mb-0">
                                    <i class="text-lg fas fa-thumbs-up text-secondary py-2 pe-1 ps-3"></i> {{$berita[$i]['belum']}}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ url('halaman-berita/'.$berita[$i]['id']) }}"
                                    class="{{ Request::is('halaman-berita/'.$berita[$i]['id']) ? 'active' : '' }}"
                                    type="button" target="_blank" title="Buka Link ID {{$berita[$i]['id']}}">
                                    <i class="fas fa-newspaper text-lg text-dark me-2" aria-hidden="true"></i>
                                </a>
                                {{-- status-link/{id} nonaktifkan --}}
                                <a href="{{ url('status-link/'.$berita[$i]['id']) }}"
                                    class="{{ Request::is('status-link/'.$berita[$i]['id']) ? 'active' : '' }}"
                                    type="button" target="_blank" title="Nonaktifkan Link ID {{$berita[$i]['id']}}">
                                    <i class="fas fa-ban text-lg text-danger me-2" aria-hidden="true"></i>
                                </a>
                                {{-- <button type="button" class="btn-link btn m-0 p-0" data-bs-toggle="modal" data-bs-target="#exampleModalMessage{{$i}}">
                                    <i class="fas fa-keyboard text-lg text-dark me-2" aria-hidden="true"></i>
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

                                <!-- Button trigger modal -->
                                {{-- <button type="button" class="btn btn-link btn m-0 p-0" data-bs-toggle="modal" data-bs-target="#exampleModalLong{{$i}}">
                                    <i class="fas fa-keyboard text-lg text-danger me-2" aria-hidden="true"></i>
                                </button> --}}

                                <!-- Modal -->
                                {{-- <div class="modal fade" id="exampleModalLong{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body w-50">
                                        I always felt like I could do anything. That’s the main thing people are controlled by! Thoughts- their perception of themselves! They're slowed down by their perception of themselves. If you're taught you can’t do anything, you won’t do anything. I was taught I could do everything.
                                        <br/><br/>
                                        As we live, our hearts turn colder. Cause pain is what we go through as we become older. We get insulted by others, lose trust for those others. We get back stabbed by friends. It becomes harder for us to give others a hand. We get our heart broken by people we love, even that we give them all we have. Then we lose family over time. What else could rust the heart more over time? Blackgold.
                                        <br/><br/>


                                        We’re not always in the position that we want to be at. We’re constantly growing. We’re constantly making mistakes. We’re constantly trying to express ourselves and actualize our dreams. If you have the opportunity to play this game of life you need to appreciate every moment. A lot of people don’t appreciate the moment until it’s passed.
                                        <br/><br/>


                                        There’s nothing I really wanted to do in life that I wasn’t able to get good at. That’s my skill. I’m not really specifically talented at anything except for the ability to learn. That’s what I do. That’s what I’m here for. Don’t be afraid to be wrong because you can’t learn anything from a compliment.
                                        <br/><br/>

                                        It really matters and then like it really doesn’t matter. What matters is the people who are sparked by it. And the people who are like offended by it, it doesn’t matter. Because it's about motivating the doers. Because I’m here to follow my dreams and inspire other people to follow their dreams, too.
                                        <br/><br/>

                                        The time is now for it to be okay to be great. People in this world shun people for being great. For being a bright color. For standing out. But the time is now to be okay to be the greatest you. Would you believe in what you believe in, if you were the only one who believed it?
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn bg-gradient-primary">Save changes</button>
                                      </div>
                                    </div>
                                  </div>
                                </div> --}}
                            </td>
                        </tr>
                        @endfor
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
